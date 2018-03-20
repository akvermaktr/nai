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
                    <li class="active"><a href="#step-3">
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
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Order Summary </h2>     <h3 class="pull-right">Order# <?php echo $summary['orderdata']->order_no; ?> </h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong> Order Placed By:</strong><br>
                            <?php echo ucwords($summary['booker_details'][0]->u_firstname) . '&nbsp;' . ucwords($summary['booker_details'][0]->u_lastname); ?>h<br>
                            Mobile : <?php echo $summary['booker_details'][0]->u_mobile_no; ?><br>
                            Email: <?php echo $summary['booker_details'][0]->u_email; ?><br>

                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Financial Approval Details:</strong><br>
                            Approval File: <?php if ($apprFileOK == 1) { ?>  
                                <a target="_blank" href="<?php echo base_url(); ?>carlisting/show_SignedPO/<?php echo $summary['orderdata']->order_no; ?>" > View </a>
                                <?php
                            } else {
                                echo "<span class='text-danger'>File Not Found!</span>";
                            }
                            ?><br>
                            Approval ID : <?php echo $summary['orderdata']->approval_id; ?><br>

                        </address>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>User Details(Buyer/HoD/Consignee: Registered with GeM)</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td class="text-center"><strong>Mobile </strong></td>
                                        <td class="text-center"><strong>E-Mail</strong></td>
                                        <td class="text-center"><strong>Department</strong></td>
                                        <td class="text-right"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <?php
                                    $i = 0;
                                    $ordusrdet = array();
                                    foreach ($summary['EndUser_id'] as $r => $v) {
                                        $ordusrdet = $this->carlist_model->getForUserDetailsview($v);
                                        ?>
                                        <tr>
                                            <td><?php echo ucwords($ordusrdet[0]->u_firstname) . '&nbsp;' . ucwords($ordusrdet[0]->u_lastname); ?> </td>                                           
                                            <td><?php echo $ordusrdet[0]->u_mobile_no; ?></td>
                                            <td><?php echo $ordusrdet[0]->u_email; ?></td>
                                            <td><?php echo $ordusrdet[0]->u_email; ?></td>
                                            <td><a>Edit</a> | <a>Delete</a></td>
                                        </tr> 
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Users (Not Registered with GeM)</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td class="text-center"><strong>Mobile </strong></td>
                                        <td class="text-center"><strong>E-Mail</strong></td>
                                        <td class="text-center"><strong>Department</strong></td>
                                        <td class="text-right"><strong>Totals</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <?php
                                    $i = 0;

                                    foreach ($spot_user as $user) {
                                        ?>
                                        <tr>
                                            <td class="text-center" ><?php echo ucwords($user->ss_name); ?></td>
                                            <td class="text-center"><?php echo $user->ss_mobile_no; ?></td>
                                            <td class="text-center"><?php echo $user->ss_department; ?></td>
                                            <td class="text-center"><?php echo $user->ss_email; ?></td>
                                            <td class="text-right"> <a>Edit</a> | <a>Delete</a></td>
                                        </tr> 
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="api_test_form">                            
                <div style="color:#F00"><strong></strong></div>
                <div class="alert alert-danger jserror" style="display:none;">
                    <ul id="error_msg">               
                    </ul>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Terms of use</label>
                        <div class="col-xs-9">
                            <div style="border: 1px solid #e5e5e5; height: 200px; overflow: auto; padding: 10px;">
                                <p>Lorem ipsum dolor sit amet, veniam numquam has te. No suas nonumes recusabo mea, est ut graeci definitiones. His ne melius vituperata scriptorem, cum paulo copiosae conclusionemque at. Facer inermis ius in, ad brute nominati referrentur vis. Dicat erant sit ex. Phaedrum imperdiet scribentur vix no, ad latine similique forensibus vel.</p>
                                <p>Dolore populo vivendum vis eu, mei quaestio liberavisse ex. Electram necessitatibus ut vel, quo at probatus oportere, molestie conclusionemque pri cu. Brute augue tincidunt vim id, ne munere fierent rationibus mei. Ut pro volutpat praesent qualisque, an iisque scripta intellegebat eam.</p>
                                <p>Mea ea nonumy labores lobortis, duo quaestio antiopam inimicus et. Ea natum solet iisque quo, prodesset mnesarchum ne vim. Sonet detraxit temporibus no has. Omnium blandit in vim, mea at omnium oblique.</p>
                                <p>Eum ea quidam oportere imperdiet, facer oportere vituperatoribus eu vix, mea ei iisque legendos hendrerit. Blandit comprehensam eu his, ad eros veniam ridens eum. Id odio lobortis elaboraret pro. Vix te fabulas partiendo.</p>
                                <p>Natum oportere et qui, vis graeco tincidunt instructior an, autem elitr noster per et. Mea eu mundi qualisque. Quo nemore nusquam vituperata et, mea ut abhorreant deseruisse, cu nostrud postulant dissentias qui. Postea tincidunt vel eu.</p>
                                <p>Ad eos alia inermis nominavi, eum nibh docendi definitionem no. Ius eu stet mucius nonumes, no mea facilis philosophia necessitatibus. Te eam vidit iisque legendos, vero meliore deserunt ius ea. An qui inimicus inciderint.</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6 col-xs-offset-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="agree" value="agree" /> Agree with the terms and conditions
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group send  col-md-12"> 
                        <input class="btn btn-primary pull-right" type="submit" value="Confirm and Submit" />  
                    </div> 
                </div>
            </form>
        </div>

    </div>

</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript">


</script>








