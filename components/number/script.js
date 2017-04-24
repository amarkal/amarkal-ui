Amarkal.UI.registerComponent('number',{
    setValue: function(value) {
        this.$el.find('input').val(value);
    },
    getValue: function() {
        return this.$el.find('input').val();
    }
});