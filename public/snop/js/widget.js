SnopWidget = {
    hashPrefix: 'GMS-',
    temp_step: null,
    floating_button_offset: 0,
    hash_params: '',
    scroll_enabled: 1,
    run: function(obj){
        this.host = obj.host;
        this.sessid = obj.sessid;
        this.$root = $('#snop_widget');

        this.addCss();
        this.process();
    },
    _call: function(url){
        var _this = this;
        $.get(this.url(url), function(resp){
            _this.processJSON(resp);
        });
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
    initParam: function(name){
        if(name in this){
            return this[name];
        }

        return null;
    },
    initBackButton: function(){
        var _this = this;
        this.hash = document.location.hash;
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
    process: function(){
        var _this = this;
        var step = this.getStep();
        if(this.routes[step]){
            $.ajax({
                cache: false,
                crossDomain: true,
                type: 'GET',
                url: this.url(this.routes[step]),
                success: function(resp){
                    try{
                        _this.processJSON(resp);
                    }catch(e){
                        _this.$root.html(resp);

                        //Skip extras step
                        if(step === 'extras' && _this.getStep() === 'extras' && _this.$root.find('#hbFormCheckout').html()){
                            step = 'checkout';
                            _this.setStep('checkout');
                        }
                        _this.promoteStep();
                        if(typeof _this[step + '_callback'] == 'function'){
                            _this[step + '_callback']();
                        }
                    }
                },
                error: function(){
                    alert('Unexpected connection error');
                }
            });
            _this.checkScroll();
        }else{
            alert('Undefined step ' + step);
        }
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
    processJSON: function(resp){
        var json = typeof resp == 'object' ? resp : $.parseJSON(resp);
        var hashParams = this.extractHashparams(json);
        if(json.type == 'step'){
            var step = json.booking_id ? json.step + '-' + json.booking_id : json.step;
            if(hashParams){
                step += hashParams;
            }
            this.setStep(step);
            this.process();
        }else if(json.type == 'location'){
            document.location.href = json.location;
        }else{
            alert('Unrecognized type ' + json.type);
        }
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
    getStep: function(){
        if(this.temp_step){
            var step = this.temp_step;
        }else{
            this.url_params = '';
            var step = this.normalizeHash(document.location.hash);
        }

        if(step == ''){
            step = 'search';
        }else if(step.indexOf('thankyouAnfrage') != -1){
            var splitted = step.split('-');
            var booking_id = splitted[1];
            step = 'thankyouAnfrage';
            this.url_params = '&booking_id=' + booking_id;
        }else if(step.indexOf('thankyou') != -1){
            var splitted = step.split('-');
            var booking_id = splitted[1];
            step = 'thankyou';
            this.url_params = '&booking_id=' + booking_id;
        }else if(step.indexOf('inquiryThank') != -1){
            var splitted = step.split('-');
            var booking_id = splitted[1];
            step = 'inquiryThank';
            this.url_params = '&booking_id=' + booking_id;
        }
        return step;
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
    url: function(url){
        var glue = url.indexOf('?') == -1 ? '?' : '&';
        var params = 'mode=widget' + this.url_params;
        if(this.sessid){

            params += '&sessid=' + this.sessid;
        }
        var pairs = {
            'GMS_date_from': 'date_from',
            'GMS_date_to': 'date_to',
            'GMS_kat_id': 'kat_id',
            'GMS_arrangement': 'arrangement',
            'GMS_filter_id': 'filter_id',
            'GMS_rule_id': 'rule_id',
            'GMS_adults': 'adults',
            'GMS_debug': 'debug',
            'GMS_reservid': 'reservid'
        };

        for(var i in pairs){
            if(this.urlParam(i)){
                params += '&' + pairs[i] + '=' + this.urlParam(i);
            }
        }

        for(var i in pairs){
            if(this.initParam(pairs[i])){
                var res = new RegExp('[\?&]' + pairs[i] + '=([^&#]*)').exec(params);
                if(!res){
                    params += '&' + pairs[i] + '=' + this.initParam(pairs[i]);
                }
            }
        }

        if(url.indexOf(params) != -1){
            return url;
        }
        return url + glue + params;
    },
    isValidHash: function(hash){
        var hashes = ['search', 'lastminute', 'inquiry', 'rooms', 'extras', 'checkout', 'thankyou', 'thankyouAnfrage', 'anfrage', 'inquiryThank', 'sessionExpired', ''];
        var splitted = this.normalizeHash(hash).split('-');
        var realhash = splitted[0];
        return $.inArray(realhash, hashes) != -1;
    },
    normalizeHash: function(hash){
        var reg = new RegExp('^' + this.hashPrefix);
        return hash.replace('#', '').replace(reg, '');
    }
}
