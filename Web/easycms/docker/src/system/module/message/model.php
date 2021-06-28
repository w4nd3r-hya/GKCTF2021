<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of message module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class messageModel extends model
{
    /**
     * Get message by ID.
     *
     * @param  int    $messageID
     * @access public
     * @return object
     */
    public function getByID($messageID)
    {
        return $this->dao->select('*')->from(TABLE_MESSAGE)->findByID($messageID)->fetch();
    }

    /**
     * Get message list By Account
     *
     * @param  string    $account
     * @param  object    $pager
     * @access public
     * @return array
     */
    public function getByAccount($account, $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_MESSAGE)
            ->where('`to`')->eq($account)
            ->orderBy('id_desc')
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * Get unread By Account
     *
     * @param  string    $account
     * @access public
     * @return int
     */
    public function getUnreadByAccount($account)
    {
        return $this->dao->select('1')->from(TABLE_MESSAGE)
            ->where('`to`')->eq($account)
            ->AndWhere('readed')->eq(0)
            ->count();
    }

    /**
     * Get messages of one object.
     *
     * @param  string $type          the message type
     * @param  string $objectType    the object type
     * @param  int    $objectID      the object id
     * @access public
     * @return array
     */
    public function getByObject($type, $objectType, $objectID, $pager = null)
    {
        $userMessages = $this->cookie->cmts;
        $userMessages = trim($userMessages, ',');
        $idList       = explode(',', $userMessages);
        if(empty($userMessages)) $userMessages = '0';

        foreach($idList as $id) 
        {
            if(!is_numeric($id)) $userMessages = '0';
        }

        return  $this->dao->select('u.realname, u.nickname, u.avatar, m.id, m.from, m.content, m.date')->from(TABLE_MESSAGE)->alias('m')
            ->leftJoin(TABLE_USER)->alias('u')->on('m.account=u.account')
            ->where('m.type')->eq($type)
            ->beginIf(RUN_MODE == 'front' and $type == 'message')->andWhere('m.public')->eq(1)->fi()
            ->andWhere('m.objectType')->eq($objectType)
            ->andWhere('m.objectID')->eq($objectID)
            ->beginIF(defined('RUN_MODE') and RUN_MODE == 'front')->andWhere("(m.id in ({$userMessages}) or (m.status = '1'))")->fi()
            ->orderBy('m.id_desc')
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get all replies of a message for front.
     *
     * @param  object  $message
     * @param  string  $type
     * @param  int     $level
     * @access public
     * @return null
     */
    public function getFrontReplies($message, $type = '', $level = 0)
    {
        $replies = $this->getReplies($message);

        if(!empty($replies))
        {
            if($this->app->clientDevice == 'mobile')
            {
                $level++;
                echo "<div class='replies'>";
                foreach($replies as $reply)
                {
                    $replyTo = $level > 1 ? '<div class="arrow"></div>' . $reply->to : '';
                    echo "<div class='reply-panel'>";
                    echo "<div class='reply-heading vertical-center'>";
                    echo "<div class='reply-ext'>";
                    echo "<span class='text-primary'>{$reply->from}{$replyTo}</i> </span>";
                    echo "<span class='text-muted'>" . $reply->date . "</span>";
                    echo "</div>";
                    echo html::a(helper::createLink('message', 'reply', "id={$reply->id}"), $this->lang->message->reply, " data-toggle='modal' data-type='iframe' class='pull-right' id='reply{$reply->id}' data-icon='reply' data-title='{$this->lang->message->reply}'");
                    echo '</div>';
                    echo "<div class='reply-body'>";
                    echo nl2br($reply->content);
                    echo '</div>';
                    $this->getFrontReplies($reply, '', $level);
                    echo "</div>";
                }
                echo $level == 1 ? '<div class="more-replies">' . $this->lang->message->moreReplies . '</div>' : '';
                echo '</div>';
            }
            elseif($type !== 'simple')
            {
                echo "<div class='replies'>";
                foreach($replies as $reply)
                {
                    echo "<div class='reply-panel'>";
                    echo "<div class='panel-heading reply-heading'>";
                    echo "<span class='text-primary'><i class='icon icon-reply'> {$reply->from}</i> </span>";
                    echo "<span class='text-muted'>" . $reply->date . "</span>";
                    echo html::a(helper::createLink('message', 'reply', "id={$reply->id}"), $this->lang->message->reply, " data-toggle='modal' data-type='iframe' class='pull-right' id='reply{$reply->id}' data-icon='reply' data-title='{$this->lang->message->reply}'");
                    echo '</div>';
                    echo "<div class='panel-body'>";
                    echo nl2br($reply->content);
                    echo '</div>';
                    $this->getFrontReplies($reply);
                    echo "</div>";
                }
                echo "</div>";
            }
            else
            {
                echo "<div class='replies'>";
                foreach($replies as $reply)
                {
                    echo "<div class='reply card'>";

                    echo "<div class='card-heading'>";
                    echo "<span class='text-primary'><i class='icon-reply'></i> {$reply->from}</span> &nbsp; <small class='text-muted'>" . formatTime($reply->date, 'Y/m/d H:m') . "</small>";
                    echo "<div class='actions'>" . html::a(helper::createLink('message', 'reply', "id={$reply->id}"), $this->lang->message->reply, " data-toggle='modal' data-type='ajax' id='reply{$reply->id}'") . "</div>";
                    echo '</div>';

                    echo "<div class='card-content'>" . nl2br($reply->content) . "</div>";

                    $this->getFrontReplies($reply, $type);

                    echo '</div>';
                }
                echo '</div>';
            }
        }
    }

    /**
     * Get replies of a message.
     *
     * @param  object  $message
     * @access public
     * @return array
     */
    public function getReplies($message)
    {
        $userMessages = $this->cookie->cmts;
        $userMessages = trim($userMessages, ',');
        $idList       = explode(',', $userMessages);
        if(empty($userMessages)) $userMessages = '0';

        foreach($idList as $id) 
        {
            if(!is_numeric($id)) $userMessages = '0';
        }

        if(!$message) return false;
        return $this->dao->select('*')->from(TABLE_MESSAGE)
            ->where('type')->eq('reply')
            ->andWhere('objectID')->eq($message->id)
            ->beginIF(defined('RUN_MODE') and RUN_MODE == 'front')->andWhere("(id in ({$userMessages}) or (status = '1'))")->fi()
            ->orderBy('id_asc')
            ->fetchAll();
    }

    /**
     * Get original message.
     *
     * @param  int    $messageID
     * @access public
     * @return bool | object
     */
    public function getOriginal($messageID)
    {
        $message = $this->dao->select('*')->from(TABLE_MESSAGE)->where('id')->eq($messageID)->fetch();
        if(strpos('message,reply,comment', $message->objectType) === false or $message->objectID == 0) return false;

        $original = $this->dao->select('*')->from(TABLE_MESSAGE)->where('id')->eq($message->objectID)->fetch();

        $original->objectTitle   = $this->getObjectTitle($original);
        $original->objectViewURL = $original->type == 'message' ? $this->getObjectLink($original) : '';
        return $original;
    }

    /**
     * Get objectTitle. 
     * 
     * @param  object    $message 
     * @access public
     * @return string
     */
    public function getObjectTitle($message)
    {
        if($message->objectType == 'message' or $message->objectType == 'comment') return zget($this->getByID($message->objectID), 'from', '');
        if($message->objectType == 'article') $objectTitle = $this->dao->select('title')->from(TABLE_ARTICLE)->where('id')->eq($message->objectID)->fetch('title');
        if($message->objectType == 'product') $objectTitle = $this->dao->select('name')->from(TABLE_PRODUCT)->where('id')->eq($message->objectID)->fetch('name');
        if($message->objectType == 'book')    $objectTitle = $this->dao->select('title')->from(TABLE_BOOK)->where('id')->eq($message->objectID)->fetch('title');
        return isset($objectTitle) ? $objectTitle : '';
    }

    /**
     * Get reply of message. 
     * 
     * @param  int    $messageID 
     * @access public
     * @return bool | object 
     */
    public function getReply($messageID)
    {
        return $this->dao->select('*')->from(TABLE_MESSAGE)->where('objectID')->eq($messageID)
            ->andWhere('objectType')->in('message,reply,comment')
            ->fetch();
    }

    /**
     * Get object of a message.
     *
     * @param  object  $message
     * @access public
     * @return array
     */
    public function getObject($message)
    {
        $object = $this->dao->select('*')->from(TABLE_MESSAGE)->where('id')->eq($message->objectID)->fetch();
        if(!$object) return false; 
        echo "<dl class='alert'>";
        printf($this->lang->message->messageItem, $object->from, $object->date, $object->content);
        echo "</dl>";
    }

    /**
     * Get message list.
     *
     * @param string $type      the message type
     * @param int    $status    the message status
     * @param object $pager
     * @access public
     * @return void
     */
    public function getList($type, $status, $pager = null)
    {
        if($type == 'reply')
        {
            $messages = $this->dao->select('*')->from(TABLE_MESSAGE)->orderBy('id_desc')->fetchAll('id');

            /* Get message id list with replies. */
            $messagesWithReply = array();
            foreach($messages as $message)
            {
                $object = zget($messages, $message->objectID, null) ;
                if(empty($object)) continue;
                if($message->type == 'reply' and $object->type != 'reply')
                {
                    $messagesWithReply[] = $message->objectID;
                }
            }

            $messageIDList = $this->dao->select('id')->from(TABLE_MESSAGE)
                ->where('id')->notin($messagesWithReply)
                ->andWhere('type')->eq('reply')
                ->andWhere('status')->eq($status)
                ->beginIf(RUN_MODE == 'front')->andWhere('public')->eq(1)->fi()
                ->orderBy('id_desc')
                ->page($pager)
                ->fetchAll('id');

            foreach($messages as $key => $message)
            {   
                if(!isset($messageIDList[$message->id])) unset($messages[$key]);
            }   
        }
        else
        {
            $messages = $this->dao->select('*')->from(TABLE_MESSAGE)
                ->where('status')->eq($status)
                ->beginIF($type != 'all')
                ->andWhere('type')->eq($type)
                ->fi()
                ->orderBy('id_desc')
                ->page($pager)
                ->fetchAll('id');
            
        }
        $messages = $this->getTitlesByList($messages);

        foreach($messages as $message) $message->objectViewURL = $this->getObjectLink($message);

        return $messages;
    }

    /**
     * Get object title of messages.
     * 
     * @param  array    $messages 
     * @access public
     * @return array
     */
    public function getTitlesByList($messages)
    {
        $objects = array();
        $titles  = array();

        foreach($messages as $message)
        {
            $objects[$message->objectType][] = $message->objectID;
        }

        foreach($objects as $type => $objectList)
        {
            if($type == 'article') $titles[$type] = $this->dao->select('id, title')->from(TABLE_ARTICLE)->where('id')->in($objectList)->fetchPairs('id', 'title');
            elseif($type == 'product') $titles[$type] = $this->dao->select('id, name')->from(TABLE_PRODUCT)->where('id')->in($objectList)->fetchPairs('id', 'name');
            elseif($type == 'book')    $titles[$type] = $this->dao->select('id, title')->from(TABLE_BOOK)->where('id')->in($objectList)->fetchPairs('id', 'title');
            elseif($type == 'comment') $titles[$type] = $this->dao->select('id, `from`')->from(TABLE_MESSAGE)->where('id')->in($objectList)->fetchPairs('id', 'from');
            elseif($type == 'message') $titles[$type] = $this->dao->select('id, `from`')->from(TABLE_MESSAGE)->where('id')->in($objectList)->fetchPairs('id', 'from');

            /* If ext function for get title callable call them, */
            elseif(is_callable(array($this, "get{$type}Title")))  $titles[$type] =  call_user_func(array($this, "get{$type}Title"), $objectList);
        }

        foreach($messages as $message)
        {
            $message->objectTitle = isset($titles[$message->objectType][$message->objectID]) ? $titles[$message->objectType][$message->objectID] : '';
        }
        
        return $messages;
    }

    /**
     * Get the link of the object of one message.
     *
     * @param string $message
     * @access public
     * @return sting
     */
    public function getObjectLink($message)
    {
        if(empty($message)) return '';
        if($message->type == 'message') return commonModel::createFrontLink('message', 'index');
        $link = '';
        if($message->objectType == 'article')
        {
            $link = $this->loadModel('article')->createPreviewLink($message->objectID);
        }
        elseif($message->objectType == 'product')
        {
            $link = commonModel::createFrontLink('product', 'view', "prodcutID=$message->objectID");
        }
        elseif($message->objectType == 'book')
        {
            $node = $this->loadModel('book')->getNodeByID($message->objectID);
            $link = commonModel::createFrontLink('book', 'read', "articleID=$message->objectID", "book={$node->book->alias}&node={$node->alias}");
        }
        elseif($message->objectType == 'message')
        {
            $link = commonModel::createFrontLink('message', 'index') . "#comment{$message->objectID}";
        }
        elseif($message->objectType == 'comment')
        {
            $object = $this->getByID($message->objectID);
            $link   = $this->getObjectLink($object);
        }
        elseif(is_callable(array($this, "get{$message->objectType}Link")))
        {
            $link = call_user_func(array($this, "get{$message->objectType}Link"), $message);
        }

        return $link;
    }


    /**
     * Post a message.
     *
     * @access public
     * @return array
     */
    public function post($type, $block = '')
    {
        $account = $this->app->user->account;
        $admin   = $this->app->user->admin;
        $message = fixer::input('post')
            ->add('date', helper::now())
            ->add('type', $type)
            ->add('status', '0')
            ->setDefault('public', '1')
            ->setIF(isset($_POST['secret']) and $_POST['secret'] == 1, 'public', '0')
            ->setIF($type == 'message', 'to', 'admin')
            ->setIF($account != 'guest', 'account', $account)
            ->setIF($admin == 'super', 'status', '1')
            ->add('ip', helper::getRemoteIP())
            ->get();

        if($block == 'block')
        {
            $message->from = $message->blockFrom;
            $message->content = $message->blockContent;
        }

        if(strlen($message->content) > 29)
        {
            $repeat = $this->loadModel('guarder')->checkRepeat($message->content); 
            if($repeat) return array('result' => 'fail', 'message' => $this->lang->error->noRepeat);
        }

        if($this->loadModel('guarder')->matchList($message))  return array('result' => 'fail', 'reason' => 'error', 'message' => $this->lang->error->sensitive);

        if(isset($this->config->site->filterSensitive) and $this->config->site->filterSensitive == 'open')
        {
            $dicts = !empty($this->config->site->sensitive) ? $this->config->site->sensitive : $this->config->sensitive;
            $dicts = explode(',', $dicts);
            if(!validater::checkSensitive($message, $dicts)) return array('result' => 'fail', 'reason' => 'error', 'message' => $this->lang->error->sensitive);
        }

        $this->dao->insert(TABLE_MESSAGE)
            ->data($message, $skip = $this->session->captchaInput . ', secret, blockFrom, blockContent, uid')
            ->autoCheck()
            ->check($this->session->captchaInput, 'captcha')
            ->check('type', 'in', $this->config->message->types)
            ->checkIF(!empty($message->email), 'email', 'email')
            ->checkIF(!empty($message->phone), 'phone', 'phone')
            ->batchCheck($this->config->message->require->post, 'notempty')
            ->exec();

        $messageID = $this->dao->lastInsertId();
        $this->setCookie($messageID);

        /* Record post number. */
        $guarder = $this->loadModel('guarder');
        $guarder->logOperation('account', 'postComment');
        $guarder->logOperation('ip', 'postComment');
        if(dao::isError()) 
        {
            $errors = dao::getError();   
            if(isset($errors[$this->session->captchaInput]))
            {
                $guarder->logOperation('ip', 'captchaFail');
                $guarder->logOperation('account', 'captchaFail');
            }
            return array('result' => 'fail', 'message' => $errors);
        }
        return array('result' => 'success', 'message' => $this->lang->message->needCheck, 'messageID' => $messageID);
    }

    /**
     * Reply a message.
     *
     * @param  int    $messageID
     * @access public
     * @return void
     */
    public function reply($messageID)
    {
        $account = $this->app->user->account;
        $admin   = $this->app->user->admin;
        $message = $this->getByID($messageID);

        $reply = fixer::input('post')
            ->add('objectType', $message->type == 'reply' ? $message->objectType : $message->type)
            ->add('objectID', $message->id)
            ->add('to', $message->account)
            ->add('type', 'reply')
            ->add('date', helper::now())
            ->add('status', '0')
            ->add('public', 1)
            ->setIF($account != 'guest', 'account', $account)
            ->setIF($admin == 'super', 'status', '1')
            ->add('ip', $this->server->REMOTE_ADDR)
            ->get();

        $this->dao->insert(TABLE_MESSAGE)
            ->data($reply, $skip = $this->session->captchaInput . ',uid')
            ->autoCheck()
            ->check($this->session->captchaInput, 'captcha')
            ->check('type', 'in', $this->config->message->types)
            ->batchCheck($this->config->message->require->reply, 'notempty')
            ->exec();

        $replyID = $this->dao->lastInsertId();

        if(!dao::isError())
        {
            if($admin == 'super')
            {
                $this->dao->update(TABLE_MESSAGE)->set('status')->eq(1)->where('status')->eq(0)->andWhere('id')->eq($messageID)->exec();
                if(dao::isError()) return false;
            }

            /* if message type is comment , check is user want to receive email reminder  */
            if(validater::checkEmail($message->email) && ($message->type != 'comment' || $message->receiveEmail))
            {
                $mail = new stdclass();
                $mail->to      = $message->email;
                $mail->subject = sprintf($this->lang->message->replySubject, $this->config->site->name);
                $mail->body    = $reply->content;

                $this->loadModel('mail')->send($mail->to, $mail->subject, $mail->body);
            }

            return $replyID;
        }

        return false;
    }

    /**
     * Delete a message.
     *
     * @param string $messageID
     * @param string $mode
     * @param int    $maxId
     * @access public
     * @return void
     */
    public function deleteMessage($messageID, $mode, $maxId = 0)
    {
        $this->dao->delete()
            ->from(TABLE_MESSAGE)
            ->where(1)
            ->beginIF($mode == 'single')->andWhere('id')->eq($messageID)->fi()
            ->beginIF($mode == 'pre')->andWhere('id')->le($maxId)->andWhere('id')->ge($messageID)->andWhere('status')->ne('1')->fi()
            ->exec();

        return !dao::isError();
    }

    /**
     * Pass messages.
     *
     * @param string $messageID
     * @param string $type          single|pr
     * @param  int   $maxId   
     * @access public
     * @return void
     */
    public function pass($messageID, $type, $maxId = 0)
    {
        $message = $this->getByID($messageID );

        if($message->type == 'reply' and strpos("message,comment", $message->objectType) !== false)
        {
            $this->pass($message->objectID, 'single', $maxId);
        }

        $this->dao->update(TABLE_MESSAGE)
            ->set('status')->eq(1)
            ->where('status')->eq(0)
            ->beginIF($type == 'single')->andWhere('id')->eq($messageID)->fi()
            ->beginIF($type == 'pre')->andWhere('id')->ge($messageID)->andWhere('id')->le($maxId)->fi()
            ->exec();

        return !dao::isError();
    }

    /**
     * Mark a message readed.
     *
     * @param  int    $messageID
     * @access public
     * @return bool
     */
    public function markReaded($messageID)
    {
        $this->dao->update(TABLE_MESSAGE)->set('readed')->eq('1')->where('id')->eq($messageID)->exec();
        return !dao::isError();
    }

    /**
     * Set the message id the user posted to the cookie. Thus before approvaled, the user can view these messages.
     *
     * @param string $messageID
     * @access public
     * @return void
     */
    public function setCookie($messageID)
    {
        $messages = $this->cookie->cmts;
        if(!$messages)
        {
            $messages = $messageID;
        }
        else
        {
            if(strpos($messages, $messageID) === false)
            {
                $messages .= ',' . $messageID;
            }
        }
        setcookie('cmts', $messages, 0, '', '', false, true);
    }

    /**
     * Delete messages of a user..
     *
     * @param  int     $message
     * @access public
     * @return void
     */
    public function deleteByAccount($message)
    {
        $this->dao->delete()->from(TABLE_MESSAGE)->where('`to`')->eq($this->app->user->account)->andWhere('id')->eq($message)->exec();
        return !dao::isError();
    }
    /**
     * Send a message.
     * 
     * @param  string    $from 
     * @param  string    $to 
     * @param  string    $content 
     * @access public
     * @return bool 
     */
    public function send($from, $to, $content)
    {
        $message = new stdclass();
        $message->from    = $from;
        $message->to      = $to;
        $message->content = $content;
        $message->status  = 1;
        $message->date    = helper::now();
        $this->dao->insert(TABLE_MESSAGE)->data($message)->batchCheck('from,to,content', 'notempty')->autocheck()->exec();
        return !dao::isError();
    }

    /**
     * Get messages not checked. 
     * 
     * @param  int    $type 
     * @access public
     * @return void
     */
    public function getListForWidget($limit)
    {
        $admins = $this->dao->setAutoLang(false)->select('account')->from(TABLE_USER)->where('admin')->ne('no')->fetchAll('account');
        $messages = $this->dao->select('*')
            ->from(TABLE_MESSAGE)
            ->where('status')->eq(0)
            ->andWhere('type')->in('comment,message,reply')
            ->andWhere('account')->notin(array_keys($admins))
            ->orderBy('date_desc')
            ->limit($limit)
            ->fetchAll();

        /* Get object titles and id. */
        $articles   = array();
        $products   = array();
        $books      = array();
        $messageIDs = array();
        $comments   = array();

        foreach($messages as $message)
        {
            if('article' == $message->objectType) $articles[]   = $message->objectID;
            if('product' == $message->objectType) $products[]   = $message->objectID;
            if('book'    == $message->objectType) $books[]      = $message->objectID;
            if('message' == $message->objectType) $messageIDs[] = $message->objectID;
            if('comment' == $message->objectType) $comments[]   = $message->objectID;
        }

        $articleTitles = $this->dao->select('id, title')->from(TABLE_ARTICLE)->where('id')->in($articles)->fetchPairs('id', 'title');
        $productTitles = $this->dao->select('id, name')->from(TABLE_PRODUCT)->where('id')->in($products)->fetchPairs('id', 'name');
        $bookTitles    = $this->dao->select('id, title')->from(TABLE_BOOK)->where('id')->in($books)->fetchPairs('id', 'title');
        $messageTitles = $this->dao->select('id, `from`')->from(TABLE_MESSAGE)->where('id')->in($messageIDs)->fetchPairs('id', 'from');
        $commentTitles = $this->dao->select('id, `from`')->from(TABLE_MESSAGE)->where('id')->in($comments)->fetchPairs('id', 'from');

        foreach($messages as $message)
        {
            if($message->objectType == 'article') $message->objectTitle = isset($articleTitles[$message->objectID]) ? $articleTitles[$message->objectID] : '';
            if($message->objectType == 'product') $message->objectTitle = isset($productTitles[$message->objectID]) ? $productTitles[$message->objectID] : '';
            if($message->objectType == 'book')    $message->objectTitle = isset($bookTitles[$message->objectID]) ? $bookTitles[$message->objectID] : '';
            if($message->objectType == 'message') $message->objectTitle = isset($messageTitles[$message->objectID]) ? $messageTitles[$message->objectID] : '';
            if($message->objectType == 'comment') $message->objectTitle = isset($commentTitles[$message->objectID]) ? $commentTitles[$message->objectID] : '';
        }

        foreach($messages as $message) $message->objectViewURL = $this->getObjectLink($message);

        return $messages;
    }
}
