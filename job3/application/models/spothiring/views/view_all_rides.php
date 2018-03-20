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
                <h2><span>Invoice Process</span></h2>
            </div>
            <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>

            <div class="row">
                <!-- left side content-->
                <div class="col-md-3" style="border-right:1px solid #ddd">
                    <ul class="nav nav-pills nav-stacked">
                        
                       <li class=" active tabdisplay"  data-index="4"><a href="/spothiring/order/view_all_rides/<?php echo $order_no ?>"> View All Rides </a></li>
                       <li class="  tabdisplay"  data-index="4"><a href="/spothiring/order/view_pending_rides/<?php echo $order_no ?>"> View Pending Rides </a></li>
                       <li class="  tabdisplay"  data-index="4"><a href="/spothiring/order/view_billed_rides/<?php echo $order_no ?>"> View Billed Rides </a></li>
                       <li class="  tabdisplay"  data-index="4"><a href="/spothiring/order/view_invoices/<?php echo $order_no ?>"> View Invoices </a></li>

                    </ul>
                </div>
                <!-- right side content-->
                <div class="col-md-9 inline-form">
                    <?php echo $spot_users; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript">

    $(".specificationsBox").on("click", ".remove", function (e) { //user click on remove text   <div><a href='javascript:void' class='btn-blue fullbrdr'>Remove</a></div>");
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
</script>








