{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The html template file of download method of file module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoCMS
 * @version     $Id$
 */
/php*}
{include TPL_ROOT . 'common/header.lite.html.php'}
<div class='row' style='margin-top:100px'>
  <div class='col-md-8 col-md-offset-2'>
  {!echo $control->fetch('score', 'noscore', array('method' => 'download', 'score' => $score))}
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header.lite')}
</body>
</html>
