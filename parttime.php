<?php
/**
 * 本地测试导入新建兼职表的数据
 */
require_once '../inc/global.php';
$dtp = Ci123_Db::factory('dtp');
/**
 * 检查一个兼职是否已被添加到兼职表
 */
function checkMemberRepeat($row){
    global $dtp;
    $member_id = intval($row['member_id']);
	$brand_id = intval($row['brand_id']);
    $admin_id = intval($row['admin_id']);
    $sql = "select * from `gp_parttime` where `member_id`={$member_id} and `brand_id`={$brand_id}";
    return $dtp->fetchRow($sql);
}
$pinyin = new PinYin;
$sql = "select * from `gp_person` where `id`>=1000 and `id`<=1200 order by `id`";
$rows = $dtp->fetchRows($sql);
$table = 'gp_parttime';
foreach ($rows as $v) {    
    $member_id = $v['member_id'];
    $brand_id = $v['brand_id'];
    $admin_id = $v['admin_id'];
    $sql = "select * from `gp_member` where `id`={$member_id}";
    $row = $dtp->fetchRow($sql);
    $name = $row['name'];
    $firstzh = $pinyin->get_all_py($name);
    $firstpin = strtoupper($pinyin->get_first_letter($firstzh));
    $mobile = $row['mobile'];
    $arr = array(
        'name' => $name,
        'letter' => $firstpin,
        'mobile' => $mobile,
        'brand_id' => $brand_id,
        'admin_id' => $admin_id,
        'created' => date('Y-m-d H:i:s'),
        'member_id' => $member_id,
    );
    $repeat = checkMemberRepeat($v);
    var_dump($repeat);
    if ($repeat){
    echo "已存在";
    $part_id = $dtp->updateRow($table, $arr, "`member_id`={$member_id} and `brand_id`={$brand_id}",1);
    echo "<br><br>";
    }else{   
    $part_id = $dtp->insert($table, $arr, true);
    echo "<br><br>";
}
}
die();
    