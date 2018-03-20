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
            <ul><li><strong>Introduction</strong>: Every Service Provider offering spot service must provide API endpoint to manage spot user/rides. *Once API MODE changed to PRODUCTION and it get approved by admin. It cannot be modified/deleted.<br></li>
                <li>Email ID : user identifier </li>
                <li><strong>How to integrate.</strong> <br>
                    <ul><li>1) Required API URL. <br></li>
                        <li>2) White-listing of URL with GeM : Form are avilable on NIC <br></li>
                        <li>3) Integration Testing over GeM <br></li>
                        <li>4) Currently we are accepting Restful Web Service in JSON Format only.
                            We may further add XML or other formats. <br></li>
                        <li>5) Mapping for Database TAble of GeM and Services.
                            For GET request GeM will call your API and save records to own database e.i; Rides data.. 
                            For POST request GeM some data to be saved on your databse like user details.<br></li>
                    </ul>
                </li>
                <li>&nbsp;<strong>API Type</strong><br>
                    <ul><li>Manage Employee/User : POST type service <br></li>
                        <li>Manage Rides. : GET method : should return Ride Details. Total KM, Waiting Time ,
                            Ride Time. Pickup Time, Droping Time.<br></li>
                        <li>Invoice Details : Service Providers have to Generge Invoice on a fixed interval. 
                            
                            And Sumbit theirs bill to GeM to related Buyers. Buyer will then Block the Budget
                            and Fwd bills to DDO for final payments. This is currently manual process.
                            that needs automation. <br></li>
                        <li> Manage Price : Service Providers can set Price Calculation function on GeM. Mange Offerings:<br></li>
                    </ul>
                </li>
            </ul>
            
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








