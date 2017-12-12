$.fn.extend({
    // NOTE: this function does not return a jQuery object!
    amarkalUIForm: function( method ) {
        
        // Store arguments for use with methods
        var args  = arguments.length > 1 ? Array.apply(null, arguments).slice(1) : [],
            methodReturnVal,
            selection,
            $form = $(this[0]),
            form = $form.data('amarkal-ui-form');
        
        selection = this.each(function(){
            var form = $(this).data('amarkal-ui-form');

            // If this is the initial call for this form, instantiate a new 
            // form object
            if( typeof form === 'undefined' ) {
                form = new Form($(this));
                $(this).data('amarkal-ui-form', form);
            }

            if( typeof method !== 'undefined' && typeof form[method] !== 'undefined') {
                methodReturnVal = form[method].apply(form, args);

                // If a method returns a value, only call it for the first 
                // element in the set
                if(typeof methodReturnVal !== 'undefined') {
                    return false;
                }
            }
        });
        
        return typeof methodReturnVal !== 'undefined' ? methodReturnVal : selection;
    }
});