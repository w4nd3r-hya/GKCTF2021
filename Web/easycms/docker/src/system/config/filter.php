<?php
$filter = new stdclass();
$filter->rules   = new stdclass();
$filter->default = new stdclass(); 
$filter->stat    = new stdclass(); 
$filter->article = new stdclass();
$filter->blog    = new stdclass();
$filter->page    = new stdclass();
$filter->product = new stdclass();
$filter->block   = new stdclass();
$filter->book    = new stdclass();
$filter->file    = new stdclass();
$filter->search  = new stdclass();
$filter->upgrade = new stdclass();
$filter->order   = new stdclass();
$filter->user    = new stdclass();
$filter->message = new stdclass();
$filter->thread  = new stdclass();
$filter->guarder = new stdclass();
$filter->log     = new stdclass();
$filter->reply   = new stdclass();
$filter->wechat  = new stdclass();

$filter->rules->md5        = '/^[a-z0-9]{32}$/';
$filter->rules->base64     = '/^[a-zA-Z0-9\+\/\=]+$/';
$filter->rules->checked    = '/^[0-9,]+$/';
$filter->rules->idList     = '/^[0-9\|]+$/';
$filter->rules->lang       = '/^[a-zA-Z_\-]+$/';
$filter->rules->any        = '/./';
$filter->rules->number     = '/^[0-9]+$/';
$filter->rules->character  = '/^[a-zA-Z_\-]+$/';
$filter->rules->date       = '/^[0-9\-]+$/';
$filter->rules->time       = '/^[0-9\-\s\:]+$/';
$filter->rules->orderBy    = '/^\w+_(desc|asc)$/i';
$filter->rules->word       = '/^\w+$/';
$filter->rules->path       = '/(^//.|^/|^[a-zA-Z])?:?/.+(/$)?/';
$filter->rules->paramName  = '/^[a-zA-Z0-9_\.]+$/';
$filter->rules->paramValue = '/^[a-zA-Z0-9=_\-\@,`#+\^\:\/\.%\|\x7f-\xff]+$/';

$filter->default->moduleName = 'code';
$filter->default->methodName = 'code';
$filter->default->paramName  = 'reg::paramName';
$filter->default->paramValue = 'reg::paramValue';

$filter->default->get['onlybody'] = 'equal::yes';
$filter->default->get['HTTP_X_REQUESTED_WITH'] = 'equal::XMLHttpRequest';

$filter->default->get['recTotal']   = 'reg::number';
$filter->default->get['recPerPage'] = 'reg::number';
$filter->default->get['pageID']     = 'reg::number';
$filter->default->get['categoryID'] = 'reg::number';
$filter->default->get['searchWord'] = 'reg::paramValue';
$filter->default->get['fullScreen'] = 'code';
$filter->default->get['key']        = 'reg::word';

$filter->default->cookie['adminLang']    = 'reg::lang';
$filter->default->cookie['cart']         = 'reg::any';
$filter->default->cookie['currentGroup'] = 'reg::character';
$filter->default->cookie['device']       = 'reg::character';
$filter->default->cookie['lang']         = 'reg::lang';
$filter->default->cookie['adminsid']     = 'reg::word';
$filter->default->cookie['theme']        = 'reg::character';

$filter->stat->default = new stdclass(); 
$filter->stat->default->get['begin'] = 'reg::date';
$filter->stat->default->get['end']   = 'reg::date';

$filter->article->admin = new stdclass();
$filter->article->admin->get['tab'] = 'reg::character';

$filter->block->edit = new stdclass();
$filter->block->edit->get['type'] = 'reg::character';

$filter->file->filemanager = new stdclass();
$filter->file->filemanager->get['order'] = 'reg::character';
$filter->file->filemanager->get['path']  = 'reg::/^[0-9]{6}\/+$/';

$filter->file->apiforueditor = new stdclass();
$filter->file->apiforueditor->get['action'] = 'reg::word';
$filter->file->apiforueditor->get['start']  = 'reg::number';
$filter->file->apiforueditor->get['size']   = 'reg::number';

$filter->search->index = new stdclass();
$filter->search->index->get['words'] = 'reg::any';

$filter->upgrade->upgradelicense = new stdclass();
$filter->upgrade->upgradelicense->get['agree'] = 'reg::any';

$filter->order->default = new stdclass();
$filter->order->default->get['trade_status'] = 'reg::character';
$filter->order->default->get['out_trade_no'] = 'reg::number';
$filter->order->default->get['trade_no']     = 'reg::number';
$filter->order->default->get['buyer_email']  = 'email';
$filter->order->default->get['buyer_id']     = 'reg::number';
$filter->order->default->get['exterface']    = 'reg::character';
$filter->order->default->get['is_success']   = 'reg::character';
$filter->order->default->get['notify_id']    = 'reg::any';
$filter->order->default->get['notify_time']  = 'reg::time';
$filter->order->default->get['notify_type']  = 'reg::character';
$filter->order->default->get['payment_type'] = 'reg::number';
$filter->order->default->get['seller_email'] = 'email';
$filter->order->default->get['seller_id']    = 'reg::number';
$filter->order->default->get['subject']      = 'reg::any';
$filter->order->default->get['total_fee']    = 'float';
$filter->order->default->get['sign']         = 'reg::md5';
$filter->order->default->get['sign_type']    = 'equal::MD5';

$filter->user->admin         = new stdclass();
$filter->user->adminlog      = new stdclass();
$filter->user->oauthcallback = new stdclass();
$filter->user->wechatbind    = new stdclass();
$filter->user->admin->get['provider']        = 'reg::character';
$filter->user->admin->get['user']            = 'reg::any';
$filter->user->admin->get['admin']           = 'reg::number';
$filter->user->adminlog->get['account']      = 'account';
$filter->user->adminlog->get['ip']           = 'ip';
$filter->user->adminlog->get['location']     = 'reg::base64';
$filter->user->adminlog->get['date']         = 'reg::date';
$filter->user->oauthcallback->get['state']   = 'reg::base64';
$filter->user->oauthcallback->get['code']    = 'reg::base64';
$filter->user->oauthcallback->get['referer'] = 'reg::base64';
$filter->user->delete->get['admin']          = 'reg::number';
$filter->user->wechatbind->get['code']       = 'code';
$filter->user->batchdelete->get['admin']     = 'reg::number';
$filter->user->register->cookie['referer']   = 'reg::any';
$filter->user->register->cookie['guestid']   = 'reg::any';

$filter->message->default = new stdclass();
$filter->message->default->cookie['cmts'] = 'reg::any';

$filter->product->view = new stdclass();
$filter->product->view->cookie['cmts'] = 'reg::any';

$filter->product->browse = new stdclass();
$filter->product->browse->cookie['productOrderBy'] = 'array';

$filter->article->view = new stdclass();
$filter->article->view->cookie['cmts'] = 'reg::any';

$filter->article->edit = new stdclass();
$filter->article->edit->get['e'] = 'reg::character';

$filter->article->browse = new stdclass();
$filter->article->browse->cookie['articleOrderBy'] = 'array';

$filter->blog->view = new stdclass();
$filter->blog->view->cookie['cmts'] = 'reg::any';

$filter->book->default = new stdclass();
$filter->book->default->cookie['cmts'] = 'reg::any';

$filter->page->default = new stdclass();
$filter->page->default->cookie['cmts'] = 'reg::any';

$filter->thread->default = new stdclass();
$filter->thread->default->cookie['t'] = 'reg::checked';

$filter->user->default = new stdclass();
$filter->user->default->cookie['referer'] = 'reg::base64';

$filter->guarder->validate = new stdclass();
$filter->guarder->validate->cookie['validate'] = 'reg::character';

$filter->log->record = new stdclass();
$filter->log->record->cookie['vid'] = 'reg::number';

$filter->log->record->paramValue = array();
$filter->log->record->paramValue['resolution'] = 'reg::any';

$filter->reply->post = new stdclass();
$filter->reply->post->cookie['r'] = 'reg::checked';

$filter->wechat->default = new stdclass();
$filter->wechat->default->get['signature'] = 'reg::base64';
$filter->wechat->default->get['timestamp'] = 'reg::number';
$filter->wechat->default->get['nonce']     = 'reg::number';
$filter->wechat->default->get['echostr']   = 'reg::word';

$filter->source = new stdclass();
$filter->source->default = new stdclass();
$filter->source->default->get['page'] = 'reg::base64';
