 <?php

/**
 * @file
 * Bartik's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template normally located in the
 * modules/system directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_firstcolumn']: Items for the first footer column.
 * - $page['footer_secondcolumn']: Items for the second footer column.
 * - $page['footer_thirdcolumn']: Items for the third footer column.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see bartik_process_page()
 * @see html.tpl.php
 */

?>
<style type="text/css">
.front .region-right-bottom .menu-block-wrapper ul, .front .region-right-bottom .menu-block-wrapper ul li {
    list-style: outside none circle;
    padding: 4px 3px 1px 0px;
}
.menu-block-wrapper .menu.clearfix {
    margin-left: 9px;
}


.right-box {
    margin-top: 23px;
}

#mytest{
width: 100%;
 margin-top: 15%;
}

#block-menu-block-5 {
    border: 1px solid #DFDFDF;
}
#block-menu-block-6 {
    border: 1px solid #DFDFDF;
}
#block-menu-block-7 {
    border: 1px solid #DFDFDF;
}
#block-menu-block-8 {
    border: 1px solid #DFDFDF;
}
#mytest h2 {
    background: #19c9e0 none repeat scroll 0 0;
    color: #ffffff;
    padding: 8px;
    font-size: 12px;
    font-weight: bold;
}
.front .region-right-bottom .menu-block-wrapper ul{
padding:0px!important;
width: 95%;
}
</style>
<script type="text/javascript">
function myFunction() {
    var password = prompt("Please enter your password.");
if (password === "Nai@admin123"){
alert("Welcome to National Archives of India Website!!");  
}else{
alert("wrong password!");
window.location = "http://google.com/";
}  
}
</script>
<script>
$(document).ready(function(){
    $(".myUl").endlessRiver();
	$("#accordion").accordion();
	$('#menu').slicknav();
	$('#photo-gallery').carouFredSel({
			prev: '#prev1',
			next: '#next1',
			pagination: "#pager5",
			auto: false,
			scroll: 1,
			
		});
});
</script>

<script type="text/javascript">
		$(function(){
			$('.vertical-ticker').totemticker({
				row_height	:	'45px',
				next		:	'#ticker-next',
				previous	:	'#ticker-previous',
				stop		:	'#stop',
				start		:	'#start',
				mousestop	:	true,
			});
		});
</script>

<script type="text/javascript">
           $(document).ready(function() {
                $(".ticker1").modernTicker({
                    effect: "scroll",
                    scrollInterval: 20,
                    transitionTime: 100,
					next		:	'.mt-next',
					previous	:	'.mt-prev',
                    autoplay: true
                });
                });
				
				
</script>
<link href="http://45.115.99.201/nai/sites/all/themes/nai/css/jquery.bxslider.css" rel="stylesheet" />

<script src="http://45.115.99.201/nai/sites/all/themes/nai/js/jquery.bxslider.js"></script>

<script type="text/javascript">
jQuery(document).ready(function () {
    var slider=jQuery('.bxslider').bxSlider({
                mode: 'fade',
				auto:true,
				moveSlides: 1,
				slideMargin: 40,
				infiniteLoop: true,
				slideWidth: 990,
				minSlides: 1,
				maxSlides: 1,
				speed: 2500,
                ease: 'cubic-bezier(0.42,0,0.58,1)',
                pager: true,
                controls: true,
				infiniteLoop: true,
                autoControlsCombine: true,
                autoControls: true,
                pause: 100
           });

 jQuery(document).on('click','.pause',function(){
     
        slider.stopAuto();
        slider1.stopAuto();
        
    });
    
   jQuery(document).on('click','.play',function(){
     
        slider.startAuto();
        slider1.startAuto();
        
    });    
    });
	
</script>
<script type="text/javascript">
$(document).ready(function() {
	$('.nav-tabs > li > a').click(function(event){
	event.preventDefault();//stop browser to take action for clicked anchor
	//get displaying tab content jQuery selector
	var active_tab_selector = $('.nav-tabs > li.active > a').attr('href');					
	//find actived navigation and remove 'active' css
	var actived_nav = $('.nav-tabs > li.active');
	actived_nav.removeClass('active');
	//add 'active' css into clicked navigation
	$(this).parents('li').addClass('active');
	//hide displaying tab content
	$(active_tab_selector).removeClass('active');
	$(active_tab_selector).addClass('hide');
	//show target tab content
	var target_tab_selector = $(this).attr('href');
	$(target_tab_selector).removeClass('hide');
	$(target_tab_selector).addClass('active');
	});
	});
</script>
<div id="page-wrapper"><div id="page">

<div class="some-class-name2"> 
	<div class="main">
    	<div class="header">
        	<div class="top-header">
				<div class="top-header-left">
				<ul>
				<li><!--<a href="https://www.facebook.com/pages/National-Archives-of-India/1591249217756061" target="_blank"><img src="<?php print $base_path . $directory ?>/images/facebook.png" alt="facebook" title="facebook"></a></li>
                   <li><a href="https://twitter.com/search?q=National%20Archives%20of%20India&src=tyah" target="_blank"><img src="<?php print $base_path . $directory ?>/images/twitter.png" alt="twitter" title="twitter"></a></li>
                   <li><a href="#"><img src="<?php print $base_path . $directory ?>/images/in.png" alt="twitter" title="twitter"></a></li>-->
				   <li><?php print render($page['header_top_left']); ?></li>
				   </ul>
				   </div>
            	<div class="top-header-right">
            	<ul>
				<li><?php print render($page['header_top_right']); ?></li>

                   <li><?php print render($page['text_size']); ?></li>
                   <li><a href="?theme=contrast"><input type="image" src="<?php print $base_path . $directory ?>/images/highcontrast.png" alt="High Contrast View" title="High Contrast View"></a></li>
                   <li><a href="?theme=nai"><img src="<?php print $base_path . $directory ?>/images/blue.png" alt="Blue Contrast View" title="Blue Contrast View"></a></li>
                   <li><a href="?theme=green"><img src="<?php print $base_path . $directory ?>/images/green.png" alt="Green Contrast View" title="Green Contrast View"></a></li>
                   <li><a href="?theme=orange"><img src="<?php print $base_path . $directory ?>/images/yellow.png" alt="Orange Contrast View" title="Orange Contrast View"></a></li>
				   <li><?php print render($page['search']) ?></li>
                   <li><?php print render($page['header']); ?></li>
                </ul>
               <!-- <script type="text/javascript">
				$('.some-class-name2').jfontsize({
				btnMinusClasseId: '#jfontsize-m2',
				btnDefaultClasseId: '#jfontsize-d2',
				btnPlusClasseId: '#jfontsize-p2',
				btnMinusMaxHits: 1,
				btnPlusMaxHits: 1,
				sizeChange: 2
				});
			  </script>
                <div class="search-box">
                	<input type="text" name=""  value="Enter the keyword" onFocus="if (this.value==this.defaultValue) this.value = ''" onBlur="if (this.value=='') this.value = this.defaultValue">
                    <input type="search" name="">
                </div><!--end of search-box-->
                </div><!--end of top-header-right-->
            </div><!--end of top-header-->
            <div class="cl"></div>
        	<div class="logo"><!--<img src="<?php print $base_path . $directory ?>/images/logo.png" alt="National Archives of India" title="National Archives of India">-->
            <ul>
                <!--<li><a href="#"><img src="<?php print $base_path . $directory ?>/images/emblem.png" alt="National Archives of India" title="National Archives of India"></a></li>
                <li><a href="#"><img src="<?php print $base_path . $directory ?>/images/moud.png" alt="National Archives of India" title="National Archives of India"></a></li>
                <li><a href="#"><img src="<?php print $base_path . $directory ?>/images/s.png" alt="National Archives of India" title="National Archives of India"></a></li>
                <li><a href="#"><span>?????? ????????? ??????????</span><p>National Archives of India</p></a></li>
                <li><a href="<?php echo $front_page; ?>"><img src="<?php print $base_path . $directory ?>/images/logo1.png" alt="National Archives of India" title="National Archives of India"></a></li>-->
				<li><?php print render($page['header_logo_left']); ?></li>
                
            </ul>
            
            
            
            </div><!--end of logo-->
            <div class="header-right">
            	<ul>
                	<!--<li><a href="#"><img src="<?php //print $base_path . $directory ?>/images/nai-icon.png" alt="National Archives of India" title="National Archives of India">
                    
                     </a></li>
                   <li><a href="http://www.abhilekh-patal.in/web/content/default.aspx" target="_blank"><img src="<?php //print $base_path . $directory ?>/images/abhilekh-logo1.png" alt="Abhilekh Patal" title="Abhilekh Patal"></a></li>-->
                   <!--<li><a href="#"><!--<img src="<?php //print $base_path . $directory ?>/images/nai-icon.png" alt="" title="">
                  </a></li>-->
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
  //$menu = theme('nice_menus', array('id' => 0, 'direction' => 'down', 'depth' => 5, 'menu_name' => 'main-menu', 'menu' => NULL));
  //print $menu['content'];
  print render($page['navigation']); 
  
?>
      </div> <!-- /#main-menu -->
    <?php endif; ?>
            </div><!--end of nav-->
            <div class="cl"></div>
            <div>
            	<div class="banner">
                <!--<img src="<?php print $base_path . $directory ?>/images/banner.png" alt="" title="">-->
				<?php print render($page['banner']); ?>
                </div><!--end of banner-->
            </div><!--ende of left-part-->
             <div class="news">
                    <span><?php $annou = t("Announcement"); print $annou; ?></span>
                   
					
                    
                            <?php print render($page['highlighted']); ?>

                    
                    <!--end of news-box-->
                    <div class="cl"></div>
                </div>
                  
            
            <div class="cl"></div>
            
            <div class="left-part">
			  
                <div class="tab-box" id="skip">
				<div class="tab-content active tab-box">
				<?php print render($page['middle_menu']); ?>
				
                    </div>
                 
                </div><!--end of tab-box-->
            </div>
			
			 <div class="what-new">
            	<h3><?php $what = t("Whats New"); print $what; ?> <p class="n-play-pause">
                <a id="stop" href="#">Stop</a>
                <a id="start" href="#">Start</a>
                </p></h3>
                <?php print render($page['sidebar_first']); ?>
				<div class="cl"></div>
               </div>
			 <div>  
			<div id="mytest" >
				
                	 <?php print render($page['right_bottom']); ?>
            </div>
			
			</div>	
                                <div class="cl">
					
					<?php print render($page['triptych_last']); ?>
					</div>
					<?php print render($page['footer_slider']); ?>
            </div><!--end of container-->
        
        <div class="cl"></div>
        <div class="container">
        <div class="footer">
            	 <?php print render($page['footer']); ?>
                <div class="cl"></div>
            	<div class="footer-box">
                
                <!--<div class="footerbox-left"><p>Visiter Counter: 1</p></div> --> <!--end of footerbox-left-->
                <div class="footerbox-mid"><p>@ 2017, All rights reserved, National Informatics Centre Services Inc.</p></div><!--end of footerbox-mid-->
                <div class="footerbox-right"><!--<p>Last Updated on 31 March -2015</p>-->
				<?php print render($page['last_page_updated']); ?>
				</div><!--end of footerbox-right-->
                
                </div><!--end of footer-box-->
            
        </div><!--end of footer-->
        </div><!--end of container-->
        <div class="cl"></div>
    </div><!--end of main-->
    </div><!--end of some-class-name2-->