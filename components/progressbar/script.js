Amarkal.UI.registerComponent('progressbar',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, $.extend({},props,{
            delta: Math.abs(props.max-props.min),
            labelWidth: 30, // The width of each label in the horizontal axis, in pixels (must match the CSS)
            minSpacing: 50 // Minimum spacing between labels
        }));

        this._updateLabel();
        this._populateValueLabels();

        $(window).on('resize', this.refresh);
    },
    setValue: function(value) {
        this.props.value = value;
        this.refresh();
    },
    getValue: function() {
        return this.props.value;
    },
    refresh: function() {
        this._updateLabel();
        this._populateValueLabels();
    },
    changed: function() {
        return false;
    },

    /**
     * Reposition the label above the slider's thumb
     */
    _updateLabel: function() {
        var left = (this.props.value-this.props.min)*100/this.props.delta;
        
        this.$el.find('.amarkal-ui-progressbar-inner').css({width: left+'%'});
        this.$el.find('.amarkal-ui-value-label').text(this.getValue()).css({left: left+'%'});
    },

    /**
     * Populate the values along the horizontal axis below the slider
     */
    _populateValueLabels: function() {
        var $progressbar = this.$el.find('.amarkal-ui-progressbar'),
            $labels = this.$el.find('.amarkal-ui-progressbar-values'),
            fn = this._formatNumber,
            p = this.props,
            lw = p.labelWidth,
            ms = p.minSpacing,
            v = this.getValue(),
            w = $progressbar.width(),
            c = Math.floor(Math.min((w+ms)/(lw+ms),(p.delta)+1));
        
        $labels.html((function(){
            var html = '';
            for(var i = 0; i < c; i++) {
                var n = (p.delta/(c-1))*i+p.min;
                html += '<span>'+fn(n)+'</span>';
            }
            return html;
        })());
    },

    /**
     * Format the given number, adding K/M when applicable
     */
    _formatNumber: function(n) {
        var d = this.props.delta,
            s = this.props.step;
        if(d/1000000 > 1) return (n/1000000).toFixed(1).replace(/\.0$/, "")+'M';
        if(d/1000 > 1) return (n/1000).toFixed(1).replace(/\.0$/, "")+'K';
        if(s < 1) return n.toFixed(1).replace(/\.0$/, "");
        return Math.round(n);
    }
});