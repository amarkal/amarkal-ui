Amarkal.UI.registerComponent('button',{
    onInit: function() {
        this._setState('start');
        this.$el.on('click', this._onClick);
    },
    _doing: false,
    _onClick: function(e) {
        e.preventDefault();
        if(!this._doing) {
            this._doing = true;
            this._setState('doing');
            $.ajax({
                url: this.props.request_url,
                data: this.props.request_data,
                method: this.props.request_method,
                success: this._onDone,
                error: this._onError
            });
        }
    },
    _onDone: function(res) {
        var _this = this;
        this._setState('done');
        setTimeout(function(){
            _this._setState('start');
            _this._doing = false;
        },3000);
    },
    _onError: function() {
        var _this = this;
        this._setState('error');
        setTimeout(function(){
            _this._setState('start');
            _this._doing = false;
        },3000);
    },
    _setState: function(name) {
        var $btn = this.$el.find('button');
        $btn.text($btn.attr('data-label-'+name))
            .attr('class','')
            .addClass('amarkal-ui-'+name);
    }
});