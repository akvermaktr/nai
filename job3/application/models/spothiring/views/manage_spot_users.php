
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
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"  ><a href="/spothiring/dashboard/manage_spot_users">Manage Users </a></li>
                            <li><a href="/spothiring/dashboard/manage_rides">Manage Rides </a></li>
                            <li class="tabdisplay" id="s1" data-index="1"><a href="/spothiring/api">Manage APIs</a></li>


                        </ul>
                    </nav>
                </div>
            </div>
            <!------------------------------end------------------------------->

            <div class="col-md-10 col-xs-12" style="border-left: 1px solid #ccc;">
                <h4>Manage Users
<!--                    <a class="btn btn-info btn-xs pull-right" href="/spothiring/dashboard/add_spot_users">Add Spot Users <i class="fa fa-plus faIcon"></i></a>
                
                 <a class="btn btn-info btn-xs pull-right" id="send_user_data" href="javascript:void(0)">Send User Data <i class="fa fa-reload faIcon"></i></a>-->
                    
                </h4>
                 <p class="lead">
                <a class="btn btn-primary btn-sm send_notification" href="" role="button">Get latest Users</a>
            </p>
                <hr />


                <?php echo $spot_users ?>



            </div>
            <div class="col-md-12 mrgnbtm20"></div>

        </div>





    </div>
</section>
</div>


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

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#example1').DataTable({
        });
    });


</script>

<script type="text/javascript">

  
    $(document).on('click', '.send_notification', function (e) {
        e.preventDefault();
         alert(2);
        $.ajax({
            method: 'GET',
            url: "<?php echo base_url() ?>spothiring/api/call_add_emp_all_sp<?php echo "/". $this->u_id ?>",
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
