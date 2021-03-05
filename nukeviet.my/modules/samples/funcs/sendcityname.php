<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung (phantandung92@gmail.com)
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 05:11 PM
 */
if (!defined('NV_IS_MOD_MUSIC'))
    die('Stop!!!');
if (!defined('NV_IS_AJAX'))
    die('Wrong URL');

$selected_city = $_POST('selected_city');

echo $selected_city;


?>