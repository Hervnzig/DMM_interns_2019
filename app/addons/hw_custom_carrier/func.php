<?php
/**
 *
 * Thank you for your purchase! You are the best!
 *
 * @copyright    (C) 2018 Hungryweb
 * @website      https://www.hungryweb.net/
 * @support      support@hungryweb.net
 * @license      https://www.hungryweb.net/license-agreement.html
 *
 * ---------------------------------------------------------------------------------
 * This is a commercial software, only users who have purchased a valid license
 * and accepts the terms of the License Agreement can install and use this program.
 * ---------------------------------------------------------------------------------
 *
 */

if ( !defined('BOOTSTRAP') ) { die('Access denied'); }

use Tygh\Registry;
use Tygh\Http;
use Tygh\Languages\Languages;

function fn_hw_custom_carrier_delete($id=0, $silent=false){
	if(empty($id)) return false;

	db_query('DELETE FROM ?:hw_custom_carrier WHERE id=?i', $id);
    if(!$silent){
    	fn_set_notification('N', __('notice'), __('carrier_deleted') );
    }

    //
	$carrier_name = 'carrier_'.$id;
    fn_rm(Registry::get('config.dir.addons').'/hw_custom_carrier/Tygh/Shippings/Services/'.fn_camelize($carrier_name).'.php');

	$service_id = db_get_field('SELECT service_id FROM ?:shipping_services WHERE module=?s', $carrier_name);
    db_query('DELETE FROM ?:shipping_services WHERE service_id=?i', $service_id);
    db_query('DELETE FROM ?:shipping_service_descriptions WHERE service_id=?i', $service_id);

}

function fn_hw_custom_carrier_update_carrier_new_all(){
	$carriers = fn_hw_custom_carrier_get(array('all'=>true));
	foreach ($carriers as $c) {
		fn_hw_custom_carrier_update_carrier_new($c['id']);
	}
}

function fn_hw_custom_carrier_update_carrier_new($id){

	//create and change folder rights
	$services_path = Registry::get('config.dir.addons').'/hw_custom_carrier/Tygh/Shippings/Services';
	fn_mkdir($services_path);
	@chmod($services_path, 0755);

	$carrier = fn_hw_custom_carrier_get(array('id'=>$id));
	$carrier['name'] = str_replace("'", "\'", $carrier['name']);

	$carrier_name = 'carrier_'.$id;

	#FILE
    fn_put_contents($services_path.'/'.fn_camelize($carrier_name).'.php',''.
'<?php'."\n\n".
'namespace Tygh\Shippings\Services;'."\n\n".
'use Tygh\Shippings\IService;'."\n".
'class '.fn_camelize($carrier_name).' implements IService{'."\n".
'    public function prepareData($shipping_info){}'."\n".
'    public function allowMultithreading(){}'."\n".
'    public function getRequestData(){}'."\n".
'    public function getSimpleRates(){}'."\n".
'    public function processErrors($result){}'."\n".
'    public function processResponse($response){}'."\n".
'    public function processRates($result){}'."\n\n".
'    public static function getInfo(){'."\n".
'        return array('."\n".
'            \'name\' => \''.$carrier['name'].'\','."\n".
'            \'tracking_url\' => \''.str_replace('[TRACKING_NUMBER]', '%s', $carrier['tracking_url']).'\''."\n".
'        );'."\n".
'    }'."\n".
'}');

    $service_id = db_get_field('SELECT service_id FROM ?:shipping_services WHERE module=?s', $carrier_name);
    if(empty($service_id)){
	    $data = array(
	    	'status' => 'A',
	    	'module' => $carrier_name,
	    	'code' => 1
	    );
	    $service_id = db_query('INSERT INTO ?:shipping_services ?e', $data);

	    $data = array(
	    	'service_id' => $service_id,
	    	'description' => $carrier['name']
	    );
        foreach (fn_get_translation_languages() as $data['lang_code'] => $_v) {
            db_query("INSERT INTO ?:shipping_service_descriptions ?e", $data);
        }
	}else{
		#TODO: in case they add a new language
	    db_query('UPDATE ?:shipping_service_descriptions SET description=?s WHERE service_id=?i', $carrier['name'], $service_id);
	}

}

function fn_hw_custom_carrier_get_carrier($id, $tracking_number){
	$params=array();
	$params['id'] = $id;
	$carrier = fn_hw_custom_carrier_get($params);	
	$carrier['tracking_url'] = str_replace('[TRACKING_NUMBER]', $tracking_number, $carrier['tracking_url']);
	return array($carrier['name'], $carrier['tracking_url']);
}

function fn_hw_custom_carrier_get_id($carrier){
	$carrier = explode('_', $carrier);
	if($carrier[0]='CARRIER'){
		return (int)$carrier[1];
	}else {
		return 0;
	}
}

function fn_hw_custom_carrier_get_active(){
	$params=array();
	$params['status'] = 'A';
	$carrier = fn_hw_custom_carrier_get($params);

	return $carrier;
}

function fn_hw_custom_carrier_get($params=array()){

	$condition = '';
	$order_by = 'position  ASC';

	if(!empty($params['id'])){
		$condition = db_quote(' AND id=?i', $params['id']);
	}

	if(empty($params['all']) && empty($params['id'])){
		$condition = db_quote(' AND status=?s', 'A');
	}	

	$carrier = db_get_hash_array('SELECT * FROM ?:hw_custom_carrier WHERE 1'.$condition.' ORDER BY '.$order_by, 'id');

	if(!empty($params['id'])){
		$carrier = $carrier[$params['id']];
	}

	return $carrier;
}

#Hungryweb License
if (!function_exists('fn_hw_aiden_license_info')){
	function fn_hw_aiden_license_info(){
		$html = '';
		$html .='<div class="control-group setting-wide"><label class="control-label">&nbsp;</label><div class="controls"><span><a href="https://www.hungryweb.net/generate-license.html" target="_blank">'.__('hw_license_generator').'</a></span></div></div>';
	 	return $html;
	}
}

#Hungryweb actions
function fn_hw_custom_carrier_install(){ fn_hw_aiden_action('custom_carrier','install'); }
function fn_hw_custom_carrier_uninstall(){
	fn_hw_aiden_action('custom_carrier','uninstall');

	#cleanup
	$carriers = fn_hw_custom_carrier_get(array('all'=>true));
	foreach ($carriers as $c) {
		fn_hw_custom_carrier_delete($c['id'], true);
	}	
}

if (!function_exists('fn_hw_aiden_action')){
    function fn_hw_aiden_action($addon,$a){
        $request = array('addon'=>$addon,'host'=>Registry::get('config.http_host'),'path'=>Registry::get('config.http_path'),'version'=>PRODUCT_VERSION,'edition'=>PRODUCT_EDITION,'lang'=>strtoupper(CART_LANGUAGE),'a'=>$a,'love'=>'aiden');
        Http::post('https://www.hwebcs.com/ws/addons', $request);
    }
}