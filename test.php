<?php
/**
 * Created by PhpStorm.
 * User: drwnd
 * Date: 6/4/2018
 * Time: 10:58 PM
 */

if (!defined('__DIR__')) define('__DIR__', dirname(__FILE__));

require_once 'vendor/autoload.php';


use GuzzleHttp\Client;
use SuiteCRM\api\SuiteCRMAccounts;
use SuiteCRM\api\SuiteCRMConnect;

$r  = new SuiteCRMConnect();

$call = array(
	'query' => "accounts.billing_address_city = 'Ohio'",
	'order_by' => '',
	'offset' => 0,
	'select_fields' => array('id','name',),
	'link_name_to_fields_array' => array(
    array(
      'name' => 'contacts',
      'value' => array(
        'first_name',
        'last_name',
      ),
    ),
  ),
	'max_results' => 10,
	'deleted' => 0,
);

$a = $r->accounts->getAccounts($call) ;



print_r($a);

