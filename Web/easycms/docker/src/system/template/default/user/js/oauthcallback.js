$(document).ready(function()
{
    var panelHeight = 0;
    $('.row > .col-md-6').each(function(){ panelHeight = Math.max($(this).find('.panel-body').outerHeight(), panelHeight);});
    $('.row > .col-md-6 > .panel > .panel-body').height(panelHeight);

    $.setAjaxForm('#registerForm');
    $.setAjaxForm('#bindForm');
});
