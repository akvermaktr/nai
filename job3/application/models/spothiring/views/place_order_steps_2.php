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
                            <li class="active"><a href="#step-2">
                                    <h4 class="list-group-item-heading">Step 2</h4>
                                    <p class="list-group-item-text">ADD Additional Users</p>
                                </a></li>
                            <li class="disabled"><a href="#step-3">
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
            </div>	

            <div class="col-md-9 inline-form">
                <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="api_test_form">                            <div style="color:#F00"><strong></strong></div>
                    <div class="alert alert-danger jserror" style="display:none;">
                        <ul id="error_msg">               
                        </ul>
                    </div>

                    <h4><b>Create Spot Users</b></h4>
                    <div class="service">



                        <div class="row">






                            <div class="col-md-12 col-xs-10 specificationsBox">


                                <div class="row">


                                    <div class="col-md-2 col-xs-12 ">
                                        <input type="text" value="" id="user_name"   name="user_name[]"  class="input" placeholder=" Name" required/>
                                    </div>
                                    <div class="col-md-2 col-xs-12 ">
                                        <input type="text" value="" id="user_mobile"   name="user_mobile[]"  class="input" placeholder=" Mobile" required/>
                                    </div>
                                    <div class="col-md-2 col-xs-12 ">
                                        <input type="text" value="" id="user_email"   name="user_email[]"  class="input" placeholder="E-mail" required/>
                                    </div>
                                    <div class="col-md-2 col-xs-12 ">
                                        <input type="text" value="" id="user_department"   name="department[]"  class="input" placeholder="Department " required/>
                                    </div>

                                    <div class="col-md-2 col-xs-2 actionButton addMore ">
                                        <a href="javascript:void" class="btn-blue fullbrdr"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="col-md-12 mrgnbtm20"></div> 
                                </div>


                            </div>
                        </div>

                        <div class="row">

                            <div class="btn-group send  col-md-3"> 
                                <input class="btn btn-primary pull-right" type="submit" value="Save User Data" />  


                            </div> 
                        </div>
                    </div> 
                </form>	
            </div>






        </section>
        <script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
        <script type="text/javascript">




        </script>









    </div>
</div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript">
                    var select = new Array();
                    var parent = "";
                    var $options;

                    /**
                     * 
                     * @type type
                     * will create an array containing string to call value of n no. of child
                     */
                    function get_child(obj, sep = "-") {
                    console.log(obj);
                            if (typeof (obj) === "object") {
                    //  alert("this is object");
                    for (i in obj) {  // i = [ride] => object

                    if (typeof (obj[i]) === "object" && obj[i] !== null) {
                    sep = sep + "x" + i;
                            // alert(sep);
                            if (parent == "") {
                    parent += i; // set parent object will add in else part. 
                    } else {
                    parent += "." + i; // set parent object will add in else part. 
                    }
                    //  alert("parent " + parent);
                    get_child(obj[i], sep); // Recurcive call 
                    } else {
                    console.log(parent + "." + i);
                            select.push(parent + "." + i);
                    }
                    }
                    }
                    parent = "";
                            return select;
                    }
                    $(".specificationsBox").on("click", ".remove", function (e) { //user click on remove text   <div><a href='javascript:void' class='btn-blue fullbrdr'>Remove</a></div>");
                    e.preventDefault();
                            $(this).parent().parent().remove();
                            x--;
                    });
                            $(document).on('click', '#check_api', function (e) {
                    e.preventDefault();
                            var api_fields = new Object();
                            // alert(1);
                            api_fields ['api_type'] = $('.api_type').val();
                            api_fields ['api_description'] = $('.api_description').val();
                            api_fields ['method'] = $('.api_type').val();
                            api_fields ['endpoint'] = $('.api_endpoint').val();
                            api_fields ['headers'] = $('.api_endpoint').val();
                            api_fields ['prams'] = $('.api_type').val();
                            $.ajax({
                            url: "<?php echo base_url() ?>spothiring/api/test_api",
                                    // async: false,
                                    type: "POST",
                                    data: $('#api_test_form').serialize(),
                                    dataType: "json",
                                    success: function (data) {
//                                            alert(data.length);
//                                            console.log(data);
//                                            console.log(data[0]);
                                    //$('#api_sample_response').val(JSON.stringify(data[0], null, 2));
                                    var $options = "";
                                            $options = get_child(data[0]); // prevent multiple records in data. 
                                            // alert(JSON.stringify(data, null, 2));
                                            console.log($options);
                                            $('#json_dropdown').html("<option  value=''>Select Dropdown</option>");
                                            $('#json_keys').html("<input type='hidden'  class='input' name='api_sample_response[]' value='" + $options[ i ] + "' />")
                                            // alert('clear keys');
                                            for (var i = 0; i < $options.length; i++) {
                                    var $split = "";
                                            $split = $options[ i ].split(".");
                                            var $value = $split[ ($split.length) - 1];
                                            $('#json_dropdown').append("<option  value='" + $options[ i ] + "'>" + $value + "</option>");
                                            $('#json_keys').append("<input type='hidden' class='input' name='api_sample_response[]' value='" + $options[ i ] + "' />")
                                    }
                                    }

                            });
                    });

</script>








