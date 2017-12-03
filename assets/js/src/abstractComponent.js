/**
 * Default component config object. Will be merged with actual component 
 * config before instantiation.
 */
Amarkal.UI.abstractComponent = {
    $el:         null,
    props:       {},
    validity:    null,
    instance:    function(){
        return this;
    },
    reset:       function(){
        this.makeValid();
    },
    getValue:    function(){
        return null;
    },
    setValue:    function(){
        return;
    },
    getProps:    function(){
        return this.props;
    },
    setProps:    function(newProps){
        this.props = Object.assign({}, this.props, newProps);
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
    onInit:      function(){},
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

    // Constants
    VALID: 'valid',
    INVALID: 'invalid'
};