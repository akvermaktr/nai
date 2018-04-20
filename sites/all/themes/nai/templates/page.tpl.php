<div id="page-wrapper"><div id="page">


        <div class="some-class-name2"> 
            <div class="main">
                <div class="header">
                    <div class="top-header">
                        <div class="top-header-left">
                            <ul>
                                
                                <li><?php print render($page['header_top_left']); ?></li>
                            </ul>
                        </div>
                        <div class="top-header-right">
                            <ul>
                                <li><?php print render($page['header_top_right']); ?></li>

                                <li><?php print render($page['text_size']); ?></li>
                                <li><a href="?theme=contrast"><img src="<?php print $base_path . $directory ?>/images/highcontrast.png" alt="High Contrast View" title="High Contrast View"></a></li>
                                <li><a href="?theme=nai"><img src="<?php print $base_path . $directory ?>/images/blue.png" alt="Blue Contrast View" title="Blue Contrast View"></a></li>
                                <li><a href="?theme=green"><img src="<?php print $base_path . $directory ?>/images/green.png" alt="Green Contrast View" title="Green Contrast View"></a></li>
                                <li><a href="?theme=orange"><img src="<?php print $base_path . $directory ?>/images/yellow.png" alt="Orange Contrast View" title="Orange Contrast View"></a></li>
                                <li><?php print render($page['search']) ?></li>
                                <li><?php print render($page['header']); ?></li>
                            </ul>

                        </div><!--end of top-header-->
                        <div class="cl"></div>
                        <div class="logo">
                            <ul>

                                <li><?php print render($page['header_logo_left']); ?></li>

                            </ul>



                        </div><!--end of logo-->
                        <div class="header-right">
                            <ul>

                                <li><?php print render($page['header_logo_right']); ?></li>
                            </ul>
                        </div><!--end of header-right-->
                    </div><!--end of header-->
                    <div class="cl"></div>

                    <div class="container">
                        <div class="cl"></div>
                        <div class="nav">
<?php if ($main_menu): ?>
                                <div id="main-menu" class="navigation">
                                <?php
                                // id, direction, depth should have the values you want them to have.
                                $menu = theme('nice_menus', array('id' => 0, 'direction' => 'down', 'depth' => 4, 'menu_name' => 'main-menu', 'menu' => NULL));
                                print $menu['content'];
                                ?>
                                </div> <!-- /#main-menu -->
                                <?php endif; ?>
                        </div><!--end of nav-->
                        <div class="cl"></div>
                        <div class="breadcrum">
<?php if ($breadcrumb): ?>
                                <div id="breadcrumb"><?php print $breadcrumb; ?></div>
                            <?php endif; ?>
                        </div><!--end of breadcrum-->
                        <div class="cl"></div>
                    </div><!--end of container-->

                    <div class="container">
                        <div class="mid">

                            <div class="left-panel-box">

                                <div id="accordion1" class="inner-left-box">

                                    <div>
<?php print render($page['left_sidebar']); ?>

                                    </div>

                                </div><!--end of inner-left-box-->
                                <div class="cl"></div>
                                <div class="related-link">
                                    <!-- <ul>
                                    <li class="even"><a href="#">What is Lorem Ipsum</a></li>
                                    <li class="odd"><a href="#">What is Lorem Ipsum</a></li>
                                    <li class="even"><a href="#">What is Lorem Ipsum</a></li>
                                    <li class="odd"><a href="#">What is Lorem Ipsum</a></li>
                                    <li class="even"><a href="#">What is Lorem Ipsum</a></li>
                                    <li class="odd"><a href="#">What is Lorem Ipsum</a></li>
                                </ul> -->

<?php print render($page['right_bottom']); ?>

                                </div><!--end or related-link-->
                                <div class="cl"></div>

                            </div><!--end of left-panel-box-->

                            <div id="skip" class="full-right-panel">
<?php if ($title): ?>
                                    <h3 class="title" id="page-title">
                                    <?php print $title; ?>
                                    </h3>
                                    <?php endif; ?>
                                <?php if ($messages): ?>
                                    <div id="messages"><div class="section clearfix">
                                    <?php print $messages; ?>
                                        </div></div> <!-- /.section, /#messages -->
                                        <?php endif; ?>
                                <?php //print render($page['triptych_last']);  ?>
                                <?php print render($page['content']); ?>


                            </div><!--end of mid-panel-->

                        </div><!--end of mid-->
                    </div><!--end of container-->

                    <div class="cl"></div>
                    <div class="container">
                        <div class="footer">
<?php print render($page['footer']); ?>
                            <div class="cl"></div>
                            <div class="footer-box">


                                <!--end of footerbox-left-->
                                <div class="footerbox-mid"><p>@ 2017, All rights reserved, National Informatics Centre Services Inc.</p></div><!--end of footerbox-mid-->
                                <div class="footerbox-right">
<?php print render($page['last_page_updated']); ?>
                                </div>

                            </div><!--end of footer-box-->

                        </div><!--end of footer-->
                    </div><!--end of container-->
                    <div class="cl"></div>
                </div><!--end of main-->
            </div><!--end of some-class-name2-->
        </div> 
    </div>
</div>
            <style type="text/css">

                #example {
                    background-image: url('/css/searchicon.png');
                    background-position: 10px 10px;
                    background-repeat: no-repeat;
                    width: 100%;
                    font-size: 16px;


                }

                #example {

                }

                #example th, #example td {

                }
                .myField1 {
                    float: right;
                    margin: 10px 15px 12px 0;
                }

            </style>
            <script type="text/javascript">
                function mySearchFunction() {
                    var input, filter, table, tr, td, i;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("example");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[1];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
                function mySearchDAteFunction() {
                    var input, filter, table, tr, td, i;
                    input = document.getElementById("myInputDAte");
                    filter = input.value;
                    table = document.getElementById("example");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[2];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
                function mySearchEmailFunction() {
                    var input, filter, table, tr, td, i;
                    input = document.getElementById("myInputEmail");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("example");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[3];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
                function mySearchContactFunction() {
                    var input, filter, table, tr, td, i;
                    input = document.getElementById("myInputContact");
                    filter = input.value;
                    table = document.getElementById("example");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[5];
                        if (td) {
                            if (td.innerHTML.indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }


                jQuery('#Ultra').change(function () {
                    var test = jQuery(this).val();
                    jQuery("table#example tbody tr").each(function ( ) {
                        var test2 = jQuery(this).find('td').find('input#hidden1');
                        jQuery(this).hide();
                        if (test2.val().indexOf(test) > -1) {

                            test2.parent().parent().parent().parent().show();

                        }

                    });
                });

            </script>
