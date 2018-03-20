Drupal.behaviors.cacheableCsrf = {
  attach: function (context, settings) {
    "use strict";
    // Store the token in this scope to check when the cookie changes.
    var current;

    // Handles page initialisation once token is available.
    function init() {
      update(context);

      // Poll the cookie token to check when it changes.
      jQuery('body').once('cacheableCsrf', function() {
        setInterval(check, 1000);
      });
    }

    // Updates forms and links with the new token.
    function update(context) {
      var old = current;
      current = token();
      jQuery('input[type="hidden"][name="cacheable_csrf_token"]', context).val(current);
      jQuery('a[href*="cacheable_csrf_token"]', context).each(function() {
        this.href.replace(old, current).replace('cacheable_csrf_token_placeholder', current);
      });
    }

    // Checks for a changed token.
    function check() {
      if (current !== token()) {
        // Update the entire page.
        update(document);
      }
    }

    // Gets the token from the cookie.
    function token() {
      return jQuery.cookie(settings.cacheableCsrfCookie);
    }

    // Ensure token is available then start initialisation.
    if (token()) {
      init();
    }
    else {
      jQuery.post(Drupal.settings.basePath + 'cacheable-csrf', init);
    }
  }
};
