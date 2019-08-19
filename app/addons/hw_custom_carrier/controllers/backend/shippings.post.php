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

use Tygh\Registry;

if ( !defined('BOOTSTRAP') ) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    fn_trusted_vars (
        'carrier_data'
    );

    if ($mode == 'update_carrier') {
        $carrier_data = $_REQUEST['carrier_data'];
        $id = (int)$carrier_data['id'];
        unset($carrier_data['id']);
        if($id == 0){     
            $id = db_query("INSERT INTO ?:hw_custom_carrier ?e", $carrier_data);            
        }else{
            db_query('UPDATE ?:hw_custom_carrier SET ?u WHERE id = ?i', $carrier_data, $id);
        }

        #04.01.2017
        fn_hw_custom_carrier_update_carrier_new($id);

        return array(CONTROLLER_STATUS_OK, "shippings.carriers");
    }


    if($mode=='import_carriers'){
            $carrier_xml = fn_filter_uploaded_data('carrier_xml', array('xml'));
            if (empty($carrier_xml[0])) {
                fn_set_notification('E', __('error'), __('text_allowed_to_upload_file_extension', array('[ext]' => implode(',', array('xml')))));
            } else {
                $carrier_xml = $carrier_xml[0];

                // Extract the add-on pack and check the permissions
                $extract_path = Registry::get('config.dir.cache_misc') . 'tmp/carrier_xml/';

                // Re-create source folder
                fn_rm($extract_path);
                fn_mkdir($extract_path);

                fn_copy($carrier_xml['path'], $extract_path . $carrier_xml['name']);

                $data = (array)simplexml_load_file($extract_path . $carrier_xml['name']);
                $carriers = $data['carrier'];
                if(!is_array($data['carrier'])){
                    $new_carriers = array();
                    $new_carriers[] = $carriers;
                    $carriers = $new_carriers;
                }
                
                if(!empty($carriers)){
                    foreach ($carriers as $carrier) {
                        $carrier_data = array(
                            'name'=> (string)$carrier->name,
                            'tracking_url'=> (string)base64_decode($carrier->tracking_url),
                            'status'=> (string)$carrier->status,
                            'position'=> (int)$carrier->position
                        );
                        //check if the same name and url
                        $id = db_query("INSERT INTO ?:hw_custom_carrier ?e", $carrier_data);

                        #04.01.2017
                        fn_hw_custom_carrier_update_carrier_new($id);
                    }
                    fn_set_notification('N', __('notice'), __('import_carriers_done') );
                }
            }

            return array(CONTROLLER_STATUS_OK, "shippings.carriers");
    }
}

if ($mode == 'carriers') {
    $params = array();
    $params['all'] = true;
    $shippings_carrier = fn_hw_custom_carrier_get($params);
    Tygh::$app['view']->assign('shippings_carrier', $shippings_carrier);
}

if ($mode == 'carrier_update') {
    $params = array();
    //$params['all'] = true;
    $params['id'] = $_REQUEST['id'];    
    $carrier_data = fn_hw_custom_carrier_get($params);
    Tygh::$app['view']->assign('carrier_data', $carrier_data);
}

if ($mode == 'carrier_delete') {
    fn_hw_custom_carrier_delete($_REQUEST['id']);
    return array(CONTROLLER_STATUS_OK, "shippings.carriers");
}

if($mode=='export_carriers'){
    $params = array();
    $params['all'] = true;
    $carriers = fn_hw_custom_carrier_get($params);
    if(!empty($carriers)){
        header('Content-Type: text/xml; charset=UTF-8');
        header('Content-Disposition: attachment; filename="shipping_carriers.xml"');

        $xml    = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml    .= '<carriers>'."\n";
        foreach ($carriers as $data) {
            $xml    .= '<carrier>'."\n";
            foreach ($data as $key => $value) {
                if(in_array($key, array('id'))) continue;
                if($key=='tracking_url'){
                    $xml    .= '   <'.$key.'>'.base64_encode($value).'</'.$key.'>'."\n";
                }else{
                    $xml    .= '   <'.$key.'>'.$value.'</'.$key.'>'."\n";
                }
            }
            $xml    .= '</carrier>'."\n";            
        }
        $xml    .= '</carriers>';
        echo $xml;
        exit();
    } else{ 
        return array(CONTROLLER_STATUS_NO_PAGE);
    }
}
/*
TODO:

if($mode=='disable_cscart_carriers' || $mode=='enable_cscart_carriers'){
    $default_carriers = array('aup','can','dhl','fedex','swisspost','temando','ups','usps');

    $status = 'A';
    if($mode=='disable_cscart_carriers') $status = 'D';

    db_query('UPDATE ?:shipping_services SET status=?s WHERE module IN (?a)', $status, $default_carriers);
    return array(CONTROLLER_STATUS_OK, "shippings.carriers");
}
*/