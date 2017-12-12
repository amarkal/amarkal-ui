Amarkal.UI.registerComponent('number',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('input').on('change',function(e){
            _this.setValue(Number(e.target.value));
        });
    },
    setValue: function(value) {
        if(value !== this.state.value) {
            this.validateType(value, 'number');
            this.state.value = value;
            this.$el.find('input').val(value);
            this.onChange();
        }
    }
});