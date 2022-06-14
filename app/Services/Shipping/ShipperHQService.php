<?php
namespace App\Services\Shipping;

use Illuminate\Support\Facades\Http;
use stdClass;

class ShipperHQService {

    private $_sandboxUrl = "http://www.localhost.com:8080/shipperhq-ws/v1/";
    private $_liveUrl = "http://api.shipperhq.com/v1/";
    private $_isLive;

    public function __construct()
    {
        $this->_isLive = config('shipping.mode') === 'live';
    }

    private function _getGatewayUrl()
    {
        return $this->_isLive ? $this->_liveUrl : $this->_sandboxUrl;
    }


    public static function client() {
        return app(ShipperHQService::class)->_client;
    }

    public function calculateShipping($cart)
    {
        $items = [];
        $declaredValue = 0;

        foreach ( $cart['items'] as $item) {
            $formattedItem = new stdClass();

            $formattedItem->id = $item['id'];
            $formattedItem->sku = $item['sku'];
            $formattedItem->storePrice = $item['storePrice'];
            $formattedItem->qty = $item['qty'];

            $formattedItem->taxInclBasePrice = $item['storePrice'];
            $formattedItem->taxInclStorePrice = $item['storePrice'];
            $formattedItem->rowTotal = $item['storePrice'] * $item['qty'];
            $formattedItem->baseRowTotal = $item['storePrice'] * $item['qty'];

//            $formattedItem->type = $item['type'] === 'simple' ? "simple" : "configurable";
            $formattedItem->type = "simple";

            $attributes = [];
            $attributes['product_id'] = $item['id'];

            if ($item['type'] === 'huge_variations') {
                $attributes['width'] = $item['attributes']['depth'] ?? $item['attributes']['width'];
                $attributes['height'] = $item['attributes']['thickness'] ?? $item['attributes']['height'];
                $attributes['length'] = isset($item['attributes']['length']) && strpos($item['attributes']['length'], '-1-2') ? $item['attributes']['length']
                    : (int)filter_var($item['attributes']['length'], FILTER_SANITIZE_NUMBER_INT);


                if (isset($attributes['height'])) {
                    $height = $attributes['height'] === '3-4' ? 0.75 : $attributes['height'];
                }
                if ($item['shipper_hq_type'] === 'artisan' && $item['sides'] === 'two_sided') {
                    $weight = ($attributes['width'] + $height) * ($attributes['length'] * 12) / 144 * 1.17;
                } elseif ($item['shipper_hq_type'] === 'artisan' && $item['sides'] === 'three_sided') {
                    if (isset($attributes['width']) && isset($attributes['length'])) {
                        $weight = ($attributes['width'] + $height + $height) * ($attributes['length'] * 12) / 144 * 1.17;
                    }
                } elseif ($item['shipper_hq_type'] === 'artisan' && $item['sides'] === 'four_sided') {
                    $weight = ($attributes['width'] + $attributes['width'] + $height + $height) * ($attributes['length'] * 12) / 144 * 1.17;
                } elseif ($item['shipper_hq_type'] == 'planks' || $item['shipper_hq_type'] == 'mantels') {
                    $height = $height == '3-4' ? 0.75 : $height; // thickness

                    if (strpos($attributes['length'], '-1-2')) {
                        $attributes['length'] = str_replace('-1-2', '', $attributes['length']);
                        if ($attributes['length'] < 96) {
                            $attributes['length']++;
                        }
                    } else {
                        $attributes['length'] = $attributes['length'] * 12;
                    }
                    if (strpos($height, '-1-2')) { // depth
                        $height = str_replace('-1-2', '', $height);
                        if ($height < 12) {
                            $height++;
                        }
                    }
                    if (strpos($attributes['width'], '-1-2')) {
                        $attributes['width'] = str_replace('-1-2', '', $attributes['width']);
                        if ($attributes['width'] < 12) {
                            $attributes['width']++;
                        }
                    }
                    $weight = ($attributes['width'] + $height + $height) * $attributes['length'] / 144 * 1.17;
                } else {
                    $weight = '';
                }
                $item['weight'] = round($weight, 1, PHP_ROUND_HALF_UP);

                if (isset($attributes['length'])) {

                    $num = strpos($attributes['length'], '-1-2') ? ceil(str_replace('-1-2', '', $attributes['length']) / 12) : $attributes['length'];
                    $num = $num < 10 ? '0' . $num : $num;
                    $attributes['shipperhq_dim_group'] = 'Beams ' . $num . 'ft';

                    $attributes['freight_class'] = 77.5;

                    $attributes['shipperhq_shipping_group'] = 'LTL';

                    $attributes['shipperhq_warehouse'] = 'Origin 1 - Phoenix AZ';

                    $attributes['length'] = strpos($attributes['length'], '-1-2') ? str_replace('-1-2', '', $attributes['length']) + 1 : $attributes['length'] * 12;


                    if($attributes['height'] === '3-4') {
                        $attributes['height'] = 0.75;
                    } elseif (strpos($attributes['height'], '-1-2')) {
                        $attributes['height'] = str_replace('-1-2', '', $attributes['height']) + 1;
                    }


                    if(strpos($attributes['width'], '-1-2')) {
                        $attributes['width'] = str_replace('-1-2', '', $attributes['width']) + 1;
                    }

                    $attributes['must_ship_freight'] = true;
                    $attributes['ship_separately'] = false;
                }
            } else {
                if(isset($item['width']) && $item['width']) {
                    $attributes['width'] = $item['width'];
                }

                if(isset($item['height']) && $item['height']) {
                    $attributes['height'] = $item['height'];
                }

                if(isset($item['length']) && $item['length']) {
                    $attributes['length'] = $item['length'];
                }
            }

            if(isset($item['weight'])) {
                $formattedItem->weight = $item['weight'];
            }

            $formattedItem->attributes = $this->populateAttributes($attributes);

            $formattedItem->freeShipping = false;
            $formattedItem->fixedPrice = false;
            $formattedItem->fixedWeight = false;

            $items[] = $formattedItem;
            $declaredValue += (double)$item['storePrice'];
        }

        $params = array (
            'cart' =>
                array (
                    'declaredValue' => $declaredValue,
                    'freeShipping' => false,
                    'items' => $items,
                ),
            'destination' =>
                array (
                    'country' => 'US',
                    'region' => $cart['state'],
                    'city' => $cart['city'] ?? 'A',
                    'street' => $cart['street'] ?? '',
                    'zipcode' => (string)$cart['zipcode'],
                    'street2' => NULL,
                    'accessorials' => NULL,
                    'selectedOptions' => NULL,
                    'email' => NULL,
                    'givenName' => NULL,
                    'familyName' => NULL,
                    'telNo' => NULL,
                ),
            'customerDetails' =>
                array ('customerGroup' => NULL),
            'cartType' => 'checkout',
            'deliveryDateUTC' => NULL,
            'deliveryDate' => NULL,
            'carrierId' => NULL,
            'carrierGroupId' => NULL,
            'shipDetails' => NULL,
            'carrierCode' => NULL,
            'validateAddress' => NULL,
            'credentials' => $this->_getCredentials(),
            'siteDetails' => $this->_getSiteDetails()
        );

        return $this->_sendRateRequest($params);
    }

    private function populateAttributes($data)
    {
        $attrs = [];

        foreach ($data as $field => $value) {
            $attrs[] = ['name' => $field, 'value' => $value];
        }

        return $attrs;
    }

    private function _sendRateRequest($requestObj) {
        try {
            $response = Http::acceptJson()->post($this->_getGatewayUrl().'rates', $requestObj);
        } catch (\Exception $e) {
            return null;
        }

        $rateParsed = $this->parseRateResult($response->json());

        return $rateParsed && is_array($rateParsed) ? $rateParsed : [];
    }

    private function parseRateResult($shipper_response) {
        if(!$shipper_response || !is_array($shipper_response)) {
            return [];
        }

        $carrierRates = [];

        if (isset($shipper_response['carrierGroups'])) {

            foreach ($shipper_response['carrierGroups'] as $carrierGroup) {
                if(isset($carrierGroup['carrierRates'])) {
                    $carrierRates = array_merge($carrierRates, $carrierGroup['carrierRates']);
                }
            }
        }

        $result = [];

        foreach ($carrierRates as $carrierRate) {
            if (isset($carrierRate['error'])) {
                continue;
            }
            if (array_key_exists('rates', $carrierRate)) {
                foreach ($carrierRate['rates'] as $rateDetails) {
                    $rate = array(
                        'id' => $carrierRate['carrierId'] . "_" . $carrierRate['carrierCode'],
                        'label' => $carrierRate['carrierTitle'],
                        'cost' => $rateDetails['totalCharges'] ?? 0,
                        'type' => $carrierRate['carrierType'],
                    );
                    $result[] = $rate;
                }
            }
        }

        return $result;
    }

    private function _getCredentials()
    {
        return [
            'apiKey' => 'ce846a6b644d7a3a5e2a5284160d49cb' ?? config('shipping.api_key'),
            'password' => '9811da974348416952a61bf5a216adae31c960ecaf25ec9784' ?? config('shipping.authentication_code'),
        ];
    }

    private function _getSiteDetails()
    {
        return [
            'ecommerceCart' => 'Woocommerce',
            'ecommerceVersion' => '5.7.1',
            'websiteUrl' => 'http://sandbox.tiltoncofferedceilings.loc',
            'environmentScope' => 'LIVE',
            'appVersion' => '',
            'ipAddress' => null,
        ];
    }
}
