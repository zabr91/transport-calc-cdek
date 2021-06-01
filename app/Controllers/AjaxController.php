<?php

include_once '../Models/CDEKCalculator.php';
$client_id = 'epT5FMOa7IwjjlwTc1gUjO1GZDH1M1rE';
$client_secret = 'cYxOu9iAMZYQ1suEqfEvsHld4YQzjY0X';
$calculator = new CDEKCalculator($client_id, $client_secret, true);



$fromLocation = isset($_POST['senderCityId']) ? $_POST['senderCityId'] : 0 ;
$toLocation = isset($_POST['receiverCityId']) ? $_POST['receiverCityId'] : 0;
$goods = isset($_POST['goods']) ? $_POST['goods'] : 0;
$cod_cost = isset($_POST['cod_cost']) ? $_POST['cod_cost'] : 0;

echo $calculator->getResult($fromLocation, $toLocation, $goods);

//echo json_encode($goods);

