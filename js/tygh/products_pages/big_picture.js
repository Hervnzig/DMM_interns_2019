(function (_, $) {
    $.ceEvent('on', 'ce.commoninit', function () {
        initSwipesListeners();
    });

    function initSwipesListeners() {
        $.swipesManagers.bigPictureProductPage();
        $.swipesManagers.productPagePreviewers();
    }
})(Tygh, Tygh.$);