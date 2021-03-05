/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sat, 31 Oct 2020 02:20:33 GMT
 */

$(document).ready(function() {
    $("#city").change(function() {
        sendcityname()
    });
});

function sendcityname() {
    var city = document.getElementById('city').value;
    $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=sendcityname&nocache=' + new Date().getTime(), 'selected_city=' + city, function(data) {
        $("#district").html(data);
    });
    return;
}
