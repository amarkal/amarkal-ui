Amarkal.UI.registerComponent('select',{
    setValue: function(value) {
        this.$el.find('select > option').attr('selected',false);
        this.$el.find('select > option[value="'+value+'"]').attr('selected',true);
    },
    getValue: function() {
        return this.$el
            .find('select > option[selected]')
            .toArray()
            .map(function(el){return el.value;})[0]; // Should be only one
    }
});