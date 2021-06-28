$(document).ready(function()
{
    /* Load the children of current category when page loaded. */
    var link = createLink('tree', 'children', 'type=' + v.type + '&root=' + v.root);
    $('#categoryBox').load(link, function(){if($.fn.placeholder) $('[placeholder]').placeholder();});
    $('#treeMenuBox li:has(ul)').each(function()
    {
        $(this).children('.deleter').remove();
    });

    $.setAjaxLoader('#treeMenuBox .ajax', '#categoryBox', function(){if($.fn.placeholder) $('[placeholder]').placeholder();});

    $('a.jsoner').click(function()
    {
        url = $(this).attr('href');
        var button = $(this);
        $.getJSON(url, function(response)
        {
            if(response.result == 'success')
            {
                 button.popover({trigger:'manual', content:response.message, placement:'right'}).popover('show');
                 button.next('.popover').addClass('popover-success');
                 function distroy(){button.popover('destroy')}
                 setTimeout(distroy,3000);
            }
            else
            {
                bootbox.alert(response.message);
            }
        });
        return false;
    });

    $(document).on('click', '.btn-plus', function()
    {
        $(this).parents('.form-group').after($('.child').html());
    })

    $(document).on('click', '.btn-remove', function()
    {
        if($(this).parents('#childForm').find('.form-group').not('.hide .form-group').find(':input[value=new]').size() == 1)
        {
            $(this).parents('.form-group').find('input').not('input[type=hidden]').val('');
            return false;
        }
        $(this).parents('.form-group').remove();
    })

    if(v.isWechatMenu) $(".leftmenu a[href*='wechat']").parent().addClass('active');

    if(v.type == 'slide') $("a[href*='slide']").parent().addClass('active');
    $.setAjaxForm('#childForm');

    $(document).on('click', 'a.plus', function()
    {
        v.key ++;
        $(this).parent().parent().after($('#entry').html().replace(/key/g, v.key));
        computeParent();
    });

    $(document).on('click', 'a.plus-child', function()
    {
        v.key ++;
        $('#child').find('[name*=parent]').val($(this).parents('.block-item').data('block'));
        var child = $('#child').html().replace(/key/g, v.key);
        $(this).parent().parent().after(child);
        computeParent();
    });

    $(document).on('click', 'a.btn-add-child', function()
    {
        v.key ++;
        $('#child').find('[name*=parent]').val($(this).parents('.block-item').data('block'));
        var entry = $('#child').html().replace(/key/g, v.key);
        $(this).parent().parent().find('.children').append(entry);
        if($(this).parent().parent().find('[name=isRegion]').val() != 1)
        {
            $(this).parent().siblings(0).children('.block').val(0).attr('readonly', true);
        }
        computeParent();
    });

    /* Delete options. */
    $(document).on('click', '.delete', function()
    {
        if($(this).parents('.children').size() == 0)
        {
            $(this).parents('.block-item').remove();
        }
        else
        {
            $(this).parent().parent('.block-item').remove();
        }
    });

    // Expand all nodes when user visit at first time of this day.
    var tree = $('.tree').data('zui.tree');
    if(tree && (!tree.store.time || tree.store.time < (new Date().getTime() - 24*40*60*1000)))
    {
        tree.show($('.item-type-tasks, .item-type-task').parent().parent());
    }
})

function computeParent()
{
    $('[name*=parent]').each(function(){$(this).val($(this).parents('.children').parents('.block-item').data('block'));});
}
