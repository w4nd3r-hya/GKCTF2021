$(function()
{
    fixLeftMenu();
    fixPositionbar();
    initPrimaryNavbar();
    $('#primaryNavbar a').click(function()
    {
        group = $(this).parent('li').data('id');
        $.cookie('currentGroup', group, {expires:config.cookieLife, path:config.cookiePath});
    })
});

/**
 * Init primary navbar
 * @return Void
 */
function initPrimaryNavbar()
{
    $('#primaryNavbar [data-toggle=tooltip]').tooltip({placement: 'right', container: 'body'});
}

/**
 * Add positionBar.
 * 
 * @access public
 * @return void
 */
function fixPositionbar()
{
    var $nav = $('#positionBar');
    $nav.html($nav.find('li').eq(0));
    var appendItem = function($item)
    {
        if($item.length)
        {
            $item = $item.first().clone().attr('class', null);
            if($.trim($item.text()) === '') $item.text($item.attr('title'));
            $nav.append($('<li>').append($item));
        }
    };

    appendItem($('#primaryNavbar > .nav:not(.fixed-bottom) > li.active > a'));

    var $mainNavbarItem = $('#mainNavbarCollapse > .nav > li.active > a');
    lastLink = $mainNavbarItem.attr('href');
    if(!$nav.find('[href="' + lastLink  + '"]').length) appendItem($mainNavbarItem);
}

/**
 * fix height of category nav in 'leftmenu'
 *
 * @access public
 * @return void
 */
function fixLeftMenu()
{
    var $leftmenu = $('.leftmenu');
    if(!$leftmenu.length) return;

    var $categoryNav = $leftmenu.children('.category-nav');
    var $panelBody = $categoryNav.find('.panel-body');
    var $stackedNav = $leftmenu.children('.nav-stacked');
    var ajustHeight = function()
    {
        if($('html').hasClass('screen-phone')) return;
        var winHeight = $(window).height();
        var maxHeight = winHeight - 120;
        var isStatic = $stackedNav.length && $stackedNav.height() > maxHeight;
        $leftmenu.toggleClass('leftmenu-static', isStatic);
        if($panelBody.length)
        {
            $panelBody.css('max-height', isStatic ? (winHeight/2) : (maxHeight - ($stackedNav.height() || 0)));
        }
    };

    ajustHeight();
    $(window).resize(ajustHeight);
}

/**
 * Init theme picker for admin menu
 */
$(function()
{
    var $themePicker = $('#menu .theme-picker');

    var refreshPicker = function(template)
    {
        var currentTemplate = $themePicker.attr('data-template');
        var currentTheme = $themePicker.attr('data-theme');
        if(!template || typeof(template) !== 'string') template = $(this).data('template') || currentTemplate;

        $themePicker.find('.menu-template.hover').removeClass('hover');
        $themePicker.find('.menu-template[data-template="' + template + '"]').addClass('hover');

        $themePicker.find('.menu-theme.current').removeClass('current');
        $themePicker.find('.menu-themes.show').removeClass('show');
        $themePicker.find('.menu-themes[data-template="' + template + '"]').addClass('show');
        $themePicker.find('.menu-themes[data-template="' + currentTemplate + '"] .menu-theme[data-theme="' + currentTheme + '"]').addClass('current');
    };

    $themePicker.on('mouseenter', '.menu-template', refreshPicker)
    .on('click', '.menu-template > a, .menu-theme', function(e)
    {
        var $this = $(this);
        $.getJSON($this.attr('href') || $this.data('url'), function(response)
        {
            if(response.result == 'success')
            {
                $themePicker.find('.menu-theme.current').removeClass('current');
                if($this.hasClass('menu-theme')) $this.addClass('current');
                $.zui.messager.success(response.message);

                if($.updateTheme) $.updateTheme($this.data('theme'));
                else setTimeout(function(){window.location.reload();}, 1000);
            }
            else
            {
                $.zui.messager.danger(response.message);
            }
        });
        return false;
    }).on('click', '.btn-custom', function(e){e.stopPropagation();});

    $('.menu-theme-picker').on('show.bs.dropdown show.zui.dropdown', function()
    {
        var $list = $('#menu .menu-themes');
        $list.css('max-height', $(window).height() - 130);
        refreshPicker();
    });

    refreshPicker();

    window.refreshThemePicker = function(template, theme)
    {
        $themePicker.find('.menu-template.active').removeClass('active');
        $themePicker.find('.menu-template[data-template="' + template + '"]').addClass('active');
        $themePicker.find('.menu-theme.active').removeClass('active');
        $themePicker.find('.menu-theme[data-theme="' + theme + '"]').addClass('active');
        $themePicker.attr('data-template', template).attr('data-theme', theme);
        refreshPicker(template, theme);
    };
});
