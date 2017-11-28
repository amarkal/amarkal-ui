Amarkal.UI.form = function($form) {
    this.$form = $form;
    this.$components = $form.find('.amarkal-ui-component');
    this.vm = new VisibilityManager(this);
};

/**
 * Check if the component whose name is given is visible or not, based on its
 * visibility condition
 */
Amarkal.UI.form.prototype.isVisible = function (name) {
    var props = this.getComponent(name).amarkalUIComponent('getProps');
    if(typeof props.show === 'string') {
        return this.vm.evaluateCondition(props.show);
    }
    return true;
};

/**
 * Get a component by its name
 */
Amarkal.UI.form.prototype.getComponent = function (name) {
    return this.$components.filter('[amarkal-component-name="'+name+'"]');
};

/**
 * Get a component by its name
 */
Amarkal.UI.form.prototype.getValue = function (name) {
    return this.getComponent(name).amarkalUIComponent('getValue');
};

/**
 * Get all component values from this form
 */
Amarkal.UI.form.prototype.getData = function () {
    var data = {};
    this.$components.each(function () {

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
};

/**
 * Update the components in this form with the given data, skipping erronous values
 */
Amarkal.UI.form.prototype.setData = function (data, errors) {
    this.$components.each(function () {

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
};