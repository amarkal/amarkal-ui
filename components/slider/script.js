Amarkal.UI.registerComponent('slider',{
    constructor: function($el, props) {
        Amarkal.UI.abstractComponent.constructor.call(this, $el, props);
        var _this  = this,
            $range = this.$el.find('input'),
            $label = this.$el.find('.slider-value-label');

        this._setProps();
        this._updateLabelPosition();
        this._populateValueLabels();
        this._updateLabelValue($range.val());

        $range.on('input change',function(){
            _this._updateLabelValue($range.val());
            _this._updateLabelPosition();
            _this.setValue(Number($range.val()));
        });

        $(window).on('resize', this.refresh);
    },
    setValue: function(value) {
        if(value !== this.state.value) {
            this.validateType(value, 'number');
            this.state.value = value;
            this.$el.find('input').val(value);
            this._updateLabelPosition();
            this._updateLabelValue(value);
            this.onChange();
        }
    },
    refresh: function() {
        this._updateLabelPosition();
        this._populateValueLabels();
    },
    /**
     * Add properties to the basic props object
     */
    _setProps: function() {
        this.props = $.extend({},this.props,{
            delta: Math.abs(this.props.max-this.props.min),
            knobWidth: 26,
            labelWidth: 30, // The width of each label in the horizontal axis, in pixels (must match the CSS)
            minSpacing: 50 // Minimum spacing between labels
        });
    },

    /**
     * Reposition the label above the slider's thumb
     */
    _updateLabelPosition: function() {
        var $range = this.$el.find('input'),
            p = this.props,
            v = $range.val(),
            w = $range.width(),
            left = p.knobWidth/2 + ((w-p.knobWidth)*(v-p.min))/(p.delta);
        
        this.$el.find('.slider-value-label')
                .css({left: left+'px'});
    },
    
    /**
     * Update the value in the label above the thumb
     */
    _updateLabelValue: function(v) {
        this.$el.find('.slider-value-label').text(v);
    },

    /**
     * Populate the values along the horizontal axis below the slider
     */
    _populateValueLabels: function() {
        var $range = this.$el.find('input'),
            $labels = this.$el.find('.slider-values'),
            fn = this._formatNumber,
            p = this.props,
            lw = p.labelWidth,
            ms = p.minSpacing,
            v = $range.val(),
            w = $range.width(),
            c = Math.floor(Math.min((w+ms)/(lw+ms),(p.delta/p.step)+1));
        
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