/**
 * Default component config object. Will be merged with actual component 
 * config before instantiation.
 */
Amarkal.UI.abstractComponent = {
    $el:         null,
    props:       {},
    validity:    null,
    reset:       function(){
        this.makeValid();
    },
    getValue:    function(){
        return null;
    },
    setValue:    function(){
        return;
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
        return this.$el.attr('amarkal-component-name');
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
    
    // Constants
    VALID: 'valid',
    INVALID: 'invalid'
};