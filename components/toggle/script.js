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
        this.$el.find('.amarkal-ui-toggle-labels div').on('click',function(){
            var prevValue = _this.getValue(),
                newValue;

            if(!_this.props.multi) {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
                newValue = $(this).attr('data-value');
            }
            else {
                $(this).toggleClass('active');
                newValue = _this._getActiveValues();
            }

            _this.setValue(newValue);
            _this.onChange();
        });
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