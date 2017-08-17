Amarkal.UI.form = {
    getData: function ($form) {
        var data = {};
        $form.find('.amarkal-ui-component').each(function () {

            // Skip composite sub components
            if (!$(this).parents('.amarkal-ui-component').length) {
                var name = $(this).amarkalUIComponent('getName'),
                    value = $(this).amarkalUIComponent('getValue');
                
                if( typeof name !== 'undefined' ) {
                    data[name] = value;
                }
            }
        });
        return data;
    },
    setData: function ($form, data, errors) {
        $form.find('.amarkal-ui-component').each(function () {

            // Skip composite sub components
            if (!$(this).parents('.amarkal-ui-component').length) {
                var name = $(this).amarkalUIComponent('getName');

                // Skip non-value components
                if( typeof name === 'undefined' ) {
                    return
                }

                // Don't update the value if this field is erronous
                if (typeof errors !== 'undefined' &&
                    errors.hasOwnProperty(name)) {
                    return;
                }

                if (data.hasOwnProperty(name)) {
                    $(this).amarkalUIComponent('setValue', data[name]);
                }
            }
        });
    }
};