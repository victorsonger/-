<?php
require_once '../inc/global.php';
$dtp = Ci123_Db::factory('dtp');
$sql = "select * from `gp_order` where `id`<=20 limit 1";
$row = $dtp->fetchRow($sql);
$table = 'gp_part';
$mem_id = $row['member_id'];
$brand_id = $row['brand_id'];
$sql = "select * from `gp_member` where `id`={$mem_id} limit 1";
$row = $dtp->fetchRow($sql);
$name = $row['name'];
$mobile = $row['mobile'];
$arr = array(
    'name' => $name,
    'letter' => 'W',
    'mobile' => $mobile,
    'brand_id' => $brand_id,
    'state' => 0,
    'created' => date('Y-m-d H:i:s'),
    'member_id' => $mem_id, 
);
$part_id = $dtp->insert($table, $arr, true);
var_dump($part_id);die();