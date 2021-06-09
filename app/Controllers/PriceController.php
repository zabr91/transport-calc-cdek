<?php

namespace TransportCalcCDEK\Controllers;

use WPMVC\MVC\Controller;
use TransportCalcCDEK\Models;
/**
 * PriceController
 * WordPress MVC controller.
 *
 * @author Ivan Zabroda <zabr91.github.io>
 * @package transport-calc-cdek
 * @version 1.0.0
 */
class PriceController extends Controller
{
    /**
     * @since 1.0.0
     *
     *
     * @return
     */
    public function init()
    {
    }
    /**
     * @since 1.0.0
     *
     *
     * @return
     */
    public function get_price()
    {
     //  var_dump($_POST['senderCityId']);

        $set = get_option('transportcalccdek');

        $login = $set['cdek_authLogin'];
        $client_secret =$set['cdek_secure'];
        $calculator = new Models\CDEKApiCalc($login, $client_secret);

        $fromLocation = isset($_POST['senderCityId']) ? $_POST['senderCityId'] : 0 ;
        $toLocation = isset($_POST['receiverCityId']) ? $_POST['receiverCityId'] : 0;
        $goods = isset($_POST['goods']) ? $_POST['goods'] : 0;
        $cod_cost = isset($_POST['cod_cost']) ? $_POST['cod_cost'] : 0;



        echo $calculator->getResult($fromLocation, $toLocation, $goods,  $cod_cost);

       // exit();
        wp_die();
    }
}