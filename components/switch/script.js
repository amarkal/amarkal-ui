Amarkal.UI.registerComponent('switch',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('input[type="checkbox"]').on('change',function(e){
            _this.setValue(e.target.checked ? 'on' : 'off');
        });
    },
    setValue: function(value) {
        if(value !== this.state.value) {
            this.validateType(value, 'string');
            this.state.value = value;
            this.$el.find('input[type="hidden"]').val(value);
            this.$el.find('input[type="checkbox"]').attr('checked','on' === value);
            this.onChange();
        }
    }
});