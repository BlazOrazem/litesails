var LiteSails = (function () {

    var map;
    var gst;

    return {
        init: function () {
            if ($('div.tab-content').length) {
                LiteSails.map = $('div.tab-content').attr('data-source');
                LiteSails.forecast();
                LiteSails.updateArea(LiteSails.ucfirst(LiteSails.map));
                LiteSails.initMainMenu();
                LiteSails.initAnimation();
            }
        },

        initMainMenu: function () {
            $('.aladin-map').on('click', function(e) {
                e.preventDefault();

                LiteSails.map = $(this).data('map');
                LiteSails.updateArea(LiteSails.ucfirst(LiteSails.map));

                $('div.tab-content').attr('data-source', LiteSails.map).load(function() {
                    LiteSails.forecast();
                });
                $('.aladin-hour > li.active > a').trigger('click');
            });
        },

        initAnimation: function () {
            $('li.animation').on('click', function(e) {
                var hourSet = ['03','06','09','12','15','18','21','24','27','30','33','36','39','42','45','48','51','54','57','60','63','66','69','72'];
                setTimeout(function loop() {
                    LiteSails.showImage(hourSet.shift());
                    if (hourSet.length)
                        LiteSails.timer = setTimeout(loop, 1000);
                }, 1000);
            });
            $('.stop-animation, .nav-tabs > li').on('click', function(e) {
                e.preventDefault();
                clearTimeout(LiteSails.timer);
            });
        },

        forecast: function () {
            $('.aladin-hour > li > a').on('click', function(e) {
                e.preventDefault();
                LiteSails.activate($(this));
                LiteSails.showImage($(this).data('value'));
            });
        },

        showImage: function (hour) {
            var target = LiteSails.map;

            if (target == 'kvarner') {
                var url_start = 'http://prognoza.hr/aladinHR/web_uv10_SENJ_';
            }
            if (target == 'zadar') {
                var url_start = 'http://prognoza.hr/aladinHR/web_uv10_MASL_';
            }
            if (target == 'split') {
                var url_start = 'http://prognoza.hr/aladinHR/web_uv10_SPLI_';
            }
            if (target == 'dubrovnik') {
                var url_start = 'http://prognoza.hr/aladinHR/web_uv10_DUBR_';
            }
            var url_end = '.gif';

            var image_url = url_start + hour + url_end;

            $("#aladin-image").attr("src",image_url);
        },

        activate: function (el) {
            $('.aladin-hour > li').removeClass('active');
            el.parent().addClass('active');
        },

        updateArea: function (areaName) {
            $('span.area').text(areaName);
        },

        initWeather: function () {
            if (!$('.weather').length) {
                return;
            }
            $('.weather li.panel > ol > li > a').on('click', function(e) {
                e.preventDefault();
                var iframeUrl = $(this).attr('href');
                $('iframe#weather').attr('src', iframeUrl);
            });
        },

        ucfirst: function(str, force) {
            str = force ? str.toLowerCase() : str;
            return str.replace(/(\b)([a-zA-Z])/,
                function(firstLetter){
                    return firstLetter.toUpperCase();
                }
            );
        }
    };

})();
LiteSails.init();
LiteSails.initWeather();