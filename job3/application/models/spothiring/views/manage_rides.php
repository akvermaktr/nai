
<script type="text/javascript" language="javascript" src="/resources/js/table/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="/resources/css/table/jquery.dataTables.css">
<style>
    h4{
        margin-top: 0px;

    }

</style>
<div class="col-md-12 mrgnbtm20"></div>
<section id="content">
    <div class="container">
        <div class="row">
            <!----------------------Consignee------------------------------>
            <div class="pageHead">
                <h2><span>Spot Hiring Dashboard</span></h2>
            </div>
            <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>


            <!------------------side menu------------------------>
            <div class="col-md-2 col-xs-12">
                <div class="row">
                    <nav class="nav-sidebar">
                        <ul class="nav tabs">
                            <li><a href="/spothiring/dashboard/manage_spot_users">Manage Users </a></li>
                            <li class="active"><a href="/spothiring/dashboard/manage_rides">Manage Rides </a></li>
                            
                            <li class="tabdisplay" id="s1" data-index="1"><a href="/spothiring/api">Manage APIs</a></li>


                        </ul>
                    </nav>
                </div>
            </div>
            <!------------------------------end------------------------------->

            <div class="col-md-10 col-xs-12" style="border-left: 1px solid #ccc;">
                <h4>Manage Rides  </h4><hr />

                <div class="row">
                    <div class="inline-form">
                        <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="get_ride_data_form"> 
                            <div class="row">
                                <?php
                                $a = 10;
                                foreach ($api_params as $key => $value) {
                                    ?>


                                    <div class="form-group col-md-4">
                                        <label class="col-md-4 col-xs-12" for="<?php echo $key ?>">  <?php echo $key ?> </label>

                                        <div class="col-md-8 col-xs-12 ">

                                            <input type="text" value="" id="wtng_price_prmin"    name="<?php echo $key ?>"  class="input" placeholder="<?php echo $value['param_vlaue'] ?> " required/>

                                        </div>
                                        <div  class="clerfix"></div>
                                    </div>

                                    <?php
                                    $a++;
                                }
                                ?>
                            </div>
                            <input type="submit" class="get_ride_data_form btn btn-md btn-primary pull-right"value="Download Data"></button>
                        </form>
                    </div>

                </div>
                <hr>
                <?php echo $spot_ride_data ?>



            </div>
            <div class="col-md-12 mrgnbtm20"></div>

        </div>






    </div>
</section>
</div>
<!--FOOTER-->

<!--FOOTER ENDS-->

<script src="/resources/js/bootstrap.js"></script>

<script type="text/javascript">
                            function DropDown(el) {
                                this.dd = el;
                                this.placeholder = this.dd.children('span');
                                this.opts = this.dd.find('ul.categoryList > li');
                                this.val = '';
                                this.index = -1;
                                this.initEvents();
                            }
                            DropDown.prototype = {
                                initEvents: function () {
                                    var obj = this;

                                    obj.dd.on('click', function (event) {
                                        $(this).toggleClass('active');
                                        return false;
                                    });

                                    obj.opts.on('click', function () {
                                        var opt = $(this);
                                        obj.val = opt.text();
                                        obj.index = opt.index();
                                        obj.placeholder.text(obj.val);
                                    });
                                },
                                getValue: function () {
                                    return this.val;
                                },
                                getIndex: function () {
                                    return this.index;
                                }
                            }
// Delete Car.
                            $(document).on('click', '.deletecar', function (e) {
                                var searchParams = new Object();
                                car_id = $(this).attr('car_id');

                                searchParams ['car_id'] = car_id;
                                if (confirm('Are you sure you want to delete?')) {
                                    $.ajax({
                                        url: "<?php echo base_url() ?>serviceprovider/provider/car_delete_spot",
// async: false,
                                        type: "POST",
                                        data: "car_id=" + car_id,
                                        dataType: "html",
                                        success: function (data) {
                                            window.location.href = "/serviceprovider/provider/spot_view";

                                        }

                                    });

                                }
                                e.preventDefault();
                                return false;
                            });

/// Delete Car End

                            $(function () {


                                var dd = new DropDown($('#catDropDown'));
                                $(document).click(function () {
// all dropdowns
                                    $('.catDropDown').removeClass('active');
                                });
                            });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#example1').DataTable({
        });
    });

    $(document).on('click', '.get_ride_data_form', function (e) {
        e.preventDefault();





        $.ajax({
            url: "<?php echo base_url() ?>spothiring/api/call_my_api/get_ride_data",
            // async: false,
            type: "POST",
            data: $('#get_ride_data_form').serialize(),
            dataType: "json",
            success: function (data) {

                alert(JSON.stringify(data, null, 2));
            }

        });
    });
</script>
