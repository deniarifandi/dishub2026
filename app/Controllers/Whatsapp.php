<?php 

namespace App\Controllers;

class Whatsapp extends BaseController
{
    public function send($recipient, $nama, $nominal, $keterangan, $idtransaksi)
    {
        $accessToken = 'EAAcbbjv93u0BPEuUSmCXAHKJVnM4csf8ZBliVEAt3UpsaqJCFx3KeOWO453s4ZAKdZAWShxZAaRXYc3a7jMVW4sgSDOj7S0nfIUJ2ZA6sgEYCXIj6uYaAGd9Jk8JYkNGdCfaUoBZBwGSXhpzAQX8DRyjPvV9G7neaCDhVDrb0vXfqM7pn6jQelrX6f6HEBgL5OZAYwcWOx9Dc9ZBZAElrZBUWikiexqpXqGePHzqNZA8G8NWmG135dF32Iy9KkeBHWLOwZDZD';
        $phoneNumberId = '631443813396840';
        $recipient = '6283834171938'; // international format

        $url = "https://graph.facebook.com/v19.0/$phoneNumberId/messages";

         $data = [
        "messaging_product" => "whatsapp",
        "to" => $recipient,
        "type" => "template",
        "template" => [
            "name" => "konfirmasi_pembayaran", // your approved template name
            "language" => [
                "code" => "id"
            ],
            "components" => [
                [
                    "type" => "body",
                    "parameters" => [
                        [ "type" => "text", "text" => $nama ],
                        [ "type" => "text", "text" => $nominal ],
                        [ "type" => "text", "text" => $keterangan ]
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
}
