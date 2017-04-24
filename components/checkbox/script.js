Amarkal.UI.registerComponent('checkbox',{
    setValue: function(value) {
        this.$el.find('input').attr('checked',false);
        if(value.length) {
            for(var i = 0; i < value.length; i++) {
                this.$el.find('input[value="'+value[i]+'"]').attr('checked',true);
            }
        }
    },
    getValue: function() {
        return this.$el
            .find('input[checked]')
            .toArray()
            .map(function(el){return el.value;});
    }
});