<!-- BEGIN: main -->

<!-- BEGIN: error -->
<div class="alert alert-warning" role="alert">{ERROR}</div>
<!-- END: error -->

<p class="h1">THÔNG TIN HỌC VIÊN</p>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <input type="hidden" name="id" value="{POST.id}">
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="name">Họ và tên:</label>
            <input class="form-control" id="name" placeholder="Nhập họ và tên" type ="text" name ="fullName" value = "{POST.fullname}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="email">Email:</label>
            <input class="form-control" id="email" placeholder="Nhập email" type ="email" name ="email" value = "{POST.email}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="text">Điện thoại:</label>
            <input class="form-control" id="phone" placeholder="Nhập số điện thoại" type ="text" name ="phone" value = "{POST.phone}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="sex">Giới tính:</label>
        </div>
        <div class="col-md-20">
<!-- BEGIN: sex -->
            <input class="form-control" id="male" type ="radio" name ="sex" value = "{SEX.key}" {SEX.checked}> {SEX.title}
<!-- END: sex -->
        </div>
    </div>
    <div>
        <div class="form-group row">
            <div class="col-sm-8">
                <label>Địa chỉ:</label>
            </div>
            <div class="col-md-20 form-inline">
                <select id="city" name="city" class="form-control" onchange="change_city()">
                    <option value="0">Chọn tên thành phố / tỉnh</option>
                    <!-- BEGIN: city -->
            		<option value="{CITY.key}" {CITY.selected}>{CITY.title}</option>
                    <!-- END: city -->
                </select> --
                <select id="district" name="district" class="form-control">
                    <option value="0">Chọn tên quận / huyện</option>                  
                </select>
            </div>
        </div>    
    <div class="form-group"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>

<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>

<script type="text/javascript">
    $("#city").select2();
    $("#district").select2();

    function change_city(){
        var id_city = $('#city').val();
        $.ajax({
            url : script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&change_city=1&id_city=' + id_city,
            success : function(result) {
                if(result != "ERROR"){
                    $('#district').html(result);
                }
            }
        });
       
    }
</script>

<!-- END: main -->

