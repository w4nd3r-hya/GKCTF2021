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
})

function computeParent()
{
    $('[name*=parent]').each(function(){$(this).val($(this).parents('.children').parents('.block-item').data('block'));});
}
