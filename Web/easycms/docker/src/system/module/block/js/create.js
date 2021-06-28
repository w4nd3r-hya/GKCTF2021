$(document).ready(function()
{
    $('#type').change(function()
    {
        location.href = createLink('block', 'create', 'type=' + $(this).val());
    })

    $.setAjaxForm('#createForm', function(response)
    {   
        if(response.result == 'fail' && response.reason == 'captcha')
        {
            $('.captchaModal').click();
        }   
        if(response.result == 'success' && response.locate != '')
        {
            if($('body').hasClass('body-modal'))
            {
                if (window.parent && window.parent.handleBlockEdit)
                {
                    $('#createForm').find('#submit').popover('destroy');
                    window.parent.handleBlockEdit();
                }
                $.closeModal();
            }
            else if(response.locate)
            {
                location.href = response.locate;
            }
        }   
    }); 

    $('[name*=group]').change(function()
    {
       $('#title').val($(this).find("option:selected").text()); 
    });
    $('[name*=group]').change();

    $(document).on('change', '[name*=imageType]', function()
    {
        if($(this).find('option:selected').val() == 'custom')
        {
            $('tr.custom-image').removeClass('hidden');
        }
        else
        {
            $('tr.custom-image').addClass('hidden');
        }
    });

    $('[name*=imageType]').change();
})
