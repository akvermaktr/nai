/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {


// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.my_custom_behavior = {
  attach: function(context, settings) {

    // Place your code here.
	
	jQuery(".item-list h3 a").removeAttr("href").css("cursor","pointer");
	$('.nav ul li.menuparent >  a').focus(function() { 
		$('li.menuparent:not(this)').removeClass('over'); 
		$(this).parents('li.menuparent').addClass('over');
	}) 


	$('a:not(.nav a)').focus(function(){
		$('li.menuparent').removeClass('over'); 
	}) ;

  }
};


})(jQuery, Drupal, this, this.document);
