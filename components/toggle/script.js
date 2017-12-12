Amarkal.UI.registerComponent('toggle',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this = this;
        if(!this.props.disabled) {
            this.$el.find('.amarkal-ui-toggle-labels div').on('click',function(){
                _this._onClick($(this));
            });
        }
    },
    setValue: function(value) {
        if(this.props.multi) {
            if(!Amarkal.Core.Array.same(value, this.state.value)) {
                this.validateType(value, 'array');
                this.state.value = value;
                this.$el.find('input').val(value.join(','));
                this._setActiveValues(value);
                this.onChange();
            }
        }
        else {
            if(value !== this.state.value) {
                this.validateType(value, 'string');
                this.state.value = value;
                this.$el.find('input').val(value);
                this._setActiveValues(value);
                this.onChange();
            }
        }
    },
    changed: function() {
        if(this.props.multi) {
            return !Amarkal.Core.Array.same(this.state.value, this.props.value);
        }
        return this.state.value !== this.props.value;
    },
    _onClick: function($el) {
        var prevValue = this.getValue(),
            newValue;

        if(!this.props.multi) {
            $el.siblings().removeClass('active');
            $el.addClass('active');
            newValue = $el.attr('data-value');
        }
        else {
            $el.toggleClass('active');
            newValue = this._getActiveValues();
        }

        this.setValue(newValue);
    },
    _getActiveValues: function() {
        var values = [];
        this.$el.find('.amarkal-ui-toggle-labels div.active').each(function(){
            values.push($(this).attr('data-value'));
        });
        return values;
    },
    _setActiveValues: function(values) {
        var multi = this.props.multi;
        this.$el.find('.amarkal-ui-toggle-labels div').each(function(){
            var value = $(this).attr('data-value');
            $(this).removeClass('active');
            if((multi && values.indexOf(value) > -1) || (!multi && values === value)) {
                $(this).addClass('active');
            }
        });
    }
});