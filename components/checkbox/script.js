Amarkal.UI.registerComponent('checkbox',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        this.$el.find('input').on('change',function(e){
            var key = e.target.value,
                newValue = _this.state.value.slice(),
                pos = newValue.indexOf(key);
            if(-1 === pos) {
                newValue.push(key);
            }
            else {
                newValue.splice(pos,1);
            }
            _this.setValue(newValue);
        });
    },
    setValue: function(value) {
        this.validateType(value, 'array');
        if(!Amarkal.Core.Array.same(this.state.value, value)) {
            this.state.value = value;

            // Set the input element's values
            this.$el.find('input').attr('checked',false);
            if(value.length) {
                for(var i = 0; i < value.length; i++) {
                    this.$el.find('input[value="'+value[i]+'"]').attr('checked',true);
                }
            }

            this.onChange();
        }
    },
    changed: function() {
        return !Amarkal.Core.Array.same(this.state.value, this.props.value);
    }
});