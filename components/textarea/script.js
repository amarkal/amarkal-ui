Amarkal.UI.registerComponent('textarea',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('textarea').on('keyup',function(e){
            _this.setValue(e.target.value);
        });
    },
    setValue: function(value) {
        if(value !== this.state.value) {
            this.validateType(value, 'string');
            this.state.value = value;
            this.$el.find('textarea').val(value);
            this.onChange();
        }
    }
});