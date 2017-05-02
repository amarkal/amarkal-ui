Amarkal.UI.registerComponent('text',{
    setValue: function(value) {
        this.$el.find('input').val(value);
    },
    getValue: function() {
        return this.$el.find('input').val();
    },
    onInit: function() {
        var _this = this;
        this.$el.on('keyup',function(){
            _this.onChange();
        });
    }
});