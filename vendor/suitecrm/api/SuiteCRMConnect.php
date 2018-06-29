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
	 * @var Client $httpClient
	 */
	protected $httpClient = null;

	/**
	 * @var string API URL
	 */
	protected $apiUrl;

	/**
	 * @var string API USER
	 */
	protected $apiUser;

	/**
	 * @var string API PASS
	 */
	protected $apiPassword;

	/**
	 * @var string API SESSION ID
	 */
	protected $apiSessionId;

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
	 * @var SuiteCRMAdmins $admins
	 */
	public $admins;

	/**
	 * @var SuiteCRMAccounts $accounts
	 */
	public $accounts;

	/**
	 * @var SuiteCRMContacts
	 */
	public $contacts;

	/**
	 * @var SuiteCRMLeads $leads
	 */
	public $leads;

	/**
	 * @var SuiteCRMFinder $finder
	 */
	public $finder;

	/**
	 * @var SuiteCRMTrials Trials
	 */
	public $trials;

	const APP_NAME = "TRIAL_API";

	/**
	 * SuiteCRMConnect constructor.
	 *
	 * @param $apiUrl
	 * @param $apiUser
	 * @param $apiPassword
	 * @param array $requestOptions
	 *
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function __construct($apiUrl, $apiUser, $apiPassword, $requestOptions = array())
	{
		$this->apiUrl = $apiUrl;
		$this->apiUser = $apiUser;
		$this->apiPassword = $apiPassword;

		$this->requestOptions = $requestOptions;

		$this->accounts = new SuiteCRMAccounts($this);
		$this->leads = new SuiteCRMLeads($this);
		$this->trials = new SuiteCRMTrials($this);
		$this->contacts = new SuiteCRMContacts($this);
		$this->finder = new SuiteCRMFinder($this);

		$authRequest = $this->createSession($this->apiUrl, $this->apiUser, $this->apiPassword);

		$this->apiSessionId = $authRequest->id;
	}

	/**
	 * @param $apiUrl
	 * @param $apiUser
	 * @param $apiPassword
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	protected function createSession($apiUrl, $apiUser, $apiPassword)
	{
		$this->apiUrl = $apiUrl;
		$this->apiUser = $apiUser;
		$this->apiPassword = $apiPassword;

		$nameValueList = array();

		$userAuth = array(
			'user_name' => $this->apiUser,
			'password' => md5($this->apiPassword),
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

		$response = $this->getHttpClient()->request(
			'post',
			$this->apiUrl,
			[
				'headers' => ['User-Agent' => '-'],
				'form_params' => $postData
			]
		);

		return $this->handleResponse($response);
	}

	/**
	 * @return Client
	 */
	public function getHttpClient()
	{
		if ($this->httpClient == null)
		{
			$this->httpClient = new Client();
		}

		return $this->httpClient;
	}

	/**
	 * @param Response $response
	 */
	private function setRateLimitDetails(Response $response)
	{
		$this->rateLimitDetails = [
			'limit' => $response->hasHeader('X-RateLimit-Limit') ? (int)$response->getHeader('X-RateLimit-Limit')[0] : null,
			'remaining' => $response->hasHeader('X-RateLimit-Remaining') ? (int)$response->getHeader('X-RateLimit-Remaining')[0] : null,
			'reset_at' => $response->hasHeader('X-RateLimit-Reset') ? (new \DateTimeImmutable())->setTimestamp((int)$response->getHeader('X-RateLimit-Reset')[0]) : null,
		];
	}

	/**
	* @param Response $response
	* @return mixed
	* @throws \Exception
	*/
	public function handleResponse(Response $response)
	{
		$this->setRateLimitDetails($response);
		$stream = \GuzzleHttp\Psr7\stream_for($response->getBody());
		$data = json_decode($stream);
		return $data;
	}

	/**
	 * @param array $defaultRequestOptions
	 * @return array
	 */
	public function getRequestOptions($defaultRequestOptions = [])
	{
		return array_replace_recursive($this->requestOptions, $defaultRequestOptions);
	}

	/**
	 * @return string
	 */
	public function getApiSessionId()
	{
		return $this->apiSessionId;
	}

	/**
	 * @return string
	 */
	public function getApiUrl()
	{
		return $this->apiUrl;
	}

	/**
	* @param $endpoint
	* @param null $options
	*
	* @return mixed
	* @throws \GuzzleHttp\Exception\GuzzleException
	*/
	public function get($endpoint, $options = null)
	{
		$requestOptions = $this->getRequestOptions();

		try
		{
			$response = $this->getHttpClient()->request('GET', $this->url . $endpoint, $requestOptions);
			return $this->handleResponse($response);
		}
		catch (\Exception $e)
		{
			//echo ($e->getMessage() . "\n");
		}
	}

	/**
	 * @param $endpoint
	 * @param null $options
	 * @return mixed
	 */
	public function put($endpoint, $options = null)
	{
		$requestOptions = $this->getRequestOptions();

		try
		{
			$response = $this->getHttpClient->request('PUT', $this->url . $endpoint, $requestOptions);
			return $this->handleResponse($response);
		}
		catch (\Exception $e)
		{
			//echo ($e->getMessage() . "\n");
		}
	}

	/**
	 * @param null $method
	 * @param null $moduleName
	 * @param null $options
	 * @return mixed
	 */
	public function post($method, $moduleName, $options = null)
	{
		$args = array_merge([
			'session' => $this->apiSessionId,
			'module_name' => $moduleName,
		], is_array($options) ? $options : []);

		$requestOptions = $this->getRequestOptions([
			'method' => $method,
			'input_type' => 'JSON',
			'response_type' => 'JSON',
			'rest_data' => json_encode($args),
		]);

		try
		{
			$response = $this->getHttpClient()->request('POST', $this->apiUrl, ['form_params' => $requestOptions]);

			return $this->handleResponse($response);
		}
		catch (\Exception $e)
		{
			//echo ($e->getMessage() . "\n");
		}
	}

	/**
	 * @param $endpoint
	 * @param null $options
	 * @return mixed
	 */
	public function delete($endpoint, $options = null)
	{
		$requestOptions = $this->getRequestOptions([]);

		try
		{
			$response = $this->getHttpClient()->request('DELETE', $this->url . $endpoint, $requestOptions);
			return $this->handleResponse($response);
		}
		catch (\Exception $e)
		{
			//echo ($e->getMessage() . "\n");
		}
	}
}