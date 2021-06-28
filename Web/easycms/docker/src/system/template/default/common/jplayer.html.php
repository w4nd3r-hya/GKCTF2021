{if(!defined("RUN_MODE"))} {!die()} {/if}
{!js::import($jsRoot . 'jplayer/dist/jplayer/jquery.jplayer.min.js')}
{!css::import($jsRoot . 'jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css')}
 
<script>
$(function()
{
    $('embed').hide().each(function(index)
    {
        var $embed        = $(this),
            src           = $embed.attr('src'),
            w             = $embed.width(),
            h             = $embed.height(),
            containerID   = 'media_container_' + index,
            id            = 'media_' + index,
            reg           = /\.flv$|\.flv\?|=flv$|=flv\?|\.webm$|\.webm\?|=webm$|=webm\?|\.wmv$|\.rtmp\?|=wmv$|=rtmp\?|\.rtmp$|\.mp3\?|\.mp3$|=mp3\?|=mp3$|\.ogg\?|\.ogg$|=ogg\?|=ogg$|\.mp4\?|\.mp4$|=mp4\?|=mp4$/,
            mediaType     = reg.exec(src),
            mediaTypeList = null,
            mediaSetting  = {title: ''};

        if(mediaType)
        {
            mediaType     = mediaType.toString().replace('.', '').replace('=', '').replace('?', '');
            mediaTypeList = {!echo json_encode($control->config->file->mediaTypes)};
            mediaType     = mediaTypeList[mediaType.toLowerCase()];
        }

        if(mediaType && typeof mediaType == 'string')
        {
            var $playerContainer = $('#playerTemplate').clone().removeClass('hide').attr('id', containerID).css('width', w + 2);
            var $player = $("<div id='" + id + "'  class='jp-player text-center' data-src='" + src + "' style='margin: 0 auto;'></div>").prependTo($playerContainer.children('.jp-type-single'));
            $embed.replaceWith($playerContainer);

            mediaSetting[mediaType] = src;
            
            $player.jPlayer(
            {
                ready: function()
                {
                    console.log('mediaSetting', mediaSetting);
                    $player.jPlayer("setMedia", mediaSetting);
                },
                play: function() { $player.jPlayer("pauseOthers"); },
                swfPath: "/js/jplayer/dist/jplayer",
                supplied: mediaType,
                size: { width: w, height: h, cssClass: "jp-video-720p" },
                useStateClassSkin: true,
                autoBlur: false,
                smoothPlayBar: true,
                keyEnabled: true,
                remainingDuration: true,
                cssSelectorAncestor: '#' + containerID,
                toggleDuration: true
            });
        }
        else
        {
            $embed.show();
        }
    })
});
</script>
<div class="hide jp-video jp-video-360p" role="application" aria-label="media player" id="playerTemplate">
  <div class="jp-type-single">
    <div class="jp-gui">
      <div class="jp-video-play">
        <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
      </div>
      <div class="jp-interface">
        <div class="jp-progress">
          <div class="jp-seek-bar">
            <div class="jp-play-bar"></div>
          </div>
        </div>
        <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
        <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
        <div class="jp-controls-holder">
          <div class="jp-controls">
            <button class="jp-play" role="button" tabindex="0">play</button>
            <button class="jp-stop" role="button" tabindex="0">stop</button>
          </div>
          <div class="jp-volume-controls">
            <button class="jp-mute" role="button" tabindex="0">mute</button>
            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
            <div class="jp-volume-bar">
              <div class="jp-volume-bar-value"></div>
            </div>
          </div>
          <div class="jp-toggles">
            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
            <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
          </div>
        </div>
        <div class="jp-details">
          <div class="jp-title" aria-label="title">&nbsp;</div>
        </div>
      </div>
    </div>
    <div class="jp-no-solution">
        <span>Update Required</span>
        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
    </div>
  </div>
</div>
