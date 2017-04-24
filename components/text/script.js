Amarkal.UI.registerComponent('text',{
    setValue: function(value) {
        this.$el.find('input').val(value);
    },
    getValue: function() {
        return this.$el.find('input').val();
    }
});