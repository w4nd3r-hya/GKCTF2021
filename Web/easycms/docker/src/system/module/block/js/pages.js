$(document).ready(function()
{
    $(document).on('click', 'a.plus', function()
    {
        v.key ++;
        $(this).parent().parent().after($('#entry').html().replace(/key/g, v.key));
        computeParent();
    });

    $(document).on('click', 'a.plus-child', function()
    {
        v.key ++;
        if($(this).parent().prev().prev().hasClass('col-probability'))
        {
            $('#random').find('[name*=parent]').val($(this).parents('.block-item').data('block'));
            var child = $('#random').html().replace(/key/g, v.key);
        }
        else
        {
            $('#child').find('[name*=parent]').val($(this).parents('.block-item').data('block'));
            var child = $('#child').html().replace(/key/g, v.key);
        }
        $(this).parent().parent().after(child);
        computeParent();
    });

    $(document).on('click', 'a.btn-add-child', function()
    {
        v.key ++;
        $(this).parent().parent().find('[name*=isRandom]').val('0');
        $('#child').find('[name*=parent]').val($(this).parents('.block-item').data('block'));
        var entry = $('#child').html().replace(/key/g, v.key);
        $(this).parent().parent().find('.children').empty().append(entry);
        if($(this).parent().parent().find('[name=isRegion]').val() != 1)
        {
            $(this).parent().siblings(0).children('.block').val(0).attr('readonly', true);
        }
        computeParent();
    });

    $(document).on('click', 'a.btn-add-random', function()
    {
        v.key ++;
        $(this).parent().parent().find('[name*=isRandom]').val('1');
        $('#random').find('[name*=parent]').val($(this).parents('.block-item').data('block'));
        var entry = $('#random').html().replace(/key/g, v.key);
        $(this).parent().parent().find('.children').empty().append(entry);
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

    $(document).on('click', '.loadInModal', function()
    {
        if($(this).attr('id') == 'edit') return false;
        $('#ajaxModal').load($(this).attr('href'), function(){ $.ajustModalPosition('fit', '#ajaxModal');});
        return false;
    });
});

function computeParent()
{
    $('[name*=parent]').each(function(){$(this).val($(this).parents('.children').parents('.block-item').data('block'));});
}
