<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sat, 31 Oct 2020 02:20:33 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['main'];

$city_selected_first = 'selected';
$city_selected_last = '';
$district_selected_first = 'selected';
$district_selected_last = '';

$sql_city = "SELECT `matp`, `name` FROM `nv4_vi_tinhthanhpho`";
$result_city = $db->query($sql_city);
while ($row_city = $result_city->fetch()) {
    $xhtml_city .= '<option value="'.$row_city['matp'].'">'.$row_city['name'].'</option>';
}




$check = '';
$uncheck = '';
$post = [];
$error = [];
$post['fullName'] = $nv_Request->get_title('fullName', 'post', '');
$post['email'] = $nv_Request->get_title('email', 'post', '');
$post['phone'] = $nv_Request->get_title('phone', 'post', '');
$post['sex'] = $nv_Request->get_title('sex', 'post', '');
$post['city'] = $nv_Request->get_title('city', 'post', '');
$post['district'] = $nv_Request->get_title('district', 'post', '');
$post['submit'] = $nv_Request->get_title('submit', 'post', '');
if (!empty($post['submit'])) {
    if(empty($post['fullName'])){
        $error[] = 'Lỗi chưa nhập họ và tên';
    }

    if(empty($post['email'])){
        $error[] = 'Lỗi chưa nhập email';
    }

    if(empty($post['phone'])){
        $error[] = 'Lỗi chưa nhập số điện thoại';
    }

    if(empty($post['sex'])){
        $error[] = 'Lỗi chưa chọn giới tính';
    }

    if(empty($post['city'])){
        $error[] = 'Lỗi chưa nhập địa chỉ - tên thành phố / tỉnh';
    }else {
        $sql_city = "SELECT `matp`, `name` FROM `nv4_vi_tinhthanhpho`";
        $result_city = $db->query($sql_city);
        while ($row_city = $result_city->fetch()) {
            if ($post['city'] == $row_city['matp']) {
                $city_selected_last = 'selected';
                $city_selected_first = '';
                $xhtml_city .= '<option '.$city_selected_last.' value="'.$row_city['matp'].'">'.$row_city['name'].'</option>';
            }else {
                $xhtml_city .= '<option value="'.$row_city['matp'].'">'.$row_city['name'].'</option>';
            }
        }
    }

    if(empty($post['district'])){
        $error[] = 'Lỗi chưa nhập địa chỉ - tên quận / huyện';
    }else {
        $sql_district = "SELECT `maqh`, `name` FROM `nv4_vi_quanhuyen` WHERE `matp` = ".$selected_city."";
        $result_district = $db->query($sql_district);
        while ($row_district = $result_district->fetch()) {
            if ($post['district'] == $row_district['maqh']) {
                $district_selected_last = 'selected';
                $district_selected_first = '';
                $xhtml_district .= '<option '.$district_selected_last.' value="'.$row_district['maqh'].'">'.$row_district['name'].'</option>';
            }else {
                $xhtml_district .= '<option value="'.$row_district['maqh'].'">'.$row_district['name'].'</option>';
            }
        }
    }

    if (empty($error)) {
        $sql = "INSERT INTO `nv4_vi_samples`(`id`, `fullName`, `email`, `phone`, `sex`, `city`, `district`) VALUES (NULL,'".$post['fullName']."','".$post['email']."','".$post['phone']."','".$post['sex']."','".$post['city']."','".$post['district']."')";
        $db->query($sql);
    }

    if ($post['sex'] == 'male') {
        $check = 'checked';
        $uncheck = '';
    }else {
        $check = '';
        $uncheck = 'checked';
    }

}

//------------------------------
// Viết code xử lý chung vào đây
//------------------------------

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('POST', $post);
$xtpl->assign('ERROR', implode('<br>', $error));
if(!empty($error)){
    $xtpl->parse('main.error');
}
$xtpl->assign('CITY', $xhtml_city);
$xtpl->assign('DISTRICT', $xhtml_district);
$xtpl->assign('CHECK', $check);
$xtpl->assign('UNCHECK', $uncheck);
$xtpl->assign('CITY_SELECTED', $city_selected_first);
$xtpl->assign('DISTRICT_SELECTED', $district_selected_first);



//-------------------------------
// Viết code xuất ra site vào đây
//-------------------------------

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';

echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
?>

