Amarkal.UI.registerComponent('composite',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('.amarkal-ui-component').on('amarkal.change',function(){
            var name   = $(this).amarkalUIComponent('getName'),
                value  = $(this).amarkalUIComponent('getValue'),
                values = Object.assign({}, _this.state.value);

            values[name] = value;
            _this.setValue(values);
        });
    },
    setValue: function(value) {
        // Given value must be an object (a PHP associative array)
        if(!Amarkal.Core.Object.equal(this.state.value, value)) {
            this.validateType(value, 'object');
            this.state.value = value;
            for(var key in value) {
                this.$el.find('[amarkal-component-name="'+key+'"]')
                    .amarkalUIComponent('setValue', value[key]);
            }
            this.onChange();
        }
    },
    changed: function() {
        return !Amarkal.Core.Object.equal(this.state.value, this.props.value);
    }
});