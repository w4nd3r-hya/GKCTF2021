/* eslint-disable object-shorthand */
/* eslint-disable prefer-arrow-callback */
/* eslint-disable space-before-function-paren */
/* eslint-disable prefer-template */
/* eslint-disable vars-on-top */
/* eslint-disable no-shadow-restricted-names */
/* eslint-disable no-var */
/* eslint-disable func-names */
/* ========================================================================
 * Xuanxuan Mini client
 * ========================================================================
 * Copyright (c) 2014-2016 cnezsoft.com;
 * ======================================================================== */

(function (window, undefined) {
    var timeSeed = new Date().getTime();
    var lastXuanxuanID;

    var LANG_DATA = {
        'zh-cn': {
            closeConfirm: '要退出聊天吗？',
            confirmBtn: '确定',
            cancelBtn: '取消',
            collapse: '收起',
            collapseBtn: '–',
            expand: '展开',
            expandBtn: '↑',
            close: '关闭',
            closeBtn: '&times;'
        },
        'zh-tw': {
            closeConfirm: '要退出聊天嗎？',
            confirmBtn: '確定',
            cancelBtn: '取消',
            collapse: '收起',
            collapseBtn: '–',
            expand: '展開',
            expandBtn: '↑',
            close: '關閉',
            closeBtn: '&times;'
        },
        en: {
            closeConfirm: 'Are you sure to quit chat?',
            confirmBtn: 'Confirm',
            cancelBtn: 'Cancel',
            collapse: 'Collapse',
            collapseBtn: '–',
            expand: 'Expand',
            expandBtn: '↑',
            close: 'Quit',
            closeBtn: '&times;'
        }
    };

    function appendStyle(css, id, doc) {
        doc = doc || document;
        if (doc.getElementById(id)) return;
        var head = doc.head || doc.getElementsByTagName('head')[0];
        var style = doc.createElement('style');

        style.type = 'text/css';
        style.id = id;
        style.appendChild(doc.createTextNode(css));
        head.appendChild(style);
    }

    function addStyle(id, options) {
        if (document.getElementById('xxc-mini-style-' + id)) return;
        if (typeof options.width === 'number') {
            options.width += 'px';
        }
        if (typeof options.height === 'number') {
            options.height += 'px';
        }
        var css = [
            '#xxc-mini-' + id + ' {background: #fff; transition: all .4s; position: fixed; bottom: 0; right: 0; transform: translateY(100%); box-shadow: 0px 3px 5px -3px rgba(0, 0, 0, 0.2), 0px 4px 10px 1px rgba(0, 0, 0, 0.14), 0px 3px 7px 2px rgba(0, 0, 0, 0.12); width: ' + (options.width || '600px') + '; height: ' + (options.height || '500px') + ';}',
            '#xxc-mini-iframe-' + id + ' {width: 100%; height: 100%; left: 0px; top: 0;}',
            '#xxc-mini-' + id + ' .xxc-mini-toolbar-btn {position: absolute; top: 10px; right: 42px; min-width: 30px; height: 30px; line-height: 27px; font-size: 24px; text-decoration: none; z-index: 1; border-radius: 4px; text-align: center; cursor: pointer; color: #666; padding: 0 4px; font-family: Monaco,Menlo,Consolas,"Courier New",monospace}',
            '#xxc-mini-' + id + ' .xxc-mini-toolbar-btn:hover, #xxc-mini-' + id + ' .xxc-mini-toolbar-btn:focus {background: #e5e5e5}',
            '#xxc-mini-minz-btn-' + id + ' {right: 40px!important;}',
            '#xxc-mini-close-btn-' + id + ' {right: 5px!important;}',
            '#xxc-mini-heading-' + id + ' {position: absolute; left: 0; top: 0; height: 50px; right: 70px; display: none; z-index: 1; cursor: pointer;}',
            '#xxc-mini-' + id + '.xxc-mini-minimize #xxc-mini-heading-' + id + ' {display: block;}',
            '#xxc-mini-' + id + '.xxc-mini-ready {transform: translateY(0%);}',
            '#xxc-mini-' + id + '.xxc-mini-minimize {transform: translateY(100%); bottom: 49px;}',
            '#xxc-mini-' + id + '.xxc-mini-hidden {transform: translateY(100%); opacity: 0;}',
            '#xxc-mini-' + id + ' .xxc-mini-close-confirm-dialog {position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 1000; background: rgba(0,0,0,.5); visibility: hidden; opacity: 0; transition: visibility .2s, opacity .2s}',
            '#xxc-mini-' + id + '.xxc-mini-show-confirm .xxc-mini-close-confirm-dialog {visibility: visible; opacity: 1;}',
            '#xxc-mini-' + id + ' .xxc-mini-close-confirm-content {width: 80%; background: #fff; margin: 0 auto; padding: 15px; position: relative; top: 50%; margin-top: -100px; min-height: 100px; max-width: 400px; box-shadow: 0px 3px 5px -3px rgba(0, 0, 0, 0.2), 0px 4px 10px 1px rgba(0, 0, 0, 0.14), 0px 3px 7px 2px rgba(0, 0, 0, 0.12);}',
            '#xxc-mini-' + id + ' .xxc-mini-close-confirm-content > p {font-size: 15px; margin-bottom: 10px}',
            '#xxc-mini-' + id + ' .xxc-mini-dialog-btn {font-size: 14px; display: inline-block; padding: 8px 15px; cursor: pointer; text-decoration: none; background: #f1f1f1; margin-right: 10px;}',
            '#xxc-mini-' + id + ' .xxc-mini-dialog-btn:hover {background: #e5e5e5;}',
            '#xxc-mini-close-confirm-btn-' + id + '.xxc-mini-dialog-btn {background: #3f51b5; color: #fff;}',
            '#xxc-mini-close-confirm-btn-' + id + '.xxc-mini-dialog-btn:hover {background: #304ffe;}',
        ].join('');
        appendStyle(css, 'xxc-mini-style-' + id);
    }

    function startXuanxuan(options) {
        if (typeof options === 'string') {
            options = {web: options};
        }
        if (typeof options !== 'object' || options === null) {
            console.log('XuanXuan options not avaliable');
            return;
        }
        if (lastXuanxuanID && (options.singleton === undefined || options.singleton)) {
            return;
        }
        if (!options.web) {
            options.web = './index.html';
        }
        if (options.lang === undefined) {
            options.lang = 'zh-cn';
        }
        if (options.autoShow === undefined) {
            options.autoShow = true;
        }
        if (options.closeConfirm === undefined) {
            options.closeConfirm = true;
        }
        if (options.closeOnLogout === undefined) {
            options.closeOnLogout = true;
        }
        var id = options.id || (timeSeed++);
        var url = options.web;
        if (url.indexOf('?') < 0) {
            url += '?_id=' + id;
        } else {
            url += '&_id=' + id;
        }
        if (options.server) {
            url += '&server=' + encodeURIComponent(options.server);
        }
        if (options.account) {
            url += '&account=' + encodeURIComponent(options.account);
        }
        if (options.token) {
            url += '&token=' + encodeURIComponent(options.token);
        }
        if (options.cgid) {
            url += '&cgid=' + encodeURIComponent(options.cgid);
        }
        if (options.lang) {
            url += '&lang=' + encodeURIComponent(options.lang);
        }
        if (typeof options.config === 'object' && options.config !== null) {
            url += '&config=' + encodeURIComponent(JSON.stringify(options.config));
        }

        if (!options.noStyle) {
            addStyle(id, options);
        }

        var langData = LANG_DATA[options.lang] || LANG_DATA['zh-cn'];
        var getLangText = function(name, userText) {
            return userText === undefined ? langData[name] : userText;
        };

        var element = document.createElement('div');
        element.classList.add('xxc-mini-dialog');
        if (options.className) {
            element.classList.add(options.className);
        }
        if (!options.autoShow) {
            element.classList.add('xxc-mini-hidden');
        }
        element.id = 'xxc-mini-' + id;
        element.innerHTML = [
            '<div class="xxc-mini-close-confirm-dialog"><div class="xxc-mini-close-confirm-content"><p>' + getLangText('closeConfirm', options.closeConfirmText) + '</p><a id="xxc-mini-close-confirm-btn-' + id + '" class="xxc-mini-close-confirm-btn xxc-mini-dialog-btn">' + getLangText('confirmBtn', options.confirmBtnText) + '</a><a id="xxc-mini-close-cancel-btn-' + id + '" class="xxc-mini-close-cancel-btn xxc-mini-dialog-btn">' + getLangText('cancelBtn', options.cancelBtnText) + '</a></div></div>',
            '<a title="' + getLangText('collapse', options.collapseText) + '" id="xxc-mini-minz-btn-' + id + '" class="xxc-mini-toolbar-btn">' + getLangText('collapseBtn', options.collapseBtnHtml) + '</a>',
            '<a title="' + getLangText('close', options.closeText) + '" id="xxc-mini-close-btn-' + id + '" class="xxc-mini-toolbar-btn">' + getLangText('closeBtn', options.closeBtnHtml) + '</a>',
            '<div class="xxc-mini-heading" id="xxc-mini-heading-' + id + '"></div>',
            '<iframe id="xxc-mini-iframe-' + id + '" name="xxc-mini-iframe-' + id + '" src="' + url + '" frameborder="no" allowtransparency="true" scrolling="auto" hidefocus="" />'
        ].join('');
        document.body.appendChild(element);
        var iframe = document.getElementById('xxc-mini-iframe-' + id);
        var iframeWindow = iframe && iframe.contentWindow;

        var minimize = function() {
            element.classList.add('xxc-mini-minimize');
            var minzBtn = document.getElementById('xxc-mini-minz-btn-' + id);
            minzBtn.innerHTML = getLangText('expandBtn', options.expandBtnHtml);
            minzBtn.setAttribute('title', getLangText('expand', options.expandText));
        };

        var maximize = function() {
            element.classList.remove('xxc-mini-minimize');
            var minzBtn = document.getElementById('xxc-mini-minz-btn-' + id);
            minzBtn.innerHTML = getLangText('collapseBtn', options.collapseBtnHtml);
            minzBtn.setAttribute('title', getLangText('collapse', options.collapseText));
            if (iframeWindow) {
                iframeWindow.focus();
            }
        };

        var toggleMinimize = function() {
            if (element.classList.contains('xxc-mini-minimize')) {
                maximize();
            } else {
                minimize();
            }
        };

        var hide = function() {
            element.classList.add('xxc-mini-hidden');
        };

        var show = function() {
            element.classList.remove('xxc-mini-hidden');
        };

        var toggleCloseConfirm = function() {
            element.classList.toggle('xxc-mini-show-confirm');
            if (element.classList.contains('xxc-mini-show-confirm')) {
                maximize();
            }
        };

        var removeStyle = function() {
            if (!options.noStyle) {
                document.getElementById('xxc-mini-style-' + id).remove();
            }
        };

        var exitIM = function() {
            hide();
            setTimeout(function() {
                element.remove();
                removeStyle();
            }, 400);
            lastXuanxuanID = null;
        };

        var exit = function() {
            try {
                if (iframeWindow && iframeWindow.exitApp) {
                    hide();
                    element.classList.remove('xxc-mini-ready');
                    iframeWindow.exitApp(exitIM);
                }
            } catch (error) {
                exitIM();
            }
        };

        if (iframeWindow) {
            iframeWindow.addEventListener('DOMContentLoaded', function() {
                if (options.injectCss) {
                    appendStyle(options.injectCss, 'xxc-mini-style-inject-' + id, iframeWindow.document);
                }
                if (options.onLoad) {
                    options.onLoad();
                }
            });
            iframeWindow.onXXCReadyCallback = function() {
                if (options.onReady) {
                    options.onReady();
                }

                if (options.onNotice) {
                    iframeWindow.onNoticeUpdate(options.onNotice);
                }

                if (options.onUserLogin) {
                    iframeWindow.onUserLogin(options.onUserLogin);
                }

                iframeWindow.onUserLogout(function(user, code, reason, unexpected) {
                    var loginoutResult;
                    if (options.onUserLogout) {
                        loginoutResult = options.onUserLogout(user, reason, unexpected);
                    }

                    if ((options.exitOnKickoff && reason === 'KICKOFF') || loginoutResult === 'exit' || (reason === 'logout' && options.closeOnLogout)) {
                        exitIM();
                    }
                });
            };
        }

        document.getElementById('xxc-mini-close-btn-' + id).addEventListener('click', function() {
            if (options.closeConfirm) {
                toggleCloseConfirm();
            } else {
                exit();
            }
        });

        document.getElementById('xxc-mini-close-cancel-btn-' + id).addEventListener('click', function() {
            toggleCloseConfirm();
        });

        document.getElementById('xxc-mini-close-confirm-btn-' + id).addEventListener('click', function() {
            toggleCloseConfirm();
            exit();
        });

        document.getElementById('xxc-mini-minz-btn-' + id).addEventListener('click', toggleMinimize);
        document.getElementById('xxc-mini-heading-' + id).addEventListener('click', toggleMinimize);

        setTimeout(function() {
            element.classList.add('xxc-mini-ready');
        }, 50);

        lastXuanxuanID = id;
        return {
            element: element,
            id: id,
            options: options,
            exit: exit,
            hide: hide,
            show: show,
            toggleMinimize: toggleMinimize,
            minimize: minimize,
            maximize: maximize,
            contentWindow: iframeWindow,
            open: function() {
                if (!document.getElementById(id)) {
                    var xxc = startXuanxuan(options);
                    element = xxc.element; // eslint-disable-line
                } else {
                    show();
                    maximize();
                }
            },
            isMaximized: function() {
                return element && !element.classList.contains('xxc-mini-minimize');
            },
            isShow: function() {
                return element && !element.classList.contains('xxc-mini-hidden');
            },
            isExited: function() {
                return !document.getElementById(id);
            }
        };
    }

    window.startXuanxuan = startXuanxuan;
}(window, undefined));
