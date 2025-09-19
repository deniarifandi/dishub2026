<?php

namespace App\Libraries;

class Jatim
{

    private $db = null;
    private $clientID = null;
    private $timestamp = null;
    private $stringtosign = null;
    private $clientSecret = null;
    private $partnerID = null;
    private $accessToken = null;
    private $signature_access_token = null;
    private $service_url = null;
    private $serverUrl = null;
    private $tokenUrl = null;

    function __construct(){
        $this->db = db_connect();
        $this->db = db_connect();
        $this->service_url = "https://sriwijaya.bankjatim.co.id/snap/rest";
        date_default_timezone_set("Asia/Bangkok");
        
        //Dev
        $this->clientID = "6992973c-c890-468e-9f14-c436c71bf5e2";
        $this->clientSecret = "59242d81-0b43-4062-a393-1543cb97c934";
        $this->partnerID = "8d15dece-f183-483b-92e5-f2ef8a2dffaf";
        $this->partnerServiceId = "   11111";

        //Prod
        $this->clientID = "6fa131de-dd46-41d5-8046-238ca5b468d2";
        $this->clientSecret = "b9cc47be-3174-4b2b-82c5-e85ad3648501";
        $this->partnerID = "382465f8-a134-43eb-bbe0-03a50683b5aa";
        $this->partnerServiceId = "   10325";

        
        $this->getTimestamp();

        //jatim
        $this->serverUrl = "https://sriwijaya.bankjatim.co.id/snap/rest";
        //$this->tokenUrl = "https://sriwijaya.bankjatim.co.id/snap/rest/access_token/v1.0/b2b";

        $this->tokenUrl = "https://sriwijaya.bankjatim.co.id/snap/rest/access_token/v1.0/b2b";

        //$this->serverUrl = "https://sisparma.com/public"; //simulator
        //$this->tokenUrl = "https://sisparma.com/public/snap/rest/access_token/v1/b2b"; //simulator
        //trying

        // $this->serverUrl = "localhost/sisparmacustom/public";
        
    }
    
    ///////////////////////////////////////

   // public function createVA($customerNo, $vaNo, $vaName, $expired, $vaEmail, $vaPhone){
    public function createVA($customerNo, $vaNo, $vaName, $expired, $vaEmail,$vaPhone){

        $method = "POST";
        $url = "/api/v1.0/transfer-va/create-va";

        $baseUrl = $this->serverUrl.$url;
    
        //$customerNo = "1234567890123456999";
        //$vaNo = "1111112345678906789";
        //$vaName = "test nama";
        //$expired = "2026-12-31T23:59:59+07:00";
        //$vaEmail = "testemail@mail.test";
        //$vaPhone = "081805173445";

        $value = "100000000.00";
        $accessToken = $this->get_access_token();

        $requestBody = [
            "partnerServiceId" => $this->partnerServiceId,
            "customerNo" => $customerNo,
            "virtualAccountNo" => $vaNo,
            "virtualAccountName" => $vaName,
            "virtualAccountEmail" => $vaEmail,
            "virtualAccountPhone" => $vaPhone,
            "trxId" => date('YmdHis'),
            "totalAmount" => [
                "value" => $value,
                "currency" => "IDR"
            ],
            "virtualAccountTrxType" => "I",
            "expiredDate" => $expired
        ];
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer ".$accessToken,
            "X-CLIENT-KEY: 6992973c-c890-468e-9f14-c436c71bf5e2",
            "X-SIGNATURE: ".$this->signature_service($method, $url, $requestBody, $accessToken),
            "X-TIMESTAMP: $this->timestamp",
            "X-PARTNER-ID: 8d15dece-f183-483b-92e5-f2ef8a2dffaf",
            "X-EXTERNAL-ID: ".date('YmdHis'),
            "CHANNEL-ID: 00002"
        ];

        $method = "POST";  // Can be 'GET', 'POST', '', etc.

        $response = $this->callApi($baseUrl, $headers, $method, $requestBody);
         return $response;
    }

    function updateVA($customerNo, $vaNo, $vaName, $expired, $vaEmail,$vaPhone){

        $url = "/api/v1.0/transfer-va/update-va";
        $baseUrl = $this->serverUrl.$url;
        $method = "PUT";
       
        // $customerNo = $_POST["custNo"];
        // $vaNo = $_POST["vaNo"];
        // $vaName = $_POST["vaName"];
         $value = "100000000.00";
        // $expired = $_POST['expired'];
        // $vaEmail = $_POST['vaEmail'];
        // $vaPhone = $_POST['hp'];

        // $customerNo = "1234567890123456999";
        //$vaNo = "1111112345678906789";
        //$vaName = "test nama";
        // $expired = "2026-12-31T23:59:59+07:00";
        // $vaEmail = "testemail@mail.test";
        // $vaPhone = "081805173445";

        $accessToken = $this->get_access_token();

        $requestBody = [
            "partnerServiceId" => $this->partnerServiceId,
            "customerNo" => $customerNo,
            "virtualAccountNo" => $vaNo,
            "virtualAccountName" => $vaName,
            "virtualAccountEmail" => $vaEmail,
            "virtualAccountPhone" => $vaPhone,
            "trxId" => date('YmdHis'),
            "totalAmount" => [
                "value" => $value,
                "currency" => "IDR"
            ],

            "virtualAccountTrxType" => "I",
            "expiredDate" => $expired,
        ];
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer ".$accessToken,
            "X-CLIENT-KEY: 6992973c-c890-468e-9f14-c436c71bf5e2",
            "X-SIGNATURE: ".$this->signature_service($method, $url, $requestBody, $accessToken),
            "X-TIMESTAMP: $this->timestamp",
            "X-PARTNER-ID: 8d15dece-f183-483b-92e5-f2ef8a2dffaf",
            "X-EXTERNAL-ID: ".date('YmdHis'),
            "CHANNEL-ID: 00002"
        ];

        $method = "PUT";  // Can be 'GET', 'POST', 'PUT', etc.

        $response = $this->callApi($baseUrl, $headers, $method, $requestBody);
        return $response;
            
    }

    function deleteVA($customerNo, $vaNo){

        $url = "/api/v1.0/transfer-va/delete-va";
        $baseUrl = $this->serverUrl.$url;
        $method = "DELETE";

       $accessToken = $this->get_access_token();

       $requestBody = [
        "partnerServiceId" => $this->partnerServiceId,
        "customerNo" => $customerNo,
        "virtualAccountNo" => $vaNo,
        "trxId" => date('YmdHis')
    ];

            // echo json_encode($requestBody);
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer ".$accessToken,
        "X-CLIENT-KEY: 6992973c-c890-468e-9f14-c436c71bf5e2",
        "X-SIGNATURE: ".$this->signature_service($method, $url, $requestBody, $accessToken),
        "X-TIMESTAMP: $this->timestamp",
        "X-PARTNER-ID: 8d15dece-f183-483b-92e5-f2ef8a2dffaf",
        "X-EXTERNAL-ID: ".date('YmdHis'),
        "CHANNEL-ID: 00002"
    ];

            // $method = "DELETE";  // Can be 'GET', 'POST', 'PUT', etc.

    $response = $this->callApi($baseUrl, $headers, $method, $requestBody);
    return $response;            
    
    }

    function inquiryva(){

        $vaNo = "1111112548164517";
        
        $method = "POST";
        $url = "/api/v1.0/transfer-va/inquiry-va";
        $baseUrl = $this->serverUrl.$url;
        $customerNo = substr($vaNo, 5);
        
        $trxId = "johnlenon";

        $accessToken = $this->get_access_token();
        
        $requestBody = [
            "partnerServiceId" => " 11111",
            "customerNo" => $customerNo,
            "virtualAccountNo" => $vaNo,
            "trxId" => $trxId
        ];

        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer ".$accessToken,
            // "X-CLIENT-KEY: 6992973c-c890-468e-9f14-c436c71bf5e2",
            "X-SIGNATURE: ".$this->signature_service($method, $url, $requestBody, $accessToken),
            "X-TIMESTAMP: $this->timestamp",
            "X-PARTNER-ID: 8d15dece-f183-483b-92e5-f2ef8a2dffaf",
            "X-EXTERNAL-ID: ".date('YmdHis'),
            "CHANNEL-ID: 00002"
        ];


        $method = "POST";  // Can be 'GET', 'POST', 'PUT', etc.

        $response = $this->callApi($baseUrl, $headers, $method, $requestBody);
        return $response;
        // print_r($response);
    }

    ///////////////////////////////

    public function getSignature(){
        echo "test";
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function get_access_token(){
        $url = $this->tokenUrl;
     // $url = "https://sriwijaya.bankjatim.co.id/snap/rest/access_token/v1/b2b";
        $headers = [
            "Content-Type: application/json",
            "X-CLIENT-KEY: 6992973c-c890-468e-9f14-c436c71bf5e2",
            "X-SIGNATURE: ".$this->signature_access_token(),
            "X-TIMESTAMP: $this->timestamp"
        ];
        $method = "POST";  // Can be 'GET', 'POST', 'PUT', etc.
        $data = [
            "grantType" => "client_credentials",
            "additionalInfo" => (object)[]
        ];

        $response = $this->callApi($url, $headers, $method, $data);
        $tokenArray = json_decode($response, true);
        print_r($response);
        
        //$this->accessToken = $tokenArray['accessToken'];
        //return $tokenArray['accessToken'];
        
    }

    function getTimestamp(){
        $this->timestamp = (new \DateTime())->format(\DateTime::ATOM);
    }

    function encryptWithHmacSHA512($plainText, $secretKey) {
        $hash = hash_hmac('sha512', $plainText, $secretKey, true);
        $base64Hash = base64_encode($hash);
        return $base64Hash;
    }

    function signature_access_token(){

        $stringtosign = $this->clientID."|".$this->timestamp;
        $signature_access_token = $this->encryptWithHmacSHA512($stringtosign, $this->clientSecret);
        return $signature_access_token;
    }

    function signature_service($method, $url, $requestBody, $accessToken){

        $requestBodyEncode = json_encode($requestBody);

            //Step 1: Minify request body by removing whitespaces
        $minifiedRequestBody = json_encode(json_decode($requestBodyEncode));

            // Step 2: Generate SHA-256 hash of minified request body
        $hashedRequestBody = hash("sha256", $minifiedRequestBody);

            // Step 3: Convert hash to lowercase hexadecimal
        $lowercaseHexHash = strtolower($hashedRequestBody);

            // Step 4: Concatenate all components
        $signature = $method . ":" . $url . ":" . $accessToken . ":".$lowercaseHexHash.":". $this->timestamp;

        $xsignature = $this->encryptWithHmacSHA512($signature,$this->clientSecret);
        return $xsignature;

    }

    function callApi($url, $headers = [], $method = 'GET', $data = null) {
    // Add X-TIMESTAMP with ISO 8601 date
    //$timestamp = (new DateTime())->format(DateTime::ATOM); // ISO 8601 format
    //$headers[] = "X-TIMESTAMP: $timestamp";

        $ch = curl_init($url);

    // Set request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    // Attach headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // If there's data for POST or PUT, attach it to the request
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

    // Return response instead of outputting it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request and capture the response
        $response = curl_exec($ch);

    // Check for errors
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

    // Close the cURL session
        curl_close($ch);

        return $response;
    }
}
