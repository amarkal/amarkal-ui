var $ = window.jQuery;

exports.UI = {
    
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
    createComponent: function($el) {
        
        var type   = $el.attr('class').match(/amarkal-ui-component-([a-z]+)/)[1],
            config = Amarkal.UI.getComponentConfig(type),
            comp   = $.extend({}, Amarkal.UI.abstractComponent, config),
            props  = JSON.parse($el.children('.amarkal-ui-component-props').text());
        
        // If the property is a function, bind the functions 'this' keyword to 
        // the component object
        for(var key in comp) {
            if(typeof comp[key] === "function") {
                comp[key] = comp[key].bind(comp);
            }
        }
        
        // Call component initiation function
        comp.constructor($el, props);
        
        return comp;
    },
    
    /**
     * Initiate all UI components
     */
    init: function() {
        $('.amarkal-ui-component').amarkalUIComponent();
    }
};

$(document).ready(function(){
    Amarkal.UI.init();
});