<?php

include_once '../Models/CDEKCalculator.php';
$client_id = 'epT5FMOa7IwjjlwTc1gUjO1GZDH1M1rE';
$client_secret = 'cYxOu9iAMZYQ1suEqfEvsHld4YQzjY0X';
$calculator = new CDEKCalculator($client_id, $client_secret, true);



$fromLocation = $_POST['senderCityId'];
$toLocation = $_POST['receiverCityId'];
$goods = $_POST['goods'];
$cod_cost = $_POST['cod_cost'];

echo $calculator->getResult($fromLocation, $toLocation, $goods);

//echo json_encode($goods);

