<?php

// app/Libraries/WAService.php
namespace App\Libraries;

class Whatsapp
{
     public function sendMessage($recipient, $nama, $nominal, $tanggal,$lokasi, $idtransaksi)
    {
        $accessToken = 'EAAcbbjv93u0BPG4iGeq3HUY7FldKMfZByJ9ZCPCfPZAm5ZAgEoZA0ZCqN3Dm8rkCYuefOn8L7006u1LSB6mP4YcyGrNg5n3V71owApSwCtdAwerz4SB7REIAYzjjTNxnvCua6SMgVXNx2oZAAZCA0XsJqW3Cp4i4tnczXAXRoMZCvpKJSgEMLzka8d7RjUmI3j8Eei8v6YLBZAK9PB4ZC30X0tSZAfPIMGnZAHr2aW866clRZBlNuoPHZAfTyK4Y2q9fmsa54EZD';
        $phoneNumberId = '631443813396840';
        $recipient = '6283834171938'; // international format

        $url = "https://graph.facebook.com/v19.0/$phoneNumberId/messages";

         $data = [
        "messaging_product" => "whatsapp",
        "to" => $recipient,
        "type" => "template",
        "template" => [
            "name" => "pembayaran_diterima", // your approved template name
            "language" => [
                "code" => "id"
            ],
            "components" => [
                [
                    "type" => "body",
                    "parameters" => [
                        [ "type" => "text", "text" => $nama ],
                        [ "type" => "text", "text" => $lokasi ],
                        [ "type" => "text", "text" => $nominal ],
                        [ "type" => "text", "text" => $tanggal ]
                    ]
                ],
                [
                    "type" => "button",
                    "sub_type" => "url",
                    "index" => 0,
                    "parameters" => [
                        [ "type" => "text", "text" => $idtransaksi ] // dynamic part of the URL
                    ]
                ]
            ]
        ]
    ];

        $headers = [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            echo "Response:\n$response";
        }

        curl_close($ch);
    }


    public function webhook(){
           $request = service('request');

        // Untuk verifikasi dari Meta
        if ($request->getMethod() === 'get' && $request->getGet('hub_mode')) {
            $verifyToken = 'ocueo8fu9oe8udo3e9udeo9uoea4u8heo243aoc223532uheochu9u8aeodue9o8u'; // Ubah sesuai token yang kamu daftarkan di Meta

            if (
                $request->getGet('hub_mode') === 'subscribe' &&
                $request->getGet('hub_verify_token') === $verifyToken
            ) {
                return $this->response->setBody($request->getGet('hub_challenge'));
            } else {
                return $this->failForbidden('Invalid verify token');
            }
        }

        // Tangkap body JSON saat ada pesan masuk
        $json = $request->getJSON(true); // true => array

        // Simpan ke log (opsional, bisa disimpan ke DB juga)
        log_message('info', 'Webhook received: ' . json_encode($json));

        // Contoh mengambil pesan teks
        if (isset($json['entry'][0]['changes'][0]['value']['messages'])) {
            $messages = $json['entry'][0]['changes'][0]['value']['messages'];

            foreach ($messages as $msg) {
                $from = $msg['from']; // nomor pengirim
                $body = $msg['text']['body'] ?? ''; // isi pesan teks

                // Lakukan sesuatu, misalnya:
                log_message('info', "Pesan dari $from: $body");
            }
        }

        return $this->respond(['status' => 'ok'], 200);
    }
}
