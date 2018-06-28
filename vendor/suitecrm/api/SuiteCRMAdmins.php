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
 * Class SuiteCRMAdmins
 * @package SuiteCRM\Api
 */
class SuiteCRMAccounts {

    /**
     * @var SuiteCRMConnect
     */
    private $client;

    /**
     * SuiteCRMAdmins constructor.
     *
     * @param $client
     */
    public function __construct($client) {
        $this->client = $client;
    }

    /**
     *
     * Get Admins
     *
     * @param array $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAdmins($options = []){
        return $this->client->post('get_entry_list','Users',$options);
    }

	/**
	 *
	 * Get Admin
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function getAdmin($options = []){
	    return $this->client->post('get_entry','Users',$options);
    }

	/**
	 *
	 * Create Admin
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function createAdmin($options = []){
	    return $this->client->post('set_entry','Users',$options);
    }

	/**
	 *
	 * Get Field Defs for Admin
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getAdminFields($options = []){
		return $this->client->post('get_module_fields','Users',$options);
	}

	/**
	 *
	 * Update Admin
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function updateAdmin
	($options = []){
		return $this->client->post('set_entry','Users',$options);
	}

	/**
	 *
	 * Delete Admin
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function deleteAccount($options = []){
		return $this->client->post('set_entry','Users',$options);
	}


}