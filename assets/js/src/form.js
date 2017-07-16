Amarkal.UI.form = {
    getData: function ($form) {
        var data = {};
        $form.find('.amarkal-ui-component').each(function () {
            
            // Skip composite sub components
            if (!$(this).parents('.amarkal-ui-component').length) {
                var name = $(this).amarkalUIComponent('getName'),
                    value = $(this).amarkalUIComponent('getValue')
                data[name] = value;
            }
        });
        return data;
    },
    setData: function ($form, data, errors) {
        $form.find('.amarkal-ui-component').each(function () {

            // Skip composite sub components
            if (!$(this).parents('.amarkal-ui-component').length) {
                var name = $(this).amarkalUIComponent('getName');

                if ( typeof errors !== 'undefined' && 
                    !errors.hasOwnProperty(name)) {

                    $(this).amarkalUIComponent('setValue', data[name]);
                }
                
            }
        });
    }
};