(function (_, $) {
    var defaultOpts = {
        preventDefault: {
            drag: false,
            swipe: false,
            tap: false
        },

        trackDocument: true,
        trackDocumentNormalize: true,

        useTouch: true,
        useMouse: true
    };


    $.swipesManagers = {
        
        
        defaultProductPage: function () {
            $('.ty-product-block__img-wrapper').touch(defaultOpts);

            $('.ty-product-block__img-wrapper').on('swipeLeft', function () {
                processProductImage('left');
            });

            $('.ty-product-block__img-wrapper').on('swipeRight', function () {
                processProductImage('right');
            });
        },


        bigPictureProductPage: function () {
            $('.ty-product-bigpicture__img').touch(defaultOpts);

            $('.ty-product-bigpicture__img').on('swipeLeft', function () {
                processProductImage('left');
            });

            $('.ty-product-bigpicture__img').on('swipeRight', function () {
                processProductImage('right');
            });
        },


        productPagePreviewers: function () {


            // Bind listening FancyBox
            $.ceEvent('on', 'ce.image-previewers.fancybox.initend', function () {
                $('#fancybox-wrap')
                    .touch(defaultOpts)
                    .on('swipeLeft', function () {
                        processFancyBox('left');
                    })
                    .on('swipeRight', function () {
                        processFancyBox('right');
                    });
            });


            // Bind listening LightBox
            $.ceEvent('on', 'ce.image-previewers.lightbox.initend', function () {
                $('#jquery-lightbox')
                    .touch(defaultOpts)
                    .on('swipeLeft', function () {
                        processLightBox('left');
                    })
                    .on('swipeRight', function () {
                        processLightBox('right');
                    });
            });


            // Bind listening MagnificPopup
            $.ceEvent('on', 'ce.image-previewers.magnificpopup.initend', function () {
                $('.mfp-content')
                    .touch(defaultOpts)
                    .on('swipeLeft', function () {
                        processMagnificPopup('left');
                    })
                    .on('swipeRight', function () {
                        processMagnificPopup('right');
                    });
            });

            // Bind listetning PrettyPhoto
            $.ceEvent('on', 'ce.image-previewers.prettyphoto.initend', function () {
                $('.pp_default')
                    .touch(defaultOpts)
                    .on('swipeLeft', function () {
                        $.prettyPhoto.changePage('next');
                    })
                    .on('swipeRight', function () {
                        $.prettyPhoto.changePage('previous');
                    });
            });

        }
    };
    
    function processMagnificPopup (direction) {
        if (direction == 'left') {
            $('.mfp-arrow-right').click();
        }

        if (direction == 'right') {
            $('.mfp-arrow-left').click();
        }
    }

    function processLightBox (direction) {
        if (direction == 'left') {
            $('#lightbox-nav-btnNext').click();
        }

        if (direction == 'right') {
            $('#lightbox-nav-btnPrev').click();
        }
    }

    function processFancyBox (direction) {
        if (direction == 'left') {
            $('#fancybox-right').click();
        }

        if (direction == 'right') {
            $('#fancybox-left').click();
        }
    }

    function processProductImage (direction) {
        var currentItem = $('.cm-thumbnails-mini.active'),
            itemsCount = currentItem.parent().children().length;

        if ( (currentItem.index() == 0) && (direction == 'right') ) {
            _click(currentItem.siblings().last());
            return;
        }

        if ( (currentItem.index() == 0) && (direction == 'left') ) {
            _click(currentItem.next());
            return;
        }

        if ( (currentItem.index() + 1 == itemsCount) && (direction == 'left') ) {
            _click(currentItem.siblings().first());
            return;
        }

        if ( (currentItem.index() + 1 == itemsCount) && (direction == 'right') ) {
            _click(currentItem.prev());
            return;
        }

        if ( (currentItem.index() != 0) && (currentItem.index() + 1 != itemsCount) ) {
            if (direction == 'right') {
                _click(currentItem.prev());
                return;
            }

            if (direction == 'left') {
                _click(currentItem.next());
                return;
            }
        }
    }

    function _click (elm) {
        $(elm).find('img').click(0);
    }
})(Tygh, Tygh.$);