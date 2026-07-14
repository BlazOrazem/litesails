let LiteSails = (function () {

    let map;
    let timer;
    let area = $('#js-content').data('area');

    return {
        init: function () {
            LiteSails.initServiceWorker();
            LiteSails.initInstall();
            LiteSails.initTheme();

            if (area == 'wind') {
                LiteSails.initWind();
            }

            if (area == 'weather') {
                LiteSails.initWeather();
            }

            if (area == 'sea') {
                LiteSails.initSea();
            }
        },

        // Register the service worker (required for the install prompt + offline).
        initServiceWorker: function () {
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('/sw.js').catch(function () {});
                });
            }
        },

        // "Add to home screen" banner.
        //  - Android/Chromium: uses the native beforeinstallprompt event.
        //  - iOS Safari: no such API, so we show manual Share instructions.
        initInstall: function () {
            var $banner = $('#js-a2hs');
            if (!$banner.length) {
                return;
            }

            // Already running as an installed app? Never prompt.
            var standalone = (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches) ||
                             window.navigator.standalone === true;
            if (standalone) {
                return;
            }

            // Respect a previous dismissal.
            try {
                if (window.localStorage && localStorage.getItem('a2hs-dismissed') === '1') {
                    return;
                }
            } catch (e) {}

            var $add = $('#js-a2hs-add');
            var isMobile = window.matchMedia && window.matchMedia('(max-width: 991px)').matches;

            $('#js-a2hs-close').on('click', function () {
                $banner.hide();
                try {
                    if (window.localStorage) {
                        localStorage.setItem('a2hs-dismissed', '1');
                    }
                } catch (e) {}
            });

            // Android / Chromium: capture the native prompt and trigger it on click.
            var deferredPrompt = null;
            window.addEventListener('beforeinstallprompt', function (e) {
                e.preventDefault();
                deferredPrompt = e;
                if (isMobile) {
                    $banner.show();
                }
            });

            $add.on('click', function () {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(function () {
                        deferredPrompt = null;
                        $banner.hide();
                    });
                }
            });

            window.addEventListener('appinstalled', function () {
                $banner.hide();
            });

            // iOS Safari: show manual "Share -> Add to Home Screen" instructions.
            var ua = window.navigator.userAgent || '';
            var isIPadOS = navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1;
            var isIOS = /iphone|ipad|ipod/i.test(ua) || isIPadOS;
            var isSafari = /^((?!chrome|android|crios|fxios|edgios).)*safari/i.test(ua);

            if (isIOS && isSafari) {
                $add.on('click', function () {
                    $('#js-ios-install').modal('show');
                });
                $banner.show();
            }
        },

        // Dark/light theme switch. The server already applied the saved theme to
        // <html data-theme> from the `theme` cookie (so no flash); here we just
        // flip it on click and persist the new choice. With no cookie the page
        // follows the OS via CSS @media (prefers-color-scheme).
        initTheme: function () {
            var $toggle = $('#js-theme-toggle');
            if (!$toggle.length) {
                return;
            }

            var root = document.documentElement;

            function systemPrefersDark() {
                return !!(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
            }

            function currentTheme() {
                return root.getAttribute('data-theme') || (systemPrefersDark() ? 'dark' : 'light');
            }

            // Keep the browser/PWA chrome colour in sync with the active theme.
            function setThemeColor(theme) {
                $('meta[name="theme-color"]').remove();
                $('<meta>', { name: 'theme-color', content: theme === 'dark' ? '#16232f' : '#f0f8ff' }).appendTo('head');
            }

            $toggle.on('click', function () {
                var next = currentTheme() === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-theme', next);
                document.cookie = 'theme=' + next + '; path=/; max-age=31536000; SameSite=Lax';
                setThemeColor(next);
            });
        },

        updateWindAreaTitle: function (area) {
            $('#js-area').text(LiteSails.camelize(area.replace('-', ' ')) + ' wind forecast', true);
        },

        initWind: function () {
            LiteSails.map = $('div.tab-content').data('source');
            LiteSails.updateWindAreaTitle(LiteSails.map);

            var $play = $('.animation-play');
            var $stop = $('.animation-stop');
            var $hours = $('.aladin-hour > li');

            if (!$play.length || !$hours.length) {
                return;
            }

            // Ordered forecast hours read from the pagination buttons.
            var hours = [];
            $hours.children('a').each(function () {
                hours.push($(this).data('value'));
            });

            var current = 0;
            var timer = null;

            // Show a forecast hour (wind + gusts) and mark its button active.
            function show(i) {
                current = i;
                LiteSails.displayWindForecastImage(hours[i]);
                $hours.removeClass('active').eq(i).addClass('active');
            }

            function stop() {
                clearInterval(timer);
                timer = null;
                $stop.hide();
                $play.show();
            }

            function play() {
                if (timer) {
                    return;
                }

                $play.hide();
                $stop.show();

                show(current);   // show the current frame straight away

                // Advance one frame per second, looping back to the start.
                timer = setInterval(function () {
                    show((current + 1) % hours.length);
                }, 1000);
            }

            $play.on('click', function (e) { e.preventDefault(); play(); });
            $stop.on('click', function (e) { e.preventDefault(); stop(); });

            // Picking an hour manually stops the animation and jumps to it.
            $hours.children('a').on('click', function (e) {
                e.preventDefault();
                stop();
                show($(this).parent().index());
            });

            // Initial state: only "Play" visible; the wind rose stays until a
            // forecast is shown (on Play, or when an hour is picked).
            $stop.hide();
        },

        displayWindForecastImage: function (hour) {
            var target = LiteSails.map;
            let url = 'https://prognoza.hr/nauticari/';
            let wind = 'uv10_';
            let gusts = 'uvgst_';
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
            var gustsUrl = url + gusts + area + hour + extension;

            $("#js-wind-rose").remove();

            if ($('#js-wind-forecast-image').length === 0) {
                $('#js-wind-forecast-image-frame').prepend('<img src="' + windUrl + '" id="js-wind-forecast-image" class="img-responsive center-block" />');
            } else {
                $("#js-wind-forecast-image").attr("src", windUrl);
            }

            if ($('#js-wind-gusts-image').length === 0) {
                $('#js-wind-gusts-image-frame').prepend('<img src="' + gustsUrl + '" id="js-wind-gusts-image" class="img-responsive center-block" />');
            } else {
                $("#js-wind-gusts-image").attr("src", gustsUrl);
            }
        },

        initWeather: function () {
            var $forecast = $('#js-weather-forecast');
            var $hourly = $('#js-weather-hourly');
            var $source = $('#js-weather-source');

            if (!$forecast.length || !$source.length) {
                return;
            }

            // Clicking "More…" on a day row swaps the 7-day table for that day's
            // hourly forecast, built from the hidden meteo.hr data tables.
            $forecast.on('click', '.js-more-link', function (e) {
                e.preventDefault();

                var $row = $(this).closest('tr[data-col]');
                var day = $row.attr('data-col');

                var cells = function (id) {
                    return $source.find('#' + id + ' tr[data-row="' + day + '"] td');
                };

                var $sat = cells('tabl_sat');
                var $simb = cells('tabl_simb');
                var $temp = cells('tabl_temp');
                var $vjet = cells('tabl_vjet');
                var $obor = cells('tabl_obor');
                var $prob = cells('tabl_prob');

                if (!$sat.length) {
                    return;
                }

                var html = function (list, i) {
                    return list[i] ? $(list[i]).html() : '';
                };

                var rows = '';

                for (var i = 0; i < $sat.length; i++) {
                    var hour = $.trim($($sat[i]).text());

                    // meteo.hr pads rows with empty cells to keep the columns
                    // aligned; the hour column is empty for those, so skip them.
                    if (!hour) {
                        continue;
                    }

                    rows += '<tr>' +
                        '<td>' + hour + ':00</td>' +
                        '<td>' + html($simb, i) + '</td>' +
                        '<td>' + html($temp, i) + '</td>' +
                        '<td>' + html($vjet, i) + '</td>' +
                        '<td>' + html($obor, i) + '</td>' +
                        '<td>' + html($prob, i) + '</td>' +
                        '</tr>';
                }

                var table = '<thead><tr>' +
                    '<th>Hour</th><th>Sky</th><th>Temp.</th><th>Wind</th><th>Precip.</th><th>Prob.</th>' +
                    '</tr></thead><tbody>' + rows + '</tbody>';

                $('#js-hourly-table').html(table);
                $('#js-hourly-title').html($row.find('th').first().html());

                $forecast.hide();
                $hourly.show();
            });

            $hourly.on('click', '.js-back', function (e) {
                e.preventDefault();

                $hourly.hide();
                $forecast.show();
            });
        },

        initSea: function () {
            var $play = $('#waves a.animation-play');
            var $stop = $('#waves a.animation-stop');
            var $days = $('.aladin-hour > li');
            var $frame = $('#js-sea-forecast-frame');
            var url = 'https://prognoza.hr/valovi/val_w.';

            if (!$play.length || !$days.length) {
                return;
            }

            // Ordered image-set per day, read from the pagination buttons.
            var days = [];
            $days.children('a').each(function () {
                days.push($(this).data('value'));
            });

            var current = 0;
            var timer = null;

            // Show a day's wave map and mark its pagination button active.
            function show(dayIndex) {
                current = dayIndex;
                var seaUrl = url + days[dayIndex][0] + '.png';

                if ($('#js-sea-forecast-image').length === 0) {
                    $frame.prepend('<img src="' + seaUrl + '" id="js-sea-forecast-image" class="img-responsive center-block" />');
                } else {
                    $('#js-sea-forecast-image').attr('src', seaUrl);
                }

                $days.removeClass('active').eq(dayIndex).addClass('active');
            }

            function stop() {
                clearInterval(timer);
                timer = null;
                $stop.hide();
                $play.show();
            }

            function play() {
                if (timer) {
                    return;
                }

                $play.hide();
                $stop.show();

                // Advance one day per second, looping back to the first day.
                timer = setInterval(function () {
                    show((current + 1) % days.length);
                }, 1000);
            }

            $play.on('click', function (e) { e.preventDefault(); play(); });
            $stop.on('click', function (e) { e.preventDefault(); stop(); });

            // Picking a day manually stops the animation and jumps to it.
            $days.children('a').on('click', function (e) {
                e.preventDefault();
                stop();
                show($(this).parent().index());
            });

            // Switching tabs stops the animation.
            $('.nav-tabs > li > a').on('click', stop);

            // Initial state: only "Play" visible, first day shown.
            $stop.hide();
            show(0);
        },

        camelize: function(str) {
            return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(word, index) {
                return word.toUpperCase();
            }).replace(/\s+/g, ' ');
        }
    };

})();

LiteSails.init();
