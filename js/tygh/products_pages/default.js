(function (_, $) {
    $.ceEvent('on', 'ce.commoninit', function () {
        initSwipesListeners();
    });

    function initSwipesListeners() {
        $.swipesManagers.defaultProductPage();
        $.swipesManagers.productPagePreviewers();
    }
})(Tygh, Tygh.$);