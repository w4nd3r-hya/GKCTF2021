$(document).ready(function()
{
    $('.blogTD').hide();
    $('tr.trBook').hide();

    $('[name=type]').change(function()
    {
        type = $(this).val();
        if(type == 'book')
        {
            $('tr#categories').hide();
            $('tr.trBook').show();
        }
        else
        {
            $('tr#categories').show();
            $('tr.trBook').hide();

            $('.articleTD, .blogTD').hide();
            $('.' + type + 'TD').show();
        }
    });

    $('select#bookList').change(function()
    {   
        var bookID=$(this).val();
        $.get(createLink('book', 'ajaxGetModules', 'bookID=' + bookID), function(data)
        {
            $('#bookCatalogBox').html(data);
            $('#bookCatalogBox select').attr('name', 'bookCatalogs').attr('id', 'bookCatalogs').chosen(defaultChosenOptions);
        });
    }); 

    $('#source').change();
    $(document).on('click', '.rejecter', function()
    {
        var deleter = $(this);
        bootbox.confirm(v.confirmReject, function(result)
        {
            if(result)
            {
                deleter.text(v.lang.doing);

                $.getJSON(deleter.attr('href'), function(data)
                {
                    if(data.result == 'success')
                    {
                        location.href = data.locate;
                        return true;
                    }
                    else
                    {
                        alert(data.message);
                    }
                });
            }
            return true;
       });
       return false;
    })
});
