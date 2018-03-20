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
        <div class="row">
            <!----------------------Consignee------------------------------>
            <div class="pageHead">
                <h2><span>Spot Hiring Dashboard</span></h2>
            </div>
            <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>

            <div class="row">
                <!-- left side content-->
                <div class="col-md-3" style="border-right:1px solid #ddd">
                    <ul class="nav nav-pills nav-stacked">
                       
                        <li class="tabdisplay" id="s4" data-index="4"><a href="/spothiring/api/api_list"> <i class="fa fa-th-list"> </i>List All API </a></li>
                        <li class="tabdisplay active" id="s4" data-index="4"><a href="/spothiring/api/check_ip"> <i class="fa fa-shield"> </i>Check IP Whitelisting </a></li>
                        <li class="tabdisplay" id="s1" data-index="1"><a href="/spothiring/api/add_new_api"><i class="fa fa-plus"></i>ADD New API</a></li>
                        <li class="tabdisplay" id="s1" data-index="1"><a href="/spothiring/dashboard"><i class="fa fa-tachometer"></i>Go To Dashboard</a></li>

                    </ul>
                </div>
                <!-- right side content-->
                <div class="col-md-9 inline-form">
                    <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="api_test_form">                           
                        <div style="color:#F00"><strong></strong></div>
                        <div class="alert alert-danger jserror" style="display:none;">
                            <ul id="error_msg">               
                            </ul>
                        </div>

                        <h4><b>Check if API ip is white-listed with GeM</b></h4>
                        <div class="service">


                            <div class=" row"> 
                                <div class=" col-md-4">

                                    <input name="host" class="input " type="text" placeholder="IP Address or hostname" value="" />

                                </div> 
                                <div class=" col-md-3">
                                    <input name="port" class="input" type="number" placeholder="PORT(80/443)" value="80" />
                                </div>
                                <div class="btn-group send  col-md-3"> 
                                    <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                                </div>

                            </div> 


                        </div> 
                    </form>	
                </div>




            </div>




        </div>
    </div>
</div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js" ></script>


