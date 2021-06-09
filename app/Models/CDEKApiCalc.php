<?php

namespace TransportCalcCDEK\Models;

use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\PostModel as Model;

/**
 * CDEKApiCalc model.
 * WordPress MVC model.
 *
 * @author Ivan Zabroda <zabr91.github.io>
 * @package transport-calc-cdek
 * @version 1.0.0
 */
class CDEKApiCalc extends Model
{
    use FindTrait;

    private $authLogin = null;
    private $secure = null;

    /* for marge to database */
    private $tarifs = [//ИМ
        7 => 'Международный экспресс документы дверь-дверь',
        8 => 'Международный экспресс грузы дверь-дверь',
        136 => 'Посылка склад-склад',
        137 => 'Посылка склад-дверь',
        138 => 'Посылка дверь-склад',
        139 => 'Посылка дверь-дверь',
        233 => 'Экономичная посылка склад-дверь',
        234 =>'Экономичная посылка склад-склад',

        //Тарифы для обычной доставки
        1 => 'Экспресс лайт дверь-дверь',
        361 => 'Экспресс лайт дверь-постамат',
        363 => 'Экспресс лайт склад-постамат',
        3 => 'Супер-экспресс до 18',
        5 => 'Экономичный экспресс склад-склад',
        10 => 'Экспресс лайт склад-склад',
        11 => 'Экспресс лайт склад-дверь',
        12 => 'Экспресс лайт дверь-склад',
        15 => 'Экспресс тяжеловесы склад-склад ',
        16 => 'Экспресс тяжеловесы склад-дверь ',
        17 => 'Экспресс тяжеловесы дверь-склад ',
        18 => 'Экспресс тяжеловесы дверь-дверь ',
        57 => 'Супер-экспресс до 9',
        58 => 'Супер-экспресс до 10',
        59 => 'Супер-экспресс до 12',
        60 => 'Супер-экспресс до 14',
        61 => 'Супер-экспресс до 16',
        62 => 'Магистральный экспресс склад-склад',
        63 => 'Магистральный супер-экспресс склад-склад',
        118 => 'Экономичный экспресс дверь-дверь',
        119 => 'Экономичный экспресс склад-дверь',
        120 => 'Экономичный экспресс дверь-склад',
        121 => 'Магистральный экспресс дверь-дверь',
        122 => 'Магистральный экспресс склад-дверь',
        123 => 'Магистральный экспресс дверь-склад',
        124 => 'Магистральный супер-экспресс дверь-дверь',
        125 => 'Магистральный супер-экспресс склад-дверь',
        126 => 'Магистральный супер-экспресс дверь-склад',
        480 => 'Экспресс дверь-дверь',
        481 => 'Экспресс дверь-склад',
        482 => 'Экспресс склад-дверь',
        483 => 'Экспресс склад-склад',
        485 => 'Экспресс дверь-постамат',
        486 => 'Экспресс склад-постамат',];

    private function getTarifList(){
        $list = [];
        foreach ($this->tarifs as $index => $value){
            $list[] = ['id' => $index];
        }

        return json_encode($list);
    }

    private $exitResult = [
        'services' => [
            [
                'name' => 'Супер-экспресс до 12',
                'pattern' => '/^Супер.экспресс.до.12/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Супер-экспресс до 14',
                'pattern' => '/^Супер.экспресс.до.14/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Супер-экспресс до 16',
                'pattern' => '/^Супер.экспресс.до.16/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Супер-экспресс лайт 12',
                'pattern' => '/Супер.экспресс.лайт.12/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Супер-экспресс лайт 14',
                'pattern' => '/^Супер.экспресс.лайт.14/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Супер-экспресс лайт 18',
                'pattern' => '/^Супер.экспресс.лайт.18/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Экспресс',
                'pattern' => '/^Экспресс.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Экспресс-лайт',
                'pattern' => '/^Экспресс.лайт.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Посылка',
                'pattern' => '/^Посылка.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Магистральный экспресс',
                'pattern' => '/^Магистральный.экспресс.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Магистральный супер-экспресс',
                'pattern' => '/^Магистральный.супер-экспресс.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Экспресс тяжеловесы',
                'pattern' => '/^Экспресс.тяжеловесы.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name' => 'Экономичная посылка',
                'pattern' => '/^Экономичная.посылка.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            /*[
                'name'=> 'Магистральный экспресс',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name'=> 'Магистральный супер-экспресс',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name'=> 'Экономичная посылка',
                'periodMin' => 0,
                'periodMax' => 0,
            ],
            [
                'name'=> 'Магистральный супер-экспресс',
                'periodMin' => 0,
                'periodMax' => 0,
            ],*/
        ]
    ];

    private $types = [
        '/дверь-дверь$/' => 'doorToDoor',
        '/склад-дверь$/' => 'warehouseToDoor',
        '/дверь-склад$/' => 'doorToWarehouse',
        '/склад-склад$/' => 'warehouseToWarehouse',
        '/Супер.экспресс.до.12/' => 'doorToDoor',
        '/Супер.экспресс.до.14/' => 'doorToDoor',
    ];

    /**
     * Get data from API
     *
     * @link https://confluence.cdek.ru/pages/viewpage.action?pageId=15616129
     *
     */
    private function getPrice($json)
    {
        $url = 'http://api.cdek.ru/calculator/calculate_tarifflist.php';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json')
        );
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }


    public function __construct($_authLogin, $_secure)
    {
        if (isset($_authLogin)) {
            $this->authLogin = $_authLogin;
        }

        if (isset($_secure)) {
            $this->secure = $_secure;
        }
    }

    /**
     * Get results form CDEK API v 1.5
     */
    public function getResult($fromLocation = 270, $toLocation = 44, $goods, $cod_cost)
    {
        $dataNow = date('Y-m-d');
        $json_goods = json_encode($goods);

        $parmsByContract = '{
        "version": "1.0",
        "receiverCityId": ' . $fromLocation . ',
        "senderCityId": ' . $toLocation . ',
        "authLogin": "' . $this->authLogin . '",
        "secure": "' . $this->secure . '",
        "currency": "RUB",
        "dateExecute": "' . $dataNow . '",
        "tariffList":' . $this->getTarifList() . ',
        "goods": ' . $json_goods . '
    }';

        $parmsByFree = '{
        "version": "1.0",
        "receiverCityId": ' . $fromLocation . ',
        "senderCityId": ' . $toLocation . ',
        "currency": "RUB",
        "dateExecute": "' . $dataNow . '",
        "tariffList":' . $this->getTarifList() . ',
        "goods": ' . $json_goods . '
    }';

        if ($cod_cost > 0) { //  * 0.075
            $cod_cost = round($cod_cost / 133.33333333, 1);
        }

        $priceByContract = $this->getPrice($parmsByContract);
        $priceByFree = $this->getPrice($parmsByFree);



        for ($services = 0; $services < count($this->exitResult['services']); $services++)
        {
            for($tarifs = 0; $tarifs < count($priceByContract["result"]); $tarifs++)
            {

                $tarifName = $this->tarifs[$priceByContract["result"][$tarifs]["tariffId"]];

                $pattern = $this->exitResult['services'][$services]['pattern'];

                if(preg_match($pattern, $tarifName) > 0)
                {
                    foreach ($this->types as $index => $type) {

                        if(preg_match($index, $tarifName) > 0)
                        {
                            $price = [];
                            $flagNoPrice = 0;

                            if($priceByContract["result"][$tarifs]["status"])
                            {
                                $price[0] = $priceByContract["result"][$tarifs]["result"]["price"];
                                $this->exitResult['services'][$services]['periodMin'] = $priceByContract["result"][$tarifs]["result"]["deliveryPeriodMin"];
                                $this->exitResult['services'][$services]['periodMax'] = $priceByContract["result"][$tarifs]["result"]["deliveryPeriodMax"];

                            }
                            else{
                                $price[0] = 'X';
                                $flagNoPrice++;
                            }

                            if($priceByFree["result"][$tarifs]["status"]){
                                $price[1] = $priceByFree["result"][$tarifs]["result"]["price"];
                            }
                            else{
                                $price[1] = 'X';
                                $flagNoPrice++;
                            }

                            if($flagNoPrice != 2){
                                $this->exitResult['services'][$services][$type] =
                                    [
                                        'price' => $price
                                    ];
                            }

                        }

                    }

                }

            }
        }

        return json_encode($this->exitResult);
    }
}