$(function()
{
    $('.color').each(function()
    {
        var $this = $(this);
        var c = $this.attr('data');
        if(!c) return;
        var cc = new Color(c).contrast().hexStr();

        ($this.hasClass('input-group') ? $this.find('.input-group-btn .dropdown-toggle') : $this).css({'background': c, 'color': cc}).find('.caret').css('border-top-color', cc);
    }).click(function()
    {
        var $this = $(this);
        if($this.hasClass('input-group')) return;
        var $plate = $this.closest('.colorplate');
        $plate.find('.color.active').removeClass('active');
        if($this.hasClass('color-tile')) $plate.find('.input-color').val($this.attr('data')).change();
        $this.addClass('active');
    });

    $('.input-color').on('keyup change', function()
    {
        var $this = $(this);
        var val = $this.val();

        $this.closest('.colorplate').find('.color.active').removeClass('active');

        if(Color.isColor(val))
        {
            var ic = (new Color(val)).contrast().hexStr();
            $this.attr('placeholder', val).closest('.color').removeClass('error').find('.input-group-btn .dropdown-toggle').css({'background': val, 'color': ic}).find('.caret').css('border-top-color', ic);;
        }
        else
        {
            $this.closest('.color').addClass('error');
        }
    });

    var $panelPreview = $('.panel-preview > .panel');
    $('#title').change(function()
    {
        $panelPreview.find('.title').text($(this).val());
    });

    $('[name="params\\[icon\\]"]').change(function()
    {
        $panelPreview.find('.icon').attr('class', 'icon ' + $(this).val());
    }).change();

    $('[name*="\\[iconColor\\]"]').change(function()
    {
        $panelPreview.find('.icon').css('color', $(this).val());
    }).change();

    $('[name*="\\[titleColor\\]"]').change(function()
    {
        $panelPreview.find('.title').css('color', $(this).val());
    }).change();

    $('[name*="\\[titleBackground\\]"]').change(function()
    {
        $panelPreview.find('.panel-heading').css('background', $(this).val());
    }).change();

    $('[name*="\\[backgroundColor\\]"]').change(function()
    {
        $panelPreview.css('background', $(this).val());
    }).change();

    $('[name*="\\[textColor\\]"]').change(function()
    {
        $panelPreview.find('.panel-body').css('color', $(this).val());
    }).change();

    $('[name*="\\[borderColor\\]"]').change(function()
    {
        $panelPreview.css('border-color', $(this).val());
        $panelPreview.find('.panel-heading').css('border-bottom-color', $(this).val());
    }).change();

    $('[name*="\\[linkColor\\]"]').change(function()
    {
        $panelPreview.find('a').css('color', $(this).val());
    }).change();

    var $form = $('.blockForm');
    $('.nav-tabs li > a').on('show.bs.tab show.zui.tab', function()
    {
        $form.attr('data-tab', $(this).attr('href').replace('#', ''));

        var height = $($(this).attr('href')).outerHeight() - 60;
        $('#panelPreview .panel').css('height', height).data('height', height);
    }).first().tab('show');

    var fixForm = function()
    {
        $('#navList').sortable({trigger: '.sort-handle-1', selector: 'li', dragCssClass: ''});
        $('#navList .ulGrade2').sortable({trigger: '.sort-handle-2', selector: 'li', dragCssClass: ''});
        $('.shut, .icon-circle').remove();
    }

    fixForm();

    /* add grade1 memu options */
    $(document).on('click', '.edit', function()
    {
        $(this).closest('li').find('.showBox:first').addClass('hide');
        $(this).closest('li').find('.editBox:first').removeClass('hide');
        fixForm();
    });
    $(document).on('click', '.plus1', function()
    {
        $(this).parent().after($('#grade1NavSource').html());
        fixForm();
    });

    /* add grade2 memu options */
    $(document).on('click', '.plus2', function() 
    {   
        var container = $(this).parents('.liGrade2');
        if(0 == container.size())
        { 
            $(this).parents('.liGrade1').find('.ulGrade2').show().prepend($('#grade2NavSource ul').html());
        }
        else
        {
            $(this).parent().after($('#grade2NavSource ul').html()); 
        }   
        e.stopPropagation();     
        fixForm();
       
    });
    /* delete nav. */
    $(document).on('click', '.remove', function()
    {
        var navCount = $(this).parent().is('.liGrade1') && $('.navList .liGrade1').size();

        if(navCount == 1)
        {
            bootbox.alert(v.cannotRemoveAll);
        }
        else 
        {
            $(this).parent().parent().parent().remove();
        }
    });

    /* toggle article common selector.*/
    $(document).on('change', '.navType', function() 
    {
        type  = $(this).val();
        grade = $(this).attr('grade');

        if(type != 'custom')
        {
            $(this).parent().children('.urlInput').hide();
            $(this).parent().children('.navSelector').hide();
            $(this).parent().children('.navSelector[name*='+type+']').removeClass('hide').show().change();
        }
        else
        {
            $(this).parent().children(':input[type=text]').val('');
            $(this).parent().children('.navSelector').hide();
            $(this).parent().children('.urlInput').removeClass('hide').show(); 
        }
    });

    /* set default nav title when selector changed. */
    $(document).on('change', '.navSelector', function()
    { 
        categories = $(this).find(':selected').text().split('/');
        if(!categories.length) return false;
        $(this).parent().children('.titleInput').val( categories[categories.length-1] );
    });
    
    $('.plus3').hide();

    $('#submit').click(function()
    {
        return submitForm();
    });

    $('[name="params\\[image\\]"]').change(function()
    {
        if($(this).prop('checked'))
        {
            $('tr.image').show();
        }
        else
        {
            $('tr.image').hide();
        }
    });

    $('[name="params\\[image\\]"]').change();

    $('[name="params\\[showType\\]"]').change(function()
    {
        if($(this).val() == 'block')
        {
            $('tr.recperrow').show();
        }
        else
        {
            $('tr.recperrow').hide();
        }
    });

    $('[name="params\\[showType\\]"]').change();
});

/**
 * Group navs and submit form
 *
 * @return void 
 */
function submitForm()
{
    $('.navList .grade1key').each(function(index,obj) { $(this).val(index); });
    $('.navList .grade2key').each(function(index){ $(this).val(1000+(parseInt(index))); })
    $('.navList .grade2parent').each(function(index){ $(this).val( $(this).closest('.liGrade1').find('.grade1key').val()); });
    $('.navList .grade3parent').each(function(i){ p = $(this).closest('.liGrade2').find('.grade2key').val(); $(this).val(p); });
}
