<?php
/**
 * Created by PhpStorm.
 * User: drwnd
 * Date: 6/4/2018
 * Time: 10:28 PM
 */

namespace SuiteCRM\api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;


class SuiteCRMConnect
{

    /**
     * @var Client $http_client
     */
    private $http_client;

    /**
     * @var string API url
     */
    protected $api_url;

    /**
     * @var string API user
     */
    protected $api_user;

    /**
     * @var string API password
     */
    protected $api_pass;

    /**
     * @var SuiteCRMAccounts $accounts
     */
    public $accounts;


    /**
     * @var string Extra Guzzle Requests Options
     */
    protected $guzzleOptions;

    protected $nameValueList;



    const API_URL ="https://crm.pinnaclecart.com/suite/service/v4_1/rest.php";

    const API_USER ="admin";

    const API_PASS ="suitecrmdemo";

    const APP_NAME = "TRIAL API";

	/**
	 * @param $api_url
	 * @param $api_user
	 * @param $api_pass
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    protected function createSession($api_url,$api_user,$api_pass){

        $this->api_user = $api_user;
        $this->api_pass = $api_pass;



        $nameValueList = array();

        $userAuth = [
            'user_name' => $this->api_user,
            'password' => md5($this->api_pass),
        ];

        $authArray = [
            'user_auth'=> $userAuth,
            'application_name' => $this::APP_NAME,
            'name_value_list' => $nameValueList,
        ];

        $postData = [
            'method' => 'login',
            'input_type' => 'JSON',
            'response_type' => 'JSON',
            'rest_data' => $authArray,

        ];

        //return $postData;


        $authClient = new Client();

        $response = $authClient->request('POST',$api_url,$postData);

        return $this->handleResponse($response);


    }

	/**
	 * SuiteCRMConnect constructor.
	 *
	 * @param null $api_url
	 * @param null $api_user
	 * @param null $api_pass
	 */
    public function __construct($api_url=null,$api_user=null,$api_pass= null){

        $this->setDefaultClient();
        $this->accounts = new SuiteCRMAccounts($this);
	
        if ($api_url !=null) $this->api_url = $api_url ; else $this->api_url = self::API_URL;
	    if ($api_user !=null) $this->api_user = $api_user ; else $this->api_user = self::API_USER;
	    if ($api_pass !=null) $this->api_pass = $api_pass ; else $this->api_pass = self::API_PASS;

        $this->sess_id = $this->createSession($this->api_url,$this->api_user,$this->api_pass);
        //$this->guzzleOptions = $guzzleOptions;
    }

    /**
     *
     */
    private function setDefaultClient()
    {
        $this->http_client = new Client();
    }

    /**
     * Sets GuzzleHttp client.
     *
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->http_client = $client;
    }

    /**
     * @param Response $response
     * @return mixed
     */
    private function handleResponse(Response $response)
    {
        $stream = \GuzzleHttp\Psr7\stream_for($response->getBody());
        $data = json_decode($stream);
        return $data;
    }

//    /**
//     * Returns Guzzle Requests Options Array
//     *
//     * @param  array $defaultGuzzleRequestsOptions
//     * @return array
//     */
//    public function getGuzzleRequestOptions($defaultGuzzleRequestOptions = [])
//    {
//        return array_replace_recursive($this->guzzleOptions, $defaultGuzzleRequestOptions);
//    }

}

