Amarkal.UI.registerComponent('radio',{
    setValue: function(value) {
        this.$el.find('input').attr('checked',false);
        this.$el.find('input[value="'+value+'"]').attr('checked',true);
    },
    getValue: function() {
        return this.$el
            .find('input[checked]')
            .val();
    }
});