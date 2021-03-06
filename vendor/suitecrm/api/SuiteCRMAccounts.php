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
 * Class SuiteCRMAccounts
 * @package SuiteCRM\Api
 */
class SuiteCRMAccounts {

    /**
     * @var SuiteCRMConnect
     */
    private $client;

    /**
     * SuiteCRMAccounts constructor.
     *
     * @param $client
     */
    public function __construct($client) {
        $this->client = $client;
    }

    /**
     *
     * Get Accounts
     *
     * @param array $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccounts($options = []){
        return $this->client->post('get_entry_list','Accounts',$options);
    }

	/**
	 *
	 * Get Account
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function getAccount($options = []){
	    return $this->client->post('get_entry','Accounts',$options);
    }

	/**
	 *
	 * Create Account
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function createAccount($options = []){
	    return $this->client->post('set_entry','Accounts',$options);
    }

	/**
	 *
	 * Get Field Defs for Accounts
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getAccountFields($options = []){
		return $this->client->post('get_module_fields','Accounts',$options);
	}

	/**
	 *
	 * Update Account
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function updateAccount
	($options = []){
		return $this->client->post('set_entry','Accounts',$options);
	}

	/**
	 *
	 * Delete Account
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function deleteAccount($options = []){
		return $this->client->post('set_entry','Accounts',$options);
	}


}