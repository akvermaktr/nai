
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/resources/css/jquery.multiselect.css" />
<div class="col-md-12 mrgnbtm20"></div>
<section id="content">
    <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>

    <div class="container">
        <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                    <li class="disabled" ><a href="#step-1">
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

                    <li class="active"><a href="#step-4">
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
                <h2> Application Details</h2>
            </div>

<!--<div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>-->
            <div class="col-md-12 mrgnbtm20"></div>




            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-7">
                    <button type="submit" class="btn btn-default">Change</button>
                </div>
                <form class="form-horizontal" action="https://sandboxsecure.payu.in/_payment"> 
                    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                    <div class="col-sm-offset-1 col-sm-2 ">
                        <button type="submit" class="btn pull-right btn-default">Make Payment</button>
                    </div>
                </form>
            </div>





        </div>

    </div>


</section>


