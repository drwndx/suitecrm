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
     * @param array $options
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccounts($options = []){
        return $this->client->post('get_entry_list','Accounts',$options);
    }
}