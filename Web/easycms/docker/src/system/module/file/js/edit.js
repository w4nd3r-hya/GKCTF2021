$(document).ready(function()
{
    var reloadAjaxModal = function()
    {
        setTimeout(function()
        {
            var $modal = $('#ajaxModal');
            var url = $modal.attr('ref') || $modal.attr('rel');
            var $file  = $(this).closest('.file');
            var file   = $file.data('file');
            var width  = $modal.find('.modal-dialog').width();
            $modal.load(url, function()
            {
                $modal.find('.modal-dialog').css('width', width);
                if($modal.hasClass('modal'))
                {
                    $.ajustModalPosition('fit', $modal);
                }
                $('.popover').remove();
            });
        }, 1000);
    };

    $(function()
    {
        $.setAjaxForm('#fileForm', reloadAjaxModal); 
        $('.goback').on('click', reloadAjaxModal)
    })
})

