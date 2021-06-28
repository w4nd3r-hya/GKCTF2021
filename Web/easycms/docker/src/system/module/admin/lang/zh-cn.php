<?php if(!defined("RUN_MODE")) die();?>
<?php 
$lang->admin->common        = '后台管理';
$lang->admin->index         = '首页';
$lang->admin->checked       = '已认证';

$lang->admin->getEmailCodeByApi  = '获取邮箱验证码';
$lang->admin->getMobileCodeByApi = '获取手机验证码';

$lang->admin->shortcuts = new stdclass();
$lang->admin->shortcuts->common             = '快捷入口';
$lang->admin->shortcuts->articleCategories  = '文章类目';
$lang->admin->shortcuts->article            = '发布文章';
$lang->admin->shortcuts->product            = '添加产品';
$lang->admin->shortcuts->feedback           = '处理反馈';
$lang->admin->shortcuts->site               = '站点设置';
$lang->admin->shortcuts->logo               = 'LOGO设置';
$lang->admin->shortcuts->company            = '公司信息';
$lang->admin->shortcuts->contact            = '联系方式';

$lang->admin->thread       = '最新帖子';
$lang->admin->order        = '最新订单';
$lang->admin->feedback     = '最新反馈';

$lang->admin->adminEntry     = '警告：您现在的管理入口还是默认的admin.php，建议将admin.php改名以增强系统安全!';

$lang->admin->connectApiFail = "不能连接到蝉知社区，请检查您的网络设置后 <a href='javascritp:loaction.reload()'>重试</a>。";
$lang->admin->registerInfo   = "站点已经绑定到蝉知账号%s，%s";
$lang->admin->registerPage   = '登记页面';
$lang->admin->rebind         = "重新绑定";
$lang->admin->bindedInfo     = '蝉知社区账号信息';

$lang->js->confirmRebind = "确认要重新绑定蝉知账号？";

$lang->admin->community = new stdclass();
$lang->admin->community->common     = '蝉知社区';
$lang->admin->community->caption    = '没有蝉知社区账号？马上注册一个!';
$lang->admin->community->lblAccount = '请设置您的用户名，英文字母和数字的组合，三位以上。';
$lang->admin->community->lblPasswd  = '请设置您的密码。数字和字母的组合，六位以上。';
$lang->admin->community->submit     = '注册';
$lang->admin->community->success    = "注册账户成功";
$lang->admin->community->update     = "更新资料";

$lang->admin->bind = new stdclass();
$lang->admin->bind->caption = '已有蝉知社区账号，输入用户名密码进行绑定！';
$lang->admin->bind->submit  = '绑定账号';
$lang->admin->bind->success = "关联账户成功";
