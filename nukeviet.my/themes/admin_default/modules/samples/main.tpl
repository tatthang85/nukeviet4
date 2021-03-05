<!-- BEGIN: main -->

<!-- BEGIN: error -->
<div class="alert alert-warning" role="alert">{ERROR}</div>
<!-- END: error -->

<p class="h1">THÔNG TIN HỌC VIÊN</p>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="form-group row">
        <div class="col-sm-6">
            <label for="name">Họ và tên:</label>
            <input class="form-control" id="name" placeholder="Nhập họ và tên" type ="text" name ="fullName" value = "{POST.fullName}">
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
            Nam <input {CHECK} class="form-check-input" id="male" type ="radio" name ="sex" value = "male">
            Nữ <input {UNCHECK} class="form-check-input" id="female" type ="radio" name ="sex" value = "female">
        </div>
    </div>
    <div>
        <div class="form-group row">
            <div class="col-sm-8">
                <label>Địa chỉ:</label>
                <select id="city" name="city" class="custom-select mb-3">
                    <option value="" {CITY_SELECTED}>Chọn tên thành phố / tỉnh</option>
            		{CITY}
                </select> --
                <select id="district" name="district" class="custom-select mb-8">
                    <option value="" {DISTRICT_SELECTED}>Chọn tên quận / huyện</option>
                    {DISTRICT}
                </select>
            </div>
        </div>    
    <div class="form-group"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>

<!-- END: main -->

