Amarkal.UI.registerComponent('switch',{
    setValue: function(value) {
        this.$el.find('input[type="hidden"]').val(value);
        if('on' === value) {
            this.$el.find('input[type="checkbox"]').attr('checked',true);
        }
        else {
            this.$el.find('input[type="checkbox"]').attr('checked',false);
        }
    },
    getValue: function() {
        return this.$el.find('input[type="hidden"]').val();
    },
    onInit: function() {
        var _this = this;
        this.$el.find('input[type="checkbox"]').on('change',function(e){
            _this.$el.find('input[type="hidden"]').val(e.target.checked ? 'on' : 'off');
            _this.onChange();
        });
    }
});