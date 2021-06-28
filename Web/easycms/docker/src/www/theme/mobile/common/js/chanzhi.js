/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
!function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=o,t}}}(function(){function g(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}return function e(l){function C(e,n,o){var t;if("undefined"!=typeof document){if(1<arguments.length){if("number"==typeof(o=g({path:"/"},C.defaults,o)).expires){var r=new Date;r.setMilliseconds(r.getMilliseconds()+864e5*o.expires),o.expires=r}o.expires=o.expires?o.expires.toUTCString():"";try{t=JSON.stringify(n),/^[\{\[]/.test(t)&&(n=t)}catch(e){}n=l.write?l.write(n,e):encodeURIComponent(String(n)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),e=(e=(e=encodeURIComponent(String(e))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var i="";for(var c in o)o[c]&&(i+="; "+c,!0!==o[c]&&(i+="="+o[c]));return document.cookie=e+"="+n+i}e||(t={});for(var a=document.cookie?document.cookie.split("; "):[],s=/(%[0-9A-Z]{2})+/g,f=0;f<a.length;f++){var p=a[f].split("="),d=p.slice(1).join("=");this.json||'"'!==d.charAt(0)||(d=d.slice(1,-1));try{var u=p[0].replace(s,decodeURIComponent);if(d=l.read?l.read(d,u):l(d,u)||d.replace(s,decodeURIComponent),this.json)try{d=JSON.parse(d)}catch(e){}if(e===u){t=d;break}e||(t[u]=d)}catch(e){}}return t}}return(C.set=C).get=function(e){return C.call(C,e)},C.getJSON=function(){return C.apply({json:!0},[].slice.call(arguments))},C.defaults={},C.remove=function(e,n){C(e,"",g(n,{expires:-1}))},C.withConverter=e,C}(function(){})});

// https://github.com/dankogai/js-base64
(function(global){"use strict";var _Base64=global.Base64;var version="2.1.9";var buffer;if(typeof module!=="undefined"&&module.exports){try{buffer=require("buffer").Buffer}catch(err){}}var b64chars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";var b64tab=function(bin){var t={};for(var i=0,l=bin.length;i<l;i++)t[bin.charAt(i)]=i;return t}(b64chars);var fromCharCode=String.fromCharCode;var cb_utob=function(c){if(c.length<2){var cc=c.charCodeAt(0);return cc<128?c:cc<2048?fromCharCode(192|cc>>>6)+fromCharCode(128|cc&63):fromCharCode(224|cc>>>12&15)+fromCharCode(128|cc>>>6&63)+fromCharCode(128|cc&63)}else{var cc=65536+(c.charCodeAt(0)-55296)*1024+(c.charCodeAt(1)-56320);return fromCharCode(240|cc>>>18&7)+fromCharCode(128|cc>>>12&63)+fromCharCode(128|cc>>>6&63)+fromCharCode(128|cc&63)}};var re_utob=/[\uD800-\uDBFF][\uDC00-\uDFFFF]|[^\x00-\x7F]/g;var utob=function(u){return u.replace(re_utob,cb_utob)};var cb_encode=function(ccc){var padlen=[0,2,1][ccc.length%3],ord=ccc.charCodeAt(0)<<16|(ccc.length>1?ccc.charCodeAt(1):0)<<8|(ccc.length>2?ccc.charCodeAt(2):0),chars=[b64chars.charAt(ord>>>18),b64chars.charAt(ord>>>12&63),padlen>=2?"=":b64chars.charAt(ord>>>6&63),padlen>=1?"=":b64chars.charAt(ord&63)];return chars.join("")};var btoa=global.btoa?function(b){return global.btoa(b)}:function(b){return b.replace(/[\s\S]{1,3}/g,cb_encode)};var _encode=buffer?function(u){return(u.constructor===buffer.constructor?u:new buffer(u)).toString("base64")}:function(u){return btoa(utob(u))};var encode=function(u,urisafe){return!urisafe?_encode(String(u)):_encode(String(u)).replace(/[+\/]/g,function(m0){return m0=="+"?"-":"_"}).replace(/=/g,"")};var encodeURI=function(u){return encode(u,true)};var re_btou=new RegExp(["[À-ß][-¿]","[à-ï][-¿]{2}","[ð-÷][-¿]{3}"].join("|"),"g");var cb_btou=function(cccc){switch(cccc.length){case 4:var cp=(7&cccc.charCodeAt(0))<<18|(63&cccc.charCodeAt(1))<<12|(63&cccc.charCodeAt(2))<<6|63&cccc.charCodeAt(3),offset=cp-65536;return fromCharCode((offset>>>10)+55296)+fromCharCode((offset&1023)+56320);case 3:return fromCharCode((15&cccc.charCodeAt(0))<<12|(63&cccc.charCodeAt(1))<<6|63&cccc.charCodeAt(2));default:return fromCharCode((31&cccc.charCodeAt(0))<<6|63&cccc.charCodeAt(1))}};var btou=function(b){return b.replace(re_btou,cb_btou)};var cb_decode=function(cccc){var len=cccc.length,padlen=len%4,n=(len>0?b64tab[cccc.charAt(0)]<<18:0)|(len>1?b64tab[cccc.charAt(1)]<<12:0)|(len>2?b64tab[cccc.charAt(2)]<<6:0)|(len>3?b64tab[cccc.charAt(3)]:0),chars=[fromCharCode(n>>>16),fromCharCode(n>>>8&255),fromCharCode(n&255)];chars.length-=[0,0,2,1][padlen];return chars.join("")};var atob=global.atob?function(a){return global.atob(a)}:function(a){return a.replace(/[\s\S]{1,4}/g,cb_decode)};var _decode=buffer?function(a){return(a.constructor===buffer.constructor?a:new buffer(a,"base64")).toString()}:function(a){return btou(atob(a))};var decode=function(a){return _decode(String(a).replace(/[-_]/g,function(m0){return m0=="-"?"+":"/"}).replace(/[^A-Za-z0-9\+\/]/g,""))};var noConflict=function(){var Base64=global.Base64;global.Base64=_Base64;return Base64};global.Base64={VERSION:version,atob:atob,btoa:btoa,fromBase64:decode,toBase64:encode,utob:utob,encode:encode,encodeURI:encodeURI,btou:btou,decode:decode,noConflict:noConflict};if(typeof Object.defineProperty==="function"){var noEnum=function(v){return{value:v,enumerable:false,writable:true,configurable:true}};global.Base64.extendString=function(){Object.defineProperty(String.prototype,"fromBase64",noEnum(function(){return decode(this)}));Object.defineProperty(String.prototype,"toBase64",noEnum(function(urisafe){return encode(this,urisafe)}));Object.defineProperty(String.prototype,"toBase64URI",noEnum(function(){return encode(this,true)}))}}if(global["Meteor"]){Base64=global.Base64}})(this);

/**
 * Create link.
 *
 * @param  string $moduleName
 * @param  string $methodName
 * @param  string $vars
 * @param  string $viewType
 * @access public
 * @return string
 */
function createLink(moduleName, methodName, vars, viewType)
{
    if(!viewType) viewType = config.defaultView;

    if(vars)
    {
        vars = vars.split('&');
        for(i = 0; i < vars.length; i ++) vars[i] = vars[i].split('=');
    }

    if(config.requestType != 'GET')
    {
        if(config.requestType == 'PATH_INFO')
        {
            link = config.webRoot + moduleName + config.requestFix + methodName;
            if(config.langCode != '') link = config.webRoot + config.langCode + '/' + moduleName + config.requestFix + methodName;
        }

        if(config.requestType == 'PATH_INFO2')
        {
            link = config.webRoot + 'index.php/'  + moduleName + config.requestFix + methodName;
            if(config.langCode != '') link = config.webRoot + 'index.php/' + config.langCode + '/' + moduleName + config.requestFix + methodName;
        }

        if(vars)
        {
            if(config.pathType == "full")
            {
                for(i = 0; i < vars.length; i ++) link += config.requestFix + vars[i][0] + config.requestFix + vars[i][1];
            }
            else
            {
                for(i = 0; i < vars.length; i ++) link += config.requestFix + vars[i][1];
            }
        }
        link += '.' + viewType;
    }
    else
    {
        link = config.router + '?' + config.moduleVar + '=' + moduleName + '&' + config.methodVar + '=' + methodName;
        if(vars) for(i = 0; i < vars.length; i ++) link += '&' + vars[i][0] + '=' + vars[i][1];
        if(config.langCode != '') link = link + '&l=' + config.langCode;
        link = link + '&' + config.viewVar + '=' + viewType;
    }
    return link;
}
/**
 * Ajax action
 */
(function($, document, window)
{
    'use strict';

    var DISABLED = 'disabled';
    var ajaxaction = function(options, $element)
    {
        options = $.extend(
        {
            spinner: 'spinner-indicator'
        }, options);

        if(options.locate === 'self') options.locate = window.location.href;

        var callEvent = function(name, event)
        {
            if(options && $.isFunction(options[name]))
            {
                return options[name](event);
            }
        };

        if(options.confirm && !confirm(options.confirm)) return;

        if(callEvent('before') === false) return;
        if($element)
        {
            if($element.hasClass(DISABLED)) return false;
            $element.addClass(DISABLED);
            if(options.spinner)
            {
                var $spinner = $element.find('.icon-' + options.spinner);
                if($spinner.length) $spinner.removeClass('hidden');
                else $element.prepend('<i class="icon icon-spin icon-' + options.spinner + '"> </i>');
            }
        }

        $[options.method || 'get'](options.url, options.data, function(response, status)
        {
            if(status == 'success')
            {
                try
                {
                    response = $.isPlainObject(response) ? response : $.parseJSON(response);
                    if(response.result === 'success')
                    {
                        var locate = response.locate || options.locate;
                        callEvent('onResultSuccess', response);
                        if(response.message)
                        {
                            $.messager.success(response.message);
                            if(locate)
                            {
                                setTimeout(function(){location.href = locate;}, 1200);
                            }
                        }
                        else if(locate) location.href = locate;
                    }
                    else
                    {
                        var locate = response.locate || options.errorLocate;
                        callEvent('onResultFailed', response);
                        if(response.message)
                        {
                            $.messager.show(response.message);
                            if(locate) setTimeout(function(){location.href = locate;}, 1200);
                        }
                        else if(locate) location.href = locate;
                    }
                }
                catch(e)
                {
                    callEvent('onNoResponse');
                }
                callEvent('onSuccess', response);
            }
            else
            {
                callEvent('onError', status);
                if(window.v && window.v.lang.timeout)
                {
                    $.messager.danger(window.v.lang.timeout);
                }
            }

            if($element)
            {
                $element.removeClass(DISABLED);
                if(options.spinner)
                {
                    var $spinner = $element.find('.icon-' + options.spinner);
                    if($spinner.length) $spinner.addClass('hidden');
                }
            }
            callEvent('onComplete', {response: response, status: status});
        });
    };

    $.ajaxaction = ajaxaction;

    $.fn.ajaxaction = function(options)
    {
        return this.each(function()
        {
            var $this   = $(this);
            var thisOption = $.extend({url: $this.attr('href')}, $this.data(), options);
            $this.on(thisOption.trigger || 'click', function(e)
            {
                e.preventDefault();
                ajaxaction(thisOption, $this);
            });
        });
    };

    $(document).on('click', '.ajaxaction, [data-toggle="action"]', function(e)
    {
        var $this   = $(this);
        var options = $.extend({url: $this.attr('href')}, $this.data(), options);
        e.preventDefault();
        ajaxaction(options, $this);
    });
}(Zepto, document, window));


$(function()
{
   /**
   * Set required fields, add star class to them.
   *
   * @access public
   * @return void
   */
    var setRequiredFields = function()
    {
        if(!config || !config.requiredFields) return;
        var requiredFields = config.requiredFields.split(',');
        for(i = 0; i < requiredFields.length; i++)
        {
            var $field = $('#' + requiredFields[i]);
            $field.closest('td,th').prepend("<div class='required required-wrapper'></div>");
            $field.closest('.form-group').addClass('required');
            if(window.v && window.v.lang.required)
            {
                $field.attr('placeholder', '(' + window.v.lang.required + ') ' + ($field.attr('placeholder') || ''));
            }
        }
    };

    // Set required feilds in form
    setRequiredFields();

    // Make links on app navbar as modalTrigger to open with modal
    $('#appnav a[data-toggle="modal"]').modalTrigger();

    // Set active item on #appnav
    var $appNav = $('#appnav');
    var activedNav = v.activedNav;
    if(!activedNav)
    {
        if(config && config.currentModule)
        {
            var moduleName = config.currentModule;
            if(moduleName === 'article' || moduleName === 'product' || moduleName === 'blog')
            {
                var liFinded = false;
                $appNav.find('li > a').each(function()
                {
                    var $a        = $(this);
                    var href      = $a.attr('href'),
                        $li       = $a.parents('li'),
                        pathName  = document.location.pathname;
                    var hrefIndex = href.indexOf(pathName);
                    if(href !== '/' && hrefIndex === 0 && !$li.hasClass('active'))
                    {
                        $li.addClass('active');
                        liFinded = true;
                    }
                });
                if(!liFinded) activedNav = '.nav-' + moduleName + '-0';
            }
            else activedNav = '.nav-system-' + (moduleName === 'index' ? 'home' : moduleName);
        }
    }
    $appNav.find(activedNav).addClass('active');
    var scrollToActiveItemTimer;
    $appNav.find('.mainnav>.nav').on('click', 'a.with-sub', function()
    {
        var $item = $(this);
        if(scrollToActiveItemTimer) clearTimeout(scrollToActiveItemTimer);
        scrollToActiveItemTimer = setTimeout(function()
        {
            if($item.hasClass('sub-open'))
            {
                var activeItem = $appNav.find('.subnavs>.nav>li.active')[0];
                if(activeItem) activeItem.scrollIntoView();
            }
            scrollToActiveItemTimer = null;
        }, 250);
    });

    // init deleter
    $(document).on('click', '.deleter', function(e)
    {

        var $this   = $(this);
        var options = $.extend({url: $this.attr('href'), confirm: window.v.lang.confirmDelete}, $this.data());
        e.preventDefault();
        $.ajaxaction(options, $this);
    });

    /* Make slide item clickable   */
    $(document).on('click', '.carousel .item[data-url]', function()
    {
        var $item  = $(this),
            url    = $item.data('url'),
            target = $item.data('target') || '_self';
        if(url && url.length) window.open(url, target);
    });

    function tidyCardsRow($row)
    {
        var $cards = $row.children('.col');
        if($cards.length < 2)
        {
            $cards.css('width', '100%');
            return;
        }
        var contentHeight = 0, minImgHeight = 9999, maxImgHeight = 0;
        var width = 100.0 / $cards.length;
        $cards.each(function()
        {
            var $col = $(this).css('width', width + '%');
            contentHeight = Math.max(contentHeight, $col.find('.card-content').height());
            var $img = $col.find('.card-img').css('height', 'auto');
            var imgHeight = $img.height();
            if(!$img.find('.media-placeholder').length) minImgHeight = Math.min(minImgHeight, imgHeight);
            maxImgHeight = Math.max(maxImgHeight, imgHeight);
        });
        if(minImgHeight === 9999) return;
        $cards.find('.card-content').css('height', contentHeight);
        if(minImgHeight > 20)
        {
            $cards.find('.card-img').css({'height': minImgHeight})
                .find('.media-placeholder').css({'height': minImgHeight, 'line-height': minImgHeight + 'px'});
        }
        if(maxImgHeight !== minImgHeight || minImgHeight <= 20) {setTimeout(function(){tidyCardsRow($row);}, 500);}
    };

    $.fn.tidyCards = function()
    {
        return $(this).each(function()
        {
            $(this).children('.row').each(function(){tidyCardsRow($(this));});
        });
    };
    $('.cards-products').tidyCards();

    $(window).on('lazyloaded', function(e, $img)
    {
        var $row = $img.closest('.row');
        if($row.parent().hasClass('cards-products')) tidyCardsRow($row);
    })

    $('.random-block-list').each(function()
    {
        var $random = $(this);
        if($random.data('random-refresh')) return;
        $random.data('random-refresh', true);
        var sum = 0;
        var $blocks = $random.children('.random-block');
        $blocks.each(function()
        {
            var $block = $(this).hide();
            $block.data('probMin', sum);
            sum += $block.data('probability');
            $block.data('probMax', sum);
        });

        var rand = Math.random() * sum;
        $blocks.each(function()
        {
            var $block = $(this);
            var blockData = $block.data();
            if(rand >= blockData.probMin && rand < blockData.probMax)
            {
                $block.show();
                return false;
            }
        });
    });

    // Make script file load in iframe modal work
    // See https://stackoverflow.com/questions/610995/cant-append-script-element
    $(document).on('loaded.ajax.modal', function(e)
    {
        var $modal = $(e.target);
        var $scripts = $modal.find('script[src]');
        $scripts.remove();
        $scripts.each(function()
        {
            var scriptEle = document.createElement('script');
            scriptEle.src = this.src;
            $modal[0].appendChild(scriptEle);
        });
    });

    // Listen scroll position and change logo position when user scroll page
    var lastScrollTop = 0;
    var $logo = $('#logo>h4,#logo>img');
    var isScrollInBottom = false;
    $(window).on('scroll', function()
    {
        var $window = $(window);
        var scrollTop = $window.scrollTop();

        if((!lastScrollTop && scrollTop) || (!scrollTop && lastScrollTop))
        {
            var isScrollDownIn = !!scrollTop;
            $('body').toggleClass('scroll-down-in', isScrollDownIn);
        }
        if((scrollTop < 10 && lastScrollTop >= 10) || (scrollTop >= 10 && lastScrollTop < 10))
        {
            $logo.css({left: scrollTop < 10 ? 0 : -1 * Math.floor(($window.width() - $logo.width()) / 2 - 8)});
        }
        lastScrollTop = scrollTop;
        var isInBottom = $window.scrollTop() + $window.height() == $(document).height();
        if(isInBottom !== isScrollInBottom)
        {
            $('body').toggleClass('scroll-in-bottom', isInBottom);
            isScrollInBottom = isInBottom;
        }
    }).scroll();

    // Init pull-up-load-more component
    var initPullUpPager = function($pager)
    {
        if($pager.data('initPullUpPager')) return;
        var id = 'pullUpPager' + ($.uuid++);
        var pagerInfo = $pager.data();
        var pageTotal = pagerInfo.pagetotal;
        var pageID = pagerInfo.pageid;
        if(pageTotal && pageTotal > 1 && pageID && pageID < pageTotal)
        {
            var $info = $pager.find('.pager-pull-up-hint');
            var triggerDistance = 100;
            var tryLoadNextPage = function()
            {
                if($pager.hasClass('page-loading') || pageID >= pageTotal) return;

                var $tmpDiv = $('<div>');
                $tmpDiv.load(pagerInfo.url.replace('$ID', pageID + 1) + ' ' + pagerInfo.list, function(response, status)
                {
                    if(status === 'success')
                    {
                        $(pagerInfo.list).append($tmpDiv.children(pagerInfo.list).children());
                        pageID += 1;
                        $pager.find('.pager-pull-up-pageID').text(pageID);
                        if(pageID >= pageTotal) $info.hide();
                    }
                    else alert(v.lang.timeout);
                    $pager.removeClass('page-loading');
                    $pager.trigger('pupLoad');
                });
                $pager.addClass('page-loading');
            };

            var touchStartX, touchStartY;
            $(document).on('touchstart.' + id, function(e)
            {
                touchStartX = e.touches[0].pageX;
                touchStartY = e.touches[0].pageY;
            }).on('touchmove.' + id, function(e)
            {
                var distanceX = e.changedTouches[0].pageX - touchStartX;
                var distanceY = e.changedTouches[0].pageY - touchStartY;
                if(Math.abs(distanceY) > Math.abs(distanceX) && distanceY < 0 && distanceY >= -triggerDistance)
                {
                    $info.css('transform', 'scaleY(' + (1 - Math.abs(distanceY/(triggerDistance * 1.1))) + ')');
                }
            }).on('touchend.' + id, function(e)
            {
                var distanceX = e.changedTouches[0].pageX - touchStartX;
                var distanceY = e.changedTouches[0].pageY - touchStartY;
                $info.css('transform', 'scaleY(1)');
                if(Math.abs(distanceY) > Math.abs(distanceX) && distanceY < -triggerDistance)
                {
                    tryLoadNextPage();
                }
            });
        }
        $pager.data('initPullUpPager', id);
    };

    $.fn.removePullUpPager = function()
    {
        return $(this).each(function()
        {
            var $pager = $(this);
            var id = $pager.data('initPullUpPager');
            if(id)
            {
                $(document).off('.' + id);
                $pager.data('initPullUpPager', null);
            }
        });
    };

    $.fn.initPullUpPager = function()
    {
        return $(this).each(function()
        {
            initPullUpPager($(this));
        });
    };
    $('.pager-pull-up').initPullUpPager();
});
