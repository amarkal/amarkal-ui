$.fn.extend({
    // NOTE: this function does not return a jQuery object!
    amarkalUIForm: function( method ) {
        
        // Store arguments for use with methods
        var args  = arguments.length > 1 ? Array.apply(null, arguments).slice(1) : [],
            data  = {},
            $form = $(this[0]);
        
        // If this is the initial call for this form, instantiate a new 
        // form object
        if( typeof $form.data('amarkal-ui-form') === 'undefined' ) {
            $form.data('amarkal-ui-form', new Amarkal.UI.form($form));
        }

        var form = $form.data('amarkal-ui-form');
        if( typeof method !== 'undefined' && typeof form[method] !== 'undefined') {
            data = form[method](args);
        }
        
        return data;
    }
});