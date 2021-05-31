<?php
/**
* Divelery Calulator with API CDEK version 2.0
*
* @link https://confluence.cdek.ru/pages/viewpage.action?pageId=29923741
*/

include_once 'CDEKAuthorization.php';

class CDEKCalculator extends CDEKAuthorization
{
    private $baseUrl = 'https://api.cdek.ru/';

    const TYPE_INTERNET_SHOP = 1;
    const TYPE_DELIVERY = 2;

    private $exitResult = [
        'Посылка' => null,
        'Экспресс-лайт' => null,
        'Магистральный экспресс' => null,
        'Экономичная посылка' => null
    ];

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
    public function getCostDeliveryByTrarrifs($fromLocation = 270, $toLocation = 44, $goods, $type = self::TYPE_INTERNET_SHOP)
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

    public function getResult($fromLocation = 270, $toLocation = 44, $goods, $type = self::TYPE_INTERNET_SHOP){

        $jsonResult = $this->getCostDeliveryByTrarrifs($fromLocation, $toLocation, $goods,self::TYPE_INTERNET_SHOP);

        $arr = json_decode($jsonResult, true);

        $exitResult = [
            'services' =>[
                [
                    'name'=> 'Посылка',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Экспресс-лайт',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Экспресс',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Магистральный экспресс',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                [
                    'name'=> 'Экономичная посылка',
                    'periodMin' => 0,
                    'periodMax' => 0,
                ],
                /*  'Экспресс-лайт' => null,
                  'Магистральный экспресс' => null,
                  'Экономичная посылка' => null*/
            ]
        ];
        $types =[
            '/дверь-дверь$/' => 'doorToDoor',
            '/склад-дверь$/' => 'warehouseToDoor',
            '/дверь-склад$/' => 'doorToWarehouse',
            '/склад-склад$/' => 'warehouseToWarehouse'
        ];



        for ($services = 0; $services < count($exitResult['services']); $services++){
            for($tarifs = 0; $tarifs < count($arr["tariff_codes"]); $tarifs++){

                $patern = '/^'.$exitResult['services'][$services]['name'].'/';


                if(preg_match($patern, $arr["tariff_codes"][$tarifs]['tariff_name']) > 0)
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
                            $exitResult['services'][$services][$type] =
                                ['price' =>
                                    [
                                        $arr["tariff_codes"][$tarifs]['delivery_sum'],
                                        $arr["tariff_codes"][$tarifs]['delivery_sum'] * 1.05
                                    ]
                            ];
                        }

                    }
                }

            }
        }
        return json_encode($exitResult);


    }


}