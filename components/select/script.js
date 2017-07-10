Amarkal.UI.registerComponent('select',{
    setValue: function(value) {
        this.$el.find('select > option').attr('selected',false);
        this.$el.find('select > option[value="'+value+'"]').attr('selected',true);
    },
    getValue: function() {
        return this.$el
            .find('select').val()
    },
    onInit: function() {
        var _this = this;
        this.$el.find('select').on('change',function(){
            _this.onChange();
        });
    }
});