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
use SuiteCRM\api\SuiteCRMConnect;

$r  = new SuiteCRMConnect();

//$call = array(
//	'query' => "accounts.billing_address_city = 'Ohio'",
//	'order_by' => '',
//	'offset' => 0,
//	'select_fields' => array('id','name',),
//	'link_name_to_fields_array' => array(
//    array(
//      'name' => 'contacts',
//      'value' => array(
//        'first_name',
//        'last_name',
//      ),
//    ),
//  ),
//	'max_results' => 10,
//	'deleted' => 0,
//);
//
//$create = array(
//	'name_value_list' => array (
//		array('name' => 'first_name', 'value' => 'David'),
//		array('name' => 'last_name', 'value' => 'Boris'),
//		array('name' => 'status', 'value' => 'New'),
//		array('name' => 'lead_source', 'value' => 'Web Site')
//	),
//);

$a = $r->accounts->getAccountFields() ;



print_r($a);

