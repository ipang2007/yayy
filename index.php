<?php
// =========================
// CONFIG
// =========================
$API_KEY = "otp_KHxwkgdnEdijaUSu";

// =========================
// HANDLE AJAX REQUEST
// =========================
if(isset($_GET['action']) && $_GET['action'] == "kirim"){

    header('Content-Type: application/json');

    if(empty($_GET['target']) || empty($_GET['id'])){
        echo json_encode(["status"=>false,"message"=>"Parameter tidak lengkap"]);
        exit;
    }

    $target = $_GET['target'];
    $id = $_GET['id'];

    $url = "https://www.rumahotp.com/api/v1/h2h/transaksi/create?target=$target&id=$id";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "x-apikey: $API_KEY",
        "Accept: application/json"
    ]);

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        echo json_encode(["status"=>false,"error"=>curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    echo $response;
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Transaksi OTP</title>

<style>
body{
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}
.box{
    background:#fff;
    width:380px;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}
h2{
    text-align:center;
    margin-bottom:20px;
}
input{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border-radius:8px;
    border:1px solid #ddd;
}
button{
    width:100%;
    padding:12px;
    background:#2a5298;
    border:none;
    color:#fff;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
}
button:hover{
    background:#1e3c72;
}
.result{
    margin-top:15px;
    background:#f4f6f9;
    padding:10px;
    border-radius:8px;
    font-size:13px;
    white-space:pre-wrap;
    max-height:180px;
    overflow:auto;
}
</style>
</head>
<body>

<div class="box">
    <h2>Transaksi OTP</h2>

    <input type="text" id="target" placeholder="Nomor Target (628xxxx)">
    <input type="text" id="productId" placeholder="ID Produk">

    <button onclick="kirim()">Kirim Transaksi</button>

    <div class="result" id="result">Menunggu transaksi...</div>
</div>

<script>
async function kirim(){

    const target = document.getElementById("target").value;
    const productId = document.getElementById("productId").value;
    const resultBox = document.getElementById("result");

    if(!target || !productId){
        resultBox.textContent = "Isi nomor & ID produk dulu.";
        return;
    }

    resultBox.textContent = "Memproses transaksi...";

    try{
        const response = await fetch(`?action=kirim&target=${target}&id=${productId}`);
        const text = await response.text();
        resultBox.textContent = text;
    }
    catch(err){
        resultBox.textContent = "ERROR: " + err;
    }
}
</script>

</body>
</html>
