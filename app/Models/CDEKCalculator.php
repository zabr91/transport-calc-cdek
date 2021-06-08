<?php
/**
* Divelery Calulator with API CDEK version 2.0
*
* @link https://confluence.cdek.ru/pages/viewpage.action?pageId=29923741
*/

include_once 'CDEKAuthorization.php';

class CDEKCalculator extends CDEKAuthorization
{
    //private $baseUrl = 'https://api.cdek.ru/';

    const TYPE_INTERNET_SHOP = 1;
    const TYPE_DELIVERY = 2;

  /*  private $exitResult = [
        'Посылка' => null,
        'Экспресс-лайт' => null,
        'Магистральный экспресс' => null,
        'Экономичная посылка' => null
    ];*/

    /**
     * Enter client data
     *
     * @parm string $client_id Account
     * @parm string $client_secret Secure password
     * @parm bool $debug choose connection database (false = api.cdek.ru, true = api.edu.cdek.ru)
     *
     * @link https://confluence.cdek.ru/pages/viewpage.action?pageId=29923849
     */

    function __construct($client_id, $client_secret, $debug = false)
    {
        parent::__construct($client_id, $client_secret, $debug);
    }

    /**
     *
     * Get cost delivery
     *
     * @return string json
     *
     * @link https://confluence.cdek.ru/pages/viewpage.action?pageId=63345519
     *
     * @throws Exception if access token is null
     */
    public function getCostDeliveryByTrarrifs($fromLocation = 270, $toLocation = 44, $goods, $type = self::TYPE_DELIVERY, $cod_cost)
    {
        if(!$this->getAccessToken())
        {
            throw new Exception("Error authorization");
        }

        for ($i = 0; $i < count($goods); $i++)
        {
            $goods[$i]['weight'] = $goods[$i]['weight'] * 1000;
        }

        $json_goods = json_encode($goods);

        $url =  $this->baseUrl . 'v2/calculator/tarifflist';

        $json =
            '{
    "type": '.$type.',
    "currency": 1,
    "lang": "rus",
    "from_location": {
        "code": '.$fromLocation.'
    },
    "to_location": {
        "code": '.$toLocation.'
    },
    "packages": '.$json_goods.'
}';

        $ch = curl_init($url);
        $payload = $json;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                'Authorization: bearer ' . $this->getAccessToken())
        );
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.

        return $result;
    }

    public function getResult($fromLocation = 270, $toLocation = 44, $goods, $type = self::TYPE_DELIVERY, $cod_cost){

        $jsonResult = $this->getCostDeliveryByTrarrifs($fromLocation, $toLocation, $goods, $type, $cod_cost);

     // return $jsonResult;

        $arr = json_decode($jsonResult, true);

        if($cod_cost > 0){ //  * 0.075
            $cod_cost = round($cod_cost / 133.33333333, 1);
        }

        $exitResult = [
            'services' =>[
                [
                    'name'=> 'Супер-экспресс до 12',
                    'pattern' => '/^Супер.экспресс.до.12/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Супер-экспресс до 14',
                    'pattern' => '/^Супер.экспресс.до.14/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Супер-экспресс до 16',
                    'pattern' => '/^Супер.экспресс.до.16/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
               [
                    'name'=> 'Супер-экспресс лайт 12',
                    'pattern' => '/Супер.экспресс.лайт.12/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Супер-экспресс лайт 14',
                    'pattern' => '/^Супер.экспресс.лайт.14/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Супер-экспресс лайт 18',
                    'pattern' => '/^Супер.экспресс.лайт.18/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Экспресс',
                    'pattern' => '/^Экспресс.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Экспресс-лайт',
                    'pattern' => '/^Экспресс.лайт.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Посылка',
                    'pattern' => '/^Посылка.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Магистральный экспресс',
                    'pattern' => '/^Магистральный.экспресс.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Магистральный супер-экспресс',
                    'pattern' => '/^Магистральный.супер-экспресс.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                       'name'=> 'Экспресс тяжеловесы',
                    'pattern' => '/^Экспресс.тяжеловесы.[дверь.дверь|склад.дверь|дверь.склад|склад.склад]/',
                       'periodMin' => 0,
                       'periodMax' => 0,
                   ],
                [
                    'name'=> 'Экономичная посылка',
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
        $types =[
            '/дверь-дверь$/' => 'doorToDoor',
            '/склад-дверь$/' => 'warehouseToDoor',
            '/дверь-склад$/' => 'doorToWarehouse',
            '/склад-склад$/' => 'warehouseToWarehouse',
            '/Супер.экспресс.до.12/' => 'doorToDoor',
            '/Супер.экспресс.до.14/' => 'doorToDoor',
        ];



        for ($services = 0; $services < count($exitResult['services']); $services++){
            for($tarifs = 0; $tarifs < count($arr["tariff_codes"]); $tarifs++){

                $pattern = $exitResult['services'][$services]['pattern'];


                if(preg_match($pattern, $arr["tariff_codes"][$tarifs]['tariff_name']) > 0)
                {
                    //echo  $arr["tariff_codes"][$tarifs]['tariff_name'].';';

                    foreach ($types as $index => $type) {

                        //echo $index;

                        if(preg_match($index, $arr["tariff_codes"][$tarifs]['tariff_name']) > 0)
                        {

                            $exitResult['services'][$services]['periodMin'] = $arr["tariff_codes"][$tarifs]['period_min'];
                            $exitResult['services'][$services]['periodMax'] = $arr["tariff_codes"][$tarifs]['period_max'];

                            // tooltipText
                            if(isset($arr["tariff_codes"][$tarifs]['tariff_description'])) {
                                $exitResult['services'][$services]['tooltipText'] = $arr["tariff_codes"][$tarifs]['tariff_description'];
                            }


                            /* Price block */
                          //  try{
                                $exitResult['services'][$services][$type] =
                                    ['price' =>
                                        [
                                            $arr["tariff_codes"][$tarifs]['delivery_sum'] + $cod_cost,
                                            round(($arr["tariff_codes"][$tarifs]['delivery_sum']  + $cod_cost),0)
                                        ]
                                    ];
                          /*  }
                            catch (Exception $e){
                                $exitResult['services'][$services][$type] =
                                    ['price' =>
                                        [
                                            $arr["tariff_codes"][$tarifs]['delivery_sum']
                                          ,0
                                        ]
                                    ];
                            }*/

                        }

                    }
                }

            }
        }
        return json_encode($exitResult);


    }


}