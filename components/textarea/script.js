Amarkal.UI.registerComponent('textarea',{
    setValue: function(value) {
        this.$el.find('textarea').val(value);
    },
    getValue: function() {
        return this.$el.find('textarea').val();
    },
    onInit: function() {
        var _this = this;
        this.$el.find('textarea').on('keyup',function(){
            _this.onChange();
        });
    }
});