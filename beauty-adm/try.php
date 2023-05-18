<!DOCTYPE html>
<html>
<head>
<!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />
     <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="vendor/toastr/build/toastr.min.css" />

    <link rel="stylesheet" href="../template/Homer_Full_Version_HTML_JS/vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="../template/Homer_Full_Version_HTML_JS/vendor/select2-bootstrap/select2-bootstrap.css" />
    <link rel="stylesheet" href="../template/Homer_Full_Version_HTML_JS/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
    <link rel="stylesheet" href="../template/Homer_Full_Version_HTML_JS/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../template/Homer_Full_Version_HTML_JS/vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" />
    <link rel="stylesheet" href="../template/Homer_Full_Version_HTML_JS/vendor/clockpicker/dist/bootstrap-clockpicker.min.css" />
    <link rel="stylesheet" href="../template/Homer_Full_Version_HTML_JS/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="styles/style.css">
     <link rel="stylesheet" href="styles/static_custom.css">
	<title></title>
</head>
<body>

        <div class="col-lg-6">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                    Select2
                </div>
                <div class="panel-body">

                    <p>
                        <strong>Select2</strong> Select2 gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options.
                    </p>

                    <h5>Bootstrap theme with Select 2 - basic example</h5>
                    <select class="js-source-states" style="width: 100%">
                        <optgroup label="Alaskan/Hawaiian Time Zone">
                            <option value="AK">Alaska</option>
                            <option value="HI">Hawaii</option>
                        </optgroup>
                        <optgroup label="Pacific Time Zone">
                            <option value="CA">California</option>
                            <option value="NV">Nevada</option>
                            <option value="OR">Oregon</option>
                            <option value="WA">Washington</option>
                        </optgroup>
                        <optgroup label="Mountain Time Zone">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NM">New Mexico</option>
                            <option value="ND">North Dakota</option>
                            <option value="UT">Utah</option>
                            <option value="WY">Wyoming</option>
                        </optgroup>
                        <optgroup label="Central Time Zone">
                            <option value="AL">Alabama</option>
                            <option value="AR">Arkansas</option>
                            <option value="IL">Illinois</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="OK">Oklahoma</option>
                            <option value="SD">South Dakota</option>
                            <option value="TX">Texas</option>
                            <option value="TN">Tennessee</option>
                            <option value="WI">Wisconsin</option>
                        </optgroup>
                        <optgroup label="Eastern Time Zone">
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="IN">Indiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="OH">Ohio</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WV">West Virginia</option>
                        </optgroup>
                    </select>

                    <h5 class="m-t-md">Multi Selection example</h5>
                    <select class="js-source-states-2" multiple="multiple" style="width: 100%">
                            <option value="Blue">Blue</option>
                            <option value="Red">Red</option>
                            <option value="Green">Green</option>
                            <option value="Maroon">Maroon</option>
                    </select>


                </div>
            </div>


            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                    Bootstrap TouchSpin
                </div>
                <div class="panel-body">

                    <p>
                        <strong>TouchSpin</strong> A mobile and touch friendly input spinner component for Bootstrap 3. It supports the mousewheel and the up/down keys.
                    </p>

                    <div>
                        <h5>Basci example</h5>
                        <input id="demo1" type="text"  name="demo1" value="50">
                    </div>

                    <div class="m-t-md">
                        <h5>Vertical button alignment:</h5>
                        <input id="demo2" type="text"  name="demo2" value="50">
                    </div>

                    <div class="m-t-md">
                        <h5>Example with postfix </h5>
                        <input id="demo3" type="text"  name="demo3" value="50">
                    </div>

                    <div class="m-t-md">
                        <h5>Basci with button postfix </h5>
                        <input id="demo4" type="text"  name="demo4" value="50">
                    </div>

                </div>
            </div>
        </div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="vendor/toastr/build/toastr.min.js"></script>

<!-- Vendor scripts -->

<script src="../template/Homer_Full_Version_HTML_JS/vendor/moment/moment.js"></script>
<script src="../template/Homer_Full_Version_HTML_JS/vendor/xeditable/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="../template/Homer_Full_Version_HTML_JS/vendor/select2-3.5.2/select2.min.js"></script>
<script src="../template/Homer_Full_Version_HTML_JS/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="../template/Homer_Full_Version_HTML_JS/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../template/Homer_Full_Version_HTML_JS/vendor/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
<script src="../template/Homer_Full_Version_HTML_JS/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


<!-- App scripts -->
<script src="scripts/homer.js"></script>

</body>
</html>