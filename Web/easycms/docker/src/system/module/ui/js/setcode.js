$(document).ready(function()
{
    $('[href=#cssTab]').click();
    $('.leftmenu li.active').removeClass('active');
    $('.leftmenu [href*=' + v.page + ']').parent().addClass('active');

    var extraHeight = $('#mainNavbar').outerHeight() + $('#menu').outerHeight() + $('#mainPanel > .panel-heading').outerHeight() + $('#mainPanel > .panel-footer').outerHeight() + 80;;
    var resizeEditors = function()
    {
        $('.codeeditor').each(function()
        {
            var options = $(this).data();
            var height = Math.max(100, $(window).height() - extraHeight);
            $('#' + options.editorId).height(height);
            options.editor.resize();
            console.log(options, height);
        });
    };

    $(window).on('resize', resizeEditors);
    resizeEditors();
})
