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
                <h2><span>Invoice Summary </span></h2>
            </div>
            <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>




            <div class="row">
                <div class="col-xs-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order Placed By:</strong></h3>
                        </div>
                        <div class="">
                            Name :  <?php echo $buyer_details->name ?><br>
                            Mobile : <?php echo  $buyer_details->mobile; ?><br>
                            Email: <?php echo  $buyer_details->emailid; ?><br>
                        </div>
                    </div>


                </div>
                <div class="col-xs-4 text-right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Financial Approval Details:</strong></h3>
                        </div>
                        <div class="">
                            Approval File: <?php if ($order_details[0]->approval_id !== NULL) { ?>  
                                <a target="_blank" href="<?php echo base_url(); ?>carlisting/show_SignedPO/<?php echo $order_details[0]->order_no; ?>" > View </a>
                                <?php
                            } else {
                                echo "<span class='text-danger'>File Not Found!</span>";
                            }
                            ?><br>
                            Approval ID : <?php echo $order_details[0]->approval_id; ?><br>
                            Approval By : <?php echo $order_details[0]->approved_by; ?><br>
                        </div>
                    </div>


                </div>
                <div class="col-xs-4 text-right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order Details:</strong></h3>
                        </div>
                        <div class="">
                            Order ID : <?php echo $order_id ?> </br>
                            Order Date: <?php echo $order_date ?> </br>
                            Ride Start Date: <?php echo $from_date ?> </br>
                            Ride End Date: <?php echo $to_date ?> </br>
                        </div>
                    </div>


                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Fare Change Log</strong></h3>
                        </div>
                        <div class="">
                            <?php echo $price_log ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
               

                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Ride Details</strong></h3>
                            </div>
                            <div class="">
                                <input type="hidden" name="order_id" value="<?php echo $order_id ; ?>" />
                                <input type="hidden" name="from_date" value="<?php echo $from_date ; ?>" />
                                <input type="hidden" name="to_date" value="<?php echo $to_date ; ?>" />
                                
                                <?php echo $spot_users ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        
                    </div>
                    <div class="col-md-4 pull-right">
                        <label for="amount"> Tota Amount : </label>  <input type="text" name="amount" value="<?php echo $sub_total ?>" /> <br/>
                        <label for="tax"> Tax :  </label><input type="text" name="tax" value="" />
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

<script type="text/javascript">
    $(document).ready(function () {
<?php $date1 = date("m/d/Y H:i"); ?>
        var startDateTextBox = $('#expected_start_date');
        var endDateTextBox = $('#expected_end_date');
        var today = '<?php echo date("m/d/Y") ?>';
        var minDate = '<?php echo date("m/d/Y") ?>';
        var minDate1 = '<?php echo date('m/d/Y H:i:s', strtotime($booked_data->car_or_startdate)); ?>'
        var currentDateTime = '<?php echo date("m/d/Y H:i"); ?>';
        var dayseven = '<?php echo date('m/d/Y H:i'); ?>';

        startDateTextBox.datetimepicker({
            timeFormat: 'HH:mm',
            minDate: minDate1,
            onClose: function (dateText, inst) {
                if (endDateTextBox.val() != '') {
                    var testStartDate = startDateTextBox.datetimepicker('getDate');
                    //                        testStartDate.setMonth(testStartDate.getMonth() + <?php echo $diff->m; ?>);
<?php if ($booked_data->servicesubtype == "Half Day" || $booked_data->servicesubtype == "Full Day") { ?>
                        testStartDate.setDate(testStartDate.getDate() + <?php echo $diff->days; ?>);
                        testStartDate.setHours(testStartDate.getHours() + <?php echo $diff->h; ?>);
                        testStartDate.setMinutes(testStartDate.getMinutes() + <?php echo $diff->i; ?>);
    <?php
}
//    print_r($diff);
if ($booked_data->servicesubtype == "Monthly") {
    ?>
    <?php if ($diff->y != 0) { ?>
                            testStartDate.setFullYear(testStartDate.getFullYear() + <?php echo $diff->y; ?>);
    <?php } if ($diff->m != 0) { ?>     testStartDate.setMonth(testStartDate.getMonth() + <?php echo $diff->m; ?>);
    <?php } if ($diff->d != 0) { ?>
                            testStartDate.setDate(testStartDate.getDate() + <?php echo $diff->d; ?>);


        <?php
    }
}
if ($booked_data->servicesubtype == "Yearly" || $booked_data->servicesubtype == "3" || $booked_data->servicesubtype == "4" || $booked_data->servicesubtype == "5") {
    ?>
                        //                       alert(date1.getFullYear());
                        testStartDate.setFullYear(testStartDate.getFullYear() + <?php echo $diff->y; ?>);
<?php } ?>
                    var testEndDate = endDateTextBox.datetimepicker('getDate');
                    if (testStartDate > testEndDate)
                        endDateTextBox.datetimepicker('setDate', testStartDate);
                    $('#budget_cal').trigger('click');
                } else {
                    endDateTextBox.val(dateText);
                }
                endDateTextBox.datetimepicker('option', 'minDate', testStartDate);
                endDateTextBox.datetimepicker('option', 'maxDate', testStartDate);
                endDateTextBox.datetimepicker('setDate', testStartDate);



            },
            onSelect: function (selectedDateTime) {
                var date1 = startDateTextBox.datetimepicker('getDate');
<?php if ($booked_data->servicesubtype == "Half Day" || $booked_data->servicesubtype == "Full Day") { ?>
                    date1.setDate(date1.getDate() + <?php echo $diff->days; ?>);
                    date1.setHours(date1.getHours() + <?php echo $diff->h; ?>);
                    date1.setMinutes(date1.getMinutes() + <?php echo $diff->i; ?>);
    <?php
}
if ($booked_data->servicesubtype == "Monthly") {
    ?>
                    date1.setMonth(date1.getMonth() + <?php echo $diff->m; ?>);
    <?php if ($diff->d != 0) { ?>
                        date1.setDate(date1.getDate() + <?php echo $diff->d; ?>);
        <?php
    }
}
if ($booked_data->servicesubtype == "Yearly" || $booked_data->servicesubtype == "3" || $booked_data->servicesubtype == "4" || $booked_data->servicesubtype == "5") {
    ?>
                    //                       alert(date1.getFullYear());
                    date1.setFullYear(date1.getFullYear() + <?php echo $diff->y; ?>);
<?php } ?>

                $('#budget_cal').trigger('click');
                endDateTextBox.datetimepicker('option', 'minDateTime', date1);
                endDateTextBox.datetimepicker('option', 'maxDateTime', date1);
                endDateTextBox.datetimepicker('setDate', date1);

            }
        });
        endDateTextBox.datetimepicker({
            timeFormat: 'HH:mm',
            minDate: minDate

        });
    });


</script>






