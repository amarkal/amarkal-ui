Amarkal.UI.registerComponent('code',{
    editor: null,
    constructor: function($el, props) {
        var _this = this,
            el    = $el.find('.amarkal-ui-component-ace-editor');

        ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/');

        this.editor = ace.edit(el[0]);
        this.editor.getSession().setUseWorker(false); // Disable syntax checking
        this.editor.setTheme("ace/theme/"+props.theme);
        this.editor.getSession().setMode("ace/mode/"+props.language);
        this.editor.setReadOnly(props.readonly || props.disabled);
        this.editor.$blockScrolling = Infinity;
        this.editor.setOptions({
            maxLines: props.max_lines
        });

        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);

        el.on('keyup',function(){
            _this.setValue(_this.editor.getValue());
        });
    },
    setValue: function(value) {
        if(this.state.value !== value) {
            this.validateType(value, 'string');
            this.state.value = value;
            // This is needed for regular form submissions (without using the Amarkal JS API)
            this.$el.children('textarea').val(value);
            this.editor.setValue(value);
            this.editor.navigateLineEnd();
            this.onChange();
        }
    },
    refresh: function() {
        this.editor.resize();
        this.editor.renderer.updateFull();
    }
});