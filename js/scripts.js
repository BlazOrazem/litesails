let LiteSails = (function () {

    let map;
    let timer;
    let area = $('#js-content').data('area');

    return {
        init: function () {
            if (area == 'wind') {
                LiteSails.map = $('div.tab-content').data('source');
                LiteSails.updateWindAreaTitle(LiteSails.map);
                LiteSails.initWindAnimation();
                LiteSails.initWindForecast();
            }

            if (area == 'weather') {
                LiteSails.initWeather();
            }

            if (area == 'sea') {
                LiteSails.initSeaAnimation();
                LiteSails.initSeaForecast();
            }
        },

        updateWindAreaTitle: function (area) {
            $('#js-area').text(LiteSails.camelize(area.replace('-', ' ')) + ' wind forecast', true);
        },

        initWindAnimation: function () {
            $('a.animation-play, li.animation').on('click', function (e) {
                let hourSet = ['03', '06', '09', '12', '15', '18', '21', '24', '27', '30', '33', '36', '39', '42', '45', '48', '51', '54', '57', '60', '63', '66', '69', '72'];

                setTimeout(function loop() {
                    if (hourSet.length == 0) {
                        hourSet = ['03', '06', '09', '12', '15', '18', '21', '24', '27', '30', '33', '36', '39', '42', '45', '48', '51', '54', '57', '60', '63', '66', '69', '72'];
                    }

                    LiteSails.displayWindForecastImage(hourSet.shift());
                    LiteSails.timer = setTimeout(loop, 1000);
                }, 500);
            });

            $('a.animation-stop, .nav-tabs > li > a').on('click', function (e) {
                e.preventDefault();

                clearTimeout(LiteSails.timer);
            });
        },

        initWindForecast: function () {
            $('.aladin-hour > li > a').on('click', function (e) {
                e.preventDefault();

                LiteSails.activatePaging($(this));
                LiteSails.displayWindForecastImage($(this).data('value'));
            });
        },

        displayWindForecastImage: function (hour) {
            var target = LiteSails.map;
            let url = 'https://prognoza.hr/nauticari/';
            let wind = 'uv10_';
            let blow = 'uvgst_';
            var area = 'jadran_';
            let extension = '.png';

            if (target == 'north-adriatic') {
                var area = 'sj_jadran_';
            } else if (target == 'middle-adriatic') {
                var area = 'sr_jadran_';
            } else if (target == 'south-adriatic') {
                var area = 'ju_jadran_';
            }

            var windUrl = url + wind + area + hour + extension;
            var blowUrl = url + blow + area + hour + extension;

            $("#js-wind-rose").remove();

            if ($('#js-wind-forecast-image').length === 0) {
                $('#js-wind-forecast-image-frame').prepend('<img src="' + windUrl + '" id="js-wind-forecast-image" class="img-responsive center-block" />');
            } else {
                $("#js-wind-forecast-image").attr("src", windUrl);
            }

            if ($('#js-blow-forecast-image').length === 0) {
                $('#js-blow-forecast-image-frame').prepend('<img src="' + blowUrl + '" id="js-blow-forecast-image" class="img-responsive center-block" />');
            } else {
                $("#js-blow-forecast-image").attr("src", blowUrl);
            }
        },

        initWeather: function () {
            $('.weather li.panel > ol > li > a').on('click', function (e) {
                e.preventDefault();

                var iframeUrl = $(this).attr('href');
                $('iframe#weather').attr('src', iframeUrl);
            });
        },

        initSeaForecast: function () {
            $('.aladin-hour > li > a').on('click', function (e) {
                e.preventDefault();
                console.log('initSeaForecast');

                LiteSails.activatePaging($(this));
                LiteSails.displaySeaForecastImage($(this).data('value'));
            });
        },

        displaySeaForecastImage: function (hours) {
            let url = 'https://prognoza.hr/valovi/val_w_';
            let extension = '.png';

            let seaUrl = url + hours[0] + extension;

            if ($('#js-sea-forecast-image').length === 0) {
                $('#js-sea-forecast-frame').prepend('<img src="' + seaUrl + '" id="js-sea-forecast-image" class="img-responsive center-block" />');
            } else {
                $("#js-sea-forecast-image").attr("src", seaUrl);
            }

            $('#waves a.animation-play').data('hours', hours);
        },

        initSeaAnimation: function () {
            $('a.animation-play').on('click', function (e) {
                e.preventDefault();

                let hourSet = $(this).data('hours');

                (function recurse(counter) {
                    let hour = hourSet[counter];

                    LiteSails.displaySeaForecastImage([hour]);

                    delete hourSet[counter];

                    hourSet.push(hour);

                    LiteSails.timer = setTimeout(function() {
                        recurse(counter + 1);
                    }, 500);
                })(0);
            });

            $('a.animation-stop').on('click', function (e) {
                e.preventDefault();

                clearTimeout(LiteSails.timer);
            });
        },

        activatePaging: function (el) {
            $('.aladin-hour > li').removeClass('active');
            el.parent().addClass('active');
        },

        camelize: function(str) {
            return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(word, index) {
                return word.toUpperCase();
            }).replace(/\s+/g, ' ');
        }
    };

})();

LiteSails.init();
