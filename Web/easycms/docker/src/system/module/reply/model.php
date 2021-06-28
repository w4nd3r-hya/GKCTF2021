<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of reply module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     reply
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class replyModel extends model
{
    /**
     * Get a reply by it's id.
     * 
     * @param  int    $replyID 
     * @access public
     * @return object
     */
    public function getByID($replyID)
    {
        $reply = $this->dao->findById($replyID)->from(TABLE_REPLY)->fetch();
        if(!$reply) return false;

        $reply->files = $this->loadModel('file')->getByObject('reply', $replyID);
        return $reply;
    }

    /**
     * Get position of reply.
     * 
     * @param  int    $replyID 
     * @access public
     * @return string
     */
    public function getPosition($replyID, $mode = 'url')
    {
        $reply = $this->getByID($replyID);
        if(!$reply) return '';

        $thread = $this->loadModel('thread')->getByID($reply->thread);
        $replies = $this->dao->select('COUNT(id) as id')->from(TABLE_REPLY)
            ->where('thread')->eq($reply->thread)
            ->beginIF($thread->discussion)->andWhere('reply')->eq(0)->fi()
            ->andWhere('id')->lt($replyID)
            ->andWhere('hidden')->eq('0')
            ->fetch('id');

        if($this->app->clientDevice == 'desktop')
        {
            $recPerPage = !empty($this->config->site->replyRec) ? $this->config->site->replyRec : $this->config->reply->recPerPage;
        }
        else
        {
            $recPerPage = !empty($this->config->site->replyMobileRec) ? $this->config->site->replyMobileRec : $this->config->reply->recPerPage;
        }
        $pageID     = (int)($replies / $recPerPage);
        
        if($mode == 'anchor') return array('pageID' => $pageID + 1, 'anchorID' => $reply->id);

        if($this->config->requestType == 'GET') return $pageID ? "&pageID=" . ($pageID + 1) . "#$replyID" : "#$replyID";
        if($this->config->requestType != 'GET') return $pageID ? "&pageID=" . ($pageID + 1) . "&replyID=$replyID" : "replyID=$replyID";
    }

    /**
     * Get replies of a thread.
     * 
     * @param  int    $threadID
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getByThread($threadID, $pager = null)
    {
        if($this->app->clientDevice == 'mobile') return $this->getRepliesByThread($threadID, $pager);

        $thread = $this->loadModel('thread')->getByID($threadID);

        $replies = $this->dao->select('*')->from(TABLE_REPLY)
            ->where('thread')->eq($thread->id)
            ->beginIF($thread->discussion)->andWhere('reply')->eq(0)->fi()
            ->orderBy('id')
            ->page($pager)
            ->fetchAll('id');

        if(!$replies) return array();

        $this->setRealNames($replies);

        /* Get files for these replies. */
        $files = $this->loadModel('file')->getByObject('reply', array_keys($replies));
        
        foreach($files as $replyID => $file) $replies[$replyID]->files = $file;

        if(commonModel::isAvailable('score'))
        {
            if($replies)
            {
                $replyScores = $this->loadModel('score')->getByObject('reply', array_keys($replies), 'valuereply');
                foreach($replyScores as $score)
                {
                    if(!isset($replies[$score->objectID]->scoreSum))$replies[$score->objectID]->scoreSum = 0;
                    $replies[$score->objectID]->scoreSum += $score->count;
                }
            }
        }

        $this->loadModel('file');
        foreach($replies as $reply)
        {
            if(strpos($reply->content, '[quote]') !== false)
            {
                $reply->content = str_replace('[quote]', "<div class='alert'>", $reply->content);
                $reply->content = str_replace('[/quote]', '</div>', $reply->content);
            }
        }

        return $replies;
    }

    /**
     * Get floors for replies.
     * 
     * @param  int    $threadID 
     * @access public
     * @return array
     */
    public function getFloors($threadID)
    {
        $replies = $this->dao->select('*')->from(TABLE_REPLY)->where('thread')->eq($threadID)->orderBy('id')->fetchAll('id');

        $i = 1;
        $floors = array();
        foreach($replies as $reply)
        {
            $floors[$reply->id] = $i;
            $i++;
        }

        return $floors;
    }

    /**
     * Get replies by reply.
     * 
     * @param  object    $reply 
     * @access public
     * @return void
     */
    public function getByReply($reply)
    {
        $replies = $this->dao->select('*')->from(TABLE_REPLY)
            ->where('reply')->eq($reply->id)
            ->orderBy('id')
            ->fetchAll('id');

        if(!$replies) return false;

        $thread = $this->loadModel('thread')->getByID($reply->thread);
        $users  = $this->loadModel('user')->getPairs();
        $canManage = $this->thread->canManage($thread->board, $reply->author);

        /* Get files for these replies. */
        $files = $this->loadModel('file')->getByObject('reply', array_keys($replies));
        foreach($files as $replyID => $file) $replies[$replyID]->files = $file;

        if(!$reply->reply) echo "<div class='alert alert-replies'>";

        foreach($replies as $data)
        {
            if(strpos($data->content, '[quote]') !== false)
            {
                $data->content = str_replace('[quote]', "<div class='alert alert-primary'>", $data->content);
                $data->content = str_replace('[/quote]', '</div>', $data->content);
            }

            echo "<div class='thread-content'><span class='reply-author text-primary'>" . zget($users, $data->author) . $this->lang->colon . "</span><div class='reply-content'>" . $data->content . '</div>';
            if(!empty($data->files))
            {
                echo "<div class='article-files'>";
                echo $this->printFiles($data, $canManage);
                echo "</div>";
            }
            echo "<div class='text-right reply-actions'><span class='text-muted reply-date'>" . formatTime($data->addedDate, 'Y-m-d') . "</span>";
            if($this->app->user->account != 'guest')
            {
                if(commonModel::isAvailable('score') and $canManage and $this->app->clientDevice == 'desktop')
                {
                    $account = helper::safe64Encode($data->author);
                    echo html::a(inlink('addScore', "account={$account}&objectType=reply&objectID={$data->id}"), $this->lang->thread->score, "data-toggle=modal");
                }
                if($this->app->clientDevice == 'mobile')
                {
                    if($canManage) echo html::a(helper::createLink('reply', 'delete', "replyID=$data->id"), '<i class="icon-trash"></i> ' . $this->lang->delete, "class='deleter text-muted'");
                    if($canManage) echo html::a(helper::createLink('reply', 'edit',   "replyID=$data->id"), '<i class="icon-pencil"></i> ' . $this->lang->edit, "data-toggle='modal' class='text-muted'");
                }
                else
                {
                    if($canManage) echo html::a(helper::createLink('reply', 'delete', "replyID=$data->id"), '<i class="icon-trash"></i> ' . $this->lang->delete, "class='deleter'");
                    if($canManage) echo html::a(helper::createLink('reply', 'edit',   "replyID=$data->id"), '<i class="icon-pencil"></i> ' . $this->lang->edit);
                }
                if(!$thread->readonly)
                {
                    if($this->app->clientDevice == 'mobile')
                    {
                        echo "<a href='#replyDialog' data-toggle='modal' data-reply='{$data->id}' class='text-muted thread-reply-btn'><i class='icon-reply'></i> {$this->lang->reply->common} </a>";
                        echo "<a href='#replyDialog' data-toggle='modal' data-reply='{$data->id}' class='text-muted thread-reply-btn quote'><i class='icon-quote-left'></i> {$this->lang->thread->quote} </a>";
                    }
                    else
                    {
                        echo "<a href='#reply' data-reply='{$data->id}' class='thread-reply-btn'><i class='icon-reply'></i> {$this->lang->reply->common} </a>";
                        echo "<a href='#reply' data-reply='{$data->id}' class='thread-reply-btn quote'><i class='icon-quote-left'></i> {$this->lang->thread->quote} </a>";
                    }
                }
            }
            else
            {
                $referer = helper::safe64Encode($this->app->getURI(true) . '#' . $data->id);
                $url = helper::createLink('user', 'login', "referer=$referer");
                echo "<a data-reply='{$data->id}' href='{$url}' class='thread-reply-btn'><i class='icon-reply'></i> {$this->lang->reply->common}</a>";
            }
            echo "</div></div><hr>";

            $replies = $this->dao->select('*')->from(TABLE_REPLY)->where('reply')->eq($data->id)->orderBy('id')->fetchAll('id');
            if($replies)
            {
                if(!$reply->reply) echo "<div class='second-replies'>";
                $this->getByReply($data);
                if(!$reply->reply) echo "</div>";
            }
        }
        if(!$reply->reply) echo "</div>";
    }

    /**
     * Get replies. 
     * 
     * @param  object $pager 
     * @access public
     * @return object | false
     */
    public function getList($orderBy = 'addedDate_desc', $pager = null)
    {
        $searchWord = $this->get->searchWord;
        $replies = $this->dao->select('*')->from(TABLE_REPLY)
            ->where(1)
            ->beginIf($searchWord)
            ->andwhere('content')->like("%{$searchWord}%")
            ->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');

        $this->setRealNames($replies);

        return $replies;
    }

    /**
     * Get replies of one thread.
     *
     * @param  int $threadID  the thread id
     * @access public
     * @return array
     */
    public function getRepliesByThread($threadID, $pager = null)
    {
        return  $this->dao->select('u.realname, u.nickname, u.avatar, r.id, r.author, r.content, r.addedDate')->from(TABLE_REPLY)->alias('r')
            ->leftJoin(TABLE_USER)->alias('u')->on('r.author=u.account')
            ->where('r.thread')->eq($threadID)
            ->andWhere('r.reply')->eq(0)
            ->andWhere('r.hidden')->eq(0)
            ->orderBy('r.id_desc')
            ->page($pager)
            ->fetchAll();
    }

    /**
     * Get all replies of a reply for thread.
     *
     * @param  object  $reply
     * @param  int     $level
     * @access public
     * @return null
     */
    public function getRepliesByReply($reply, $level = 0)
    {
        $replies = $this->dao->select('*')->from(TABLE_REPLY)
            ->where('reply')->eq($reply->id)
            ->andWhere('hidden')->eq(0)
            ->orderBy('id_asc')
            ->fetchAll();

        if(!empty($replies))
        {
            $threadIDs = array_column($replies, 'thread');
            $thread = $this->loadModel('thread')->getByID(array_pop($threadIDs));

            $level++;
            echo "<div class='replies'>";
            foreach($replies as $row)
            {
                $replyTo = $level > 1 ? '<div class="arrow"></div>' . $reply->author : '';
                echo "<div class='reply-panel'>";
                echo "<div class='reply-heading vertical-center'>";
                echo "<div class='reply-ext'>";
                echo "<span class='text-primary'>{$row->author}{$replyTo}</i> </span>";
                echo "<span class='text-muted'>" . $row->addedDate . "</span>";
                echo "</div>";
                if(!$thread->readonly) echo '<a href="#replyDialog" data-toggle="modal" data-reply-id="' . $row->id . '" class="text-muted thread-reply-btn">' . $this->lang->reply->reply . '</a>';
                echo '</div>';
                echo "<div class='reply-body'>";
                echo nl2br($row->content);
                echo '</div>';
                $this->getRepliesByReply($row, $level);
                echo "</div>";
            }
            echo $level == 1 ? '<div class="more-replies">' . $this->lang->reply->moreReplies . '</div>' : '';
            echo '</div>';
        }
    }

    /**
     * Get replies of a user.
     * 
     * @param string $account       the account
     * @param string $pager         the pager object
     * @access public
     * @return array
     */
    public function getByUser($account, $pager = null)
    {
        $replies = $this->dao->select('t1.*, t2.title, t2.board')->from(TABLE_REPLY)->alias('t1')
            ->leftJoin(TABLE_THREAD)->alias('t2')->on('t1.thread = t2.id')
            ->where('t1.author')->eq($account)
            ->orderBy('id desc')
            ->page($pager)
            ->fetchAll('id');
    
        $boards = $this->loadModel('tree')->getPairs(0, 'forum');
        foreach($replies as $reply) $reply->boardName = zget($boards, $reply->board);

        return $replies;
    }

    /**
     * Reply a thread.
     * 
     * @param  int      $threadID
     * @access public
     * @return void
     */
    public function post($threadID)
    {
        $thread = $this->loadModel('thread')->getByID($threadID);
        $allowedTags = $this->app->user->admin == 'super' ? $this->config->allowedTags->admin : $this->config->allowedTags->front;
        $reply = fixer::input('post')
            ->setForce('author', $this->app->user->account)
            ->setForce('addedDate', helper::now())
            ->setForce('editedDate', helper::now())
            ->setForce('thread', $threadID)
            ->stripTags('content', $allowedTags)
            ->remove('files, labels, hidden')
            ->get();

        if(strlen($reply->content) > 40)
        {
            $repeat = $this->loadModel('guarder')->checkRepeat($reply->content); 
            if($repeat) return array('result' => 'fail', 'message' => $this->lang->error->noRepeat);
        }

        if($this->loadModel('guarder')->matchList($reply))  return array('result' => 'fail', 'reason' => 'error', 'message' => $this->lang->error->sensitive);

        if(isset($this->config->site->filterSensitive) and $this->config->site->filterSensitive == 'open')
        {
            $dicts = !empty($this->config->site->sensitive) ? $this->config->site->sensitive : $this->config->sensitive;
            $dicts = explode(',', $dicts);
            if(!validater::checkSensitive($reply, $dicts)) return array('result' => 'fail', 'message' => $this->lang->error->sensitive);
        }

        $this->dao->insert(TABLE_REPLY)
            ->data($reply, $skip = $this->session->captchaInput . ',uid')
            ->autoCheck()
            ->batchCheck($this->config->reply->require->edit, 'notempty')
            ->check($this->session->captchaInput, 'captcha')
            ->exec();

        $replyID = $this->dao->lastInsertID();                     // Get reply id.

        $this->loadModel('file')->updateObjectID($this->post->uid, $replyID, 'reply');

        /* Record reply number. */
        $this->loadModel('guarder')->logOperation('ip', 'postReply');
        $this->loadModel('guarder')->logOperation('account', 'postReply');

        if(!dao::isError())
        {
            $this->saveCookie($replyID);                               // Save reply id to cookie.
            $this->loadModel('file')->saveUpload('reply', $replyID);   // Save file.
            if(commonModel::isAvailable('score')) $this->loadModel('score')->earn('reply', 'reply', $replyID);

            /* Update thread stats. */
            $this->thread->updateStats($threadID);

            /* Update board stats. */
            $this->loadModel('forum')->updateBoardStats($thread->board);

            $urlInfo = $this->getPosition($replyID, 'anchor');
            
            if($this->config->requestType == 'GET') $locate = helper::createLink('thread', 'view', "threadID=$threadID&pageID=" . $urlInfo['pageID'] . "&noice=" . rand(1, 100) . "#" . $urlInfo['anchorID']);
            if($this->config->requestType != 'GET') $locate = helper::createLink('thread', 'view', "threadID=$threadID", "pageID=" . $urlInfo['pageID']) . "?rand=" . rand(1, 100) . "#" . $urlInfo['anchorID'];

            return array('result' => 'success', 'replySuccess' => $this->lang->thread->replySuccess, 'replyID' => $this->post->reply, 'locate' => $locate);
        }
        return array('result' => 'fail', 'message' => dao::getError());
    }

    /**
     * Update a reply.
     * 
     * @param  int      $replyID 
     * @access public
     * @return void
     */
    public function update($replyID)
    {
        $allowedTags = $this->app->user->admin == 'super' ? $this->config->allowedTags->admin : $this->config->allowedTags->front;

        $reply = fixer::input('post')
            ->setForce('editor', $this->session->user->account)
            ->setForce('editedDate', helper::now())
            ->stripTags('content', $allowedTags)
            ->remove('files,labels,hidden')
            ->get();

        if(isset($this->config->site->filterSensitive) and $this->config->site->filterSensitive == 'open')
        {
            $dicts = !empty($this->config->site->sensitive) ? $this->config->site->sensitive : $this->config->sensitive;
            $dicts = explode(',', $dicts);
            if(!validater::checkSensitive($reply, $dicts)) return array('result' => 'fail', 'message' => $this->lang->error->sensitive);
        }

        $this->dao->update(TABLE_REPLY)
            ->data($reply, $skip = $this->session->captchaInput . ',uid')
            ->autoCheck()
            ->batchCheck($this->config->reply->require->post, 'notempty')
            ->check('captcha', 'captcha')
            ->where('id')->eq($replyID)
            ->exec();

        $this->loadModel('file')->updateObjectID($this->post->uid, $replyID, 'reply');

        if(!dao::isError())
        {
            $this->loadModel('file')->saveUpload('reply', $replyID);
            return true;
        }

        return false;
    }

    /**
     * Hide a reply. 
     * 
     * @param  int      $replyID 
     * @access public
     * @return void
     */
    public function hide($replyID)
    {
        $this->dao->update(TABLE_REPLY)->set('hidden')->eq(1)->where('id')->eq($replyID)->exec();
    }

    /**
     * Delete a reply.
     * 
     * @param string $replyID 
     * @access public
     * @return void
     */
    public function delete($replyID, $null = null)
    {
        $author = $this->dao->select('author')->from(TABLE_REPLY)->where('id')->eq($replyID)->fetch('author');

        $thread = $this->dao->select('t2.id, t2.board')->from(TABLE_REPLY)->alias('t1')
            ->leftJoin(TABLE_THREAD)->alias('t2')
            ->on('t1.thread = t2.id')
            ->where('t1.id')->eq($replyID)
            ->fetch();

        $this->dao->delete()->from(TABLE_REPLY)->where('id')->eq($replyID)->exec();
        if(dao::isError()) return false;

        /* Update thread and board stats. */
        $this->loadModel('thread')->updateStats($thread->id);
        $this->loadModel('forum')->updateBoardStats($thread->board);

        if(commonModel::isAvailable('score')) $this->loadModel('score')->punish($author, 'delReply', $this->config->score->counts->delReply, 'reply', $replyID);

        return !dao::isError();
    }

    /**
     * Print files of for a reply.
     * 
     * @param  object $thread 
     * @param  bool   $canManage 
     * @access public
     * @return void
     */
    public function printFiles($reply, $canManage)
    {
        if(empty($reply->files)) return false;

        $imagesHtml = '';
        $filesHtml  = '';

        foreach($reply->files as $file)
        {
            if($file->isImage)
            {
                if($file->editor) continue;
                $imagesHtml .= "<li class='file-image file-{$file->extension}'>" . html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), html::image($this->loadModel('file')->printFileURL($file, 'smallURL')), "target='_blank' data-toggle='lightbox'");
                if($canManage) $imagesHtml .= "<span class='file-actions'>" . html::a(helper::createLink('reply', 'deleteFile', "replyID=$reply->id&fileID=$file->id"), "<i class='icon-trash'></i>", "class='deleter'") . '</span>';
                $imagesHtml .= '</li>';
            }
            else
            {
                $file->title = $file->title . ".$file->extension";
                $filesHtml .= "<li class='file file-{$file->extension}'>" . html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), $file->title, "target='_blank'");
                if($canManage) $filesHtml .= "<span class='file-actions'>" . html::a(helper::createLink('reply', 'deleteFile', "replyID=$reply->id&fileID=$file->id"), "<i class='icon-trash'></i>", "class='deleter'") . '</span>';
                $filesHtml .= '</li>';
            }
        }
        if($imagesHtml or $filesHtml) echo "<ul class='files-list clearfix'><li class='files-list-heading'>". $this->lang->reply->files . '</li>' . $imagesHtml . $filesHtml . '</ul>';
    }

    /**
     * Save the reply id to cookie.
     * 
     * @param  int     $replyID 
     * @access public
     * @return void
     */
    public function saveCookie($reply)
    {
        $reply = "$reply,";
        $cookie = $this->cookie->r != false ? $this->cookie->r : ',';
        if(strpos($cookie, $reply) === false) $cookie .= $reply;
        setcookie('r', $cookie , time() + 60 * 60 * 24 * 30, '', '', false, true);
    }

    /**
     * Set real name for author and editor of replies.
     * 
     * @param  array     $replies 
     * @access public
     * @return void
     */
    public function setRealNames($replies)
    {
        $speakers = array();
        foreach($replies as $reply)
        {
            $speakers[] = $reply->author;
            $speakers[] = $reply->editor;
        }

        $speakers = $this->loadModel('user')->getRealNamePairs($speakers);

        foreach($replies as $reply) 
        {
           $reply->authorRealname = !empty($reply->author) ? $speakers[$reply->author] : '';
           $reply->editorRealname = !empty($reply->editor) ? $speakers[$reply->editor] : '';
        }
    }

    /**
     * Get lastest replies 
     * 
     * @access public
     * @return int 
     */
    public function getReplies()
    {
        $replies = $this->dao->select('count(*) as count')->from(TABLE_REPLY)
            ->where('editedDate')->like(date("Y-m-d") . '%')
            ->fetch();

        return $replies->count;
    }

    /**
     * Judge the use can edit the reply or not
     *
     * @param  object $reply
     * @access public
     * @return bool
     */
    public function canEdit($reply)
    {
        return $this->loadModel('thread')->canReply($reply->thread); 
    }
}
