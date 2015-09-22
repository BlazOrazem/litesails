var LiteSails = (function () {

    var map;

    return {
        init: function () {
            LiteSails.map = 'kvarner';
            LiteSails.forecast();
            LiteSails.updateArea(LiteSails.ucfirst(LiteSails.map));
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

        forecast: function () {
            $('.aladin-hour > li > a').on('click', function(e) {
                e.preventDefault();
                LiteSails.activate($(this));
                LiteSails.showImage($(this));
            });
        },

        showImage: function (el) {
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
            var url_value = el.data('value');
            var url_end = '.gif';

            var image_url = url_start + url_value + url_end;

            $("#aladin-image").attr("src",image_url);
        },

        activate: function (el) {
            $('.aladin-hour > li').removeClass('active');
            el.parent().addClass('active');
        },

        updateArea: function (areaName) {
            $('span.area').text(areaName);
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
LiteSails.initMainMenu();