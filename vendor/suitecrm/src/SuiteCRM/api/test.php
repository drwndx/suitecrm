<?php
/**
 * Created by PhpStorm.
 * User: drwnd
 * Date: 6/4/2018
 * Time: 10:58 PM
 */

namespace SuiteCRM\api;

use GuzzleHttp\Client;
use SuiteCRM\api\SuiteCRMAccounts;

$r  = new SuiteCRMAccounts(null);

$a = $r->getAccounts();

print_r($a);

