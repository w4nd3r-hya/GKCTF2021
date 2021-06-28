$(function()
{
    var $commentForm = $('#commentForm'),
        $commentBox = $('#commentBox'),
        $commentContent = localStorage.getItem('commentContent');

    if($commentContent)
    {
        $commentForm.find('#commentContent').val($commentContent);
    }

    $.refreshCommentList = function ()
    {
        $('.pager-pull-up').removePullUpPager();
        $('#commentsListAsync').load(window.location.href + ' #commentsListWrapper', function ()
        {
            $('.pager-pull-up').initPullUpPager();
            moreRepliesHide();
            moreReliesBind();
            pupLoadBind();
        });
    };

    var pupLoadBind = function ()
    {
        $('.pager-pull-up').on('pupLoad', function ()
        {
            moreRepliesHide();
            moreReliesBind();
        });
    };
    pupLoadBind();

    $commentBox.find('.pager').on('click', 'a', function()
    {
        $commentBox.load($(this).attr('href'));
        return false;
    });

    $commentForm.ajaxform({
        onSubmit: function () 
        {
            localStorage.setItem('commentContent', $commentForm.find('#commentContent').val());
        },
        onSuccess: function(response)
        {
            if(response.result == 'success')
            {
                localStorage.setItem('commentContent', '');
                $commentForm.find('#commentContent').val('');
                setTimeout($.refreshCommentList, 200);
                $('.comment-list, .message-list').show();
            }
        }
    });

    var moreRepliesHide = function ()
    {
        $('.comment').each(function ()
        {
            var i = 0;
            $(this).children('.replies').find('.reply-heading').each(function ()
            {
                i++;
                if(i > 3) $(this).hide();
            });
            var j = 0;
            $(this).children('.replies').find('.reply-body').each(function ()
            {
                j++;
                if(j > 3) $(this).hide();
            });
            if(j > 3)
            {
                $(this).find('.more-replies-amount').html(j - 3);
            } else {
                $(this).find('.more-replies').hide();
            }
        });
    };
    moreRepliesHide();

    var moreReliesBind = function ()
    {
        $('.more-replies').on('click', function ()
        {
            $(this).hide();
            $(this).parent().parent().children('.replies').find('.reply-heading,.reply-body').show();
        });
    };
    moreReliesBind();
});
