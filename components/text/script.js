Amarkal.UI.registerComponent('text',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('input').on('keyup',function(e){
            _this.setValue(e.target.value);
        });
    },
    setValue: function(value) {
        if(value !== this.state.value) {
            this.validateType(value, 'string');
            this.state.value = value;
            this.$el.find('input').val(value);
            this.onChange();
        }
    }
});