$.fn.extend({
    // NOTE: this function does not return a jQuery object!
    amarkalUIForm: function( method ) {
        
        // Store arguments for use with methods
        var args  = arguments.length > 1 ? Array.apply(null, arguments).slice(1) : [],
            data  = {},
            $form = $(this[0]);
            
        args.unshift($form);
        
        if( typeof method !== 'undefined' && Amarkal.UI.form.hasOwnProperty(method)) {
            data = Amarkal.UI.form[method].apply(null, args);
        }
        
        return data;
    }
});