<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// from 9-09-2016 to 28-02-2017 for regular hiring
$z = 0;
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

                        <li class="  tabdisplay"  data-index="4"><a href="/spothiring/order/view_all_rides/<?php echo $order_id ?>"> View All Rides </a></li>
                        <li class=" active tabdisplay"  data-index="4"><a href="/spothiring/order/view_pending_rides/<?php echo $order_id ?>"> View Pending Rides </a></li>
                        <li class="  tabdisplay"  data-index="4"><a href="/spothiring/order/view_billed_rides/<?php echo $order_id ?>"> View Billed Rides </a></li>
                        <li class="  tabdisplay"  data-index="4"><a href="/spothiring/order/view_invoices/<?php echo $order_id ?>"> View Invoices </a></li>

                    </ul>
                </div>
                <!-- right side content-->
                <div class="col-md-9 inline-form">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-2 col-xs-6">
                                <label>Start Date </label>
                            </div>
                            <div class="col-md-2 col-xs-6" id="usrDept">

                                <input class="input" id="expected_start_date" name="from_date" autocomplete="off" placeholder="" value="<?php
                                if (isset($from_date)) {
                                    echo $from_date;
                                }
                                ?>" required/>
                            </div>
                            <div class="col-md-2 col-xs-6">
                                <label>End Date </label>
                            </div>
                            <div class="col-md-2 col-xs-6" id="usrDept">
                                <input class="input" readonly="" id="expected_end_date" name="to_date" autocomplete="off" placeholder="" value="<?php
                                if (isset($to_date)) {
                                    echo $to_date;
                                }
                                ?>"  required/>
                            </div>
                            <div class="col-md-2 col-xs-6" id="usrDept">
                                <input class="button btn-primary"  id="filter" type="submit" autocomplete="off" placeholder="" value="Filter"  required/>
                            </div>
                        </div>
                        </form>
                    
                        <?php echo $spot_users; ?>
                        <div class="row">
                            <?php
                            $z = 10; 
                            ?>
                            <form action="/spothiring/order/generate_invoice/<?php echo $order_id ?>" method="POST">
                                <input type="hidden" name="from_date" value="<?php echo $from_date ?>" />
                                <input type="hidden" name="to_date" value="<?php echo $to_date ?>" />
                                <?php if(isset($from_date) && isset($to_date)) {?>
                                <input type="submit" class="btn btn-primary" href="" id="gen_invoice" value=" Generate Invoice" />
                                <?php } ?>
                            </form>
                        </div>
                    
                </div>

            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript">

    $(".specificationsBox").on("click", ".remove", function (e) { //user click on remove text   <div><a href='javascript:void' class='btn-blue fullbrdr'>Remove</a></div>");
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
</script>



<script type="text/javascript">
    $(function () {
        $("#expected_start_date").datepicker({
        });
        $("#expected_end_date").datepicker({
        });



    });



</script>







