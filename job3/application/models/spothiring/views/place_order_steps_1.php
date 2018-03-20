<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// from 9-09-2016 to 28-02-2017 for regular hiring
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/resources/css/jquery.multiselect.css" />
<div class="col-md-12 mrgnbtm20"></div>
<section id="content">


    <div class="container">
        <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                    <li class="active"><a href="#step-1">
                            <h4 class="list-group-item-heading">Step 1</h4>
                            <p class="list-group-item-text">First step description</p>
                        </a></li>
                    <li class="disabled"><a href="#step-2">
                            <h4 class="list-group-item-heading">Step 2</h4>
                            <p class="list-group-item-text">Second step description</p>
                        </a></li>
                    <li class="disabled"><a href="#step-3">
                            <h4 class="list-group-item-heading">Step 3</h4>
                            <p class="list-group-item-text">Third step description</p>
                        </a></li>
                    <li class="disabled"><a href="#step-4">
                            <h4 class="list-group-item-heading">Step 4</h4>
                            <p class="list-group-item-text">Second step description</p>
                        </a></li>    
                </ul>
            </div>
        </div>


        <div class="row">
            <form enctype="multipart/form-data" role="form" id="Indentorform" method="post" action="/spothiring/order/finalorder_add_spot/" onsubmit="return validateForm();" >
                <input type="hidden" name="eFAfile" id="eFAfile" value="" />
                <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>

                <div class="pageHead">
                    <h2>Order Placement // Spot Hiring </h2>
                </div>

<!--<div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>-->
                <div class="col-md-12 mrgnbtm20"></div>

                <div class="formBox">
                    <h2 class="formHead">Order Information</h2>
                    <div class="row">

                        <div class="col-md-3 col-xs-6">
                            <label>Order No. </label>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <input readonly="" class="input" type="text" id="order_no" name="order_no" value="<?php echo $booked_no; ?>" > 
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <label>Service Provider</label>
                        </div>
                        <div class="col-md-3 col-xs-6" id="usrDept">
                            <input readonly="" class="input" type="text" name="service_provider" value="<?php echo ucwords($booked_data->s_comp_name); ?>" > 
                        </div>
                        <!--<div class="col-md-12 mrgnbtm20"></div>-->
                        <?php /* ?><div class="col-md-3 col-xs-6">
                          <label>Start Date </label>
                          </div>
                          <div class="col-md-3 col-xs-6" id="usrDept">
                          <?php
                          $date = str_replace('-', '/', $booked_data->car_or_startdate);
                          $date1 = str_replace('-', '/', $booked_data->car_or_enddate);

                          $currdate = date('m-d-Y', strtotime($date));
                          $onemonth = date('m-d-Y', strtotime($date1));
                          ?>
                          <input class    ="input" id="expected_start_date" name="start_date" autocomplete="off" placeholder="Start Date" value="<?php echo $currdate; ?>"  required/>
                          </div>
                          <div class="col-md-3 col-xs-6">
                          <label>End Date </label>
                          </div>
                          <div class="col-md-3 col-xs-6" id="usrDept">
                          <input class="input" id="expected_end_date" name="end_date" autocomplete="off" placeholder="End Date" value="<?php echo $onemonth ?>"  required/>
                          </div><?php */ ?>


                        <div class="col-md-12 mrgnbtm20"></div>
                        <div class="col-md-3 col-xs-6">
                            <label>Select End User</label>
                        </div>
                        <div class="col-md-3 col-xs-6" id="usrDept">

                            <select class="select" id="ddConsignee" multiple="1" name="end_user[]" required="">
                                <?php
                                $userId = $this->nehbr_auth->get_user_id();
                                $usrParent = $this->db->select('u_parent_id as p_id ,u_dept_id as u_dept_id', false)->from('users')->where('u_id', $userId)->get()->result();
                                if ($userId) {
                                    $userRoles = $this->db->select('usr.u_id,usr.u_email,usr.u_firstname , ur.ur_role')->from('users as usr')->join('user_roles as ur', 'ur.ur_user_id = usr.u_id', 'left')->where_in('ur.ur_role', array('7', '3', '4', '5', '6', '2'))->where('( usr.u_parent_id = ' . $usrParent[0]->p_id . '  or  usr.u_id  = ' . $usrParent[0]->p_id . '  ) and ( usr.u_status = 1 ) ')->group_by('usr.u_id')->get()->result();
                                    $q = $this->db->queries;
                                    if (!empty($userRoles)) {

                                        foreach ($userRoles as $row) {
                                            if ($row->ur_role == "2") {
                                                echo '<option readonly selected="selected" value="' . $row->u_id . '">' . $row->u_firstname . '  -  ' . $row->u_email . '</option>';
                                            } else {
                                                echo '<option value="' . $row->u_id . '">' . $row->u_firstname . '  -  ' . $row->u_email . '</option>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>                         
                        </div>


                        <?php /* ?> <div class="col-md-3 col-xs-6">
                          <label>Select Payment Authority</label>
                          </div>
                          <div class="col-md-3 col-xs-6" id="usrDept">

                          <select class="select" id="ddPayAuthroty" name="ddPayAuthroty">
                          <?php
                          $userId = $this->nehbr_auth->get_user_id();
                          if ($userId) {
                          $userRoles = $this->db->select('usr.u_id,usr.u_email,usr.u_firstname')->from('users as usr')->join('user_roles as ur', 'ur.ur_user_id = usr.u_id', 'left')->where('ur.ur_role', '9')->where('usr.u_parent_id', $usrParent[0]->p_id)->get()->result();
                          if (!empty($userRoles)) {

                          foreach ($userRoles as $row) {
                          echo '<option value="' . $row->u_id . '">' . $row->u_firstname . '  -  ' . $row->u_email . '</option>';
                          }
                          }
                          }
                          ?>
                          </select>
                          </div><?php */ ?>

                        <!--<div class="col-md-3 col-xs-6">
                            <label>Financial Approval <small class="red">(Only .PDF file)</small></label>
                        </div>
                        <div class="col-md-3 col-xs-6" id="usrDept">
                            <input accept="application/pdf"  required="" type="file" class="input" name="FinancialApprove" autocomplete="off" placeholder="Financial Approval" value=""/>
    
                        <?php //echo form_error('FinancialApproval');  ?>
                             <p id="errFANo" class="red" style="display:none" ></p> 
                        </div>-->

                        <div  style="display:block">
                            <div class="col-md-4 col-xs-8">
                                <label>Financial Approval <small class="red">(Only .PDF file)</small></label>
                                <input accept="application/pdf"  required="" type="file" class="input" id="FinancialApproval" name="FinancialApproval" autocomplete="off" placeholder="Financial Approval"   value="" />
                                <?php echo form_error('FinancialApproval'); ?>
                                <p id="errFANo" class="red" style="display:none" ></p> 
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <label>&nbsp;</label>
                                <a id="upload" class="button FAuploadDiv" >Upload & Verify</a> 
                                <a style="display: none;" id="ViewFile" target="_blank" class="button" href="/carlisting/show_SignedPO/<?php echo $booked_no; ?>">View</a> 
                            </div>
                            <div class="col-md-3 col-xs-6">

                            </div>
                            <div class="col-md-3 col-xs-6">
                            </div>     
                            <div class="col-md-6 otpCtrl row" style="display:none">
                                <div class="col-md-7 col-xs-7">
                                    <label>Enter OTP <sup class="red">&lowast;</sup></label>
                                    <input autocomplete="off" type="number" onKeyPress="return isNumberKey(event)" id="aadharotp1" value="" class="input" maxlength="8"/>
                                    <p id="errFANo1" class="red" style="display:none" ></p>
                                </div>
                                <div class="col-md-5 col-xs-5">
                                    <label>&nbsp;</label>
                                    <a  onclick="generate_verify()" class="button mrgnRight10">Verify</a>
                                    <a  onclick="init_Esign()" class="button redButton">RESEND OTP</a>


                                </div>
                            </div>
                        </div>





                    </div>
                </div>
                <?php
                if (!empty($booked_data)) {
                    ?>
                    <div class="formBox">
                        <h2 class="formHead">Car Description</h2>
                        <div class="row">

                            <table id="example1" style="margin:auto;width:80%" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>

                                        <th>S. No</th>
                                        <th>Engine Capacity</th>                                            	
                                        <th>Service Provider</th>
                                        <th>City</th>
                                        <th>Base Price</th>  
                                        <th>Price/KM</th> 
                                        <th>Waiting Time/min</th> 



                                    </tr>
                                </thead> 
                                <tbody>


                                    <tr>
                                        <td>1</td>
                                        <td><?php echo $booked_data->car_enginecapacity; ?> cc</td>
                                        <td><?php echo ucwords($booked_data->s_comp_name); ?></td>
                                        <td><?php echo ucwords($booked_data->city == 1 ? 'Delhi' : $booked_data->city ); ?></td>



                                        <td><?php echo $booked_data->car_od_basefare; ?>/-</td>
                                        <td><?php echo $booked_data->car_od_price_prkm; ?>/-</td>
                                        <td><?php echo $booked_data->car_od_watingpriceprmin; ?>/-</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>                  
                        <div class="clearfix"></div>
                    </div>
                    <!--COMPANY INFO-->
                    <?php
                }
                ?>
                <?php
                if (!empty($comparision_data)) {
//                                    echo"<pre>";
//                                    print_r($comparision_data);
//                                    die;
                    ?>
                    <div class="formBox">
                        <h2 class="formHead">Car Comparison List</h2>
                        <div class="row">

                            <table id="example1" style="margin:auto;width:80%" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Engine Capacity</th>                                            	
                                        <th>Service Provider</th>
                                        <th>City</th>
                                        <th>Base Price</th>  
                                        <th>Price/KM</th> 
                                        <th>Waiting Time/min</th> 


                                    </tr>
                                </thead> 
                                <tbody>

                                    <?php
                                    $cnt = 1;
                                    foreach ($comparision_data as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $value->car_enginecapacity; ?> cc</td>
                                            <td><?php echo ucwords($value->s_comp_name); ?></td>
                                            <td><?php echo ucwords($booked_data->city == 1 ? 'Delhi' : $booked_data->city); ?></td>

                                            <td><?php echo $value->car_od_basefare; ?>/-</td>
                                            <td><?php echo $value->car_od_price_prkm; ?>/-</td>
                                            <td><?php echo $value->car_od_watingpriceprmin; ?>/-</td>
                                        </tr>
                                        <?php
                                        $cnt++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>                  
                        <div class="clearfix"></div>
                    </div>
                    <!--COMPANY INFO-->
                    <?php
                }
                ?>

                <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_hash; ?>" />
                <input type="hidden" name="trailid" id="trailid" value="<?php echo $trail_id; ?>" />
                <div class="formBox">

                    <h2 class="formHead">Approval Specifications</h2>


                    <div class="col-md-12 mrgnbtm20"></div>

                    <div class="col-md-12 col-xs-12">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-3 col-xs-6">
                                <label>Approval Id <sup class="red">∗</sup></label>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <input type="text" class="input"  name="approval_id" required/>
                            </div>    
                            <div class="col-md-3 col-xs-6">
                                <label>Approved By <sup class="red">∗</sup></label>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <input type="text" class="input" name="approval_by" onKeyPress="return validateNameString(event, this)"  required/>
                            </div> 
                            <div class="col-md-12 mrgnbtm20"></div>
                            <div class="col-md-12 col-xs-12">
                                <label>Remarks </label>
                                <textarea value=""  name="remarks" id="prod_desc" class="textarea" required="" placeholder="Request approved for  <NAME>, Department to book the vechile(Brand) starting from dd-mm-yyyy to dd-mm-yyyy "> </textarea>
                            </div>
                        </div>
                    </div>




                    <div class="col-md-12 mrgnbtm20"></div>

                    <div class="col-md-12 col-xs-12 text-center">
                        <input type="button" class="button" value="UnBook Car" id="unblock" name="unblock"/>
                        <input type="submit" class="button" value="Save and ADD additional Users" name="process"/>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!--ACCOUNT DETAIL-->



                <div class="col-md-12 mrgnbtm20"></div>

                <?php if ($alreadybooked->order_id != "") { ?>
                    <div class="alert alert-warning alert-dismissable"><i class="fa fa-error"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Out of Stock.</b> Currently this Taxi for <?php echo $booked_data->service_type; ?>  <?php echo $booked_data->servicesubtype; ?></div>
                <?php } ?>


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
<script type="text/javascript">
                                    function isNumberKey(e) {
                                        evt = e || window.event;
                                        var t = evt.which || evt.keyCode;
                                        return"Left" == evt.key || "Up" == evt.key || "Right" == evt.key || "Down" == evt.key || "ArrowLeft" == evt.key || "ArrowUp" == evt.key || "ArrowRight" == evt.key || "ArrowDown" == evt.key || "Del" == evt.key || "Delete" == evt.key || "Backspace" == evt.key || "Tab" == evt.key || "Enter" == evt.key ? !0 : "-" == evt.key ? !1 : "48" != t && "49" != t && "50" != t && "51" != t && "52" != t && "53" != t && "54" != t && "55" != t && "56" != t && "57" != t && "45" != t && "46" != t ? !1 : !0;/*fnbynileshgupta;gupta.nilesh76@gmail.com;*/
                                    }
                                    var UserDetails = new Object();

                                    $(document).ready(function () {


                                        $('.updateStatus').click(function () {
                                            var status = $('.radioBtn:checked').val();
                                            var U_ID = $('#user_id').val();


                                            var rejected_reason = '';
                                            if (status == 4) {
                                                rejected_reason = $.trim($('.rejected_reason').val());
                                                if (rejected_reason == '') {
                                                    alert('Please add reason for rejected.');
                                                    return false;
                                                }
                                            }
                                            var uId = U_ID;
                                            $.ajax({
                                                url: "<?php echo base_url() ?>dgsnd/supplierapproval/updatehodstatus",
                                                async: false,
                                                type: "POST",
                                                data: "uId=" + uId + "&status=" + status + "&remarks=" + rejected_reason,
                                                dataType: "JSON",
                                                success: function (returnData) {
                                                    alert(returnData ['return_message']);
                                                    window.location = window.location;
                                                }
                                            });
                                        });

                                        $(document).on("click", "#upload", function () {

                                            $('#FinancialApproval').addClass('loadinggif');
                                            if ($('#FinancialApproval').val() == "") {
                                                $("#errFANo").show();
                                                $("#errFANo").html("Please select file");
                                                return;
                                            }

                                            $(".otpCtrl").slideUp(200);
                                            $("#otpCtrl").hide();

                                            var file_data = $("#FinancialApproval").prop("files")[0];   // Getting the properties of file from file field
                                            var form_data = new FormData();                  // Creating object of FormData class
                                            form_data.append("file", file_data)              // Appending parameter named file with properties of file_field to form_data
                                            form_data.append("demand_id", $('#order_no').val());
                                            $.ajax({
                                                url: '/carlisting/FAupload/', // point to server-side PHP script 
                                                dataType: 'json', // what to expect back from the PHP script, if anything
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                data: form_data,
                                                type: 'post',
                                                success: function (data) {
                                                    // display response from the PHP script, if any
                                                    console.log(data);
//                    alert(data['error']);
// alert(data['success']);
                                                    if (data['error'] == true)
                                                    {
                                                        $(".otpCtrl").slideUp(200);
                                                        $("#otpCtrl").hide();

                                                        $("#errFANo").show();
                                                        $("#errFANo").html(data['return_message']);
                                                        $('#FinancialApproval').removeClass('loadinggif');

                                                    }
//alert(data['status']);
                                                    if (data['status'] == true)

                                                    {
                                                        $(".otpCtrl").slideDown(200);
                                                        $("#otpCtrl").hide();
                                                        $("#errFANo").hide();
//                         alert(data['filename']);
                                                        $('#FinancialApproval').removeClass('loadinggif');
                                                    }
                                                }
                                            });

                                        });

                                        $('#unblock').click(function () {
                                            var uId = $('#trailid').val();
                                            $.ajax({
                                                url: "<?php echo base_url() ?>carlisting/unblock_car_spot",
                                                async: false,
                                                type: "POST",
                                                data: "uId=" + uId,
                                                dataType: "JSON",
                                                success: function (returnData) {
                                                    if (returnData == 'success')
                                                    {
                                                        window.location.href = '/carlisting/place_order';
                                                    }
                                                }
                                            });
                                        });




                                    });

</script>


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