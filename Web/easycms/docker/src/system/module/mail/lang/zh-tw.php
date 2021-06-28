<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->mail->common = '發信設置';
$lang->mail->index  = '首頁';
$lang->mail->detect = '檢測';
$lang->mail->edit   = '編輯配置';
$lang->mail->save   = '成功保存';
$lang->mail->test   = '測試發信';
$lang->mail->reset  = '重置';

$lang->mail->turnon       = '是否打開';
$lang->mail->fromAddress  = '發信郵箱';
$lang->mail->fromName     = '發信人';
$lang->mail->mta          = '發信方式';
$lang->mail->host         = 'smtp伺服器';
$lang->mail->port         = 'smtp連接埠號';
$lang->mail->auth         = '是否需要驗證';
$lang->mail->username     = 'smtp帳號';
$lang->mail->password     = 'smtp密碼';
$lang->mail->secure       = '是否加密';
$lang->mail->debug        = '調試級別';
$lang->mail->getEmailCode = '獲取郵箱驗證碼';

$lang->mail->turnonList[1] = '打開';
$lang->mail->turnonList[0] = '關閉';

$lang->mail->debugList[0] = '關閉';
$lang->mail->debugList[1] = '一般';
$lang->mail->debugList[2] = '較高';

$lang->mail->authList[1] = '需要';
$lang->mail->authList[0] = '不需要';

$lang->mail->secureList['']    = '不加密';
$lang->mail->secureList['ssl'] = 'ssl';
$lang->mail->secureList['tls'] = 'tls';

$lang->mail->inputFromEmail = '請輸入發信郵箱：';
$lang->mail->nextStep       = '下一步';
$lang->mail->successSaved   = '配置信息已經成功保存。';
$lang->mail->subject        = '測試郵件';
$lang->mail->content        = '郵箱設置成功';
$lang->mail->sending        = "郵件正在發往%s,請稍侯...";
$lang->mail->successSended  = '郵件已發送到 %s';
$lang->mail->needConfigure  = '無法找到郵件配置信息，請先配置郵件發送參數。';
$lang->mail->error          = '你的郵箱地址有誤，請填寫正確的郵箱地址。'; 
$lang->mail->trySendlater   = '三分鐘內不能重複發送郵件。'; 

$lang->mail->captcha     = '驗證碼';
$lang->mail->sendContent = <<<EOT
<p>%s 您好：</p>
<p>您在<strong>%s</strong>(%s)上面的驗證碼為：%s </p>
<p>如非您本人操作，請忽略。</p>
<p> <a style="color:gray;font-size:12px;text-decoration:none" href="http://www.chanzhi.org" target="_blank">Powerd By 蟬知</a> </p>
EOT;
