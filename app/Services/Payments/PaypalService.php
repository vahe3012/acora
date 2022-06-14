<?php
namespace App\Services\Payments;

class PaypalService {

    private $client;

    public function __construct()
    {
//        $this->client = new PayPalHttpClient(self::environment());
    }


    public static function client() {
        return app(PaypalService::class)->client;
    }

    public static function getConfig()
    {
        $config = array(
            // values: 'sandbox' for testing
            //		   'live' for production
            //         'tls' for testing if your server supports TLSv1.2
            "mode" => "sandbox",
            // TLSv1.2 Check: Comment the above line, and switch the mode to tls as shown below
            // "mode" => "tls"

            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'FINE'

            // These values are defaulted in SDK. If you want to override default values, uncomment it and add your value.
            // "http.ConnectionTimeOut" => "5000",
            // "http.Retry" => "2",
        );
        return $config;
    }

    // Creates a configuration array containing credentials and other required configuration parameters.
    public static function getAcctAndConfig()
    {
        $config = array(
             "acct1.UserName" => "sb-ctcir8919270_api1.business.example.com",
             "acct1.Password" => "KFFPF989MTJVDGWT",
             "acct1.CertPath" => public_path("paypal_cert.pem"),
//             "acct1.Subject" => "",
        );

        return array_merge($config, self::getConfig());
    }

    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "PAYPAL-SANDBOX-CLIENT-ID";
        $clientSecret = getenv("CLIENT_SECRET") ?: "PAYPAL-SANDBOX-CLIENT-SECRET";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
