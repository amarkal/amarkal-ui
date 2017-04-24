Amarkal.UI.registerComponent('textarea',{
    setValue: function(value) {
        this.$el.find('textarea').val(value);
    },
    getValue: function() {
        return this.$el.find('textarea').val();
    }
});