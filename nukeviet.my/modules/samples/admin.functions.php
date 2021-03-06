<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sat, 31 Oct 2020 02:20:33 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

define('NV_IS_FILE_ADMIN', true);

$allow_func = ['main', 'config', 'list'];

$array_gender = [];
$array_gender[1] = "Nam";
$array_gender[2] = "Nữ";
$array_gender[3] = "N/A";

$sql = "SELECT matp,name FROM `nv4_vi_tinhthanhpho` ORDER BY matp ASC";
$result = $db->query($sql);
$array_city = [];
while ($city = $result->fetch()) {
    $array_city[$city['matp']] = $city;
}