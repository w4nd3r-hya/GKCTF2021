$(function ()
{
    var setDelHref = function ()
    {
        var delIDs = [];
        $('input[name="deliveryAddress"]:checked').each(function (i)
        {
            delIDs[i] = $(this).val();
        });
        var delHref = $('.deleter').attr('href');
        delHref = delHref.replace(/(.*-).*(\..*)/, '$1' + delIDs.join(',') + '$2');
        $('.deleter').attr('href', delHref);
    };

    $.refreshAddressList = function ()
    {
        $('#addressListWrapper').load(window.location.href + ' #addressList');
        $('p[name="operate"]').show();
        $('#create').parent().removeClass('create-center');
    };

    $(document).on('click', '.item', function ()
    {
        if($('.address-manage').children('p[name="operate"]').attr('current') === 'manageDone')
        {
            if($(this).find('input[name="deliveryAddress"]').attr('checked') === false)
            {
                $(this).find('input[name="deliveryAddress"]').attr('checked', true);
            }
            else
            {
                $(this).find('input[name="deliveryAddress"]').removeAttr('checked');
                $('#allSelect').removeAttr('checked');
            }
            setDelHref();
        }
    });

    $(document).on('click', '.address-manage', function ()
    {
        if($(this).children('p[name="operate"]').attr('current') === 'manage')
        {
            $(this).children('p[name="operate"]').html($(this).children('input[name="manageDone"]').val());
            $(this).children('p[name="operate"]').attr('current', 'manageDone');
            $('.checkbox-circle').show();
            $('#create').hide();
            $('#delete').show();
            $('.edit-button').hide();
        }
        else
        {
            $(this).children('p[name="operate"]').html($(this).children('input[name="manage"]').val());
            $(this).children('p[name="operate"]').attr('current', 'manage');
            $('.checkbox-circle').hide();
            $('#create').show();
            $('#delete').hide();
            $('.edit-button').show();
        }
    });

    $(document).on('click', '.all-select', function ()
    {
        if($(this).find('input[name="allSelect"]').attr('checked') === false)
        {
            $(this).find('input[name="allSelect"]').attr('checked', true);
            $('input[name="deliveryAddress"]').attr('checked', true);
        }
        else
        {
            $(this).find('input[name="allSelect"]').removeAttr('checked');
            $('input[name="deliveryAddress"]').removeAttr('checked');
        }
        setDelHref();
    });
});