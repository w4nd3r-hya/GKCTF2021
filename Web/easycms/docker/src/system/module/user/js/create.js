$().ready(function()
{
    appendFingerprint('#ajaxForm');
    $('[name^=admin]').change(function()
    {
        $(this).parents('tr').next().toggle();
    });
});
