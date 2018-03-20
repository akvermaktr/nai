
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/resources/css/jquery.multiselect.css" />
<div class="col-md-12 mrgnbtm20"></div>
<section id="content">
<div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>

    <div class="container">
        <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                    <li class="active"><a href="#step-1">
                            <h4 class="list-group-item-heading">Step 1</h4>
                            <p class="list-group-item-text">Basic Details</p>
                        </a></li>
                    <li class="disabled"><a href="#step-2">
                            <h4 class="list-group-item-heading">Step 2</h4>
                            <p class="list-group-item-text">Application Details</p>
                        </a></li>
                    <li class="disabled"><a href="#step-3">
                            <h4 class="list-group-item-heading">Step 3</h4>
                            <p class="list-group-item-text">Qualification Details</p>
                        </a></li>
                     
                    <li class="disabled"><a href="#step-4">
                            <h4 class="list-group-item-heading">Step 4</h4>
                            <p class="list-group-item-text">Confirm and Payment</p>
                        </a></li> 
                    <li class="disabled"><a href="#step-4">
                            <h4 class="list-group-item-heading">Step 5</h4>
                            <p class="list-group-item-text">Finish </p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="row">
            
                <input type="hidden" name="eFAfile" id="eFAfile" value="" />
                <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>

                <div class="pageHead">
                    <h2>Basic Details</h2>
                </div>

<!--<div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>-->
                <div class="col-md-12 mrgnbtm20"></div>

                <div class="formBox">
                    <h2 class="formHead"></h2>

                </div>
                <form class="form-horizontal" action="">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Password:</label>
                        <div class="col-sm-10">          
                            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
                        </div>
                    </div>
                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label><input type="checkbox" name="remember"> Remember me</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-7">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                        
                        <div class="col-sm-offset-1 col-sm-2 ">
                            <button type="submit" class="btn pull-right btn-default">Next</button>
                        </div>
                    </div>
        

            </form>


        </div>

    </div>


</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript">




</script>








<script src="/resources/js/jquery-ui.js"></script>
<script src="/resources/js/custom/addCars.js"></script>
<script src="/resources/css/jquery-ui.css"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/jquery.multiselect.js"></script>


<script>
                $(function () {

                    $("#expected_start_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd-mm-yy",
                        minDate: "1D",
//      yearRange: "-100:+0"
                    });
                    $("#expected_end_date").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd-mm-yy",
                        minDate: "1D",
//      yearRange: "-100:+0"
                    });
                    $('#ddConsignee').multiselect();
                });
</script>

<script type="text/javascript">
    var PRODUCT_SPECIFICATION_BOX_HTML = $('.specBox:first').html();
    var PRODUCT_SPECIFICATION_BOX_CLASS = $('.specBox:first').attr('class');
    var CUSTOM_SPECIFICATION_HTML = $('.specificationsBox').html();
    var SPECIFICATION_RES = new Object();
    var TOTAL_ALLOWED_SPECS = 6;
    $(document).ready(function () {


        //  lastValue = '';
        $("#yearExp").on('change keyup paste mouseup', function () {
            // if ($(this).val() != lastValue) {
            var qty = $(this).val();
            var base_fare = parseInt(<?php echo $booked_data->car_od_basefare; ?>);
            var estimate = qty * base_fare;
            $('#estimate_prc').val(estimate);
        });

    });
    function canAddSpecifications() {
        var catSpecs = $('#productSpecificationBox .specBox').length;
        var customSpecs = $('.specificationsBox>div').length;
        var totalSpecs = catSpecs + customSpecs;
        if (totalSpecs < TOTAL_ALLOWED_SPECS) {
            return true;
        }
        return false;
    }
    function removeCustomExtraSpecs() {
        var catSpecs = $('#productSpecificationBox .specBox').length;
        var customSpecs = $('.specificationsBox>div').length;
        var totalSpecs = catSpecs + customSpecs;
        if (totalSpecs > TOTAL_ALLOWED_SPECS) {
            for (var i = totalSpecs; totalSpecs > TOTAL_ALLOWED_SPECS; totalSpecs--) {
                $('.specificationsBox>div:last').remove();
            }
        }
    }

    function init_Esign() {
        // alert('sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss');
        if ($('#FinancialApproval').val() == "")
        {
            $("#errFANo").show();
            $("#errFANo").html("Please select file");
            return;
        }
        $.ajax({
            url: "<?php echo base_url() ?>carlisting/genereate_otp",
            async: true,
            type: "POST",
            data: "aadhar=1",
            dataType: "json",
            success: function (data) {
//                alert("vinay,9460395370");
                if (data['status'] = 'true') {
                    $(".otpCtrl").slideDown(200);
                    $("#otpCtrl").hide();
                }
            }
        });
    }



    function generate_verify() {
        var otp = $('#aadharotp1').val();

        if (otp == "")
        {
            $("#errFANo1").show();
            $("#errFANo1").html("Please enter OTP to verify document");
            return;
        }

        $('#aadharotp1').addClass('loadinggif');
        $.ajax({
            url: "<?php echo base_url() ?>carlisting/aadhar_sign_pdf",
            async: true,
            type: "POST",
            data: "aadhar=" + otp + "&demid=" + $('#order_no').val(),
            dataType: "json",
            success: function (data) {
                console.log(data);
//    data['status'] = "success";
                if (data['status'] == "success") {

                    $("#FAuploadDiv").slideUp(200);
                    $(".FAuploadDiv").slideUp(200);
                    $("#ViewFile").slideDown(200);
                    $('#eFAfile').val("true");
                    $('#aadharotp1').removeClass('loadinggif');

                    $(".otpCtrl").slideUp(200);
                    $("#otpCtrl").hide();

//                                    window.location = "/consignee/processuccess/"+data['notID'];
                }
                if (data['status'] == "error") {
                    alert("Verification Failed Please Try Again.");
                    $('#aadharotp1').removeClass('loadinggif');
                    $('#eFAfile').val("");

                    $("#FAuploadDiv").slideDown(200);
                    $(".FAuploadDiv").slideDown(200);
                    $("#ViewFile").slideUp(200);
//                                       $(".otpCtrl").slideUp(200);
//                                       $("#otpCtrl").hide();
                }

            }
        });
    }

    function validateForm() {
        if ($('#eFAfile').val() == "") {
            alert('Approval file is not uploaded or not e-signed properly, please retry.');
            $('#aadharotp1').focus();
            return false;
        }

        if ($('#ddConsignee').val() == "") {
            alert('Approval file is not uploaded or not e-signed properly, please retry.');
            $('#aadharotp1').focus();
            return false;
        }
    }
</script>


<style type="text/css">
    #hodDetail p{
        font-weight: bold;
    }
    input[type="button"] {
        border: 0 none;
        margin: 20px 10px;
    }
    .loadinggif {
        background:url('/resources/images/ajax-loader.gif') no-repeat right center;

    }
</style>