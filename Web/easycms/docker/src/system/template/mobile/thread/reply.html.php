{if(!defined("RUN_MODE"))} {!die()} {/if}
<div class='comments panel'>
  <div class='comment-list' style="{if(!isset($replies) || !$replies)}display:none;{/if}">
    <div class='title vertical-center'>
      <span class='vertical-line'></span>
      <span class="list-text">{$lang->reply->list}</span>
    </div>
    <div id="commentsListAsync">
      <div id="commentsListWrapper">
        <div class='condensed bordered' id="commentsList">
          {foreach($replies as $number => $reply)}
          <div class='comment'>
            <div class='comment-heading vertical-center'>
              <div class='left vertical-center'>
                <div class="avatar vertical-center text-muted">
                  {if(empty($reply->avatar))}
                  <i class="icon icon-user icon-10x"></i>
                  {else}
                  <img src="{$reply->avatar}" alt="">
                  {/if}
                </div>
                <div class="comment-ext">
                  <span class="authorName"> {$reply->author} </span>
                  <span class="addedDate">{!formatTime($reply->addedDate)}</span>
                </div>
              </div>
              <div class='actions reply-text'>
                {if($control->app->user->account != 'guest')}
                <a href='#replyDialog' data-toggle='modal' data-reply-id='{$reply->id}' class='text-muted thread-reply-btn'>{$lang->reply->reply}</a>
                {else}
                <a href="{!$control->createLink('user', 'login', 'referer=' . helper::safe64Encode($control->app->getURI(true)))}#reply" class="thread-reply-btn text-muted">{$lang->reply->reply}</a>
                {/if}
              </div>
            </div>
            <div class="comment-content">{!nl2br($reply->content)}</div>
            {$control->reply->getRepliesByReply($reply)}
          </div>
          {/foreach}
        </div>
        <div id="paginator">
          {$pager->createPullUpJS('#commentsList', $lang->mobile->pullUpHint)}
        </div>
      </div>
    </div>
  </div>
  <div class='comment-post vertical-center'>
    <form class='comment-form vertical-center' method='post' id='commentForm' action='{$control->createLink("reply", "post", "thread=$thread->id")}'>
      <div class='form-group required'>
        <input class="comment-input" type="text" name="content" id="commentContent" value="" rows="5" placeholder="&nbsp&nbsp{$lang->reply->inputPlaceholder}">
      </div>
      <div class='form-group'>
        {if($control->app->user->account != 'guest')}
        <input type="submit" class="submitComment" id="submitComment" value="{$lang->reply->post}" data-loading="{$lang->reply->submitting}...">
        {else}
        <a href="{!$control->createLink('user', 'login', 'referer=' . helper::safe64Encode($control->app->getURI(true)))}#reply" class="thread-reply-btn text-muted submitComment">{$lang->reply->post}</a>
        {/if}
      </div>
    </form>
  </div>
</div>

{if(!$thread->readonly)}
<div class='modal fade' id='replyDialog'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
        <h5 class='modal-title'><i class='icon-reply'></i> {$lang->reply->common}</h5>
      </div>
      <div class='modal-body'>
        <form method='post' enctype='multipart/form-data' id='replyForm' action='{$control->createLink("reply", "post", "thread=$thread->id")}'>
          <div class='form-group' id='reply-content'>
            {!html::textarea('content', '', "rows='6' class='form-control' placeholder='{{$lang->reply->content}}'")}
          </div>
          <div class='form-group clearfix captcha-box hide'></div>
          <div class='form-group'>{!html::submitButton('', 'btn primary block')}</div>
          {!html::hidden('reply', 0)}
        </form>
      </div>
    </div>
  </div>
</div>
{/if}

{include TPL_ROOT . 'common/form.html.php'}

{noparse}
<style>
input:focus, textarea:focus {outline: none;}
.comments {margin-top: 12px;}
.comments .comment {margin-bottom: 5px;}
.comments .comment-heading {justify-content: space-between; height: 32px; margin: 16px 0;}
.comments .comment-input {border-radius: 3px; border: 0; background-color: #F3F3F3; height: 30px; width: 243px; font-size: 12px;}
.comments .comment-post {width: 100%; height: 50px; background-color: #ffffff; position: fixed; bottom: 50px; border: 1px solid #f8f8f8; padding: 0 10px;}
.comments .comment-form {width: 100%; justify-content: space-between;}
.comments .comment-form .submitComment {border-radius: 2px; background: linear-gradient(to left, #1B5AFF, #709BFE);; height: 30px; font-size: 14px; margin: auto; color: white; font-weight: bold; border: 0; padding: 8px 14px; line-height: 10px; text-align: center; vertical-align: middle;}
.comments .comment-content {margin-left: 42px; word-break: break-all;}
.comments .vertical-line {float: left; width: 2px; height: 14px; background: #3C77FE;}
.comments .vertical-center {display: flex; display: -webkit-flex; align-items: center;}
.comments .form-group {margin-bottom: 0;}
.comments .comment-list {padding: 13px 12px; background-color: #FFFFFF;}
.comments .list-text {margin-left: 4px; font-size: 16px;}
.comments .avatar img {border-radius: 3px; width: 32px; height: 32px;}
.comments .avatar i {border-radius: 3px; font-size: 40px;}
.comments .comment-ext {margin-left: 10px; display: flex; flex-direction: column; justify-content: space-between;}
.comments .authorName {color: #333333; font-size: 14px;}
.comments .addedDate {color: #999999; font-size: 13px;}
.comments .reply-text {margin-top: -20px;}
.comments .reply-text a {color: #999999; font-size: 12px;}
.comments .replies {border-radius: 3px; margin: 8px 0 0 42px; background-color: #F0F0F0;}
.comments .replies .arrow {display: inline-block; border-radius: 2px; width: 0; height: 0; margin: 0 4px; border-top: 4px solid transparent; border-bottom: 4px solid transparent; border-left: 6px solid gray;}
.comments .replies .more-replies {font-size: 12px; color: #3C77FE; margin: 0 0 0 12px; height: 24px; width: 40%;}
.comments .reply-panel {justify-content: space-between;}
.comments .reply-panel .replies {border-radius: 0; margin: 0; background-color: #F0F0F0;}
.comments .reply-panel .text-primary {color: #333333; font-size: 12px; display: flex; align-items: center;}
.comments .reply-panel .text-muted {color: #999999; font-size: 12px;}
.comments .reply-panel a {color: #999999; font-size: 12px;}
.comments .reply-panel .reply-heading {margin: 0 12px 0 12px; justify-content: space-between; height: 30px;}
.comments .reply-panel .reply-heading .reply-ext {display: inline-flex;}
.comments .reply-panel .reply-heading .text-muted {margin-left: 12px;}
.comments .reply-panel .reply-body {color: #676767; font-size: 12px; margin: 0 12px 5px 12px; word-break: break-all;}
</style>
<script>
    $(function()
    {
        var $commentForm = $('#commentForm'),
            $commentBox = $('#commentBox'),
            $replyForm = $('#replyForm'),
            $commentContent = localStorage.getItem('commentContent');

        if($commentContent)
        {
            $commentForm.find('#commentContent').val($commentContent);
        }

        $.refreshCommentList = function ()
        {
            $('.pager-pull-up').removePullUpPager();
            console.log(window.location.href);
            $('#commentsListAsync').load(window.location.href + ' #commentsListWrapper', function ()
            {
                $('.pager-pull-up').initPullUpPager();
                moreRepliesHide();
                moreReliesBind();
                pupLoadBind();
                threadReplyBtnBind();
            });
        };

        var threadReplyBtnBind = function ()
        {
            $('.thread-reply-btn').on('click', function ()
            {
                $('#reply').val($(this).data('reply-id'));
            });
        };
        threadReplyBtnBind();

        var pupLoadBind = function ()
        {
            $('.pager-pull-up').on('pupLoad', function ()
            {
                moreRepliesHide();
                moreReliesBind();
                threadReplyBtnBind();
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
                    $('.comment-list').show();
                }
            }
        });

        $replyForm.ajaxform({
            onSubmit: function ()
            {
                localStorage.setItem('replyContent', $replyForm.find('#content').val());
            },
            onResultSuccess: function()
            {
                localStorage.setItem('replyContent', '');
                $replyForm.find('#content').val('');
                $('#replyDialog').modal('hide');
                setTimeout($.refreshCommentList, 200);
            },
            onSuccess: function(response)
            {
                if(response.reason == 'needChecking')
                {
                    $replyForm.find('.captcha-box').html(Base64.decode(response.captcha)).removeClass('hide');
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
</script>
{/noparse}

