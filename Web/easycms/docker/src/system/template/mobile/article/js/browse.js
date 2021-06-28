$(function() {
    var articleOrderBy = 'articleOrderBy[' + v.categoryID + ']';
    var init = function () {
        switch (Cookies.get(articleOrderBy)) {
            case 'addedDate_asc':
                $('.order-time .up-triangle').addClass('active');
                break;
            case 'addedDate_desc':
                $('.order-time .down-triangle').addClass('active');
                break;
            case 'views_asc':
                $('.order-hot .up-triangle').addClass('active');
                break;
            case 'views_desc':
                $('.order-hot .down-triangle').addClass('active');
                break;
            default:
                $('.order-time .up-triangle').addClass('active');
                break;
        }
    };
    init();

    $('.order-time').on('click', function () {
        $('.order-time .up-triangle .down-triangle').removeClass('active');
        $('.order-hot .up-triangle .down-triangle').removeClass('active');
        if (Cookies.get(articleOrderBy) === 'addedDate_desc' || Cookies.get(articleOrderBy) === '') {
            Cookies.set(articleOrderBy, 'addedDate_asc');
        } else {
            Cookies.set(articleOrderBy, 'addedDate_desc');
        }
        window.location.reload();
    });

    $('.order-hot').on('click', function () {
        $('.order-time .up-triangle .down-triangle').removeClass('active');
        $('.order-hot .up-triangle .down-triangle').removeClass('active');
        if (Cookies.get(articleOrderBy) === 'views_desc') {
            Cookies.set(articleOrderBy, 'views_asc');
        } else {
            Cookies.set(articleOrderBy, 'views_desc');
        }
        window.location.reload();
    });
});