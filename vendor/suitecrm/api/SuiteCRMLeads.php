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
 * Class SuiteCRMLeads
 * @package SuiteCRM\Api
 */
class SuiteCRMLeads {

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
     * Get Lead
     *
     * @param array $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLeads($options = []){
        return $this->client->post('get_entry_list','Leads',$options);
    }

	/**
	 *
	 * Get Lead
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function getLead($options = []){
	    return $this->client->post('get_entry','Leads',$options);
    }

	/**
	 *
	 * Get Field Defs for Leads
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getLeadFields($options = []){
		return $this->client->post('get_module_fields','Leads',$options);
	}

	/**
	 *
	 * Create Lead
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function createLead($options = []){
	    return $this->client->post('set_entry','Leads',$options);
    }

	/**
	 *
	 * Update Lead
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function updateLead
	($options = []){
		return $this->client->post('set_entry','Leads',$options);
	}

	/**
	 *
	 * Delete Lead
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function deleteLead($options = []){
		return $this->client->post('set_entry','Leads',$options);
	}


}