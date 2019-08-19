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
use Tygh\Shippings\Shippings;

if ( !defined('BOOTSTRAP') ) { die('Access denied'); }

if ($mode == 'manage' || $mode == 'search') {
    $orders = Tygh::$app['view']->getTemplateVars('orders');
    if(!empty($orders)){
        foreach($orders as $k => $o) {
            $shipments = db_get_array('SELECT a.`carrier`, a.`tracking_number` FROM `?:shipments` a
                                       JOIN `?:shipment_items` b ON b.`shipment_id`=a.`shipment_id`
                                       WHERE b.`order_id`=?i
                                       GROUP BY a.`shipment_id`
                                       ORDER BY a.`timestamp` DESC', $o['order_id']);
            if(!empty($shipments)){
                foreach($shipments as $s){
                    $carrier_info = Shippings::getCarrierInfo($s['carrier'], $s['tracking_number']);
                    $orders[$k]['hw_custom_carrier']['shipments'][] = array(
                        'carrier' => $s['carrier'],
                        'tracking_number' => $s['tracking_number'],
                        'tracking_url' => $carrier_info['tracking_url'],
                        'name' => $carrier_info['name'],
                    );
                }
            }
        }

        Tygh::$app['view']->assign('orders', $orders);
    }
}