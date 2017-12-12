/**
 * Default component config object. Will be merged with actual component 
 * config before instantiation.
 */
Amarkal.UI.abstractComponent = {
    constructor:      function($el, props){
        this.$el = $el;
        this.props = props;
        this.state = {};
        this.validity = this.VALID;
        this.setValue(this.props.value);
    },
    instance:    function(){
        return this;
    },
    reset:       function(){
        this.makeValid();
    },
    getValue:    function(){
        return this.state.value;
    },
    setValue:    function(){
        return;
    },
    hasValue:    function(){
        return this.state && typeof this.state.value !== 'undefined';
    },
    getProps:    function(){
        return this.props;
    },
    setProps:    function(newProps){
        this.props = Object.assign({}, this.props, newProps);
    },
    changed:     function(){
        return this.props.value !== this.state.value;
    },
    refresh:     function(){},
    setValidity: function(validity){
        var errorClass = 'amarkal-ui-component-error';
        if(validity === this.VALID) {
            this.$el.removeClass(errorClass);
        }
        if(validity === this.INVALID) {
            this.$el.addClass(errorClass);
        }
        this.validity = validity;
    },
    getValidity: function(){
        return this.validity;
    },
    getName: function(){
        return typeof this.props.name === 'undefined' ? false : this.props.name;
    },
    makeInvalid: function(){
        this.setValidity(this.INVALID);
    },
    makeValid: function(){
        this.setValidity(this.VALID);
    },
    onChange:    function(){
        this.$el.trigger('amarkal.change',[this]);
    },
    show:        function(){
        this.$el.show();
        this.refresh();
        this.$el.trigger('amarkal.show',[this]);
    },
    hide:        function(){
        this.$el.hide();
        this.$el.trigger('amarkal.hide',[this]);
    },
    validateType:function(value, type) {
        if(!Amarkal.Core.Utility.validateType(value, type))
            console.warn(
                'Amarkal.UI.abstractComponent(...).validateType(...): '+
                'Expected a value of type "'+type+'" but instead got a "'+(typeof value)+'" (occurred in component "'+this.props.name+'")'
            );
    },

    // Constants
    VALID: 'valid',
    INVALID: 'invalid'
};