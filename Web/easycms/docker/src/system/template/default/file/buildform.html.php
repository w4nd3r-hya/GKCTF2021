{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(!$writeable)}
  <h5 class='text-danger a-left'> {$control->lang->file->errorUnwritable} </h5>
{else}
  <div class="file-form" id='fileform'>
    {$fileRow = " <table class='fileBox' id='fileBox\$i'>"}
    {$fileRow .= "<tr>"}
    {$fileRow .= "  <td class='w-p45'><div class='form-control file-wrapper'><input type='file' name='files[]' class='fileControl'  tabindex='-1' /></div></td>"}
    {$fileRow .= "  <td class=''><input type='text' name='labels[]' class='form-control' placeholder='{{$lang->file->label}}' tabindex='-1' /></td>"}
    {$fileRow .= "  <td class='w-30px'><a href='javascript:;' onclick='addFile(this)' class='btn btn-block'><i class='icon-plus'></i></a></td>"}
    {$fileRow .= "  <td class='w-30px'><a href='javascript:;' onclick='delFile(this)' class='btn btn-block'><i class='icon-remove'></i></a></td>"}
    {$fileRow .= "</tr>"}
    {$fileRow .= "</table>"}
    {for($i = 1; $i <= $fileCount; $i ++)} {!str_replace('$i', $i, $fileRow)} {/for}
    {$fileLimit = trim(ini_get('upload_max_filesize'), 'M') > trim(ini_get('post_max_size'), 'M') ? trim(ini_get('post_max_size'), 'M') : trim(ini_get('upload_max_filesize'), 'M')}
    {if(!is_numeric($fileLimit))} {$fileLimit = $control->config->file->maxSize / 1024 / 1024} {/if}
    {!printf($lang->file->sizeLimit, $fileLimit)}
  </div>
{/if}
<script>
/**
 * Add a file input control.
 * 
 * @param  object $clickedButton 
 * @access public
 * @return void
 */
function addFile(clickedButton)
{
    fileRow = {!json_encode($fileRow)};
    fileRow = fileRow.replace('$i', $('.fileID').size() + 1);
    $(clickedButton).closest('.fileBox').after(fileRow);

    updateID();
}

{noparse}
/**
 * Delete a file input control.
 * 
 * @param  object $clickedButton 
 * @access public
 * @return void
 */
function delFile(clickedButton)
{
    if($('.fileBox').size() == 1) return;
    $(clickedButton).closest('.fileBox').remove();
    updateID();
}

/**
 * Update the file id labels.
 * 
 * @access public
 * @return void
 */
function updateID()
{
    i = 1;
    $('.fileID').each(function(){$(this).html(i ++)});
}
{/noparse}
</script>
