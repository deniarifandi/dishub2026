<?php

namespace App\Controllers;

use App\Libraries\DataTable;


class Sisparma extends BaseController
{

    public function va_notify(){
            $clientID = "d3f92b7e-8a4c-4e6a-9f21-3b2d1c5e8a7f";
            $secretKey = "4a7c9e2f1b6d8f0a3c5e7b9d2f6a1c8b";

                header("Content-Type: application/json");
                $headers = getallheaders();

                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Method Not Allowed
        echo json_encode([
            "responseCode" => "4050001",
            "responseMessage" => "Method Not Allowed. Please use POST"
        ]);
        exit;
    }

    // Check if required headers are present
    if (!isset($headers['X-TIMESTAMP'], $headers['X-SIGNATURE'], $headers['X-PARTNER-ID'], $headers['X-EXTERNAL-ID'])) {
        http_response_code(400);
        echo json_encode([
            "responseCode" => "4000001",
            "responseMessage" => "Missing required headers"
        ]);
        exit;
    }

    // Validate X-SIGNATURE
    $timestamp = $headers['X-TIMESTAMP'];

    //$expectedSignature = base64_encode($clientID . "|" . $timestamp);
    $sts = $clientID . "|" . $timestamp;
    $expectedSignature = $this->encryptWithHmacSHA512($sts,$secretKey);

    //echo $expectedSignature;

    if ($headers['X-SIGNATURE'] !== $expectedSignature) {
        http_response_code(401);
        echo json_encode([
            "responseCode" => "4010001",
            "responseMessage" => "Unauthorized. Invalid signature"
        ]);
        exit;
    }

    // Read and decode JSON input
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    // Validate JSON body structure
    if (!isset($data['latestTransactionStatus'], $data['transactionStatusDesc'], $data['virtualAccountNo'], $data['amount'], $data['coreReferenceNo'], $data['transactionDate'])) {
        http_response_code(400);
        echo json_encode([
            "responseCode" => "4000002",
            "responseMessage" => "Invalid JSON structure"
        ]);
        exit;
    }

    // Process the request (add your logic here)

    $data['transactionDate'] = (new \DateTime())->format(\DateTime::ATOM);

    $this->store_payment($data['latestTransactionStatus'], $data['transactionStatusDesc'], $data['virtualAccountNo'], $data['amount'], $data['coreReferenceNo'], $data['transactionDate']);

    $responseCode = "2000000";
    $responseMessage = "Request has been processed successfully";

    // Send JSON response
    http_response_code(200);
    echo json_encode([
        "responseCode" => $responseCode,
        "responseMessage" => $responseMessage
    ]);
    }

    public function store_payment($latestTransactionStatus, $transactionStatusDesc,$virtualAccountNo,$amount,$coreReferenceNo,$transactionDate){
    $this->db = db_connect();
    $builder = $this->db->table('transaksi');
    $data = [
        'latestTransactionStatus' => $latestTransactionStatus,
        'transactionStatusDesc'   => $transactionStatusDesc,
        'transaksi_va'            => $virtualAccountNo,
        'transaksi_nominal'       => $amount['value'],
        'coreReferenceNo'         => $coreReferenceNo,
        'transaksi_tanggal'       => $transactionDate
    ];
    $builder->insert($data);

    // Get the inserted ID
    $id = $this->db->insertID();

    // Call sendKonfirmasi with new ID
    $transaksi = new \App\Controllers\Transaksi();
    $result = $transaksi->send_konfirmasi($id);
}


    function signature_service($method, $url, $requestBody, $accessToken){

    $requestBodyEncode = json_encode($requestBody);

        //Step 1: Minify request body by removing whitespaces
    $minifiedRequestBody = json_encode(json_decode(json)($requestBodyEncode));

        // Step 2: Generate SHA-256 hash of minified request body
    $hashedRequestBody = hash("sha256", $minifiedRequestBody);

        // Step 3: Convert hash to lowercase hexadecimal
    $lowercaseHexHash = strtolower($hashedRequestBody);

        // Step 4: Concatenate all components
    $signature = $method . ":" . $url . ":" . $accessToken . ":".$lowercaseHexHash.":". $this->timestamp;

    $xsignature = $this->encryptWithHmacSHA512($signature,$this->clientSecret);
    return $xsignature;

}   

    function encryptWithHmacSHA512($plainText, $secretKey) {
    // Generate the HMAC SHA-512 hash
        $hash = hash_hmac('sha512', $plainText, $secretKey, true);
        
        // Encode the hash in Base64
        $base64Hash = base64_encode($hash);
        
        return $base64Hash;
    }

}
