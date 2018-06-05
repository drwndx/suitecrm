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

$r  = new SuiteCRMAccounts(null);

$a = $r->getAccounts();

print_r($a);

