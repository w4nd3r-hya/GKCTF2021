$(document).ready(function()
{
    if(v.step == 'license') $.setAjaxLoader('.loadInModal', '#ajaxModal');

    $(document).on('click', '.btn-reload', function()
    {
        $.reloadAjaxModal(); 
    })
});
