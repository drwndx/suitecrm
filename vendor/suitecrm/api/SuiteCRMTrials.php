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
 * Class SuiteCRMTrials
 * @package SuiteCRM\Api
 */
class SuiteCRMTrials {

    /**
     * @var SuiteCRMConnect
     */
    private $client;

    /**
     * SuiteCRMTrials constructor.
     *
     * @param $client
     */
    public function __construct($client) {
        $this->client = $client;
    }

    /**
     *
     * Get Trials
     *
     * @param array $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTrials($options = []){
        return $this->client->post('get_entry_list','Trial_Trials',$options);
    }

	/**
	 *
	 * Get Trial
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function getTrial($options = []){
	    return $this->client->post('get_entry','Trial_Trials',$options);
    }

	/**
	 *
	 * Create Trial
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function createTrial($options = []){
	    return $this->client->post('set_entry','Trial_Trials',$options);
    }

	/**
	 *
	 * Get Field Defs for Trials
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getTrialFields($options = []){
		return $this->client->post('get_module_fields','Trial_Trials',$options);
	}

	/**
	 *
	 * Update Trial
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function updateTrial
	($options = []){
		return $this->client->post('set_entry','Trial_Trials',$options);
	}

	/**
	 *
	 * Delete Trial
	 *
	 * @param array $options
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function deleteTrial($options = []){
		return $this->client->post('set_entry','Trial_Trials',$options);
	}


}