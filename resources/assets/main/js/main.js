$(function () {

    // Ensure primary nav is active even if the page starts already scrolled
    (function ensurePrimaryNavActiveIfPageStartsScrolled() {

        if ($('.js-navbar-booking').data('fade-nav') == true &&

            $(window).scrollTop() > 0) {

            $('.js-navbar-booking').addClass('scrolled');

        }

    })();


    //Match height
    $('.js-match-height').matchHeight();


    //Slick slider vacancy
    $('.slick-slider--vacancy').on('init afterChange', function (event, slick, currentSlide) {

        $('.js-match-height').matchHeight();

    });


    $('.slick-slider--vacancy').slick({

        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: false,
        responsive: [
            {
                breakpoint: 915,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false
                }
            }
        ]

    });


    //Slick slider story
    $('.slick-slider--story').slick({

        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true

    });


    //Fade nav background on scroll
    $(window).bind('scroll', function () {

        // add this effect only if fade-nav is on the navbar
        if ($('.js-navbar-booking').data('fade-nav') != true) {
            return;
        }

        var distance = 20;

        if ($(window).scrollTop() > distance) {
            $('.js-navbar-booking').addClass('scrolled');
        }
        else {
            $('.js-navbar-booking').removeClass('scrolled');
        }
    });


    //Mega menu display on hover
    $('.navbar-booking-fw').hover(function () {

        $(this).find('.dropdown-menu').stop(true, true).fadeIn(300);

        $('.navbar-booking__secondary--white').addClass('l-index');

    }, function () {

        $(this).find('.dropdown-menu').stop(true, true).fadeOut(300);

    });


    //Clipboard copied message
    $('button').tooltip({

        trigger: 'click',
        placement: 'bottom'

    });


    function setTooltip(btn, message) {

        $(btn).tooltip('hide')

            .attr('data-original-title', message)
            .tooltip('show');

    }


    function hideTooltip(btn) {

        setTimeout(function () {

            $(btn).tooltip('hide');

        }, 2000);

    }


    // Clipboard
    var clipboard = new Clipboard('button');

    clipboard.on('success', function (e) {

        setTooltip(e.trigger, 'Copied!');
        hideTooltip(e.trigger);

    });


    clipboard.on('error', function (e) {

        setTooltip(e.trigger, 'Failed!');
        hideTooltip(e.trigger);

    });


    // Mobile Menu
    var overlayNav = $('.nav--mobile-overlay'),
        overlayContent = $('.nav--mobile-content'),
        navigation = $('.nav--mobile'),
        toggleNav = $('.nav--mobile-trigger');


    //Initialize navigation and content layers
    layerInit();

    $(window).on('resize', function () {

        window.requestAnimationFrame(layerInit);

    });


    //Open and close the menu and cover layers
    toggleNav.on('click', function () {

        if (!toggleNav.hasClass('close-nav')) {


            //Navigation is not visible yet - open and animate navigation layer
            toggleNav.addClass('close-nav');

            overlayNav.children('span').velocity({

                translateZ: 0,
                scaleX: 1,
                scaleY: 1,

            }, 500, 'easeInCubic', function () {

                navigation.addClass('fade-in');

            });


        } else {


            //Navigation is open - close it and remove navigation layer
            toggleNav.removeClass('close-nav');

            overlayContent.children('span').velocity({

                translateZ: 0,
                scaleX: 1,
                scaleY: 1,

            }, 500, 'easeInCubic', function () {

                navigation.removeClass('fade-in');

                overlayNav.children('span').velocity({

                    translateZ: 0,
                    scaleX: 0,
                    scaleY: 0,

                }, 0);


                overlayContent.addClass('is-hidden').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {

                    overlayContent.children('span').velocity({

                        translateZ: 0,
                        scaleX: 0,
                        scaleY: 0,

                    }, 0, function () {
                        overlayContent.removeClass('is-hidden')
                    });

                });


                if ($('html').hasClass('no-csstransitions')) {

                    overlayContent.children('span').velocity({

                        translateZ: 0,
                        scaleX: 0,
                        scaleY: 0,

                    }, 0, function () {
                        overlayContent.removeClass('is-hidden')
                    });

                }

            });

        }

    });


    function layerInit() {

        var diameterValue = (Math.sqrt(Math.pow($(window).height(), 2) + Math.pow($(window).width(), 2)) * 2);

        overlayNav.children('span').velocity({

            scaleX: 0,
            scaleY: 0,
            translateZ: 0,

        }, 50).velocity({

            height: diameterValue + 'px',
            width: diameterValue + 'px',
            top: -(diameterValue / 2) + 'px',
            left: -(diameterValue / 2) + 'px',

        }, 0);

        overlayContent.children('span').velocity({

            scaleX: 0,
            scaleY: 0,
            translateZ: 0,

        }, 50).velocity({

            height: diameterValue + 'px',
            width: diameterValue + 'px',
            top: -(diameterValue / 2) + 'px',
            left: -(diameterValue / 2) + 'px',

        }, 0);
    }


    //Toggle hamburger icon
    var $hamburger = $(".hamburger");

    $hamburger.on("click", function () {

        $hamburger.toggleClass("is-active");

    });


    // Update
    (function () {
        var $toggle = $(".js-collapse-toggle");
        var searchOptionsContainerRef = $toggle.attr('href');

        if (searchOptionsContainerRef) {
            var $searchOptionsContainer = $(searchOptionsContainerRef);

            $searchOptionsContainer.on('show.bs.collapse', function() {
                var label = $toggle.data('hide-label');
                if (label) {
                    $toggle.text(label);
                }
                $toggle.addClass('active');
            });

            $searchOptionsContainer.on('hide.bs.collapse', function() {
                var label = $toggle.data('show-label');
                if (label) {
                    $toggle.text(label);
                }
                $toggle.removeClass('active');
            });
        }
    })();


    //Read more button
    var $readMore = $(".js-read-more");
    var $lineBreak = $(".js-list-inline--read-more");
    var $readLess = $(".js-read-less");
    var $collapseMore = $(".js-collapse-toggle--xsm");
    var $collapseLess = $(".js-collapse-toggle--xsl");
    var $hideNotification = $(".js-close--jobs");
    var $removeJobsMargin = $(".row-intro-jobs");


    //Hide read more button when clicked
    $collapseMore.on("click", function () {

        $collapseMore.hide();

    });


    //Hide read more button when clicked
    $collapseLess.on("click", function () {

        $collapseMore.show();

    });


    //Hide read more button when clicked
    $readMore.on("click", function () {

        $readMore.hide();
        $lineBreak.hide();

    });


    //Show read more button when clicked
    $readLess.on("click", function () {

        $readMore.show();
        $lineBreak.show();

    });


    //Remove large margin when jobs alert is closed for mobile
    $hideNotification.on("click", function () {

      $removeJobsMargin.addClass('u-mt-50');

    });


    $("#btnShow").on('click', function () {
        $("#ulList").empty();
        var fp = $("#fUpload");
        var lg = fp[0].files.length; // get length
        var items = fp[0].files;
        var fragment = "";

        if (lg > 0) {
            for (var i = 0; i < lg; i++) {
                var fileName = items[i].name; // get file name
                var fileSize = items[i].size; // get file size
                var fileType = items[i].type; // get file type

                // append li to UL tag to display File info
                fragment += "<li>" + fileName + " (<b>" + fileSize + "</b> bytes) - Type :" + fileType + "</li>";
            }

            $("#ulList").append(fragment);
        }
    });


    /**
     * Load More
     * -------------------------
     */
    (function() {

        $('.js-loadmore-btn').each(function() {
            var $btn = $(this);
            //var $wrap = $btn.closest('.js-loadmore-wrap');
            var $container = $('.jobs-container');
            var $loader = $('.js-loadmore-loading');
            var $form = $('.js-loadmore-form');
            var $pager = $('#page');
            var loading = false;
            var hasMore = true;

            $(this).on('click', function(e) {

                e.preventDefault();

                // don't make a request when a request is already in progress or there is no more data
                //if (loading == true && hasMore == false) return;

                $.ajax({
                    type: 'POST',
                    url: '/jobs/loadmore',
                    dataType: 'JSON',
                    beforeSend: function(xhr) {
                        loading = true;
                        $btn.addClass('is-hidden');
                        $loader.removeClass('is-hidden');
                    },
                    data: $form.serialize(),
                    success: function(data) {
                        //console.log(data);
                        if (data.content !== '') {
                            // append the new html to the content placeholder
                            $loader.append(data.content);
                            // update the page number
                            $pager.val(data.page);
                        }
                        if (data.noMore === true) {
                            // when no data was returned, hide the loading icon
                            hasMore = false;
                            $btn.addClass('is-hidden');
                        }
                        else {
                            $btn.removeClass('is-hidden');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // console.log(errorThrown);
                    },
                    complete: function() {
                        loading = false;
                        $loader.addClass('is-hidden');
                    }
                });

            });
        });

    })();

    var $document = $(document),
        $element = $('.js-vacancy-fixed'),
        className = 'js-is-fixed';

    $document.scroll(function() {
      $element.toggleClass(className, $document.scrollTop() >= 700);
    });



    /**
     * Link tracking
     * -------------------------
     */
    (function() {
        $('.u-p-search-button').on('click', function(e) {
            // send vitual page view for application link clicks
            // we can make a goal funnel based on this later
            ga('send', 'event', 'Search jobs','Search');
        });
        $('.btn-applynow').on('click', function(e) {
            // send vitual page view for application link clicks
            // we can make a goal funnel based on this later
            ga('send', 'event', 'Apply job','Apply');
        });
        $('.btn-apply-next').on('click', function(e) {
            // send vitual page view for application link clicks
            // we can make a goal funnel based on this later
            ga('send', 'event', 'Apply to next step','Next');
        });
        $('.btn-apply-submit').on('click', function(e) {
            // send vitual page view for application link clicks
            // we can make a goal funnel based on this later:
            ga('send', 'event', 'Apply submit to DB&GH','Submit');
        });
    })();


});
