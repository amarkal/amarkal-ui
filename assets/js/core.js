if(typeof global.Amarkal === "undefined") {
    var Amarkal = {};
    global.Amarkal = Amarkal;
}

Amarkal.UI = {
    
    /**
     * Stores the list of registered component types
     */
    components: {},
    
    /**
     * Register a component type and configuration
     * 
     * @param {String} type
     * @param {Object} config
     */
    registerComponent: function(type, config) {
        if(Amarkal.UI.components.hasOwnProperty(type)) {
            console.error("Attempting to register an existing component type '"+type+"'");
        }
        else {
            Amarkal.UI.components[type] = config;
        }
    },
    
    /**
     * Get the registered configuration object for the given component type.
     * 
     * @param {String} type
     * @returns {Object}
     */
    getComponentConfig: function(type) {
        if(Amarkal.UI.components.hasOwnProperty(type)) {
            return Amarkal.UI.components[type];
        }
        console.error("A component type '"+type+"' has not been registered");
    },
    
    /**
     * Instantiate a UI component for the given element.
     * 
     * @param {jQuery} $el
     * @returns {Object}
     */
    component: function($el) {
        var type   = $el.attr('class').match(/amarkal-ui-component-([a-z]+)/)[1],
            config = Amarkal.UI.getComponentConfig(type),
            comp   = $.extend({}, config, {$el:$el});
    
        // If the property is a function, bind the functions 'this' keyword to 
        // the component object
        for(var key in comp) {
            if(typeof comp[key] === "function") {
                comp[key] = comp[key].bind(comp);
            }
        }

        return comp;
    }
};

$.fn.extend({
    // NOTE: this function does not return a jQuery object!
    amarkalUIcomponent: function() {
        // If this is the initial call for this component, instantiate a new 
        // component object
        if( typeof this.data('amarkal-ui-component') === 'undefined' ) {
            this.data('amarkal-ui-component', Amarkal.UI.component(this));
        }
        return this.data('amarkal-ui-component');
    }
});