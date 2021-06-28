{if(!defined("RUN_MODE"))} {!die()} {/if}
{!js::import($jsRoot . 'videojs/video.min.js')}
{!css::import($jsRoot . 'videojs/video-js.min.css')}
{$videoHtml = '<video id="VIDEO_ID" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" loop="loop" '}
{$videoHtml .= 'data-setup=\'{{"autoplay": VIDEO_AUTOSTART, "width": VIDEO_WIDTH, "height": VIDEO_HEIGHT, "controlBar": {{"fullscreenToggle": VIDEO_FULLSCREEN}}}}\'>'}
{$videoHtml .= '<source src="VIDEO_SRC" type="video/VIDEO_TYPE" /> </video>'}
<script>
$(function()
{
    var videoContainer = {!echo json_encode($videoHtml)};
    $('embed').each(function(index)
    {
        if($(this).hasClass('videojs')) 
        {
            var $embed      = $(this),
                src         = $embed.attr('src'),
                w           = $embed.width(),
                h           = $embed.height(),
                type        = src.match(/t=\w+/g),
                autostart   = $embed.attr('autostart'),
                fullscreen  = $embed.attr('allowfullscreen'),
                containerID = 'video_' + index;

            $container = videoContainer.replace(/VIDEO_SRC/g, src);
            $container = $container.replace(/VIDEO_WIDTH/, w);
            $container = $container.replace(/VIDEO_HEIGHT/, h);
            $container = $container.replace(/VIDEO_ID/, containerID);
            $container = $container.replace(/VIDEO_AUTOSTART/, autostart);
            $container = $container.replace(/VIDEO_FULLSCREEN/, fullscreen);
            $container = $container.replace(/VIDEO_TYPE/, type[0].replace('t=', ''));
            $(this).replaceWith($container);
        }
    })
});
</script>
