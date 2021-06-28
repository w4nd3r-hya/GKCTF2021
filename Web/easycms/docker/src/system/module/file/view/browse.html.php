<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/view/header.modal.html.php';?>
<?php
js::import($jsRoot . 'uploader/min.js');
css::import($jsRoot . 'uploader/min.css');
?>
<style>
.icon-file-o:before {content: '\e616';}
.icon-file-text-o:before {content: '\e6d4';}
.icon-file-pdf:before {content: '\f1c1';}
.icon-file-word:before {content: '\f1c2';}
.icon-file-excel:before {content: '\f1c3';}
.icon-file-powerpoint:before {content: '\f1c4';}
.icon-file-image:before {content: '\f1c5';}
.icon-file-photo:before {content: '\f1c5';}
.icon-file-picture:before {content: '\f1c5';}
.icon-file-archive:before {content: '\f1c6';}
.icon-file-zip:before {content: '\f1c6';}
.icon-file-audio:before {content: '\f1c7';}
.icon-file-sound:before {content: '\f1c7';}
.icon-file-movie:before {content: '\f1c8';}
.icon-file-video:before {content: '\f1c8';}
.icon-file-code:before {content: '\f1c9';}
.file-size > span {display: block; text-align:left; padding-right: 0px;}
.file-info-size {min-width: 60px;}
.file-list .file[data-status=done] .actions>.btn{padding:3px 4px;}
.file-list .file[data-status=done] .actions>.btn-sort-file,
.file-list .file[data-status=done] .actions>.btn-edit-file {display: inline-block;}
.file-list .file-wrapper > .actions {width: 120px;}
#uploader {margin-bottom: 0}
.file-label-id {display: inline-block; padding: 0 2px; border: 1px solid #ccc; line-height: 14px; font-size: 12px; color: #999; margin-right: 5px;}

/* Fix upload button not work in ie9 */
#uploader {position: relative;}
.moxie-shim.moxie-shim-flash {top: auto!important; width: 90px!important; height: 34px!important; bottom: 0px!important; border: 0px solid red; Z-index: 100}
</style>
<script>
if(!$.zui.strCode)
{
    $.zui.strCode = function(str)
    {
        var code = 0;
        if(str && str.length)
        {
            for(var i = 0; i < str.length; ++i) code += i * str.charCodeAt(i);
        }
        return code;
    };
}
</script>
<div class='uploader' id='uploader' data-url='<?php echo inlink('uploadFile', "objectType=$objectType&objectID=$objectID");?>'>
  <div class='uploader-message text-center'>
    <div class='content'></div>
    <button type='button' class='close'>×</button>
  </div>
  <div class='file-list file-list-grid' data-drag-placeholder="<?php echo $lang->file->dragFile;?>"></div>
  <div>
    <div class='uploader-status pull-right text-muted'></div>
    <button type='button' class='btn btn-primary uploader-btn-browse'><i class='icon icon-plus'></i><?php echo $lang->file->addFile;?></button>
    <button type='button' class='btn btn-success uploader-btn-start'><i class='icon icon-cloud-upload'></i><?php echo $lang->file->beginUpload;?></button>
  </div>
</div>
<script>
<?php
$filesArray = array();
if(!empty($files))
{
    foreach($files as $file)
    {
        $file->url       = inlink('download', "id=$file->id");
        $file->name      = $file->title . '.' . $file->extension;
        $file->size      = filesize($this->app->getWwwRoot() . $file->fullURL);
        $file->ext       = $file->extension;
        $file->addedDate = substr($file->addedDate, 2, 14);
        $file->remoteId  = $file->id;
        if($file->isImage) $file->previewImage = $this->file->printFileURL($file, 'smallURL');
        $filesArray[] = $file;
    }
}
?>
$('#uploader').uploader(
{
	flash_swf_url: '<?php echo $jsRoot?>uploader/Moxie.swf',
	silverlight_xap_url: '<?php echo $jsRoot?>uploader/Moxie.xap',
    staticFiles: <?php echo json_encode($filesArray) ?>,
    autoResetFails: true,
    fileFormater: function($file, file, status)
    {
        $('#uploader .file-list').removeAttr('data-drag-placeholder');
        if(file.remoteData && file.remoteData.file && $.isPlainObject(file.remoteData.file))
        {
            var remoteData = file.remoteData.file;
            file.addedDate = remoteData.addedDate;
            file.addedBy   = remoteData.addedBy;
            file.downloads = remoteData.downloads;
            file.remoteId  = remoteData.id;
            file.name      = remoteData.title + '.' + remoteData.extension;
            file.url       = createLink('file', 'download', 'id=' + file.remoteId);
        }
        if(!file.downloads) file.downloads = 0;
        var downloadUrl = (status == 'done' && file.url) ? file.url : null;
        var nameText = (file.remoteId) ? ('<span class="file-label-id">#' + file.remoteId + '</span> ') : '';
        nameText += '<span>' + file.name + '</span>';
        $file.find('.file-name').html(nameText);
        var infoText = '<span class="file-info-size" data-tip-class="tooltip-in-modal" data-toggle="tooltip" title="<?php echo $lang->file->size;?>">' + (status == 'uploading' ? (window.plupload.formatSize(Math.floor(file.size*file.percent/100)).toUpperCase() + '/') : '') + window.plupload.formatSize(file.size).toUpperCase() + '</span>';
        $file.find('.file-size').html(infoText);
        if(file.static) $file.find('.file-status').hide();
        $file.find('.btn-delete-file i').removeClass('text-danger');
        if(status == 'done' && !$file.find('.btn-edit-file').length)
        {
            $file.find('.btn-delete-file').before('<button type="button" data-tip-class="tooltip-in-modal" data-toggle="tooltip" class="btn btn-link btn-edit-file" title="<?php echo $lang->edit ?>"><i class="icon icon-pencil"></i></button>');
        }
        <?php if($showSort):?>
        if(status == 'done' && !$file.find('.btn-sort-file').length)
        {
            $file.find('.btn-delete-file').after('<a href="javascript:;" class="btn-sort-file btn btn-link"><i class="icon icon-move"></i></a>');
        }
        <?php endif;?>
        $file.find('.file-icon').html(this.createFileIcon(file)).css('color', 'hsl(' + $.zui.strCode(file.type || file.ext) + ', 70%, 40%)');
        if(file.percent !== undefined) $file.find('.file-progress-bar').css('width', file.percent + '%');
        var $status = $file.find('.file-status').attr('title', this.lang[status]);

        if(status == 'uploading') $statusText = file.percent + '%';
        if(status != 'uploading') $statusText = status == 'failed' ? this.lang[status] : '';
        $status.find('.text').text($statusText);

        $file.find('a.btn-download-file, a.file-name').attr('href', downloadUrl);
        if($.fn.tooltip) $file.find('[data-toggle="tooltip"]').tooltip('fixTitle');
        sortFile();
    },
    deleteConfirm: true,
    deleteActionOnDone: function(file, doDelete)
    {
        var that = this;
        $.getJSON(createLink('file', 'delete', 'id=' + file.remoteId), function(data)
        {
            if(data.result == 'success')
            {
                doDelete();
            }
            else
            {
                that.showMessage(data.message, 'danger');
            }
        });
    },
    onBeforeUpload: function(file)
    {
        this.plupload.setOption(
        {
            'multipart_params' : 
            {
              label: file.ext ? file.name.substr(0, file.name.length - file.ext.length - 1) : file.name,
              uuid: file.id,
              size: file.size
            }
        });
    }
}).on('click', '.btn-edit-file', function()
{
    var $file  = $(this).closest('.file');
    var file   = $file.data('file');
    var url    = createLink('file', 'edit', 'id=' + file.remoteId);
    var $modal = $('#ajaxModal');
    var width  = $modal.find('.modal-dialog').width();
    $modal.load(url, function()
    {
        $modal.find('.modal-dialog').css('width', width);
        if($modal.hasClass('modal'))
        {
            $.ajustModalPosition('fit', $modal);
        }
    });
});

function sortFile()
{
    $('.file-list').sortable(
    {
        trigger: '.icon-move',
        selector: '.file',
        finish: function()
        {
            var orders = {};     
            var orderNext = 1;
            $('.file-list .file').each(function()
            {
                orders[$(this).data('id')] = orderNext ++;
            });

            $.post(createLink('file', 'sort'), orders, function(data)
            {
                if(data.result == 'success')
                {
                    $('#ajaxModal').load($('#ajaxModal').attr('ref'), function(){$.ajustModalPosition('fit', '#ajaxModal');});
                }
                else
                {
                    alert(data.message);
                    return location.reload(); 
                }
            }, 'json');
        }
    });
}
</script>
<?php include '../../common/view/footer.modal.html.php';?>
