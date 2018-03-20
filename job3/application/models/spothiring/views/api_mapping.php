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
                        <li class="active"><a href="">API DETAILS</a></li>
                        <li class="tabdisplay" id="s4" data-index="4"><a href="/spothiring/api/api_list"> List All API </a></li>
                        <li class="tabdisplay" id="s1" data-index="1"><a href="/spothiring/api/add_new_api">ADD New API</a></li>
                         <li class="tabdisplay" id="s1" data-index="1"><a href="/spothiring/dashboard">Go To Dashboard</a></li>

                    </ul>
                </div>
                <!-- right side content-->
                <div class="col-md-9 inline-form">

                    <div style="color:#F00"><strong></strong></div>
                    <div class="alert alert-danger jserror" style="display:none;">
                        <ul id="error_msg">               
                        </ul>
                    </div>

                    <h4><b>API Integration with GeM</b></h4>
                    <div class="service">
                        <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="api_test_form">                    
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
                                <div class=" col-md-9">
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


                                                <div class="col-md-5 col-xs-12 ">
                                                    <input type="text" value="<?php echo $key ?>" id="price_prkm"   name="pram_name[]"  class="input" placeholder="Query Parameter Name" required/>
                                                </div>
                                                <div class="col-md-5 col-xs-12 ">
                                                    <input type="text" value="<?php echo $value ?>" id="wtng_price_prmin"    name="pram_value[]"  class="input" placeholder="Value" required/>
                                                </div>
                                                <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                    <a href="javascript:void(0)" class="btn-blue fullbrdr"><i class="fa fa-plus"></i></a>
                                                </div>
                                                <div class="col-md-12 mrgnbtm20"></div> 
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>

                                        <div class="row">


                                            <div class="col-md-5 col-xs-12 ">
                                                <input type="text" value="" id="price_prkm"   name="pram_name[]"  class="input" placeholder="Query Parameter Name" required/>
                                            </div>
                                            <div class="col-md-5 col-xs-12 ">
                                                <input type="text" value="" id="wtng_price_prmin"    name="pram_value[]"  class="input" placeholder="Value" required/>
                                            </div>
                                            <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                <a href="javascript:void(0)" class="btn-blue fullbrdr"><i class="fa fa-plus"></i></a>
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
                                                <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                    <a href="javascript:void(0)" class="btn-blue <?php $a > 0 ? 'remove' : 'fullbrdr' ?>"><i class="fa fa-plus"></i></a>
                                                </div>
                                                <div class="col-md-12 mrgnbtm20"></div> 
                                            </div>
                                            <?php
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
                                                <a href="javascript:void(0)" class="btn-blue fullbrdr"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="col-md-12 mrgnbtm20"></div> 
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                        </form>
                        <form action="" method="post" accept-charset="utf-8" autocomplete="off" onsubmit="return validateForm();" id="api_test_form">                    
                            <div class="row">
                                <div class="col-md-12 col-xs-10 specificationsBox">
                                    <!-- 
                                    check api_type if api_type = "user" 
                                    --> 

                                    <?php
                                    $a = 0;
                                    if (count($gem_table_fields) > 0 && is_array($gem_table_fields)) {
                                        $a = 0;
                                        if (is_array($api_fields_map_to_gem['gem_field'])) { // if key preset in database
                                            //To prevent duplicate records. merged same values
                                            $api_fields_map_to_gem['gem_field'] = array_unique(array_merge($api_fields_map_to_gem['gem_field'], $gem_table_fields));
                                        } else {
                                            $api_fields_map_to_gem['gem_field'] = array_unique($gem_table_fields);
                                        }
                                        foreach ($api_fields_map_to_gem['gem_field'] as $key => $value) {
                                            ?>

                                            <div class="row">
                                                <div class="col-md-3 col-xs-12 ">
                                                    <input  type="text" value="<?php echo $api_fields_map_to_gem['gem_field'][$key] ?>" id="price_prkm"   name="gem_field[]"  class="input" placeholder="GeM DB table Field" required/>
                                                </div>
                                                <div class="col-md-1 col-xs-12 ">
                                                    <i class="fa fa-arrow-left" ></i> <i class="fa fa-arrow-right" ></i>
                                                </div>                                                
                                                <div class="col-md-3 col-xs-12 ">
<!--                                                    <input type="hidden" value="<?php echo $api_fields_map_to_gem['api_fields'][$key] ?>" id="wtng_price_prmin"    name="api_fields[]"  class="input mapped_response" placeholder="API Fields" required/>-->
                                                       <select  name="api_fields_list[]" class="input response_array">
                                                      <?php
                                      
                                                    if (isset($api_sample_response)) {
                                                        foreach ($api_sample_response as $key2 => $value2) {
                                                            $split = explode(".", $value2);
                                                            $txt = $split[count($split) -1];
                                                            if( $api_fields_map_to_gem['api_fields_list'][$key] == $value2) {                  
                                                                 echo "<option selected='selected' value='$value2'> " . $txt . " </option>";
                                                            } else {
                                                            echo "<option value='$value2'> " . $txt . " </option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                        </select> 
                                                </div>
                                                <div class="col-md-2 col-xs-12 ">
                                                    <input type="text" value="<?php echo $api_fields_map_to_gem['data_type'][$key] ?>" id="price_prkm"   name="data_type[]"  class="input" placeholder="HEADER Parameter Name" required/>
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
                                        $a = 0;
                                        ?>
                                        <div class="row">


                                            <div class="col-md-4 col-xs-12 ">
                                                <input  disabled="disabled"  type="text" value="" id="price_prkm"   name="gem_field[]"  class="input" placeholder="GeM DB table Field" required/>
                                            </div>
                                            <div class="col-md-1 col-xs-12 ">
                                                <i class="fa fa-arrow-left" ></i> <i class="fa fa-arrow-right" ></i>

                                            </div>
                                            <div class="col-md-3 col-xs-12 ">
                                                
                                                <input type="text" value="" id="wtng_price_prmin"    name="api_fields[]"  class="input" placeholder="API Fields" required/>
                                            </div>
                                            <div class="col-md-2 col-xs-12 ">
                                                <input type="text" value="" id="price_prkm"   name="data_type[]"  class="input" placeholder="Data Type" required/>
                                            </div>
                                            <div class="col-md-2 col-xs-2 actionButton addMore ">
                                                <a href="javascript:void(0)" class="btn-blue <?php $a > 0 ? 'remove' : 'fullbrdr' ?>"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="col-md-12 mrgnbtm20"></div> 
                                        </div>
                                    <?php } ?>

                                </div>

                            </div>
                            <div class="row">

                                <div class="btn-group send  col-md-3"> 
                                    <input class="btn btn-primary pull-right" type="submit" value="Map API to GeM" />  


                                </div> 
                            </div>
                        </form>	
                    </div> 

                </div>




            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>/resources/js/custom/addCars.js"></script>
<script type="text/javascript">
                            var i;
                            var select = new Array();
                            parent = "";
                            /**
                             * 
                             * @type type
                             * will create an array containing string to call value of n no. of child
                             */
                            function get_child(obj, sep = "-") {
                            // alert(typeof (obj));
                            if (typeof (obj) === "object") {
                            //  alert("this is object");
                            for (i in obj) {  // i = [ride] => object

                            if (typeof (obj[i]) === "object" && obj[i] !== null) {
                            sep = sep + "x" + i;
                                    // alert(sep);
                                    parent += "[" + i + "]"; // set parent object will add in else part. 
                                    //  alert("parent " + parent);
                                    get_child(obj[i], sep); // Recurcive call 
                            } else {
                            //select.push( parent + i + ":" + obj[i]);
                            select.push(parent + "." + i);
                            }
                            }
                            }
                            //console.log(select);
                            return select;
                            }


                            $(".specificationsBox").on("click", ".remove", function (e) { //user click on remove text   <div><a href='javascript:void(0)' class='btn-blue fullbrdr'>Remove</a></div>");
                            e.preventDefault();
                                    $(this).parent().parent().remove();
                                    x--;
                            });
                            
                            $('.response_array').change(function(){
                                $(this).parent().find('.mapped_response').val($(this).val());
                               // alert($(this).val());   
                            });
</script>








