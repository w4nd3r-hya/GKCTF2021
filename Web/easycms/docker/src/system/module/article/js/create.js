$(document).ready(function()
{
    $('#source').change();
    $('#isLink').change();
    var parseColor = function(c)
    {
        try {return new Color(c);}
        catch(e) {return null;}
    };

    $('.color').each(function()
    {
        var $this = $(this);
        var c = $this.attr('data').replace(';', '');
        if(!c) return;
        var cc = parseColor(c);
        if(!cc) return;
        cc = cc.contrast().toCssStr();

        var $inputColor = ($this.hasClass('current') ? $this.find('.dropdown-toggle') : $this).css({'background': c === 'transparent' ? '' : c, 'color': cc}).find('.caret').css('border-top-color', cc).closest('.input-group-btn').find('.input-color');
        if(!$inputColor.attr('placeholder'))
        {
            $inputColor.attr('placeholder', c);
        }
    }).click(function()
    {
        var $this = $(this);
        if($this.hasClass('current')) return;
        var $plate = $this.closest('.input-group-btn');
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
            $this.attr('placeholder', val).prev('.color').removeClass('error').find('.dropdown-toggle').css({'background': val, 'color': ic}).find('.caret').css('border-top-color', ic);;
        }
        else
        {
            $this.closest('.color').addClass('error');
        }
    });
});
