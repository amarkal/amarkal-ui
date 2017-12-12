function Form($form) {
    this.$form = $form;
    this.$components = $form.find('.amarkal-ui-component');
    this.vm = new VisibilityManager(this);

    var _this = this;
    $(window).on('beforeunload',function(){
        if(_this.changed()) {
            return 'Are you sure you want to leave this page?';
        }
    });
}

/**
 * Check if the component whose name is given is visible or not, based on its
 * visibility condition
 */
Form.prototype.isVisible = function (name) {
    var props = this.getComponent(name).amarkalUIComponent('getProps');
    if(typeof props.show === 'string') {
        return this.vm.evaluateCondition(props.show);
    }
    return true;
};

/**
 * Refresh all the components in this form
 */
Form.prototype.refresh = function () {
    this.$components.each(function(){
        $(this).amarkalUIComponent('refresh');
    });
};

/**
 * Get a component by its name
 */
Form.prototype.getComponent = function (name) {
    var $component;
    this.$components.each(function(){
        if($(this).amarkalUIComponent('getName') === name) {
            $component = $(this);
            return false;
        }
    });
    return $component;
};

/**
 * Check if any of the values in the form has changed by comparing
 * its current value with its initial value
 */
Form.prototype.changed = function () {
    var changed = false;
    this.$components.each(function () {
        if($(this).amarkalUIComponent('changed')) {
            changed = true;
            return false;
        }
    });
    return changed;
};

/**
 * Get the value of the component whose name is given
 */
Form.prototype.getValue = function (name) {
    return this.getComponent(name).amarkalUIComponent('getValue');
};

/**
 * Get all component values from this form
 */
Form.prototype.getData = function () {
    var data = {};
    this.$components.each(function () {

        // Skip composite sub components
        if (!$(this).parents('.amarkal-ui-component').length) {
            if( $(this).amarkalUIComponent('hasValue') ) {
                var name = $(this).amarkalUIComponent('getName');
                data[name] = $(this).amarkalUIComponent('getValue');
            }
        }
    });
    return data;
};

/**
 * Update the components in this form with the given data, skipping erronous values
 */
Form.prototype.setData = function (data, errors) {
    this.$components.each(function () {

        // Skip composite sub components
        if (!$(this).parents('.amarkal-ui-component').length) {
            var name = $(this).amarkalUIComponent('getName');

            // Skip non-value components
            if( typeof name === 'undefined' ) {
                return;
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