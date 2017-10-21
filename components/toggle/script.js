Amarkal.UI.registerComponent('toggle',{
    setValue: function(value) {
        if(this.props.multi) {
            this.$el.find('input').val(value.join(','));
        }
        else {
            this.$el.find('input').val(value);
        }
        this._setActiveValues(value);
    },
    getValue: function() {
        var value = this.$el.find('input').val();
        if(this.props.multi) {
            return value.split(',');
        }
        return value;
    },
    onInit: function() {
        var _this = this;
        if(!this.props.disabled) {
            this.$el.find('.amarkal-ui-toggle-labels div').on('click',function(){
                _this._onClick($(this))
            });
        }
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
        this.onChange();
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