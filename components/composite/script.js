Amarkal.UI.registerComponent('composite',{
    setValue: function(values) {
        // Given value must be an object (a PHP associative array)
        for(var key in values) {
            this.$el.find('[amarkal-component-name="'+key+'"]')
                .amarkalUIComponent('setValue', values[key]);
        }
    },
    getValue: function() {
        var values = {};
        this.$el.find('.amarkal-ui-component').each(function(){
            var name = $(this).attr('amarkal-component-name');
            $(this).amarkalUIComponent();
                
            values[name] = $(this).amarkalUIComponent('getValue');
        });
        return values;
    },
    onInit: function() {
        var _this = this;
        this.$el.find('.amarkal-ui-component').on('amarkal.change',function(){
            _this.onChange();
        });
    }
});