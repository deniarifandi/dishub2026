<?php

namespace App\Controllers;

use App\Libraries\DataTable;


class Sisparma extends BaseController
{

    public function va_notify(){
            //  $clientID = "6992973c-c890-468e-9f14-c436c71bf5e2"; // 
            // $secretKey = "59242d81-0b43-4062-a393-1543cb97c934";
            $clientID = "6992973c-c890-468e-9f14-c436c71bf5e2"; // 
            $secretKey = "59242d81-0b43-4062-a393-1543cb97c934";
            //$partnerID = "46ec5f21-6b31-4bd8-81ed-5a79e323655a";

                header("Content-Type: application/json");

    // Get headers
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

    // echo $expectedSignature;
    // exit;

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

    public function store_payment(
    $latestTransactionStatus,
    $transactionStatusDesc,
    $virtualAccountNo,
    $amount,
    $coreReferenceNo,
    $transactionDate
) {
            $this->db = db_connect();
            $builder  = $this->db->table('transaksi');

            $exists = $builder->where('coreReferenceNo', $coreReferenceNo)->get()->getRow();
        if ($exists) return true;

        $data = [
            'latestTransactionStatus' => $latestTransactionStatus,
            'transactionStatusDesc'   => $transactionStatusDesc,
            'transaksi_va'            => $virtualAccountNo,
            'transaksi_nominal'       => is_array($amount) ? $amount['value'] : $amount,
            'coreReferenceNo'         => $coreReferenceNo,
            'transaksi_tanggal'       => $transactionDate
        ];

        $builder->insert($data);
        $id = $this->db->insertID();

        // if ($id) {
        //     try {
        //         $transaksi = new \App\Controllers\Transaksi();
        //         $transaksi->send_konfirmasi($id);
        //     } catch (\Exception $e) {
        //         log_message('error', 'Failed to send konfirmasi: ' . $e->getMessage());
        //     }
        // }

        return true;
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
