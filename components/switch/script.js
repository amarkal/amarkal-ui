Amarkal.UI.registerComponent('switch',{
    setValue: function(value) {
        if('on' === value) {
            this.$el.find('input').attr('checked',true);
        }
        else this.$el.find('input').attr('checked',false);
    },
    getValue: function() {
        return this.$el.find('input').is(':checked') ? 'on' : 'off';
    },
    onInit: function() {
        var _this = this;
        this.$el.find('input').on('change',function(){
            _this.onChange();
        });
    }
});