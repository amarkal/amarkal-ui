Amarkal.UI.registerComponent('select',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('select').on('change',function(e){
            _this.setValue(e.target.value);
        });
    },
    setValue: function(value) {
        if(value !== this.state.value) {
            this.validateType(value, 'string');
            this.state.value = value;
            this.$el.find('select > option').attr('selected',false);
            this.$el.find('select > option[value="'+value+'"]').attr('selected',true);
            this.onChange();
        }
    }
});