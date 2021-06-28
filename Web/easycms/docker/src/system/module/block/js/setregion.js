$(document).ready(function()
{
    var initSortable = function()
    {
        $('#blockList').sortable({trigger: '.sort-handle-1', selector: '.block-item', dragCssClass: ''});
        $('#blockList .children').sortable({trigger: '.sort-handle-2', selector: '.block-item', dragCssClass: ''});
    };

    var hideEmptyChildren = function()
    {
        $('#blockList .block-item .children').each(function()
        {
            var $this = $(this);
            $this.toggleClass('hide', !$this.children('.block-item').length);
        });
    }
    
    hideEmptyChildren();
    computeParent();
    initSortable();

    /* Set border and title show. */
    $(document).on('change', 'input[type=checkbox]', function()
    {
        if($(this).prop('checked')) $(this).next('input[type=hidden]').val(1);
        if(!$(this).prop('checked')) $(this).next('input[type=hidden]').val(0);
    });

    $('input[type=checkbox]').change();

    /* Fix edit link. */
    $(document).on('change', 'select.block', function()
    {
        $(this).parents('.block-item').find('.edit').attr('href', createLink('block', 'edit', 'id=' + $(this).find('option:selected').val()));
        $(this).parents('.block-item').find('.edit').attr('id', 'edit' + $(this).find('option:selected').val());
    });

    $('#blockList').on('click', '.plus, .plus-child, .btn-add-child, .btn-add-random', function()
    {
        setTimeout(hideEmptyChildren, 100);
        setTimeout(initSortable, 200);
    });
})
