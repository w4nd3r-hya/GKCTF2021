{if(!defined("RUN_MODE"))} {!die()} {/if}
{include TPL_ROOT . 'common/header.modal.html.php'}
<table class='table table-bordered'>
  <thead>
    <tr>
      <th class='text-center'>{!echo $lang->file->id}</th>
      <th class='text-center'>{!echo $lang->file->common}</th>
      <th class='text-center'>{!echo $lang->file->extension}</th>
      <th class='text-center'>{!echo $lang->file->size}</th>
      <th class='text-center'>{!echo $lang->file->addedBy}</th>
      <th class='text-center'>{!echo $lang->file->addedDate}</th>
      <th class='text-center'>{!echo $lang->file->downloads}</th>
      <th class='text-center'>{!echo $lang->actions}</th>
    </tr>          
  </thead>
  <tbody>
    {foreach($files as $file)}
    <tr class='text-middle'>
      <td>{!echo $file->id}</td>
      <td>
        {if($file->isImage)
            {!html::a(inlink('download', "id=$file->id"), html::image($control->loadModel('file')->printFileURL($file, 'smallURL'), "class='image-small' title='{$file->title}'"), "target='_blank'")}
            {if($file->primary == 1)} {!echo '<small class="label label-success">'. $lang->file->primary .'</small>'} {/if}
        {else}
            {!html::a(inlink('download', "id=$file->id"), "{$file->title}.{$file->extension}", "target='_blank'")}
        {/if}
      </td>
      <td>{!echo $file->extension}</td>
      <td>{!echo $file->size}</td>
      <td>{!echo $file->addedBy}</td>
      <td>{!echo $file->addedDate}</td>
      <td>{!echo $file->downloads}</td>
      <td>
      {!html::a(inlink('edit',   "id=$file->id"), $lang->edit, "class='edit'")}
      {!html::a(inlink('delete', "id=$file->id"), $lang->delete, "class='deleter'")}
      {if($file->isImage)} {!html::a(inlink('setPrimary', "id=$file->id"), $lang->file->setPrimary, "class='option'")} {/if}
      </td>
    </tr>
    {/foreach}          
  </tbody>

</table>
<form id="fileForm" method='post' enctype='multipart/form-data' action='{!inlink('upload', "objectType=$objectType&objectID=$objectID")}'>
  <table class='table table-form'>
    {if($writeable)}
    <tr>
      <td class='text-middle'>{!echo $lang->file->upload . sprintf($lang->file->limit, $control->config->file->maxSize / 1024 /1024)}</td>
      <td>{!echo $control->fetch('file', 'buildForm')}</td>
    </tr>
    <tr><td colspan='2' class='text-center'>{!html::submitButton()}</td></tr>
    {else}
    <tr><td colspan='2'><h5 class='text-danger'>{!echo $lang->file->errorUnwritable}</h5></td></tr>
    {/if}
  </table>
</form>
{include TPL_ROOT . 'common/footer.modal.html.php'}
