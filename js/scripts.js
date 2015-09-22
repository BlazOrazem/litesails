var LiteSails = (function () {

    return {
        init: function () {
            LiteSails.forecast();
            //$( "#content" ).load( "kvarner.html", function() {
            //    LiteSails.forecast();
            //});

            //$('.map-area').on('click', function(e) {
            //    e.preventDefault();
            //    $( "#content" ).load( $(this).data('source'), function() {
            //        LiteSails.forecast();
            //    });
            //});
        },

        initMainMenu: function () {
            $('.aladin-map').on('click', function(e) {
                e.preventDefault();

                var source = $(this).data('source');

                //$('div.tab-content').attr('data-source', source);

                $('div.tab-content').attr('data-source', source).load(function() {
                    LiteSails.forecast();
                });



                //$( "#content" ).load( $(this).data('source'), function() {
                //    LiteSails.forecast();
                //});
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
            //var target = el.parent().parent().data('source');
            var target = el.closest('.tab-content').data('source');
            alert(target);

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
        }
    };

})();
LiteSails.init();
LiteSails.initMainMenu();