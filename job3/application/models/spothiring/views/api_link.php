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
                <h2><span>Spot Hiring Dashboard</span></h2>
            </div>
            <div style="color:#F00"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>

            <div class="row">
                <!-- left side content-->
                <div class="col-md-3" style="border-right:1px solid #ddd">
                   <ul class="nav nav-pills nav-stacked">
                       
                        <li class="tabdisplay" id="s4" data-index="4"><a href="/spothiring/api/api_list"> <i class="fa fa-th-list"> </i>List All API </a></li>
                        <li class="tabdisplay " id="s4" data-index="4"><a href="/spothiring/api/check_ip"> <i class="fa fa-shield"> </i>Check IP Whitelisting </a></li>
                        <li class="tabdisplay active" id="s1" data-index="1"><a href="/spothiring/api/add_new_api"><i class="fa fa-plus"></i>ADD New API</a></li>
                        <li class="tabdisplay" id="s1" data-index="1"><a href="/spothiring/dashboard"><i class="fa fa-tachometer"></i>Go To Dashboard</a></li>

                    </ul>
                </div>
                <!-- right side content-->
                <div class="col-md-9 inline-form">
                    <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="api_test_form">                           
                        <div style="color:#F00"><strong></strong></div>
                        <div class="alert alert-danger jserror" style="display:none;">
                            <ul id="error_msg">               
                            </ul>
                        </div>

                        <h4><b>API Integration with GeM</b></h4>
                        <div class="service">
                            <div class=" row">
                                <div class=" col-md-3">
                                    <select name="api_type" class="select api_type">
                                        <option <?php if (strtolower($api_type) == "") echo "selected" ?> value="">--Select API For-- </option>
                                        <option <?php if (strtolower($api_type) == "add_emp") echo "selected" ?> value="add_emp"> Add Employee </option>
                                        <option <?php if (strtolower($api_type) == "remove_emp") echo "selected" ?> value="remove_emp"> Remove  Employee </option>
                                        <option <?php if (strtolower($api_type) == "get_emp_data") echo "selected" ?> value="get_emp_data"> List Employee  Details </option>
                                        <option <?php if (strtolower($api_type) == "update_emp") echo "selected" ?> value="update_emp"> Update Employee </option>
                                        <option <?php if (strtolower($api_type) == "get_ride_data") echo "selected" ?> value="get_ride_data"> Get Ride  Details </option>
                                        <option <?php if (strtolower($api_type) == "downlod_invoice") echo "selected" ?> value="downlod_invoice"> Download Invoice  </option>
                                        <option <?php if (strtolower($api_type) == "others") echo "selected" ?>value="others"> Other  </option>
                                    </select>
                                </div>
                                 <div class="col-md-3">
                                    <select class="select">
                                        <option <?php if (strtoupper($api_mode) == "UAT") echo "selected" ?> value="UAT"> UAT </option>
                                        <option <?php if (strtoupper($api_mode) == "PRODUCTION") echo "selected" ?> value="PRODUCTION"> PRODUCTION </option>
                                    </select>
                                </div>
                                <div class=" col-md-6">
                                    <input type="text" name="api_description" value= "<?php echo $api_description ?>" class="input api_description" id="gwt-uid-527" placeholder="API Description">
                                </div>
                                <div class="col-md-12 mrgnbtm20"></div> 
                            </div>

                            <div class=" row"> 
                                <div class=" col-md-3">

                                    <?php
                                    $z = 2;
                                    ?>


                                    <select name="method" class="select api_mothod">
                                        <option value="">--Select Method-- </option>
                                        <option <?php if (strtolower($method) == "get") echo "selected" ?> value="get"> GET </option>
                                        <option <?php if (strtolower($method) == "post") echo "selected" ?> value="post"> POST </option>
                                        <option <?php if (strtolower($method) == "put") echo "selected" ?> value="put"> PUT </option>
                                        <option <?php if (strtolower($method) == "delete") echo "selected" ?> value="delete"> DELETE </option>
                                        <option <?php if (strtolower($method) == "head") echo "selected" ?> value="head"> HEAD </option>
                                        <option <?php if (strtolower($method) == "option") echo "selected" ?> value="option"> OPTIONS </option>
                                        <option <?php if (strtolower($method) == "patch") echo "selected" ?> value="patch"> PATCH </option>
                                    </select>

                                </div> 
                               
                                <div class="uri-editor  col-md-9"> 
                                    <div class="uri-input"> 
                                        <div class="uri-input-lock hide"> <i class="fa fa-lock"></i> </div> <span class="expression-input input-append uri-path">
                                            <input name="api_endpoint" value="<?php echo $api_endpoint ?>" type="text" class="input" class = "api_endpoint" placeholder="type an URI">
                                            <span class="add-on" title="Expression builder"><i class="icon-magic"></i></span></span> 
                                        <div class="uri-length" title="length: 51 bytes" style="display: inline;">length: 51 bytes</div> 
                                    </div> 

                                </div> 

                            </div> 
                            <div class="row">

                                <div class="col-md-6 col-xs-10 specificationsBox">
                                    <?php
                                    if (count($api_params) > 0) {
                                        $a = 0;

                                        foreach ($api_params as $key => $value) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-2 col-xs-12">
                                                    <div class="form-check">
                                                        <select name="is_required[]" class="select form-check-label">
                                                            <option <?php if (strtoupper($value['is_required']) == "NO") echo "selected" ?> value="no">NO</option>
                                                            <option <?php if (strtoupper($value['is_required']) == "YES") echo "selected" ?> value="yes"> YES</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12 ">
                                                    <input type="text" value="<?php echo $key ?>" id="price_prkm"   name="pram_name[]"  class="input" placeholder="Query Parameter Name" required/>
                                                </div>
                                                <div class="col-md-4 col-xs-12 ">

                                                    <input type="text" value="<?php echo $value['param_vlaue'] ?>" id="wtng_price_prmin"    name="pram_value[]"  class="input" placeholder="Value" required/>
                                                    <select  name="api_fields_list[]" class="input gem_fields">
                                                        <?php
                                                        if (isset($gem_table_fields)) {
                                                            foreach ($gem_table_fields as $key2 => $value2) {
                                                                if ($value2 == $value['api_fields_list']) {
                                                                    echo "<option selected='selected' value='$value2'> " . $value2 . " </option>";
                                                                } else {
                                                                    echo "<option value='$value2'> " . $value2 . " </option>";
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select> 
                                                </div>

                                                <?php if ($a < 1) { ?>
                                                    <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                        <a href="javascript:void(0)" class="btn-blue "><i class="fa fa-plus"></i></a>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="col-md-2 col-xs-2 actionButton">
                                                        <a href="javascript:void(0)" class="btn-blue remove"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-md-12 mrgnbtm20"></div> 
                                            </div>
                                            <?php
                                            $a++;
                                        }
                                    } else {
                                        ?>

                                        <div class="row">

                                            <div class="col-md-2 col-xs-12">

                                                <select name="is_required[]" class="select form-check-label">
                                                    <option value="no">NO</option>
                                                    <option value="yes"> YES</option>

                                                </select>

                                            </div>
                                            <div class="col-md-4 col-xs-12 ">
                                                <input type="text" value="" id="price_prkm"   name="pram_name[]"  class="input" placeholder="Query Parameter Name" required/>
                                            </div>
                                            <div class="col-md-4 col-xs-12 ">
                                                <input type="text" value="" id="wtng_price_prmin"    name="pram_value[]"  class="input" placeholder="Value" required/>
                                                <select  name="api_fields_list[]" class="input gem_fields">
                                                    <?php
                                                    if (isset($gem_table_fields)) {
                                                        foreach ($gem_table_fields as $key2 => $value2) {
                                                            echo "<option value='$value2'> " . $value2 . " </option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>                                                
                                            </div>
                                            <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                <a href="javascript:void" class="btn-blue fullbrdr"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="col-md-12 mrgnbtm20"></div> 
                                        </div>
                                    <?php } ?>

                                </div>




                                <div class="col-md-6 col-xs-10 specificationsBox">

                                    <?php
                                    if (count($headers) > 0) {
                                        $a = 0;

                                        foreach ($headers as $key => $value) {
                                            ?>

                                            <div class="row">


                                                <div class="col-md-5 col-xs-12 ">
                                                    <input type="text" value="<?php echo $key ?>" id="price_prkm"   name="header_pram_name[]"  class="input" placeholder="HEADER Parameter Name" required/>
                                                </div>
                                                <div class="col-md-5 col-xs-12 ">
                                                    <input type="text" value="<?php echo $value ?>" id="wtng_price_prmin"    name="header_pram_value[]"  class="input" placeholder="Value" required/>
                                                </div>
                                                <?php if ($a < 1) { ?>
                                                    <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                        <a href="javascript:void(0)" class="btn-blue "><i class="fa fa-plus"></i></a>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="col-md-2 col-xs-2 actionButton">
                                                        <a href="javascript:void(0)" class="btn-blue remove"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-md-12 mrgnbtm20"></div> 
                                            </div>
                                            <?php
                                            $a++;
                                        }
                                    } else {
                                        ?>
                                        <div class="row">


                                            <div class="col-md-5 col-xs-12 ">
                                                <input type="text" value="" id="price_prkm"   name="header_pram_name[]"  class="input" placeholder="HEADER Parameter Name" required/>
                                            </div>
                                            <div class="col-md-5 col-xs-12 ">
                                                <input type="text" value="" id="wtng_price_prmin"    name="header_pram_value[]"  class="input" placeholder="Value" required/>
                                            </div>
                                            <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                <a href="javascript:void" class="btn-blue fullbrdr"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="col-md-12 mrgnbtm20"></div> 
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-12 ">
                                    <select class="input" name="json_dropdown[]" id="json_dropdown">
                                        <?php
                                        if (isset($api_sample_response)) {
                                            foreach ($api_sample_response as $key => $value) {
                                                $split = explode(".", $value);
                                                $txt = $split[count($split) - 1];
                                                echo "<option value='$value'> " . $txt . " </option>";
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>  
                                <div class="col-md-6 col-xs-12 ">


                                    <div id="json_keys">

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="btn-group send  col-md-3"> 
                                    <a href="javascript:void" id="check_api" class="btn btn-primary btn-sm">TEST API</a>
                                </div>
                                <div class="btn-group send  col-md-3"> 
                                    <input class="btn btn-primary pull-right" type="submit" value="Connect This API to GeM" />  


                                </div> 
                            </div>
                        </div> 
                    </form>	
                </div>




            </div>




        </div>
    </div>
</div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js" ></script>

<script type="text/javascript">
                        $(document).on('change', '.gem_fields', function () {
                            $selected = $(this).val();
                            if ($selected !== "USER DEFINED") {
                                $(this).prev('input').val($selected);
                            } else {
                                $(this).prev('input').val("");
                            }
                        });
                        var select = new Array();
                        var parent = "";
                        var prev_parent = "";
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
                        for (i in obj) { // i = [ride] => object

                        if (typeof (obj[i]) === "object" && obj[i] !== null) {
                        sep = sep + "x" + i;
                                // alert(sep);
                                if (parent == "") {
                        parent += i; // set parent object will add in else part. 
                        } else {
                        parent += "." + i; // set parent object will add in else part. 
                                prev_parent = parent + "." + (i - 1); //previous parent 
                        }
                        //  alert("parent " + parent);
                        get_child(obj[i], sep); // Recurcive call 
                        } else {
                        console.log(parent + "." + i);
                                //check if key exists -- break form loop
                                if (select.indexOf(prev_parent + "." + i) >= 0) {  // already exists key ; break the loop 
                        break;
                        }
                        select.push(parent + "." + i);
                        }
                        }
                        }
                        parent = parent.split(".");
                                parent.pop();
                                parent = parent.join(".");
                                return select;
                        }
                        $(".specificationsBox").on("click", ".remove", function(e) { //user click on remove text   <div><a href='javascript:void' class='btn-blue fullbrdr'>Remove</a></div>");
                        e.preventDefault();
                                $(this).parent().parent().remove();
                                x--;
                        });
                                $(document).on('click', '#check_api', function(e) {
                        e.preventDefault();
                                var api_fields = new Object();
                                // alert(1);
                                api_fields['api_type'] = $('.api_type').val();
                                api_fields['api_description'] = $('.api_description').val();
                                api_fields['method'] = $('.api_type').val();
                                api_fields['endpoint'] = $('.api_endpoint').val();
                                api_fields['headers'] = $('.api_endpoint').val();
                                api_fields['prams'] = $('.api_type').val();
                                $.ajax({
                                url: "<?php echo base_url() ?>spothiring/api/test_api",
                                        // async: false,
                                        type: "POST",
                                        data: $('#api_test_form').serialize(),
                                        dataType: "json",
                                        success: function(data) {
                                        // alert(data);
                                        // console.log(data);
                                        // console.log(data);
                                        //$('#api_sample_response').val(JSON.stringify(data[0], null, 2));
                                        var $options = "";
                                                $options = get_child(data); // prevent multiple records in data. 
                                                // alert(JSON.stringify(data, null, 2));
                                                console.log($options);
                                                $('#json_dropdown').html("<option  value=''>Select Dropdown</option>");
                                                $('#json_keys').html("<input type='hidden'  class='input' name='api_sample_response[]' value='" + $options[i] + "' />")
                                                // alert('clear keys');
                                                for (var i = 0; i < $options.length; i++) {
                                        var $split = "";
                                                $split = $options[i].split(".");
                                                var $value = $split[($split.length) - 1];
                                                $('#json_dropdown').append("<option  value='" + $options[i] + "'>" + $value + "</option>");
                                                $('#json_keys').append("<input type='hidden' class='input' name='api_sample_response[]' value='" + $options[i] + "' />")
                                        }
                                        }

                                });
                        });

</script>
