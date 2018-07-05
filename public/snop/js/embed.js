(function($){
    if(!$.url){
        window.url = (function() {

            function _t() {
                return new RegExp(/(.*?)\.?([^\.]*?)\.?(com|net|org|biz|ws|in|me|co\.uk|co|org\.uk|ltd\.uk|plc\.uk|me\.uk|edu|mil|br\.com|cn\.com|eu\.com|hu\.com|no\.com|qc\.com|sa\.com|se\.com|se\.net|us\.com|uy\.com|ac|co\.ac|gv\.ac|or\.ac|ac\.ac|af|am|as|at|ac\.at|co\.at|gv\.at|or\.at|asn\.au|com\.au|edu\.au|org\.au|net\.au|id\.au|be|ac\.be|adm\.br|adv\.br|am\.br|arq\.br|art\.br|bio\.br|cng\.br|cnt\.br|com\.br|ecn\.br|eng\.br|esp\.br|etc\.br|eti\.br|fm\.br|fot\.br|fst\.br|g12\.br|gov\.br|ind\.br|inf\.br|jor\.br|lel\.br|med\.br|mil\.br|net\.br|nom\.br|ntr\.br|odo\.br|org\.br|ppg\.br|pro\.br|psc\.br|psi\.br|rec\.br|slg\.br|tmp\.br|tur\.br|tv\.br|vet\.br|zlg\.br|br|ab\.ca|bc\.ca|mb\.ca|nb\.ca|nf\.ca|ns\.ca|nt\.ca|on\.ca|pe\.ca|qc\.ca|sk\.ca|yk\.ca|ca|cc|ac\.cn|com\.cn|edu\.cn|gov\.cn|org\.cn|bj\.cn|sh\.cn|tj\.cn|cq\.cn|he\.cn|nm\.cn|ln\.cn|jl\.cn|hl\.cn|js\.cn|zj\.cn|ah\.cn|gd\.cn|gx\.cn|hi\.cn|sc\.cn|gz\.cn|yn\.cn|xz\.cn|sn\.cn|gs\.cn|qh\.cn|nx\.cn|xj\.cn|tw\.cn|hk\.cn|mo\.cn|cn|cx|cz|de|dk|fo|com\.ec|tm\.fr|com\.fr|asso\.fr|presse\.fr|fr|gf|gs|co\.il|net\.il|ac\.il|k12\.il|gov\.il|muni\.il|ac\.in|co\.in|org\.in|ernet\.in|gov\.in|net\.in|res\.in|is|it|ac\.jp|co\.jp|go\.jp|or\.jp|ne\.jp|ac\.kr|co\.kr|go\.kr|ne\.kr|nm\.kr|or\.kr|li|lt|lu|asso\.mc|tm\.mc|com\.mm|org\.mm|net\.mm|edu\.mm|gov\.mm|ms|nl|no|nu|pl|ro|org\.ro|store\.ro|tm\.ro|firm\.ro|www\.ro|arts\.ro|rec\.ro|info\.ro|nom\.ro|nt\.ro|se|si|com\.sg|org\.sg|net\.sg|gov\.sg|sk|st|tf|ac\.th|co\.th|go\.th|mi\.th|net\.th|or\.th|tm|to|com\.tr|edu\.tr|gov\.tr|k12\.tr|net\.tr|org\.tr|com\.tw|org\.tw|net\.tw|ac\.uk|uk\.com|uk\.net|gb\.com|gb\.net|vg|sh|kz|ch|info|ua|gov|name|pro|ie|hk|com\.hk|org\.hk|net\.hk|edu\.hk|us|tk|cd|by|ad|lv|eu\.lv|bz|es|jp|cl|ag|mobi|eu|co\.nz|org\.nz|net\.nz|maori\.nz|iwi\.nz|io|la|md|sc|sg|vc|tw|travel|my|se|tv|pt|com\.pt|edu\.pt|asia|fi|com\.ve|net\.ve|fi|org\.ve|web\.ve|info\.ve|co\.ve|tel|im|gr|ru|net\.ru|org\.ru|hr|com\.hr|ly|xyz)$/);
            }

            function _d(s) {
                return decodeURIComponent(s.replace(/\+/g, ' '));
            }

            function _i(arg, str) {
                var sptr = arg.charAt(0),
                    split = str.split(sptr);

                if (sptr === arg) { return split; }

                arg = parseInt(arg.substring(1), 10);

                return split[arg < 0 ? split.length + arg : arg - 1];
            }

            function _f(arg, str) {
                var sptr = arg.charAt(0),
                    split = str.split('&'),
                    field = [],
                    params = {},
                    tmp = [],
                    arg2 = arg.substring(1);

                for (var i = 0, ii = split.length; i < ii; i++) {
                    field = split[i].match(/(.*?)=(.*)/);

                    // TODO: regex should be able to handle this.
                    if ( ! field) {
                        field = [split[i], split[i], ''];
                    }

                    if (field[1].replace(/\s/g, '') !== '') {
                        field[2] = _d(field[2] || '');

                        // If we have a match just return it right away.
                        if (arg2 === field[1]) { return field[2]; }

                        // Check for array pattern.
                        tmp = field[1].match(/(.*)\[([0-9]+)\]/);

                        if (tmp) {
                            params[tmp[1]] = params[tmp[1]] || [];

                            params[tmp[1]][tmp[2]] = field[2];
                        }
                        else {
                            params[field[1]] = field[2];
                        }
                    }
                }

                if (sptr === arg) { return params; }

                return params[arg2];
            }

            return function(arg, url) {
                var _l = {}, tmp, tmp2;

                if (arg === 'tld?') { return _t(); }

                url = url || window.location.toString();

                if ( ! arg) { return url; }

                arg = arg.toString();

                if (tmp = url.match(/^mailto:([^\/].+)/)) {
                    _l.protocol = 'mailto';
                    _l.email = tmp[1];
                }
                else {

                    // Ignore Hashbangs.
                    if (tmp = url.match(/(.*?)\/#\!(.*)/)) {
                        url = tmp[1] + tmp[2];
                    }

                    // Hash.
                    if (tmp = url.match(/(.*?)#(.*)/)) {
                        _l.hash = tmp[2];
                        url = tmp[1];
                    }

                    // Return hash parts.
                    if (_l.hash && arg.match(/^#/)) { return _f(arg, _l.hash); }

                    // Query
                    if (tmp = url.match(/(.*?)\?(.*)/)) {
                        _l.query = tmp[2];
                        url = tmp[1];
                    }

                    // Return query parts.
                    if (_l.query && arg.match(/^\?/)) { return _f(arg, _l.query); }

                    // Protocol.
                    if (tmp = url.match(/(.*?)\:?\/\/(.*)/)) {
                        _l.protocol = tmp[1].toLowerCase();
                        url = tmp[2];
                    }

                    // Path.
                    if (tmp = url.match(/(.*?)(\/.*)/)) {
                        _l.path = tmp[2];
                        url = tmp[1];
                    }

                    // Clean up path.
                    _l.path = (_l.path || '').replace(/^([^\/])/, '/$1').replace(/\/$/, '');

                    // Return path parts.
                    if (arg.match(/^[\-0-9]+$/)) { arg = arg.replace(/^([^\/])/, '/$1'); }
                    if (arg.match(/^\//)) { return _i(arg, _l.path.substring(1)); }

                    // File.
                    tmp = _i('/-1', _l.path.substring(1));

                    if (tmp && (tmp = tmp.match(/(.*?)\.(.*)/))) {
                        _l.file = tmp[0];
                        _l.filename = tmp[1];
                        _l.fileext = tmp[2];
                    }

                    // Port.
                    if (tmp = url.match(/(.*)\:([0-9]+)$/)) {
                        _l.port = tmp[2];
                        url = tmp[1];
                    }

                    // Auth.
                    if (tmp = url.match(/(.*?)@(.*)/)) {
                        _l.auth = tmp[1];
                        url = tmp[2];
                    }

                    // User and pass.
                    if (_l.auth) {
                        tmp = _l.auth.match(/(.*)\:(.*)/);

                        _l.user = tmp ? tmp[1] : _l.auth;
                        _l.pass = tmp ? tmp[2] : undefined;
                    }

                    // Hostname.
                    _l.hostname = url.toLowerCase();

                    // Return hostname parts.
                    if (arg.charAt(0) === '.') { return _i(arg, _l.hostname); }

                    // Domain, tld and sub domain.
                    if (_t()) {
                        tmp = _l.hostname.match(_t());

                        if (tmp) {
                            _l.tld = tmp[3];
                            _l.domain = tmp[2] ? tmp[2] + '.' + tmp[3] : undefined;
                            _l.sub = tmp[1] || undefined;
                        }
                    }

                    // Set port and protocol defaults if not set.
                    _l.port = _l.port || (_l.protocol === 'https' ? '443' : '80');
                    _l.protocol = _l.protocol || (_l.port === '443' ? 'https' : 'http');
                }

                // Return arg.
                if (arg in _l) { return _l[arg]; }

                // Return everything.
                if (arg === '{}') { return _l; }

                // Default to undefined for no match.
                return undefined;
            };
        })();


        $.extend({
            url: function(arg, url) { return window.url(arg, url); }
        });

    }
    $.fn.serializeObject = function () {
        "use strict";

        var result = {};
        var extend = function (i, element) {
            var node = result[element.name];

            // If node with same name exists already, need to convert it to an array as it
            // is a multi-value field (i.e., checkboxes)

            if ('undefined' !== typeof node && node !== null) {
                if ($.isArray(node)) {
                    node.push(element.value);
                } else {
                    result[element.name] = [node, element.value];
                }
            } else {
                result[element.name] = element.value;
            }
        };

        $.each(this.serializeArray(), extend);
        return result;
    };

    var GMS_Embed = {
        sid: null,
        hashPrefix: 'GMS-',
        temp_step: null,
        floating_button_offset: 0,
        hash_params: '',
        scroll_enabled: 1,
        init: function(obj){
            this.sid = obj.sid;
            this.host = obj.host;
            this.date_from = obj.date_from;
            this.date_to = obj.date_to;
            this.arrangement = obj.arrangement;
            this.kat_id = obj.kat_id;
            this.filter_id = obj.filter_id;
            this.rule_id = obj.rule_id;
            this.floating_button_offset = obj.floating_button_offset;
            this.scroll_enabled = obj.scroll_enabled;
            this.$root = $('#GMS_embed_container');
            this.loading();
            this.initBackButton();
            if(obj.type){
                if(this.getStep() == 'search'){
                    this.setStep(obj.type);
                }
            }
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
            var params = 'layout=embed' + this.url_params;
            if(this.sid){
                // no need to send sid when sid is undefined
                params += '&sid=' + this.sid;
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
        extras_callback: function(){
            var _this = this;
            $("#gms_back_to_rooms").click(function(){
                _this.loadRooms();
                return false;
            });
            $('.bookingBtn').click(function(){
                _this.loadCheckout();
                return false;
            });
        },
        rooms_callback: function(){
            var _this = this;
            $('#gms_back_to_search').click(function(){
                _this.loadSearch();
                return false;
            });
            $("#gms_back_to_extras").click(function(){
                _this.loadExtras();
                return false;
            });
            window.isLoadedChangeRoom = false;
        },
        alternativeRooms_callback: function(){
            var _this = this;
            $('#GMS_goto_anfrage').click(function(){
                _this.loadAnfrage();
                return false;
            });
            $('.GMS_alt_date a').click(function () {
                _this._call(this.href);
                return false;
            });
        },
        search_callback: function(){
            var _this = this;
            $('#searchForm').submit(function(){
                try {
                    var data = $(this).serialize();
                    var dataObject = $(this).serializeObject();
                    var url = _this.url(this.action);

                    $.ajax({
                        cache: false,
                        crossDomain: true,
                        url: url,
                        type: this.method,
                        data: data,
                        success: function (resp) {
                            try {
                                _this.pushState(dataObject);
                                _this.processJSON(resp);
                            } catch (e) {
                                alert(e);
                            }
                        },
                        error: function () {
                            alert('ajax error');
                        }
                    });
                    _this.loading();
                }catch(e){
                    alert(e);
                }
                return false;
            });
        },
        pushState: function(dataObject){
            console.log(JSON.stringify(dataObject));
            var url = document.location.href;
            var urlKeys = {
                GMS_date_to: 'search[date_to]',
                GMS_date_from: 'search[date_from]',
                GMS_adults: 'search[adults]'
            }
            for(var key in urlKeys){
                var urlVal = $.url('?' + key);
                if(urlVal){
                    url = url.replace(key + '=' + urlVal, key + '=' + dataObject[urlKeys[key]]);
                }
            }
            if(url != document.location.href) {
                window.history.pushState('searchParams', window.title, url);
            }
        },
        checkout_callback: function(){
            var _this = this;
            $("#gms_back_to_rooms").click(function(){
                _this.loadRooms();
                return false;
            });
            $("#gms_back_to_extras").click(function(){
                _this.loadExtras();
                return false;
            });
            $("#gms_back_to_lastminute").click(function(){
                _this.loadLastminute();
                return false;
            });
            $('#hbFormCheckout').submit(function(){
                var data =$(this).serialize();
                var url = _this.url(this.action);

                $.ajax({
                    url: url,
                    method: this.method,
                    cache: false,
                    crossDomain: true,
                    data: data,
                    success: function(resp){
                        try{
                            //var json = typeof resp == 'object' ? resp : $.parseJSON(resp);
                            //_this.setStep(json.step + '-' + json.booking_id);
                            //_this.process();
                            _this.processJSON(resp);
                        }catch(e){
                            alert(e);
                        }
                    },
                    error: function(){
                        alert('ajax error');
                    }
                });
                _this.loading();
                return false;
            });
        },
        thankyou_callback: function(){

        },
        lastminute_callback: function(){
            var _this = this;
            this.url_params = '';
            $('.GMS_online_booking .bookingBtn').click(function(){
                _this.loading();
                var url = _this.url(this.href);
                $.ajax({
                    method: 'GET',
                    cache: false,
                    crossDomain: true,
                    url: url,
                    success: function(resp){
                        try{
                            _this.processJSON(resp);
                        }catch(e){
                            alert(e);
                        }
                    },
                    error: function(){
                        alert('ajax error');
                    }
                });
                return false;
            });
        },
        inquiry_callback: function(){
            $('#GMS_inquiry form').submit(function(){

                return false;
            });
        },
        anfrage_callback: function(){
            var _this = this;
            $('#changesearch').click(function(){
                _this.loadSearch();
                return false;
            });
            this.checkout_callback();
        },
        loading: function(){
            this.$root.html(("<div style='height: 200px; background: url(%host%img/loading.gif) 50% 50% no-repeat;'></div>").replace('%host%', this.host));
        },
        loadExtras: function(){
            this.loading();
            this.setStep('extras');
            this.process();
        },
        loadSearch: function(){
            this.loading();
            this.setStep('search');
            this.process();
        },
        loadRooms: function(){
            this.loading();
            this.setStep('rooms');
            this.process();
        },
        loadCheckout: function(){
            this.loading();
            this.setStep('checkout');
            this.process();
        },
        loadAnfrage: function(){
            this.loading();
            this.setStep('anfrage');
            this.process();
        },
        loadLastminute: function(){
            this.loading();
            this.setStep('lastminute');
            this.process();
        },
        loadInquiryThank: function () {
            this.loading();
            this.setStep('inquiryThank');
            this.process();
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
    };
    window.GMS_Embed = GMS_Embed;
})(jQuery);
