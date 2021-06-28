$(document).ready(function()
{
    $('#thumbExecButton').click(function()
    {   
        $(this).text(v.lang.doing);
        $(this).addClass('disabled');

        $.getJSON($(this).attr('href'), function(response)
        {   
            if(response.result == 'finished')
            {   
                 $('#thumbExecButton').attr('href', createLink('file', 'rebuildthumbs'));
                 $('#thumbExecButton').text(v.rebuildThumbs);
                 $('#thumbExecButton').next('.total').text(response.message);
                 $('#thumbExecButton').removeClass('disabled');
                 setTimeout(function(){$('#thumbExecButton').next('.total').hide();}, 3000);
                 return false;
             }   
             else
             {   
                 $('#thumbExecButton').next('.total').text(response.completed).show();
                 $('#thumbExecButton').attr('href', response.next);
                 return $('#thumbExecButton').click();
             }   
        }); 
        return false;
    }); 

    $('a[href=#displayTab]').click();

    var parseColor = function(c)
    {
        try {return new Color(c);}
        catch(e) {return null;}
    };

    var $css = $('#css');

    $('.color').each(function()
    {
        var $this = $(this);
        var c = $this.attr('data').replace(';', '');
        if(!c) return;
        var cc = parseColor(c);
        if(!cc) return;
        cc = cc.contrast().toCssStr();

        var $inputColor = ($this.hasClass('input-group') ? $this.find('.input-group-btn .dropdown-toggle') : $this).css({'background': c === 'transparent' ? '' : c, 'color': cc}).find('.caret').css('border-top-color', cc).closest('.input-group').find('.input-color');

        if(!$this.hasClass('input-group') && $this.attr('data').toLowerCase() == $('.input-group.color').attr('data').toLowerCase()) $this.addClass('active');

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
    
    $('#watermarkExecButton').click(function()
    {   
        $(this).text(v.lang.doing);
        $(this).addClass('disabled');

        $.getJSON($(this).attr('href'), function(response)
        {   
            if(response.result == 'finished')
            {   
                 $('#watermarkExecButton').attr('href', createLink('file', 'rebuildWatermark'));
                 $('#watermarkExecButton').text(v.rebuildWatermark);
                 $('#watermarkExecButton').next('.total').text(response.message);
                 $('#watermarkExecButton').removeClass('disabled');
                 setTimeout(function(){$('#watermarkExecButton').next('.total').hide();}, 3000);
                 return false;
            }   
            else
            {   
                $('#watermarkExecButton').next('.total').text(response.completed).show();
                $('#watermarkExecButton').attr('href', response.next);
                return $('#watermarkExecButton').click();
            }   
        }); 
        return false;
    }); 

    $('#browseTab input[name*=showCategory]').click(function()
    {
        if($(this).val() == '1')
        {
            $('#browseTab .blog-setting').show();
        }
        else
        {
            $('#browseTab .blog-setting').hide();
        }
    });

    $('#watermarkTab input[name*=watermark][type=radio]').change(function()
    {
        if($(this).val() == 'open')
        {
            $('#watermarkTab .watermark-info').show();
        }
        else
        {
            $('#watermarkTab .watermark-info').hide();
        }
    });

    $('.nav-tabs > li > a').click(function()
    {
        if($(this).attr('href') == '#watermarkTab')
        {
            if(v.gdInstalled == 0) $('.form-footer').hide();
            $('.watermark-footer').removeClass('hidden');
        }
        else
        {
            $('.watermark-footer').addClass('hidden');
        }

        if($(this).attr('href') == '#thumbTab')
        {
            $('.thumb-footer').removeClass('hidden');
        }
        else
        {
            $('.thumb-footer').addClass('hidden');
        }
    })

    $('[name*=product][name*=showViews]').change(function()
    {
        if($(this).find('option:selected').val() == '1')
        {
            $('[name*=product][name*=namePosition]').val('left').attr('disabled', true);
        }
        else
        {
            $('[name*=product][name*=namePosition]').val('left').attr('disabled', false);
        }
    })

    $('[name*=product][name*=showViews]').change();
});
