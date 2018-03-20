<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// from 9-09-2016 to 28-02-2017 for regular hiring
?>
<div class="col-md-12 mrgnbtm20"></div>
<section id="content">
    <div class="container">
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

// from 9-09-2016 to 28-02-2017 for regular hiring
        ?>
        <div class="col-md-12 mrgnbtm20"></div>
        <section id="content">


            <div class="container">
                <div class="row form-group">
                    <div class="col-xs-12">
                        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                            <li class="disabled"><a href="#step-1">
                                    <h4 class="list-group-item-heading">Step 1</h4>
                                    <p class="list-group-item-text">First step description</p>
                                </a></li>
                            <li class="active"><a href="#step-2">
                                    <h4 class="list-group-item-heading">Step 2</h4>
                                    <p class="list-group-item-text">ADD Additional Users</p>
                                </a></li>
                            <li class="disabled"><a href="#step-3">
                                    <h4 class="list-group-item-heading">Step 3</h4>
                                    <p class="list-group-item-text">Order Preview</p>
                                </a></li>
                            <li class="disabled"><a href="#step-4">
                                    <h4 class="list-group-item-heading">Final Step</h4>
                                    <p class="list-group-item-text">Complete your Order</p>
                                </a></li>    
                        </ul>
                    </div>
                </div>
            </div>	

            <div class="col-md-4 col-xs-12">
                <label>Import User Data From CSV <small class="red">(Only .CSV file)</small></label>
                <input accept="application/csv" type="file" class="input" id="FinancialApproval" name="FinancialApproval" autocomplete="off" placeholder="Financial Approval"   value="" />
                <?php echo form_error('FinancialApproval'); ?>
                <p id="errFANo" class="red" style="display:none" ></p> 
            </div>
            <div class="col-md-2 col-xs-12">
                <label>&nbsp;</label>
                <a id="upload" class="button FAuploadDiv" >Upload & Verify</a> 
                <a style="display: none;" id="ViewFile" target="_blank" class="button" href="/carlisting/show_SignedPO/<?php echo $booked_no; ?>">View</a> 
            </div>

            <div class="col-md-6 otpCtrl row" style="display:none">
                <div class="col-md-7 col-xs-7">
                    <label>Enter OTP <sup class="red">&lowast;</sup></label>
                    <input autocomplete="off" type="number" onKeyPress="return isNumberKey(event)"  id=aadharotp1 value="" class="input" maxlength="8"/>
                </div>
                <div class="col-md-5 col-xs-5">
                    <label>&nbsp;</label>
                    <a  onclick="generate_verify()" class="button mrgnRight10">Verify</a>
                    <a  onclick="init_Esign()" class="button redButton">RESEND OTP</a>
                </div>
            </div>
            <div class="col-md-6 otpCtrl row" >

                <div class="col-md-4 col-xs-5">
                    <label>&nbsp;</label>

                    <a   class="button pastefrom redButton"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        Ctrl + C</a>
                </div>

                <div class="col-md-4 col-xs-5">
                    <label>&nbsp;</label>

                    <a   class="button pastefrom redButton">COPY DATA FROM EXCEL</a>
                </div>
                <div class="col-md-4 col-xs-5">
                    <label>&nbsp;</label>

                    <a   class="button pastefrom redButton">Ctrl+V</a>
                </div>

            </div>

            <div class="col-md-12 inline-form">
                <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="api_test_form">                            
                    <div style="color:#F00"><strong></strong></div>
                    <div class="alert alert-danger jserror" style="display:none;">
                        <ul id="error_msg">               
                        </ul>
                    </div>

                    <h4><b>Create Spot Users</b></h4>
                    <div class="service">
                        <div class="row">
                            <div class="col-md-3 col-xs-12 ">
                                <label for="user_name"> Name</label>
                            </div>
                            <div class="col-md-2 col-xs-12 ">
                                <label for="user_name"> Mobile</label>
                            </div>
                            <div class="col-md-3 col-xs-12 ">
                                <label for="user_name">E-Mail Address</label>
                            </div>
                            <div class="col-md-2 col-xs-12 ">
                                <label for="user_name">Department </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-10 specificationsBox">
                                <div class="row">
                                    <div class="col-md-3 col-xs-12 ">
                                     
                                        <input type="text" value="" id="user_name"   name="user_name[]"  class="input" placeholder=" Name" required/>
                                    </div>
                                    <div class="col-md-2 col-xs-12 ">
                                        <input type="number" value="" id="user_mobile"   name="user_mobile[]"  class="input" placeholder=" Mobile" required/>
                                    </div>
                                    <div class="col-md-3 col-xs-12 ">
                                        <input type="email" value="" id="user_email"   name="user_email[]"  class="input" placeholder="E-mail" required/>
                                    </div>
                                    <div class="col-md-2 col-xs-12 ">
                                        <select name="method" class="select api_mothod">
                                            <option value="">--Select Method-- </option>
                                            <option <?php if (strtolower($method) == "get") echo "selected" ?> value="get"> GET </option>
                                            <option <?php if (strtolower($method) == "post") echo "selected" ?> value="post"> POST </option>
                                            <option <?php if (strtolower($method) == "put") echo "selected" ?> value="put"> PUT </option>
                                            <option <?php if (strtolower($method) == "delete") echo "selected" ?> value="delete"> DELETE </option>
                                            <option <?php if (strtolower($method) == "head") echo "selected" ?> value="head"> HEAD </option>
                                            <option <?php if (strtolower($method) == "option") echo "selected" ?> value="option"> OPTIONS </option>
                                            <option <?php if (strtolower($method) == "patch") echo "selected" ?> value="patch"> PATCH </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 col-xs-2 actionButton addMore ">
                                        <a class="btn-blue fullbrdr"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="col-md-12 mrgnbtm20"></div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="btn-group send  col-md-12"> 
                                <input class="btn btn-primary pull-right" type="submit" value="Save User Data" />  
                            </div> 
                        </div>
                    </div> 
                </form>	
            </div>

        </section>

    </div>
</section>


<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/svgcheckbx.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/copyFromxl.js"></script>

<script type="text/javascript">


copyFromXL("api_test_form" , ".addMore" ) ;

                    $(".specificationsBox").on("click", ".remove", function (e) { //user click on remove text   <div><a href='javascript:void' class='btn-blue fullbrdr'>Remove</a></div>");
                        e.preventDefault();
                        $(this).parent().parent().remove();
                        //x--;
                    });


</script>








