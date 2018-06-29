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
 * Class SuiteCRMContacts
 * @package SuiteCRM\Api
 */
class SuiteCRMContacts {

    /**
     * @var SuiteCRMConnect
     */
    private $client;

    /**
     * SuiteCRMContacts constructor.
     *
     * @param $client
     */
    public function __construct($client) {
        $this->client = $client;
    }

    /**
     *
     * Get Contacts
     *
     * @param array $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getContacts($options = []){
        return $this->client->post('get_entry_list','Contacts', $options);
    }

	/**
	 *
	 * Get Contact
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function getContact($options = []){
	    return $this->client->post('get_entry','Contacts', $options);
    }

	/**
	 *
	 * Create Contact
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function createContact($options = []){
	    return $this->client->post('set_entry','Contacts', $options);
    }

	/**
	 *
	 * Get Field Defs for Contacts
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getContactFields($options = []){
		return $this->client->post('get_module_fields','Contacts', $options);
	}

	/**
	 *
	 * Update Contact
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function updateContact
	($options = []){
		return $this->client->post('set_entry','Contacts', $options);
	}

	/**
	 *
	 * Delete Contact
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function deleteContact($options = []){
		return $this->client->post('set_entry','Contacts', $options);
	}
}