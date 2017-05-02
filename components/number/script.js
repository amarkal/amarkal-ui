Amarkal.UI.registerComponent('number',{
    setValue: function(value) {
        this.$el.find('input').val(value);
    },
    getValue: function() {
        return this.$el.find('input').val();
    },
    onInit: function() {
        var _this = this;
        this.$el.find('input').on('change',function(){
            _this.onChange();
        });
    }
});