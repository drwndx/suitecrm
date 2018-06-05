<?php
/**
 * Created by PhpStorm.
 * User: drwnd
 * Date: 6/4/2018
 * Time: 10:35 PM
 */

namespace SuiteCRM\api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;


class SuiteCRMAccounts
{
    /**
     * @var SuiteCRMConnect
     */
    private $client;

    /**
     * SuiteCRMAccounts constructor.
     *
     * @param SuiteCRMConnect $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getAccounts()
    {
        return $this->client->sess_id;
    }
}
