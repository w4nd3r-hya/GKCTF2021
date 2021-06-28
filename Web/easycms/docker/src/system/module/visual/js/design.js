var clientLang = $.zui.clientLang().replace('zh-', '');

/// Set default values for future Ajax requests
$.ajaxSetup(
{
    beforeSend: function()
    {
        $('#preview').addClass('loading');
    },
    error: function()
    {
        $.zui.messager.danger(v.lang.timeout);
    },
    complete: function()
    {
        $('#preview').removeClass('loading');
    }
});

/**
 * Open iframe modal
 *
 * @param {string} url Remote iframe modal url
 * @param {?object} options ZUI ModalTrigger options
 * @access public
 * @return void
 */
function openModal(url, options)
{
    window.modalTrigger.show($.extend(
    {
        iframeBodyClass    : 'body-modal-ve',
        name               : 'vModal',
        url                : url,
        type               : 'iframe',
        width              : '80%',
        icon               : 'pencil',
        title              : '',
        mergeOptions       : true,
        backdrop           : 'static'
    }, options));
}

/**
 * Toggle show/remove loading state
 *
 * @param {?boolean} [result=true] true: show loading ui, false: remove loading ui
 * @access public
 * @return void
 */
function toggleLoadingState(loading)
{
    if(loading === false) $('#preview').removeClass('loading');
    else $('#preview').addClass('loading');
}

/**
 * Show messager for remote operation result
 *
 * @param {?boolean} [result=true] true: success message, false: failure message
 * @access public
 * @return void
 */
function showRemoteResult(result)
{
    if(result === false) $.zui.messager.warning(v.visualLang.operateFail);
    else $.zui.messager.success(v.visualLang.saved);
}

/**
 * Toggle show or hide menu
 *
 * @param {?boolean} toggle true: show menu, false: hide menu, undefined: toggle show/hide menu
 * @access public
 * @return void
 */
function toggleDSMenu(toggle)
{
    var $dsBox = $('#dsBox');
    if(toggle === undefined) toggle = $dsBox.hasClass('ds-hide-menu');
    $dsBox.toggleClass('ds-hide-menu', !toggle);
    $.zui.store.set('ds-menu-collapsed', !toggle);
}

/**
 * Toggle show block list
 *
 * @param {?string} name Hide others and show the named one
 * @access public
 * @return void
 */
function toggleBlockList(name)
{
    var $blockListSelector = $('#blockListSelector');
    if(!name) name = $blockListSelector.val();
    else $blockListSelector.val(name);
    var $blockList = $('#blocks .block-list').addClass('hidden');
    $blockList.filter('[data-id="' + name + '"]').removeClass('hidden');
}

/**
 * Resize code editor
 *
 * @param {string} name 'js' or 'css' or ''
 * @access public
 * @return void
 */
function resizeCodeEditor(name)
{
    if(!name) return $.each(['css', 'js'], function(_, iName){resizeCodeEditor(iName)});
    var $editor = $('#' + name + '-editor');
    $editor.height($editor.closest('.tab-pane').height() - 59);
    $('#' + name).data('editor').resize();
}

/**
 * Init code editor
 *
 * @access public
 * @return void
 */
function initCodeEditor()
{
    $('#dsTool').on('resize', function(){resizeCodeEditor();});
    resizeCodeEditor();

    $.setAjaxForm('#tabCss');
    $.setAjaxForm('#tabJS');
}

/**
 * Init custom theme form
 *
 * @access public
 * @return void
 */
function initCustomThemeForm()
{
    var parseColor = function(c)
    {
        try {return new $.zui.Color(c);}
        catch(e) {return null;}
    };

    $.setAjaxForm('#customThemeForm');

    var $form = $('#customThemeForm');

    $('.color').each(function()
    {
        var $this = $(this);
        var c = $this.attr('data').replace(';', '');
        if(!c) return;
        var cc = parseColor(c);
        if(!cc) return;
        cc = cc.contrast().toCssStr();

        var $inputColor = ($this.hasClass('input-group') ? $this.find('.input-group-btn .dropdown-toggle') : $this).css({'background': c === 'transparent' ? '' : c, 'color': cc}).find('.caret').css('border-top-color', cc).closest('.input-group').find('.input-color');
        if(!$inputColor.attr('placeholder'))
        {
            $inputColor.attr('placeholder', c);
        }
    }).click(function()
    {
        var $this = $(this);
        if($this.hasClass('input-group')) return;
        var $plate = $this.closest('.colorplate');
        $plate.find('.color.active').removeClass('active');
        if($this.hasClass('color-tile')) $plate.find('.input-color').val($this.attr('data')).change();
        $this.addClass('active');
    });

    $('.input-color').on('keyup change.color', function()
    {
        var $this = $(this);
        var val = $this.val();

        $this.closest('.colorplate').find('.color.active').removeClass('active');

        if(Color.isColor(val))
        {
            var ic = (new Color(val)).contrast().toCssStr();
            $this.attr('placeholder', val).closest('.color').removeClass('error').find('.input-group-btn .dropdown-toggle').css({'background': val, 'color': ic}).find('.caret').css('border-top-color', ic);;
        }
        else
        {
            $this.closest('.color').addClass('error');
        }
    });

    $('.input-group-textbox-couple input[data-target]').on('keyup change', function()
    {
        var $this = $(this);
        var name = $this.data('target');
        $('#' + name).val($('[data-sid="' + name + '-1"]').val() + ' ' + $('[data-sid="' + name + '-2"]').val());
    });

    var $resetThemeBtn = $('#resetTheme');
    $resetThemeBtn.click(function()
    {
        bootbox.confirm($resetThemeBtn.data('success-tip'), function(result)
        {
            if(result)
            {
                $form.find('input.form-control, select.form-control, input[type="hidden"]').each(function()
                {
                    var $this = $(this);
                    $this.val($this.attr('data-origin-default') || $this.attr('data-default') || $this.attr('placeholder') || $this.val()).trigger('change.color');
                });
                $('#submit').click();
                return true;
            }
            return true;
        });
    });

    $form.submit(function()
    {
        $form.find('input.form-control, select.form-control, input[type="hidden"]').each(function()
        {
            var $this = $(this);
            var val = $this.val();
            var type = $this.data('type');
            if(val === '') $this.val($this.data('origin-default') || $this.data('default') || $this.attr('placeholder') || $this.val()).trigger('change.color');
            else if(type === 'image' && val != 'inherit' && val != 'none' && val.indexOf('url(') != 0)
            {
                $this.val('url(' + val + ')');
            } else if(type === 'color') {
                $this.val(val.replace(';', ''));
            }
        });

        $form.find('.input-group-textbox-couple input[data-target]').each(function()
        {
            var name = $(this).data('target');
            $('#' + name).val($('[data-sid="' + name + '-1"]').val() + ' ' + $('[data-sid="' + name + '-2"]').val());
        });
    });
}

/**
 * Get region blocks data from remote server
 *
 * @param {?string} region
 * @param {?function} callback
 * @access public
 * @return void
 */
function getRegionBlocks(region, callback)
{
    if ($.isFunction(region))
    {
        callback = region;
        region = '';
    }
    $.getJSON(createLink('visual', 'ajaxGetRegionBlocks', 'page=' + v.page + '&region=' + (region || '')), function(data)
    {
        if(callback) callback(data.blocks, data.side);
    });
}

/**
 * Tidy row blocks, make all blocks in same row has same height
 *
 * @param {object} $row
 * @access public
 * @return void
 */
function tidyRowBlocks($row)
{
    if(!$row)
    {
        var $rows = $('#preview').find('.layout-region>.row,.block-container>.row');
        var rowsLength = $rows.length;
        for(var i = (rowsLength - 1); i >= 0; i--)
        {
            tidyRowBlocks($rows.eq(i));
        }
        return;
    }

    // Caculate real rows
    var row = 0, gridValue = 0;
    var $cols = $row.children('.col');
    $cols.each(function()
    {
        var $col = $(this);
        var grid = $col.data('grid');
        if((grid + gridValue) > 12)
        {
            row++;
            gridValue = grid;
        }
        else
        {
            gridValue+= grid;
        }
        $col.attr('data-row', row).data('row', row);
    });

    // Set blocks height
    for(var j = 0; j <= row; ++j)
    {
        var $rowCols = $cols.filter('[data-row="' + j + '"]');

        // Get max block height
        var maxHeight = 0;
        $rowCols.each(function()
        {
            var $col = $(this);
            var $block = $col.children('.block');
            var blockHeight = $block.outerHeight();
            maxHeight = Math.max(maxHeight, blockHeight);
        });
        $rowCols.each(function()
        {
            var $col = $(this);
            $col.children('.block').css('min-height', maxHeight).not('.block-container').children('.block-title').css('line-height', (maxHeight - 20) + 'px');
        });
    }
}

/**
 * Render block item
 *
 * @param {object} block
 * @param {boolean} [isGrid=false]
 * @access public
 * @return void
 */
function renderBlock(block, isGrid)
{
    var blockTitle = block.title;
    var isSubRegion    = block.children || block.type === 'region';
    var isRandomRegion = block.isRandom === 1;
    if(isSubRegion && !blockTitle) blockTitle = v.visualLang.subRegion + '-' + block.id;
    if(isRandomRegion) blockTitle = v.visualLang.randomRegion + '-' + block.id;
    blockTitle = blockTitle || '';

    var $block = $('<div class="block" data-id="' + block.id + '" data-title="' + blockTitle + '" data-region="' + block.region + '"></div>');
    var $blockTitle = $('<div class="block-title" title="' + blockTitle + '">' + blockTitle + '</div>');
    var $blockActions = $('<div class="block-actions clearfix"><a class="btn-edit" data-toggle="tooltip" title="' + v.visualLang.actions.edit + '"><i class="icon icon-pencil"></i></a><a class="btn-delete" data-toggle="tooltip" title="' + v.visualLang.actions.delete + '"><i class="icon icon-remove"></i></a><a class="btn-layout" data-toggle="tooltip" title="' + v.visualLang.changeLayout + '"><i class="icon icon-list-alt"></i></a></div>');
    $block.append($blockTitle).append($blockActions);
    if(isSubRegion)
    {
        $block.addClass('block-container');
        var $row = $('<div class="row"></div>');
        if(block.children && block.children.length)
        {
            $.each(block.children, function(childIndex, child)
            {
                child.region  = block.region;
                var $subBlock = renderBlock(child, !isRandomRegion);
                $subBlock.addClass('block-sub');
                $row.append($subBlock);
            });
        }
        else $block.addClass('empty');
        $block.append($row);
    }
    if(isGrid)
    {
        $block.append('<div class="block-resize-handler right"><i class="icon icon-resize-horizontal"></i></div>');
        var grid = (block.grid || 4);
        return $('<div data-grid="' + grid + '" class="col block-wrapper"></div>').append($block);
    }
    else
    {
        $block.addClass('block-wrapper');
    }
    return $block;
}

/**
 * Update region blocks from remote
 *
 * @param {?string} region if region not set then update all regions in page
 * @param {?function} callback
 * @access public
 * @return void
 */
function updateRegionBlocks(region, callback)
{
    if ($.isFunction(region))
    {
        callback = region;
        region = '';
    }
    var $preview = $('#preview').addClass('loading');
    getRegionBlocks(region, function(regionBlocks, side)
    {
        $preview.find('[data-toggle="tooltip"]').tooltip('hide');
        $.each(regionBlocks, function(regionName, blocks)
        {
            var $region = $preview.find('.layout-region[data-name="' + regionName + '"]');
            if(!$region.length) return;
            var isGrid = $region.hasClass('type-grid');
            var $regionWrapper = isGrid ? $region.children('.row').first() : $region;
            $regionWrapper.empty();
            if(blocks && blocks.length)
            {
                $.each(blocks, function(blockIdx, block)
                {
                    block.region = regionName;
                    $regionWrapper.append(renderBlock(block, isGrid));
                });
                $region.removeClass('empty');
            }
            else
            {
                $region.addClass('empty');
            }
        });
        $preview.removeClass('loading').find('[data-toggle="tooltip"]').tooltip({container: '#preview'});
        if(side)
        {
            $preview.toggleClass('ds-side-float-left', side.float === 'left').toggleClass('ds-side-float-right', side.float === 'right').toggleClass('ds-side-float-hidden', side.float === 'hidden');
            var $mainRow = $preview.find('.layout-row');
            $mainRow.find('.layout-col[data-name="main"]').css('width', (100*(12 - side.grid)/12) + '%');
            $mainRow.find('.layout-col[data-name="side"]').css('width', (100*side.grid/12) + '%');
        }
        tidyRowBlocks();
        if(callback) callback(region);
    });
}

/**
 * Delete block from remote server
 *
 * @param {object} block block item object
 * @param {?string} confirmMessage
 * @param {?function} callback
 * @access public
 * @return void
 */
function deleteBlock(block, confirmMessage, callback)
{
    if(confirmMessage)
    {
        if(bootbox && bootbox.confirm)
        {
            bootbox.confirm({size: 'small', message: confirmMessage, callback: function(result)
            {
                if(result) deleteBlock(block, false, callback);
            }});
        }
        else if(confirm(confirmMessage))
        {
            deleteBlock(block, false, callback);
        }
        return;
    }
    var deleteUrl = createLink('visual', 'removeBlock', 'blockID=' + block.id + '&page=' + v.page + '&region=' + block.region + '&object=&l=' + clientLang);
    $.getJSON(deleteUrl, function(response)
    {
        if(response && response.result === 'success')
        {
            callback && callback(true);
            showRemoteResult();
        }
        else
        {
            callback(false);
            showRemoteResult(false);
        }
    });
}

/**
 * Show block edit modal
 *
 * @param {object} block block item object
 * @access public
 * @return void
 */
function editBlock(block)
{
    openModal(createLink('block', 'edit', 'blockID=' + block.id),
    {
        title: v.visualLang.actions.edit + ' [' + block.title + ']',
        width: '80%'
    });
}

/**
 * Change block layout setting on remote server
 *
 * @param {object} block block item object
 * @param {object} postData setting data for post to server
 * @param {?function} callback
 * @access public
 * @return void
 */
function changeBlockLayout(block, postData, callback)
{
    if ($.isFunction(postData))
    {
        callback = postData;
        postData = null;
    }
    var dialogUrl = createLink('visual', 'fixBlock', 'page=' + v.page + '&region=' + block.region + '&blockID=' + block.id + '&object=&l=' + clientLang);
    if(postData)
    {
        $.post(dialogUrl, postData, function(response)
        {
            if(response && response.result === 'success')
            {
                updateRegionBlocks(block.region);
                showRemoteResult();
            }
            else showRemoteResult(false);
            callback && callback();
        }, 'json');
    }
    else
    {
        openModal(dialogUrl,
        {
            title: v.visualLang.changeLayout + ' [' + block.title + ']',
            width: 600,
            loaded: function(e)
            {
                var modal$ = e.jQuery;
                if(modal$ && modal$.setAjaxForm) modal$.setAjaxForm('.ve-form', function(response)
                {
                    $.closeModal();
                    updateRegionBlocks(block.region);
                    callback && callback();
                    showRemoteResult();
                });
            },
            hidden: callback
        });
    }
}

/**
 * Show page columns setting modal
 *
 * @access public
 * @return void
 */
function setPageColumns()
{
    var dialogUrl = createLink('block', 'setColumns', 'page=' + v.page + '&object=&l=' + clientLang);
    openModal(dialogUrl,
    {
        title: v.visualLang.setColumns,
        width: 600,
        loaded: function(e)
        {
            var modal$ = e.jQuery;
            if(modal$ && modal$.setAjaxForm) modal$.setAjaxForm('.ve-form', function(response)
            {
                $.closeModal();
                updateRegionBlocks();
            });
        },
    });
}

/**
 * Init region blocks
 *
 * @access public
 * @return void
 */
function initRegionBlocks()
{
    updateRegionBlocks();
    var $preview = $('#preview');
    $preview.on('click', '.btn-delete', function()
    {
        var $block = $(this).closest('.block');
        deleteBlock($block.data(), v.visualLang.deleteConfirm.format($block.data('title')), function(result)
        {
            if(result) updateRegionBlocks($block.closest('.layout-region').data('name'));
        });
    }).on('click', '.btn-edit', function()
    {
        var $block = $(this).closest('.block');
        editBlock($block.data());
    }).on('click', '.btn-layout', function()
    {
        var $block = $(this).closest('.block');
        changeBlockLayout($block.data());
    }).on('click', '.btn-setPageColumns', setPageColumns).on('mousedown', '.block-resize-handler', function(e)
    {
        var $handler = $(this);
        var $block = $handler.closest('.block');
        var $col = $block.parent().addClass('block-resizing');
        var $row = $block.closest('.row');
        var startX = e.pageX;
        var startWidth = $col.width();
        var rowWidth = $row.width();
        var oldGrid = $col.attr('data-grid');
        var lastGrid = oldGrid;

        var mouseMove = function(event)
        {
            $block.addClass('block-editing block-editing-resize');
            var x = event.pageX;
            var grid = Math.max(1, Math.min(12, Math.round(12 * (startWidth + (x - startX)) / rowWidth)));
            if(lastGrid != grid)
            {
                $col.attr('data-grid', grid);
                lastGrid = grid;
                $handler.attr('title', grid + '/12');
            }
            event.preventDefault();
            event.stopPropagation();
        };

        var mouseUp = function(event)
        {
            $block.removeClass('block-editing block-editing-resize');
            $col.removeClass('block-resizing');

            lastGrid = $col.attr('data-grid');
            if(oldGrid !== lastGrid)
            {
                changeBlockLayout($block.data(), {grid: lastGrid});
            }

            $('body').off('mousemove.ve.resize', mouseMove).off('mouseup.ve.resize', mouseUp);
            event.preventDefault();
            event.stopPropagation();
        };

        $('body').on('mousemove.ve.resize', mouseMove).on('mouseup.ve.resize', mouseUp);
        e.preventDefault();
        e.stopPropagation();
    });
}

/**
 * Update block list from remote server
 *
 * @param {?function} callback
 * @access public
 * @return void
 */
function updateBlockList(callback)
{
    $('#blockLists').load(window.location.href + ' #blockLists .block-list', function()
    {
        toggleBlockList();
        if(callback) callback();
    });
}

/**
 * Handle things after edit block on modal dialog
 *
 * @access public
 * @return void
 */
function handleBlockEdit()
{
    updateBlockList();
    updateRegionBlocks();
    showRemoteResult();
}

/**
 * Init design menu
 *
 * @access public
 * @return void
 */
function initDSMenu()
{
    var lastMenuScrollTop = $.zui.store.get('lastDSMenuScrollTop');
    var $dsMenuContent = $('#dsMenu > .content');
    if(lastMenuScrollTop)
    {
        $dsMenuContent.scrollTop(lastMenuScrollTop);
    }
    $dsMenuContent.on('scroll', function()
    {
        $.zui.store.set('lastDSMenuScrollTop', $dsMenuContent.scrollTop());
    });

    var $dsBox = $('#dsBox');
    var isDsMenuCollapsed = !!$.zui.store.get('ds-menu-collapsed');
    if(isDsMenuCollapsed) toggleDSMenu(false);
    $dsBox.on('click', '.ds-menu-toggle', function()
    {
        toggleDSMenu();
    });
}

/**
 * Init block list
 *
 * @access public
 * @return void
 */
function initBlockList()
{
    toggleBlockList();
    $('#blockListSelector').on('change', function()
    {
        toggleBlockList();
    });
}

/**
 * Add block to region container and post to remote server
 *
 * @param {object} block block item object
 * @param {object} $target jquery element
 * @param {?function} callback
 * @access public
 * @return void
 */
function addBlock(block, $target, callback)
{
    var isContainer = $target.is('.block-container');
    var $region = $target.closest('.layout-region') ;
    var parentId = isContainer ? $target.data('id') : '';
    var isRandom = block.random === undefined ? '' : block.random;
    var region = $region.data('name');
    var allowregionblock = $target.is('.block-container,.type-grid') ? true : '';
    if(!allowregionblock && block.id === 'region')
    {
        return $.zui.messager.warning(v.visualLang.addRegionAlert.format($region.data('title')));
    }
    var postUrl = createLink('visual', 'appendBlock', 'page=' + v.page + '&region=' + region + '&parent=' + parentId + '&allowregionblock=' + allowregionblock + '&object=&isRandom=' + isRandom + '&l=' + clientLang);
    $.post(postUrl, {block: block.id}, function(response)
    {
        if(response && response.result === 'success')
        {
            updateRegionBlocks(region);
            showRemoteResult();
        } else showRemoteResult(false);
        callback && callback();
    }, 'json');
}

/**
 * Sort blocks in region container and post to remote server
 *
 * @param {object} $target jquery element
 * @param {?function} callback
 * @access public
 * @return void
 */
function sortBlocks($target, callback)
{
    var $region = $target.closest('.layout-region') ;
    var region = $region.data('name');
    var $container = $target.closest('.block-container');
    var parentId = $container.length ? $container.data('id') : '';
    var postUrl = createLink('visual', 'sortblocks', 'page=' + v.page + '&region=' + region + '&parent=' + parentId + '&object=&l=' + clientLang);
    var orders = [];
    $target.parent().children('.block-wrapper').each(function()
    {
        var $wrapper = $(this);
        orders.push($wrapper.is('.col') ? $wrapper.children('.block').data('id') : $wrapper.data('id'));
    });

    $.post(postUrl, {orders: orders.join(',')}, function(response)
    {
        if(response && response.result === 'success')
        {
            updateRegionBlocks(region);
            showRemoteResult();
        } else showRemoteResult(false);
        callback && callback();
    }, 'json');
}

/**
 * Init drag and drop events.
 *
 * @access public
 * @return void
 */
function initDnDAddBlock()
{
    var $preview = $('#preview');
    $('#blocks').droppable(
    {
        container: '#dsBox',
        nested: true,
        // target: '.layout-region .block,.layout-region',
        target: '.layout-region .block-container,.layout-region',
        selector: '.block-item',
        start: function()
        {
            $preview.addClass('drag-and-drop');
        },
        drop: function(event)
        {
            var $element = event.element;
            if(event.isIn) addBlock($element.data(), event.target);
        },
        finish: function()
        {
            $preview.removeClass('drag-and-drop');
        }
    });

    $preview.sortable(
    {
        container: '#dsBox',
        dropToClass: 'sort-to',
        nested: true,
        selector: '.block-wrapper',
        stopPropagation: true,
        targetSelector: function($ele, $root)
        {
            var $parent = $ele.parent();
            if($parent.is('.col')) $ele = $parent;
            var $container = $ele.closest('.row,.layout-region');
            return $container.children('.block,.col');
        },
        start: function()
        {
            $preview.addClass('block-sorting');
        },
        finish: function(e)
        {
            if(e.changed)
            {
                sortBlocks(e.element);
            }
            $preview.removeClass('block-sorting');
        }
    })
}

$(function()
{
    // Init UI elements
    initDSMenu();
    initBlockList();
    initCodeEditor();
    initCustomThemeForm();
    initRegionBlocks();
    initDnDAddBlock();

    // Init tooltip
    $('[data-toggle="tooltip"]').tooltip({container: '#dsBox'});

    // Show UI delay
    setTimeout(function()
    {
        $('#dsBox').addClass('in');
    }, 100);
});
