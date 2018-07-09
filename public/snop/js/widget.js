SnopWidget = {
    hashPrefix: 'GMS-',
    temp_step: null,
    floating_button_offset: 0,
    hash_params: '',
    scroll_enabled: 1,
    loading_html: '',
    step: '',
    params: '',
    hash_delim: '[&]',
    hash_eq_delim: '==',
    run: function(obj){
        this.host = obj.host;
        this.sessid = obj.sessid;
        this.$root = $('#snop_widget');
        this.loading_html = $('#snop_widget').html();

        this.addCss();
        this.initBackButton();

    },
    urlParam: function(name){
        try {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        }catch(e){
            return null;
        }
    },
    addCss: function(){

         var linkCss = "<link rel='stylesheet' type='text/css' href='" + this.routes.css + "' >";
         $('head').append(linkCss);
    },
    loading: function(){
        this.$root.html(this.loading_html);
    },
    initParam: function(name){
        if(name in this){
            return this[name];
        }

        return null;
    },
    initBackButton: function(){
        var _this = this;
        this.hash = 'SNOP STARTER HASH';
        if(!this.interval){
            this.interval = setInterval(function(){
                if(_this.hash != document.location.hash && _this.isValidHash(document.location.hash)){
                    _this.hash = document.location.hash;
                    _this.loading();
                    _this.process();
                }
            }, 500);
        }
    },
    ajax: function(url, method, params, callback){
        var _this = this;
        var obj = {
            cache: false,
            crossDomain: true,
            type: method,
            url: url,
            success: function(resp){
                try{
                    _this.processJson(resp);
                }catch(e){
                    _this.$root.html(resp);

                    //  _this.promoteStep();
                    _this.processHtml();
                    if(callback){
                        callback(_this, resp);
                    }

                }
            },
            error: function(){
                alert('Unexpected connection error');
            }
        };
        if(method == 'POST' && params){
            obj.data = params;
        }
        $.ajax(obj);
    },
    process: function(){
        var _this = this;
        _this.getStepAndParamsFromHash();
        if(_this.routes[_this.step]){
            var callback;
            if(typeof _this.Callback[_this.step] == 'function'){
                callback = _this.Callback[_this.step];
            }
            _this.ajax(_this.url(_this.routes[_this.step]), 'GET', {}, callback);
            _this.checkScroll();
        }else{
            alert('Undefined step ' + _this.step);
        }
    },
    goTo: function(step, params){
        var hash = '';
        if(step){
            hash += hash = 'step' + this.hash_eq_delim + step;
        }
        if(params){
            var delim = hash ? this.hash_delim : '';
            hash += delim + 'params' + this.hash_eq_delim + params;
        }
        document.location.hash = hash;
    },
    checkScroll: function(){
        try {
            if(this.scroll_enabled == 1){
                var gms_top = $('#GMS_top_of_the_widget').offset().top;
                var doc_top = $(window).scrollTop();
                if (Math.abs(gms_top - doc_top) > 200) {
                    $('html, body').animate({
                        scrollTop: gms_top
                    });
                }
            }
        }catch(e){
            console.log(e);
        }
    },
    processJson: function(json){
        if(typeof json != 'object'){
            json = $.parseJSON(json);
        }
        if(json.step) {
            this.goTo(json.step, json.params);
        }else if(json.redirect){
            document.location.href = json.redirect;
        }else if(json.error){
            alert(json.error);
        }
    },
    processHtml: function(){
        var _this = this;
        var NOPARAMS = true;
        this.$root.find('.snop-process-html:not(.snop-processed)').each(function(){
            if($(this).data('step')){
                $(this).click(function(){

                    _this.goTo($(this).data('step'), $(this).data('params'));
                    return false;
                });
            }else if($(this).data('ajax') == 'link'){
                $(this).click(function(){
                    _this.ajax(_this.url(this.href,NOPARAMS ), 'GET');
                   return false;
                });
            }else if($(this).data('ajax') == 'form'){
                $(this).submit(function(){
                    var data = $(this).serialize();
                    _this.ajax(_this.url(this.action, NOPARAMS), 'POST', data);
                    return false;
                });
            }
            $(this).addClass('snop-processed');
        });
    },
    extractHashparams: function(json){
        var map = {
            hsh: 'hsh'
        };
        var hashParams = '';
        for(var i in map){
            if(json[i]){
                hashParams += '&' + map[i] + '=' + json[i];
            }
        }
        return hashParams;
    },
    getStepAndParamsFromHash: function(){
        this.step = 'search';
        this.params = '';
        var hash = this.normalizeHash(document.location.hash);
        var splitted = hash.split(this.hash_delim);
        for(var i = 0; i < splitted.length; i++){
            var item = splitted[i].split(this.hash_eq_delim);
            if(this.isValidHashItem(item[0], item[1])){
                if(typeof item[1] == 'undefined'){
                    item[1] = null;
                }
                this[item[0]] = item[1];
            }
        }
    },
    isValidHashItem: function(name, value){
        return name == 'step' || name == 'params';
    },
    setStep: function(step){
        this.temp_step = step;
    },
    promoteStep: function(){
        if(this.temp_step){
            var step = this.hashPrefix + this.temp_step;
            if(document.location.hash){
                document.location.href = document.location.href.replace(document.location.hash, '#' + step);
            }else{
                document.location.href += '#' + step;
            }
            this.hash = '#' + step;
            this.temp_step = null;
        }
    },
    url: function(url, noparams){
        var glue = url.indexOf('?') == -1 ? '?' : '&';
        var params = 'mode=widget';
        if(this.params && !noparams){
            params += '&' + this.params;
        }
        if(this.sessid){

            params += '&sessid=' + this.sessid;
        }
        return url + glue + params;
    },
    isValidHash: function(hash){
        return true;
        var hashes = ['search', 'lastminute', 'inquiry', 'rooms', 'extras', 'checkout', 'thankyou', 'thankyouAnfrage', 'anfrage', 'inquiryThank', 'sessionExpired', ''];
        var splitted = this.normalizeHash(hash).split('-');
        var realhash = splitted[0];
        return $.inArray(realhash, hashes) != -1;
    },
    normalizeHash: function(hash){
        var reg = new RegExp('^' + this.hashPrefix);
        return hash.replace('#', '').replace(reg, '');
    },
    Callback: {
        search: function(_this, resp){
            SnopBooking.init_search();

            $('#snop_search_form').submit(function(){
                var params = $(this).serialize();
                _this.goTo('rooms', params);
                return false;
            })
        },
        rooms: function(_this, resp){
            SnopBooking.init_rooms();

            $('#snop_link_search').click(function(){
               _this.goTo('search');
               return false;
            });
        },
        checkout: function(_this, resp){
            SnopBooking.init_checkout();

            $('#snop_booking_payment').click(function(){
               $('#snop_checkout_form').append("<input type='hidden' name='order[payment]' value='1' >");
            });
        }
    }
}
