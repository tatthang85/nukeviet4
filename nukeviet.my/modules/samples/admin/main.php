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

$post = $error = [];

if ($nv_Request->isset_request("change_city", "post,get")) {
    $id_city = $nv_Request->get_int('id_city', "post,get");
    if ($id_city != '') {
        $sql = "SELECT maqh, name FROM `nv4_vi_quanhuyen` WHERE matp =" . $id_city . " ORDER BY maqh ASC";
        $result = $db->query($sql);
        $html = '<option value="0">Chọn tên quận / huyện</option>';
        while ($district = $result->fetch()) {
            $html .= '<option value=" ' . $district['maqh'] . ' ">' . $district['name'] . '</option>';
        }
        die($html);
    }else {
        die("ERROR");
    }
}

$post['id'] = $nv_Request->get_int('id',"post,get",0);
if ($nv_Request->isset_request("submit", "post")) {
    $post['fullName'] = $nv_Request->get_title('fullName', 'post', '');
    $post['email'] = $nv_Request->get_title('email', 'post', '');
    $post['phone'] = $nv_Request->get_title('phone', 'post', '');
    $post['sex'] = $nv_Request->get_title('sex', 'post', '');
    $post['city'] = $nv_Request->get_title('city', 'post', '');
    $post['district'] = $nv_Request->get_title('district', 'post', '');
    $post['submit'] = $nv_Request->get_title('submit', 'post', '');
}

if (!empty($post['submit'])) {
    if(empty($post['fullName'])){
        $error[] = 'Lỗi chưa nhập họ và tên';
    }

    if(empty($post['email'])){
        $error[] = 'Lỗi chưa nhập email';
    } elseif (!preg_match("/^(.*?)&(.*?)&/", $post['email'])){
        $error['Email chưa đúng quy tắc'];
    }

    if(empty($post['phone'])){
        $error[] = 'Lỗi chưa nhập số điện thoại';
    } elseif (!preg_match('/[0-9]{10|11}/', $post['phone'])){
        $error['Số điện thoại chưa đúng quy tắc'];
    }

    if($post['sex'] == 3){
        $error[] = 'Lỗi chưa chọn giới tính';
    }

    if($post['city'] == 0){
        $error[] = 'Lỗi chưa chọn tỉnh / thành phố';
    }

//     if($post['district'] == 0){
//         $error[] = 'Lỗi chưa chọn quận / huyện';
//     }

    if (empty($error)) {
        if ($post['id'] > 0) {
            //update
            $sql = "UPDATE ".NV_PREFIXLANG."_".$module_data. " SET fullName=:fullName,email=:email,phone=:phone,sex=:sex,city=:city,district=:district,updatetime=:updatetime WHERE id= ".$post['id'];
            $stmt = $db->prepare($sql);
            $stmt->bindValue("updatetime", 0);
        } else {
            //insert
            $sql = "INSERT INTO `nv4_vi_samples`(`fullName`, `email`, `phone`, `sex`, `city`, `district`, `active`, `addtime`, `updatetime`, `weight`) VALUES (:fullName,:email,:phone,:sex,:city,:district,:active,:addtime,:updatetime,:weight)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue("active", 1);
            $stmt->bindValue("weight", 1);
            $stmt->bindValue("addtime", NV_CURRENTTIME);
        }

        $stmt->bindParam("fullName", $post['fullName']);
        $stmt->bindParam("email", $post['email']);
        $stmt->bindParam("phone", $post['phone']);
        $stmt->bindParam("sex", $post['sex']);
        $stmt->bindParam("city", $post['city']);
        $stmt->bindParam("district", $post['district']);

        $exe = $stmt->execute();
        if ($exe) {
            if ($post['id'] > 0) {
                $error[] = "Update ok";
            } else {
                $error[] = "Insert ok";
            }
        }else {
            $error[] = "Lỗi ko thực hiện được";
        }
    }

} elseif ($post['id'] > 0){
    // tồn tại id thì thực hiện lấy dữ liệu của id đó
    $sql = "SELECT * FROM ".NV_PREFIXLANG . "_". $module_data." WHERE id = ".$post['id'];
    $post = $db->query($sql)->fetch();

}else {
    $post['fullName'] = '';
    $post['email'] = '';
    $post['phone'] = '';
    $post['sex'] = 3;
    $post['city'] = 0;
    $post['district'] = 0;
}

try{
$sql = "SELECT matp, name FROM `nv4_vi_tinhthanhpho` ORDER BY matp ASC";
$result = $db->query($sql);
$array_city = [];
while ($city = $result->fetch()) {
    $array_city[$city['matp']] = $city;
}
}catch (PDOException $e){
    print_r($e);die;
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

$array_sex = [];
$array_sex [1] = "Nam";
$array_sex [2] = "Nữ";
$array_sex [3] = "N/A";

foreach ($array_sex as $key => $sex) {
    $xtpl->assign('SEX', array(
        'key' => $key,
        'title' => $sex,
        'checked' => $key == $post['sex'] ? 'checked="checked"' : ''
    ));
    $xtpl->parse('main.sex');
}

foreach ($array_city as $key => $city) {
    $xtpl->assign('CITY', array(
        'key' => $key,
        'title' => $city['name'],
        'selected' => $key == $post['city'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.city');
}

$xtpl->assign('POST',$post);
if (!empty($error)) {
    $xtpl->assign('ERROR',implode("<br/>", $error));
    $xtpl->parse('main.error');
}

// $xtpl->assign('POST', $post);
// $xtpl->assign('ERROR', implode('<br>', $error));
// if(!empty($error)){
//     $xtpl->parse('main.error');
// }

//-------------------------------
// Viết code xuất ra site vào đây
//-------------------------------

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
?>

