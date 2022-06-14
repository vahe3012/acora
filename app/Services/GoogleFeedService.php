<?php
namespace App\Services;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Vitalybaev\GoogleMerchant\Feed;
use Vitalybaev\GoogleMerchant\Product as GoogleProduct;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;

class GoogleFeedService {
    const UPLOAD_DIR = 'feeds/';
    const DEFAULT_TITLE = 'Google review Feed';

    public static function generateProductFeedXml($feedDb) {
        $publicDisk = Storage::disk('public');

        $title = $feedDb->title ?? $feedDb->file_name;

        if(!$title) {
            $title = self::DEFAULT_TITLE;
        }

        $productCount = 0;

        $feedGenerator = new Feed($title, url('/'), $feedDb->description ?? $title);
        $categories = $feedDb->categories->pluck('id')->toArray();

        $products = Product::published()->typeIn($feedDb->include_variations ? [Product::TYPE_SIMPLE, Product::TYPE_PRODUCT_VARIATION, Product::TYPE_HUGE_VARIATION] : [Product::TYPE_SIMPLE])
            ->withRelations()
            ->whereHas('categories', function($q) use($categories) {
                return $q->whereIn('id', $categories);
            })
            ->get();

        foreach($products as $product) {
            $feed = [];

            if($product->isHugeVariation()) {
                $paColors = ['dark-walnut', 'driftwood', 'espresso', 'gray', 'ledgewood', 'light-walnut', 'mahogany', 'oak', 'primed'];
                foreach ($paColors as $paColor) {
                    if($product->shipper_hq_type === 'planks') {
                        $tabKeys = ["4ft" => 1.05, "6ft" => 1.39, "8ft" => 1.75, "10ft" => 2.11, "12ft" => 2.47, "14ft" => 2.83, "16ft" => 3.19, "18ft" => 3.55, "20ft" => 3.8];

                        foreach ($tabKeys as $key => $val) {
                            $texture_attributes = ['ship-lap-w-nickel-gap', 'ship-lap', 'v-groove-tg', 'textured'];
                            foreach ($texture_attributes as $attribute) {
                                $length_ft = $key;
                                $price = 25; // thickness
                                $price *= 1.01; // width
                                $price *= $val; // length
                                $price *= $paColor === 'primed' ? 1 : 1.2; // color
                                $price *= 1.2; // edge style

                                $varAttrs = [
                                    "thickness" => 1,
                                    "width" => 4,
                                    "length" => $length_ft,
                                    "color" => $paColor,
                                    "edge-style" => $attribute,
                                    "fire-rated" => "no",
                                ];

                                $variantImageAttrs = ['textured', $paColor];

                                $feed = self::createFeedForHugeVariationItem($product, $varAttrs, $variantImageAttrs, $price);
                                self::addProductFeed($feedGenerator, $feed, $feedDb->google_category);
                                $productCount++;
                            }
                        }


                    }
                    elseif($product->shipper_hq_type === 'mantels') {
                        $length_ft = ['4ft' => 1.01, '5ft' => 25, '6ft' => 50, '7ft' => 75, '8ft' => 100];
                        foreach ($length_ft as $key => $val) {
                            $textures = ["doug-fir", "hand-hewn", "rough-sawn", "sand-blast", "tuscany"];
                            foreach ($textures as $texture) {
                                $depth = 4;
                                $height = 4;
                                $length_ft = $key;
                                $price = 190;
                                if ($key == '4ft') {
                                    $price *= $val;
                                } else {
                                    $price += $val;
                                }

                                $varAttrs = [
                                    "pa_depth" => $depth,
                                    "pa_height" => $height,
                                    "pa_length" => $length_ft,
                                    "pa_color" => $paColor,
                                    "pa_end-cap-type" => "none",
                                    "pa_texture" => $texture,
                                    "pa_fire-rated" => "no",
                                ];

                                $variantImageAttrs = [$texture, $paColor];

                                $feed = self::createFeedForHugeVariationItem($product, $varAttrs, $variantImageAttrs, $price);
                                self::addProductFeed($feedGenerator, $feed, $feedDb->google_category);
                                $productCount++;
                            }
                        }
                    }
                    else {
                        $tab_keys = ["4ft", "6ft", "8ft", "10ft", "12ft", "14ft", "16ft", "18ft", "20ft"];
                        foreach ($tab_keys as $val) {
                            $width = 4;
                            $height = 4;

                            $length = str_replace('ft', '', $val) * 12;
                            $sides = $product->sides;

                            $multipliers = [
                                'height' => 0.01,
                                'width' => 0.01,
                                'length' => 1,
                            ];

                            $misc = [
                                'two_sided' => 0.11,
                                'three_sided' => 0.1,
                                'four_sided' => 0.125,
                            ];

                            if ($sides == 'two_sided') {
                                $area = ((($width + $height) * $length) * $misc['two_sided']);
                                $price = $area * $multipliers['length'];
                            } else if ($sides == 'three_sided') {
                                $area = (($width + $height + $height) * $length);
                                $price = ($area * $misc['three_sided']) * array_sum($multipliers);
                            } else if ($sides == 'four_sided') {
                                $area = (($width + $height + $height) * $length);
                                $area = ($area * $misc['three_sided']) * array_sum($multipliers);
                                $price = $area + (($width * $length) * $misc['four_sided']);
                            } else {
                                $price = null;
                            }

                            $baseCost = $price;
                            $main_beam = ["two_sided_stain_multiplier" => 0.3, "three_four_sided_stain_multiplier" => 0.275];

                            if ($paColor !== 'primed') {
                                $multipliers = ($sides == 'two_sided' ? $main_beam['two_sided_stain_multiplier'] : $main_beam['three_four_sided_stain_multiplier']);
                                $price = $price + ($baseCost * $multipliers);
                            }

                            $varAttrs = [
                                "pa_width" => $width,
                                "pa_height" => $height,
                                "pa_length" => $val,
                                "pa_color" => $paColor,
                                "pa_end-cap-type" => "none",
                                "pa_end-cap-quantity" => "none",
                                "pa_fire-rated" => "no",
                            ];

                            $variantImageAttrs = [$paColor];

                            $feed = self::createFeedForHugeVariationItem($product, $varAttrs, $variantImageAttrs, $price);
                            self::addProductFeed($feedGenerator, $feed, $feedDb->google_category);
                            $productCount++;
                        }
                    }
                }

            } else {
                $feed['sku'] = $product->sku;
                $feed['title'] = $product->title;
                $feed['content'] = $product->content;
                $feed['link'] = $product->publishUrl();
                $feed['image_link'] = $product->mainImage ? $product->mainImage['urls']['original'] : null;
                $feed['availability'] = $product->isAvailable() ? Availability::IN_STOCK : Availability::OUT_OF_STOCK;
                $feed['price'] = $product->price;
                $feed['regular_price'] = $product->regular_price;
                self::addProductFeed($feedGenerator, $feed, $feedDb->google_category);
                $productCount++;
            }
        }

        $feedXml = $feedGenerator->build();
        $publicDisk->put(self::UPLOAD_DIR . $feedDb->file_name . '.xml', $feedXml);

        $feedDb->product_count = $productCount;
        $feedDb->status = 'done';
        $feedDb->save();
    }

    public static function addProductFeed(&$feedGenerator, $feed, $category) {
//        if($feed['regular_price'] < 1.00) {
//            return;
//        }

        $item = new GoogleProduct();
        if($feed['sku']) {
            $item->setId($feed['sku']);
            $item->setMpn($feed['sku']);
        }

        if($feed['title']) {
            $item->setTitle($feed['title']);
        }

        if($feed['content']) {
            $item->setDescription($feed['content']);
        }

        if($feed['link']) {
            $item->setLink($feed['link']);
        }

        if($feed['image_link']) {
            $item->setImage($feed['image_link']);
        }

        $item->setAvailability($feed['availability']);

        if($feed['price']) {
            $item->setPrice($feed['price'] . " USD");
        }

        $item->setGoogleCategory($category);
        $item->setBrand('Tilton');
        $item->setCondition('new');

        $feedGenerator->addProduct($item);
    }

    public static function createFeedForHugeVariationItem($product, $varAttrs, $variantImageAttrs, $price) {
        $sku = $product->sku;
        if($product->sku_pattern) {
            foreach ($varAttrs as $attr => $opt) {
                $option = $product->getOption($attr, $opt);
                if($option) {
                    $sku = str_replace('%' . $attr . '%', $option->sku_part, $product->sku_pattern);
                }
            }
        }

        $image = $product->getVariantImage(Product::generateAttrHash($variantImageAttrs));

        $formatted_price = self::round_hv_price($price, $product);

        $feed['sku'] = $sku;
        $feed['title'] = $product->title;
        $feed['content'] = $product->content;
        $feed['link'] = $product->publishUrl();
        $feed['image_link'] = $image ? $image['urls']['original'] : null;
        $feed['availability'] = $product->isAvailable() ? Availability::IN_STOCK : Availability::OUT_OF_STOCK;
        $feed['price'] = $formatted_price;
        $feed['regular_price'] = $formatted_price;

        return $feed;
    }

    public static function round_hv_price($sum, $product)
    {
        $is_smooth = $product->is_smooth;
        $multiple = $is_smooth === 'is_smooth' ? 1.35 : 1.1;
        if (is_numeric($sum)) {
            $sum = $sum * $multiple;
            $int = floor($sum);
            $float = $sum - $int;
            if ($float < 0.5) {
                $sum = $int - 0.01;
            } else {
                $sum = $int + 0.99;
            }
        }
        return $sum;
    }
}
