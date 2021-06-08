<?php
/**
 * Class CDEKAuthorization
 */

class CDEKAuthorization
{
    private $access_token;
    private $client_id;
    private $client_secret;

    public $baseUrl = 'https://api.cdek.ru/';

    private $grantType = "client_credentials";

    public function __construct($client_id, $client_secret, $debug = false)
    {
        if ($client_id == null || $client_secret == null) {
            throw new Exception('One parameter with null value');
        }

        $this->client_id = $client_id;
        $this->client_secret = $client_secret;

        if ($debug) {
            $this->baseUrl = 'https://api.edu.cdek.ru/';
        }

        if ($this->authorization()) {
            return true;
        }
    }

    /**
     * Authorization in service
     *
     * @link https://confluence.cdek.ru/pages/viewpage.action?pageId=29923918
     * @throws Exception if error authorization
     */
    public function authorization()
    {

        $urlAuth = $this->baseUrl . 'v2/oauth/token?parameters';

        $data = [
            'grant_type' => $this->grantType,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($urlAuth, false, $context);

        if ($result === FALSE) {
            throw new Exception("Error authorization");
        } else {
            $resultArray = json_decode($result, true);
            $this->access_token = $resultArray["access_token"];
            return true;
        }
    }

    /**
     * Get access token
     *
     * @return string access token
     *
     * @throws Exception
     */
    public function getAccessToken()
    {
        if($this->access_token == null)
        {
            $this->authorization();
        }

        return $this->access_token;
    }
}