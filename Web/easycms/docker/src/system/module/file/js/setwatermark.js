$(document).ready(function()
{
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
    
    $('#execButton').click(function()
    {   
        $(this).text(v.lang.doing);
        $(this).addClass('disabled');

        $.getJSON($(this).attr('href'), function(response)
        {   
            if(response.result == 'finished')
            {   
                 $('#execButton').attr('href', createLink('file', 'rebuildWatermark'));
                 $('#execButton').text(v.rebuildWatermark);
                 $('#execButton').next('.total').text(response.message);
                 $('#execButton').removeClass('disabled');
                 setTimeout(function(){$('#execButton').next('.total').hide();}, 3000);
                 return false;
            }   
            else
            {   
                $('#execButton').next('.total').text(response.completed).show();
                $('#execButton').attr('href', response.next);
                return $('#execButton').click();
            }   
        }); 
        return false;
    }); 
});
