$(document).ready(function()
{
    $.setAjaxForm('#editForm', function(response) 
    {
        if(response.result == 'fail')
        {
            bootbox.alert(response.warning);
        }
        if(response.result == 'success')
        {
            setTimeout(function()
            {
                location.href = response.locate;  
            }, 3000);
        }
    });

    $.setAjaxLoader('.okFile', '#ajaxModal');

    $('#resetBtn').click(function()
    {
        $('#content').val($('#rawContent').val());
        $('#editForm').submit();
    });

    var extraHeight = $('#mainNavbar').outerHeight() + $('#menu').outerHeight() + $('#mainPanel > .panel-heading').outerHeight() + $('#mainPanel > .panel-footer').outerHeight() + 80 + $('#mainMenu').outerHeight();
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
});
