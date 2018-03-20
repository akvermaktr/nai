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
                    <li class="disabled"><a href="#step-2">
                            <h4 class="list-group-item-heading">Step 2</h4>
                            <p class="list-group-item-text">ADD Additional Users</p>
                        </a></li>
                    <li class="disabled"><a href="#step-3">
                            <h4 class="list-group-item-heading">Step 3</h4>
                            <p class="list-group-item-text">Order Preview</p>
                        </a></li>
                    <li class="active"><a href="#step-4">
                            <h4 class="list-group-item-heading">Final Step</h4>
                            <p class="list-group-item-text">Complete your Order</p>
                        </a></li>    
                </ul>

            </div>
        </div>
        <div id="prog"></div>
        <div class="jumbotron text-xs-center">
            <h1 class="display-3">Thank You!</h1>
            <p>All users has been authorized to take Spot Hiring Rides From our chanel partners. </p>
            <p>Partners:</p>
            
            <em> New service Providers will automatically get Updated list of Riders once they Get themself register on GeM and successfully Integrated minimum required  API. </em>
            <p class="lead"><strong>Please check your email</strong> for further instructions on how to complete your account setup.</p>
            <hr>
            <p>
                Having trouble? <a href="">Contact us</a>
            </p>
            <p class="lead">
                <a class="btn btn-primary btn-sm send_notification" href="" role="button">Send Notification</a>
            </p>
        </div>

    </div>	




</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/jquery.ajax-progress.js"></script>

<script type="text/javascript">

    $('#prog').progressbar({value: 0});

    $(document).on('click', '.send_notification', function (e) {
        e.preventDefault();
       // alert(2);
        $.ajax({
            method: 'GET',
            url: "<?php echo base_url() ?>spothiring/api/call_add_emp_all_sp",
            dataType: 'json',
            success: function (data) {
                alert(data);
                console.log(data);
            },
            error: function (error) {
                
                console.log(error);
            }
        });

    })


</script>








