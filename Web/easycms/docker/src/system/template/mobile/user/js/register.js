$(function()
{
    if(v.agreement == 'open')
    {
        $('#submit').attr("disabled",true);
        $("input[name=agreement]").change(function()
        {
            if($('input[name=agreement]').prop('checked'))
            {
                $('#submit').removeAttr("disabled");
            }
            if(!$('input[name=agreement]').prop('checked'))
            {
                $('#submit').attr("disabled", true);
            }
        });
    }
});
