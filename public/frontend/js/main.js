$(document).ready(function () {

    /* float label checking input is not empty */
    $('.float-label .form-control').on('blur', function () {
        if ($(this).val() || $(this).val().length != 0) {
            $(this).closest('.float-label').addClass('active');
        } else {
            $(this).closest('.float-label').removeClass('active');
        }
    });

    /* menu open close wrapper screen click close menu */
    $('.menu-btn').on('click', function (e) {
        e.stopPropagation();
        if ($('body').hasClass('sidemenu-open') == true) {
            $('body, html').removeClass('sidemenu-open menuactive');
        } else {
            $('body, html').addClass('sidemenu-open menuactive');
        }
    });
    $('.wrapper').on('click', function () {

        if ($('body').hasClass('sidemenu-open') == true) {

            $('body, html').removeClass('sidemenu-open menuactive');
            //alert('teste');
        }
    });

    /* filter click open filter */
    if ($('body').hasClass('filtermenu-open') == true) {
        $('.filter-btn').find('i').html('close');
    }
    $('.filter-btn').on('click', function () {
        if ($('body').hasClass('filtermenu-open') == true) {
            $('body').removeClass('filtermenu-open');
            $(this).find('i').html('filter_list')

        } else {
            $('body').addClass('filtermenu-open');
            $(this).find('i').html('close')
        }
    });


    /* background image to cover */
    $('.background').each(function () {
        var imagewrap = $(this);
        var imagecurrent = $(this).find('img').attr('src');
        imagewrap.css('background-image', 'url("' + imagecurrent + '")');
        $(this).find('img').remove();
    });


    /* theme color cookie */
    if ($.type($.cookie("theme-color")) != 'undefined' && $.cookie("theme-color") != '') {
        $('html').removeClass('grey-theme');
        $('html').addClass($.cookie("theme-color"));
    }

    $('.theme-color .btn').on('click', function () {
        $('html').removeClass('grey-theme');
        $('html').removeClass($.cookie("theme-color"));
        var themecolor = $(this).attr('data-theme');
        $.cookie("theme-color", themecolor, {
            expires: 1
        });
        $('html').addClass($.cookie("theme-color"));

    });

    /* theme layout cookie */    
    if ($.type($.cookie("theme-color-layout")) !== 'dark-layout' && $.cookie("theme-color-layout") !== 'dark-layout') {
        $('#theme-dark').prop('checked', false);
        $('html').addClass($.cookie("theme-color-layout"));
        $('html').removeClass('dark-layout');
    } else {
        $('#theme-dark').prop('checked', true);
        $('html').addClass($.cookie("theme-color-layout"));
    }
    $('#theme-dark').on('change', function () {
        if ($(this).is(':checked') === true) {
            $('html').removeClass('light-layout');
            $('html').removeClass($.cookie("theme-color-layout"));
            $.cookie("theme-color-layout", 'dark-layout', {
                expires: 1
            });
            $('html').addClass($.cookie("theme-color-layout"));
        } else {
            $('html').removeClass('dark-layout');
            $('html').removeClass($.cookie("theme-color-layout"));
            $.cookie("theme-color-layout", 'light-layout', {
                expires: 1
            });
            $('html').addClass($.cookie("theme-color-layout"));
        }


    });

});


$(window).on('load', function () {
    $('.loader-screen').fadeOut('slow');
});

$("a[href^='#']").click(function( event ) {
    $('#sidebar').hide();
});

$('.sidebarCollapse').on('click', function () {
    if($("#sidebar").css("display") == "none") {
        $('#sidebar').attr('style',  'display:block');
    } else {
        $('#sidebar').hide();
    }
});

(function(document, history, location) {
    var HISTORY_SUPPORT = !!(history && history.pushState);

    var anchorScrolls = {
        ANCHOR_REGEX: /^#[^ ]+$/,
        OFFSET_HEIGHT_PX: 54,

        /**
         * Establish events, and fix initial scroll position if a hash is provided.
         */
        init: function() {
            this.scrollToCurrent();
            $(window).on('hashchange', $.proxy(this, 'scrollToCurrent'));
            $('body').on('click', 'a', $.proxy(this, 'delegateAnchors'));
        },

        /**
         * Return the offset amount to deduct from the normal scroll position.
         * Modify as appropriate to allow for dynamic calculations
         */
        getFixedOffset: function() {
            return this.OFFSET_HEIGHT_PX;
        },

        /**
         * If the provided href is an anchor which resolves to an element on the
         * page, scroll to it.
         * @param  {String} href
         * @return {Boolean} - Was the href an anchor.
         */
        scrollIfAnchor: function(href, pushToHistory) {
            var match, anchorOffset;

            if(!this.ANCHOR_REGEX.test(href)) {
                return false;
            }

            match = document.getElementById(href.slice(1));

            if(match) {
                anchorOffset = $(match).offset().top - this.getFixedOffset();
                $('html, body').animate({ scrollTop: anchorOffset});
                setTimeout(function() {
                    $(match).fadeOut('fsat', function() {
                        $(this).fadeIn('fast', function() {
                            //
                        });
                    });
                }, 1);


                // Add the state to history as-per normal anchor links
                if(HISTORY_SUPPORT && pushToHistory) {
                    history.pushState({}, document.title, location.pathname + href);
                }
            }

            return !!match;
        },

        /**
         * Attempt to scroll to the current location's hash.
         */
        scrollToCurrent: function(e) {
            if(this.scrollIfAnchor(window.location.hash) && e) {
                e.preventDefault();
            }
        },

        /**
         * If the click event's target was an anchor, fix the scroll position.
         */
        delegateAnchors: function(e) {
            var elem = e.target;

            if(this.scrollIfAnchor(elem.getAttribute('href'), true)) {
                e.preventDefault();
            }
        }
    };

    $(document).ready($.proxy(anchorScrolls, 'init'));
})(window.document, window.history, window.location);

