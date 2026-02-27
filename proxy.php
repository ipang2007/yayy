<?php

$API_KEY = "otp_KHxwkgdnEdijaUSu";

$target = $_GET['target'];
$id = $_GET['id'];

if(!$target || !$id){
    echo json_encode(["status"=>false,"message"=>"Parameter kurang"]);
    exit;
}

$url = "https://www.rumahotp.com/api/v1/h2h/transaksi/create?target=$target&id=$id";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "x-apikey: $API_KEY",
    "Accept: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;
