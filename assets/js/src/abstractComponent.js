/**
 * Default component config object. Will be merged with actual component 
 * config before instantiation.
 */
Amarkal.UI.abstractComponent = {
    $el:      null,
    getValue: function(){},
    setValue: function(){},
    onInit:   function(){},
    onChange: function(){
        this.$el.trigger('amarkal.change',[this]);
    }
};