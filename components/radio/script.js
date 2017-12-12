Amarkal.UI.registerComponent('radio',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('input').on('change',function(e){
            _this.setValue(e.target.value);
        });
    },
    setValue: function(value) {
        if(value !== this.state.value) {
            this.validateType(value, 'string');
            this.state.value = value;
            this.$el.find('input').attr('checked',false);
            this.$el.find('input[value="'+value+'"]').attr('checked',true);
            this.onChange();
        }
    }
});