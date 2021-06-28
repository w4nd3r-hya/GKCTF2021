{if(!defined("RUN_MODE"))} {!die()} {/if}
<table class='table-1 f-12px' align='center'>
  <caption>{!echo $lang->file->browse}</caption>
  <tr>
    <th>{!echo $lang->file->id}</th>
    <th>{!echo $lang->file->title}</th>
    <th>{!echo $lang->file->extension}</th>
    <th>{!echo $lang->file->size}</th>
    <th>{!echo $lang->file->addedDate}</th>
    <th>{!echo $lang->file->public}</th>
    {if(commonModel::isAvailable('score'))}
    <th>{!echo $lang->file->score}</th>
    {/if}
    <th>{!echo $lang->file->downloads}</th>
    <th>{!echo $lang->file->download}</th>
  </tr>
  {$i = 1}
  {foreach($files as $file)}
  <tr class='a-center'>
    <td>{!echo $i ++}</td>
    <th class='a-left'>{!html::a($control->createLink('file', 'download', "id=$file->id"), $file->title, $file->isImage ? "target='_blank'" : '')}</th>
    <td>{!echo $file->extension}</td>
    <td>{!echo $file->size}</td>
    <td>{!echo $file->addedDate}</td>
    <td>{$file->public or (!$file->public and $app->user->account != 'guest') ? print($lang->file->publics[$file->public]) : print(html::a($control->createLink('user', 'login'), $lang->file->publics[$file->public]))}</td>
    {if(commonModel::isAvailable('score'))}
    <td>{!echo $file->score}
    {/if}
    <td>{!echo $file->downloads}</td>
    <td>{!html::a($control->createLink('file', 'download', "id=$file->id"), $lang->file->download, $file->isImage ? "target='_blank' class='red'" : "class='red'")}</td>
  </tr>
  {/foreach}
  {if(commonModel::isAvailable('score'))}
  <tr><td colspan='9'>{!printf($lang->file->lblInfo, $control->loadModel('user')->getByAccount($app->user->account)->score)}</td></tr>
  {/if}
</table>
