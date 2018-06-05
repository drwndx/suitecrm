<?php

$url = "https://crm.pinnaclecart.com/suite/service/v4_1/rest.php";

function restRequest($method, $arguments){
 global $url;
 $curl = curl_init($url);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 $post = array(
         "method" => $method,
         "input_type" => "JSON",
         "response_type" => "JSON",
         "rest_data" => json_encode($arguments),
 );

 curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

 $result = curl_exec($curl);
 curl_close($curl);
 return json_decode($result,1);
}


$userAuth = array(
        'user_name' => 'admin',
        'password' => md5('suitecrmdemo'),
);
$appName = 'My SuiteCRM REST Client';
$nameValueList = array();

$args = array(
            'user_auth' => $userAuth,
            'application_name' => $appName,
            'name_value_list' => $nameValueList);

$result = restRequest('login',$args);
$sessId = $result['id'];

$entryArgs = array(
 //Session id - retrieved from login call
	'session' => $sessId,
 //Module to get_entry_list for
	'module_name' => 'Accounts',
 //Filter query - Added to the SQL where clause,
	'query' => "",
 //Order by - unused
	'order_by' => '',
 //Start with the first record
	'offset' => 0,
 //Return the id and name fields
	'select_fields' => array('id','name',),
 //Link to the "contacts" relationship and retrieve the
 //First and last names.
	'link_name_to_fields_array' => array(
        array(
                'name' => 'contacts',
                        'value' => array(
                        'first_name',
                        'last_name',
                ),
        ),
),
   //Show 10 max results
  		'max_results' => 10,
   //Do not show deleted
  		'deleted' => 0,
 );
 $result = restRequest('get_entry_list',$entryArgs);

print_r($result);