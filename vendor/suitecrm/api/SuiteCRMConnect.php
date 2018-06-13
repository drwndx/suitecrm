<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 6/1/2018
 * Time: 3:50 PM
 */

namespace SuiteCRM\api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class SuiteCRMConnect {

    /**
     * @var Client $http_client
     */
    private $http_client;

    /**
     * @var string API URL
     */
    protected $api_url;

    /**
     * @var string API USER
     */
    protected $api_user;

    /**
     * @var string API PASS
     */
    protected $api_pass;

    /**
     * @var string API SESSION ID
     */
    protected $api_sessId;

    /**
     * @var string API MODULE NAME
     */
    protected $moduleName;


	/**
	 * @var string name value list
	 */
	protected $nameValuelist;

    /**
     * @var array Request Options
     */
    protected $requestOptions;

    /**
     * @var
     */
    protected $rateLimitDetails;

    /**
     * @var SuiteCRMAdmins Admins
     */
    public $admins;

    /**
     * @var SuiteCRMAccounts Accounts
     */
    public $accounts;


    const API_URL = "https://crm.pinnaclecart.com/suite/service/v4_1/rest.php";

    const API_USER = "admin";

    const API_PASS = "suitecrmdemo";

    const APP_NAME = "TRIAL_API";

	/**
	 * @param $api_url
	 * @param $api_user
	 * @param $api_pass
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	protected function createSession($api_url,$api_user,$api_pass){

        $this->api_url = $api_url;
		$this->api_user = $api_user;
		$this->api_pass = $api_pass;
		$nameValueList = array();
		$userAuth = array(
			'user_name' => $this->api_user,
			'password' => md5($this->api_pass),
		);
		$authArray = array(
			'user_auth'=> $userAuth,
			'application_name' => $this::APP_NAME,
			'name_value_list' => $nameValueList,
		);
		$postData = array(
			'method' => 'login',
			'input_type' => 'JSON',
			'response_type' => 'JSON',
			'rest_data' => json_encode($authArray),
		);

		$authClient = new Client(['headers' => [
			'User-Agent' => '-',]]);
		$response = $authClient->request('post',"$this->api_url",[ 'form_params' => $postData]);

		return $this->handleResponse($response);
	}

        /**
     * Connection constructor.
     *
     * @param null $api_url
     * @param null $api_user
     * @param null $api_pass
     * @param null $api_sessId
     * @param array $requestOptions
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */


    public function __construct($api_url=null,$api_user=null,$api_pass= null, $requestOptions = [] )
    {
        $this->setDefaultClient();
        $this->accounts = new SuiteCRMAccounts($this);

	    $this->api_url = ($api_url !=null) ? $api_url : self::API_URL;
	    $this->api_user = ($api_user !=null) ? $api_user : self::API_USER;
	    $this->api_pass = ($api_pass !=null) ? $api_pass : self::API_PASS;
	    $authRequest = $this->createSession($this->api_url,$this->api_user,$this->api_pass);
	    $this->api_sessId = $authRequest->id;

	    $this->requestOptions = $requestOptions;
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
     * @throws \Exception
     */
    private function setRateLimitDetails(Response $response)
    {
        $this->rateLimitDetails = [
            'limit' => $response->hasHeader('X-RateLimit-Limit')
                ? (int)$response->getHeader('X-RateLimit-Limit')[0]
                : null,
            'remaining' => $response->hasHeader('X-RateLimit-Remaining')
                ? (int)$response->getHeader('X-RateLimit-Remaining')[0]
                : null,
            'reset_at' => $response->hasHeader('X-RateLimit-Reset')
                ? (new \DateTimeImmutable())->setTimestamp((int)$response->getHeader('X-RateLimit-Reset')[0])
                : null,
        ];
    }

    /**
     * @param Response $response
     * @return mixed
     * @throws \Exception
     */
    private function handleResponse(Response $response)
    {
        $this->setRateLimitDetails($response);
        $stream = \GuzzleHttp\Psr7\stream_for($response->getBody());
        $data = json_decode($stream);
        return $data;
    }

    public function getRequestOptions($defaultRequestOptions = [])
    {
        return array_replace_recursive($this->requestOptions, $defaultRequestOptions);
    }

    /**
     * @param $endpoint
     * @param null $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($endpoint,$options = null)
    {
        $requestOptions = $this->getRequestOptions(
            [

            ]
        );

        try{
            $response = $this->http_client->request('GET',"$this->url$endpoint",$requestOptions);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            echo ($e->getMessage() . "\n");
        }
    }

    /**
     * @param $endpoint
     * @param null $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($endpoint,$options = null)
    {
        $requestOptions = $this->getRequestOptions(
            [

            ]
        );

        try{
            $response = $this->http_client->request('PUT',"$this->url$endpoint",$requestOptions);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            echo ($e->getMessage() . "\n");
        }
    }

    /**
     * @param $endpoint
     * @param null $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($method = null, $moduleName = null, $options = null)
    {
        if($method) $this->method = $method;
        if($moduleName) $this->moduleName = $moduleName;

        $args = [
            'session' => $this->api_sessId,
            'module_name' => $this->moduleName,
        ];

        $args += $options;

        $requestOptions = $this->getRequestOptions(
            [
                'method' => $method,
                'input_type' => 'JSON',
                'response_type' => 'JSON',
                'rest_data' => json_encode($args),
            ]
        );

        try{
            $response = $this->http_client->request('POST',"$this->api_url",[ 'form_params' => $requestOptions]);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            echo ($e->getMessage() . "\n");
        }
    }

    /**
     * @param $endpoint
     * @param null $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch($endpoint,$options = null)
    {
        $requestOptions = $this->getRequestOptions(
            [

            ]
        );

        try{
            $response = $this->http_client->request('PATCH',"$this->url$endpoint",$requestOptions);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            echo ($e->getMessage() . "\n");
        }
    }

    /**
     * @param $endpoint
     * @param null $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($endpoint,$options = null)
    {
        $requestOptions = $this->getRequestOptions(
            [

            ]
        );

        try{
            $response = $this->http_client->request('DELETE',"$this->url$endpoint",$requestOptions);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            echo ($e->getMessage() . "\n");
        }
    }
}