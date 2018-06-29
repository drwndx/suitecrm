<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 6/1/2018
 * Time: 5:00 PM
 */

namespace SuiteCRM\api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;


/**
 * Class SuiteCRMFinder
 * @package SuiteCRM\Api
 */
class SuiteCRMFinder
{
	/**
	 * @var SuiteCRMConnect
	 */
	private $client;

	/**
	 * SuiteCRMAccounts constructor.
	 *
	 * @param $client
	 */
	public function __construct(SuiteCRMConnect $client)
	{
		$this->client = $client;
	}

	public function find($searchString)
	{
		$connector = $this->client;


		$httpClient = $connector->getHttpClient();
		$apiUrl = $connector->getApiUrl();
		$apiSessionId = $connector->getApiSessionId();

		$args = array(
			'session' => $apiSessionId,
			'search_string' => $searchString,
			'modules' => array(
				'Accounts', 'Leads', 'Contacts', 'Trial_Trials','Emails'
			),
			'offset' => 0,
			'max_results' => 100,
			'assigned_user_id' => '',
			'select_fields' => array(
				'id',
				'name',
				'email_address',
				'phone_office'
			),
			'unified_search_only' => false,
			'favorites' => false
		);

		$requestOptions = $connector->getRequestOptions([
			'method' => 'search_by_module',
			'input_type' => 'JSON',
			'response_type' => 'JSON',
			'rest_data' => json_encode($args),
		]);

		try
		{
			$response = $httpClient->request('POST', $apiUrl, ['form_params' => $requestOptions]);

			return new SuiteCRMFinderResponse($connector->handleResponse($response));
		}
		catch (\Exception $e)
		{
			//echo ($e->getMessage() . "\n");
		}
	}
}