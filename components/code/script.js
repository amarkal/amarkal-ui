Amarkal.UI.registerComponent('code',{
    editor: null,
    setValue: function(value) {
        this.editor.setValue(value);
        this.editor.navigateLineEnd();
    },
    getValue: function() {
        return this.editor.getValue();
    },
    onInit: function() {
        var _this = this,
            el    = this.$el.find('.amarkal-ui-component-ace-editor');
 
        ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/');

        this.editor = ace.edit(el[0]);
        this.editor.getSession().setUseWorker(false); // Disable syntax checking
        this.editor.setTheme("ace/theme/"+this.props.theme);
        this.editor.getSession().setMode("ace/mode/"+this.props.language);
        this.editor.setOptions({
            maxLines: this.props.max_lines
        });

        this.editor.setReadOnly(this.props.readonly || this.props.disabled);

        el.on('keyup',function(){
            _this.onChange();

            // This is needed for regular form submissions (without using the Amarkal API)
            _this.$el.children('textarea').val(_this.editor.getValue());
        });
    },
    refresh: function() {
        this.editor.resize();
        this.editor.renderer.updateFull();
    }
});