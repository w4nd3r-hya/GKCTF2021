<?php
class chat extends control
{
    public function __construct()
    {
        parent::__construct();

        if(RUN_MODE == 'xuanxuan')
        {
            $this->output = new stdclass();
            $this->output->module = $this->moduleName;
            $this->output->method = $this->methodName;
        }
    }

    /**
     * Server start.
     *
     * @access public
     * @return void
     */
    public function serverStart()
    {
        $this->chat->resetUserStatus();
        $this->chat->createSystemChat();
    }

    /**
     * Login.
     *
     * @param  string $account
     * @param  string $password encrypted password
     * @param  string $status   online | away | busy
     * @access public
     * @return void
     */
    public function login($account = '', $password = '', $status = '', $userID = 0, $version = '')
    {
        $user = $this->loadModel('user')->identify($account, $password);
        if(!$user)
        {
            $password = md5($password . $account);
            $user     = $this->loadModel('user')->identify($account, $password);
        }

        if($user)
        {
            $this->output->result = 'success';
            if($status == 'online')
            {
                $data = new stdclass();
                $data->id           = $user->id;
                $data->clientStatus = $status;
                $user = $this->chat->editUser($data);

                $this->loadModel('action')->create('user', $user->id, 'loginXuanxuan', '', 'xuanxuan-v' . (empty($version) ? '?' : $version), $user->account);

                $users = $this->chat->getUserList($status = 'online');
                $user->signed = $this->chat->getSignedTime($account);

                $user->ranzhiUrl = commonModel::getSysURL();
                $user->status    = $user->clientStatus;

                $this->output->users = array_keys($users);
                $this->output->data  = $user;
            }
        }
        else
        {
            $this->output->result = 'fail';
            $this->output->data   = $this->lang->user->loginFailed;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Logout.
     *
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function logout($userID = 0)
    {
        $user = new stdclass();
        $user->id           = $userID;
        $user->clientStatus = 'offline';

        $user  = $this->chat->editUser($user);
        $users = $this->chat->getUserList($status = 'online');

        $user->status = $user->clientStatus;
        $this->loadModel('action')->create('user', $userID, 'logoutXuanxuan', '', 'xuanxuan', $user->account);

        $this->output->result = 'success';
        $this->output->users  = array_keys($users);
        $this->output->data   = $user;

        session_destroy();
        setcookie('za', false);
        setcookie('zp', false);

        die($this->app->encrypt($this->output));
    }

    /**
     * Get user list.
     *
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function userGetList($idList = '', $userID = 0)
    {
        $users = $this->chat->getUserList($status = '', $idList, $idAsKey = false);

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Get userlist failed.';
        }
        else
        {

            $this->output->result = 'success';
            $this->output->users  = !empty($userID) ? array($userID) : array();
            $this->output->data   = $users;

            if(empty($idList))
            {
                $this->app->loadLang('user');
                $roles = $this->lang->user->roleList;

                $allDepts = $this->loadModel('tree')->getListByType('dept');
                $depts = array();
                foreach($allDepts as $id => $dept)
                {
                    $depts[$id] = array('name' => $dept->name, 'order' => (int)$dept->order, 'parent' => (int)$dept->parent);
                }
                $this->output->roles = $roles;
                $this->output->depts = $depts;
            }
            else
            {
                $this->output->partial = $idList;
            }
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Change a user.
     *
     * @param  array  $user
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function userChange($user = array(), $userID = 0)
    {
        $user = (object)$user;
        $user->id = $userID;
        if(isset($user->status)) 
        {
            $user->clientStatus = $user->status;
            unset($user->status);
        }
        $user  = $this->chat->editUser($user);
        $users = $this->chat->getUserList($status = 'online');
        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Change user failed.';
        }
        else
        {
            $this->loadModel('action')->create('user', $userID, 'update');
            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $user;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Keep session active
     *
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function ping($userID = 0)
    {
        $this->output->result = 'success';
        $this->output->users  = array($userID);

        die($this->app->encrypt($this->output));
    }

    /**
     * Get public chat list.
     *
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function getPublicList($userID = 0)
    {
        $chatList = $this->chat->getList();
        foreach($chatList as $chat)
        {
            $chat->members = $this->chat->getMemberListByGID($chat->gid);
        }

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Get public chat list failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $chatList;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Get chat list of a user.
     *
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function getList($userID = 0)
    {
        $chatList = $this->chat->getListByUserID($userID);
        foreach($chatList as $chat)
        {
            $chat->members = $this->chat->getMemberListByGID($chat->gid);
        }
        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Get chat list failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $chatList;
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Get members of a chat.
     *
     * @param  string $gid
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function members($gid = '', $userID = 0)
    {
        $members = $this->chat->getMemberListByGID($gid);
        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Get member list failed.';
        }
        else
        {
            $data = new stdclass();
            $data->gid     = $gid;
            $data->members = $members;

            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $data;
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Get offline messages.
     *
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function getOfflineMessages($userID = 0)
    {
        $messages = $this->chat->getOfflineMessages($userID);
        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Get offline messages fail.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $messages;
        }
        $this->output->method = 'message';
        die($this->app->encrypt($this->output));
    }

    /**
     * Create a chat.
     *
     * @param  string $gid
     * @param  string $name
     * @param  string $type
     * @param  array  $members
     * @param  int    $subjectID
     * @param  bool   $public    true: the chat is public | false: the chat isn't public.
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function create($gid = '', $name = '', $type = 'group', $members = array(), $subjectID = 0, $public = false, $userID = 0)
    {
        $chat = $this->chat->getByGID($gid, true);

        if(!$chat)
        {
            $chat = $this->chat->create($gid, $name, $type, $members, $subjectID, $public, $userID);
        }
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Create chat fail.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $chat;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Set admins of a chat.
     *
     * @param  string $gid
     * @param  array  $admins
     * @param  bool   $isAdmin
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function setAdmin($gid = '', $admins = array(), $isAdmin = true, $userID = 0)
    {
        $user = $this->chat->getUserByUserID($userID);
        if(!empty($user->admin) && $user->admin != 'super')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notAdmin;

            die($this->app->encrypt($this->output));
        }

        $chat = $this->chat->getByGID($gid);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }
        if($chat->type != 'system')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notSystemChat;

            die($this->app->encrypt($this->output));
        }

        $chat  = $this->chat->setAdmin($gid, $admins, $isAdmin);
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Set admin failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $chat;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Join or quit a chat.
     *
     * @param  string $gid
     * @param  bool   $join   true: join a chat | false: quit a chat.
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function joinChat($gid = '', $join = true, $userID = 0)
    {
        $chat = $this->chat->getByGID($gid);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }
        if($chat->type != 'group')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notGroupChat;

            die($this->app->encrypt($this->output));
        }

        if($join && $chat->public == '0')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notPublic;

            die($this->app->encrypt($this->output));
        }

        $this->chat->joinChat($gid, $userID, $join);

        $chat  = $this->chat->getByGID($gid, true);
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));
        $users = array_keys($users);
        $users[] = $userID;

        if(dao::isError())
        {
            if($join)
            {
                $message = 'Join chat failed.';
            }
            else
            {
                $message = 'Quit chat failed.';
            }

            $this->output->result  = 'fail';
            $this->output->message = $message;
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = $users;
            $this->output->data   = $chat;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Change the name of a chat.
     *
     * @param  string $gid
     * @param  string $name
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function changeName($gid = '', $name ='', $userID = 0)
    {
        $chat = $this->chat->getByGID($gid);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }
        if($chat->type != 'group' && $chat->type != 'system')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notGroupChat;

            die($this->app->encrypt($this->output));
        }

        $chat->name = $name;
        $chat  = $this->chat->update($chat, $userID);
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Change name failed.';
        }
        else
        {

            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $chat;

        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Dismiss a chat
     *
     * @param  string $gid
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function dismiss($gid = '', $userID = 0)
    {
        $chat = $this->chat->getByGID($gid);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }
        if($chat->type != 'group')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notGroupChat;

            die($this->app->encrypt($this->output));
        }

        $chat->dismissDate = helper::now();
        $chat  = $this->chat->update($chat, $userID);
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Dismiss chat failed.';
        }
        else
        {

            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $chat;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Change the committers of a chat
     *
     * @param  string $gid
     * @param  string $committers
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function setCommitters($gid = '', $committers = '', $userID = 0)
    {
        $chat = $this->chat->getByGID($gid);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }
        if($chat->type != 'group' && $chat->type != 'system')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notGroupChat;

            die($this->app->encrypt($this->output));
        }

        $chat->committers = $committers;
        $chat  = $this->chat->update($chat, $userID);
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Set committers failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $chat;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Change a chat to be public or not.
     *
     * @param  string $gid
     * @param  bool   $public true: change a chat to be public | false: change a chat to be not public.
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function changePublic($gid = '', $public = true, $userID = 0)
    {
        $chat = $this->chat->getByGID($gid);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }
        if($chat->type != 'group')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notGroupChat;

            die($this->app->encrypt($this->output));
        }

        $chat->public = $public ? 1 : 0;
        $chat  = $this->chat->update($chat, $userID);
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Change public failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $chat;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Star or cancel star a chat.
     *
     * @param  string $gid
     * @param  bool   $star true: star a chat | false: cancel star a chat.
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function star($gid = '', $star = true, $userID = 0)
    {
        $chat = $this->chat->starChat($gid, $star, $userID);
        if(dao::isError())
        {
            if($star)
            {
                $message = 'Star chat failed';
            }
            else
            {
                $message = 'Cancel star chat failed';
            }

            $this->output->result  = 'fail';
            $this->output->message = $message;
        }
        else
        {
            $data = new stdclass();
            $data->gid  = $gid;
            $data->star = $star;

            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $data;
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Hide or display a chat.
     *
     * @param  string $gid
     * @param  bool   $hide true: hide a chat | false: display a chat.
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function hide($gid = '', $hide = true, $userID = 0)
    {
        $chatList = $this->chat->hideChat($gid, $hide, $userID);
        if(dao::isError())
        {
            if($hide)
            {
                $message = 'Hide chat failed.';
            }
            else
            {
                $message = 'Display chat failed.';
            }

            $this->output->result  = 'fail';
            $this->output->message = $message;
        }
        else
        {
            $data = new stdclass();
            $data->gid  = $gid;
            $data->hide = $hide;

            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $data;
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Mute a chat.
     *
     * @param  string $gid
     * @param  bool   $mute true: mute a chat | false: cacel mute a chat.
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function mute($gid = '', $mute = true, $userID = 0)
    {
        $chatList = $this->chat->muteChat($gid, $mute, $userID);
        if(dao::isError())
        {
            if($mute)
            {
                $message = 'mute chat failed.';
            }
            else
            {
                $message = 'Mute chat failed.';
            }

            $this->output->result  = 'fail';
            $this->output->message = $message;
        }
        else
        {
            $data = new stdclass();
            $data->gid  = $gid;
            $data->mute = $mute;

            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $data;
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Set category for a chat
     *
     * @param  array $gids
     * @param  string $category
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function category($gids = array(), $category = '', $userID = 0)
    {
        $chatList = $this->chat->categoryChat($gids, $category, $userID);
        if(dao::isError())
        {
            $message = 'Set chat category failed.';

            $this->output->result  = 'fail';
            $this->output->message = $message;
        }
        else
        {
            $data = new stdclass();
            $data->gids  = $gids;
            $data->category = $category;

            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $data;
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Add members to a chat or kick members from a chat.
     *
     * @param  string $gid
     * @param  array  $members
     * @param  bool   $join     true: add members to a chat | false: kick members from a chat.
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function addMember($gid = '', $members = array(), $join = true, $userID = 0)
    {
        $chat = $this->chat->getByGID($gid);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }
        if($chat->type != 'group')
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notGroupChat;

            die($this->app->encrypt($this->output));
        }

        foreach($members as $member) $this->chat->joinChat($gid, $member, $join);

        $chat->members = $this->chat->getMemberListByGID($gid);
        $users = $this->chat->getUserList($status = 'online', array_values($chat->members));

        if(dao::isError())
        {
            if($join)
            {
                $message = 'Add member failed.';
            }
            else
            {
                $message = 'Kick member failed.';
            }

            $this->output->result  = 'fail';
            $this->output->message = $message;
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $chat;
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Send message to a chat.
     *
     * @param  array  $messages
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function message($messages = array(), $userID = 0)
    {
        /* Check if the messages belong to the same chat. */
        $chats = array();
        foreach($messages as $key => $message)
        {
            $chats[$message->cgid] = $message->cgid;
        }
        if(count($chats) > 1)
        {
            $this->output->result = 'fail';
            $this->output->data   = $this->lang->chat->multiChats;

            die($this->app->encrypt($this->output));
        }
        /* Check whether the logon user can send message in chat. */
        $errors  = array();
        $message = current($messages);
        $chat    = $this->chat->getByGID($message->cgid, true);
        if(!$chat)
        {
            $error = new stdclass();
            $error->gid      = $message->cgid;
            $error->messages = $this->lang->chat->notExist;

            $errors[] = $error;
        }
        elseif(!empty($chat->committers))
        {
            $committers = explode(',', $chat->committers);
            if(!in_array($userID, $committers))
            {
                $error = new stdclass();
                $error->gid      = $message->cgid;
                $error->messages = $this->lang->chat->cantChat;

                $errors[] = $error;
            }
        }
        elseif(!empty($chat->dismissDate))
        {
            $error = new stdclass();
            $error->gid      = $message->cgid;
            $error->messages = $this->lang->chat->chatHasDismissed;

            $errors[] = $error;
        }

        if($errors)
        {
            $this->output->result = 'fail';
            $this->output->data   = $errors;

            die($this->app->encrypt($this->output));
        }

        $onlineUsers  = array($userID);
        $offlineUsers = array();
        $users = $this->chat->getUserList($status = '', array_values($chat->members));
        foreach($users as $id => $user)
        {
            if($id == $userID) continue;

            if($user->clientStatus == 'offline')
            {
                $offlineUsers[] = $id;
            }
            else
            {
                $onlineUsers[] = $id;
            }
        }

        /* Create messages. */
        $messages = $this->chat->createMessage($messages, $userID);
        $this->chat->saveOfflineMessages($messages, $offlineUsers);

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Send message failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = $onlineUsers;
            $this->output->data   = $messages;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Get history messages of a chat.
     *
     * @param  string $gid
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @param  int    $recTotal
     * @param  bool   $continued
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function history($gid = '', $recPerPage = 20, $pageID = 1, $recTotal = 0, $continued = false, $startDate = 0, $userID = 0)
    {
        if($startDate) $startDate = date('Y-m-d H:i:s', $startDate);

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        if($gid)
        {
            $messageList = $this->chat->getMessageListByCGID($gid,  $pager, $startDate);
        }
        else
        {
            $messageList = $this->chat->getMessageList($idList = array(), $pager, $startDate);
        }

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Get history failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $messageList;

            $pagerData = new stdclass();
            $pagerData->recPerPage = $pager->recPerPage;
            $pagerData->pageID     = $pager->pageID;
            $pagerData->recTotal   = $pager->recTotal;
            $pagerData->gid        = $gid;
            $pagerData->continued  = $continued;

            $this->output->pager = $pagerData;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Save or get settings.
     *
     * @param  string $account
     * @param  string $settings
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function settings($account = '', $settings = '', $userID = 0)
    {
        $this->loadModel('setting');
        if($settings)
        {
            $this->setting->setItem("system.sys.chat.settings.$account", helper::jsonEncode($settings));
        }

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Save settings failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = !empty($settings) ? $settings : json_decode($this->setting->getItem("owner=system&app=sys&module=chat&section=settings&key=$account"));
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Upload file.
     *
     * @param  string $fileName
     * @param  string $path
     * @param  int    $size
     * @param  int    $time
     * @param  string $gid
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function uploadFile($fileName = '', $path = '', $size = 0, $time = 0, $gid = '', $userID = 0)
    {
        $chat = $this->chat->getByGID($gid, true);
        if(!$chat)
        {
            $this->output->result  = 'fail';
            $this->output->message = $this->lang->chat->notExist;

            die($this->app->encrypt($this->output));
        }

        $user      = $this->chat->getUserByUserID($userID);
        $users     = $this->chat->getUserList($status = 'online', array_values($chat->members));
        $extension = $this->loadModel('file')->getExtension($fileName);

        $file = new stdclass();
        $file->pathname    = $path;
        $file->title       = rtrim($fileName, ".$extension");
        $file->extension   = $extension;
        $file->size        = $size;
        $file->objectType  = 'chat';
        $file->objectID    = $chat->id;
        $file->addedBy     = !empty($user->account) ? $user->account : '';
        $file->addedDate   = date(DT_DATETIME1, $time);

        $this->dao->setAutoLang(false)->insert(TABLE_FILE)->data($file)->exec();

        $fileID = $this->dao->lastInsertID();
        $path  .= md5($fileName . $fileID . $time);
        $this->dao->setAutoLang(false)->update(TABLE_FILE)->set('pathname')->eq($path)->where('id')->eq($fileID)->exec();

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Upload file failed.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array_keys($users);
            $this->output->data   = $fileID;
        }

        die($this->app->encrypt($this->output));
    }

    /**
     * Get latest notification and offline user.
     * @param array $offline
     * @param array $sendfail
     * @access public
     * @return void
     */
    public function notify($offline = array(), $sendfail = array())
    {
        if(!empty($offline))  $this->chat->offlineUser($offline);
        if(!empty($sendfail)) $this->chat->sendFailMessage($sendfail);

        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = "Get notify fail.";
        }
        else
        {
            $this->output->result = 'success';
            $this->output->data   = $this->chat->getNotify();
        }
        die($this->app->encrypt($this->output));
    }

    /**
     * Get offline notify by user id.
     * @param int $userID
     * @access public
     * @return void
     */
    public function getOfflineNotify($userID = 0)
    {
        $messages = $this->chat->getOfflineNotify($userID);
        if(dao::isError())
        {
            $this->output->result  = 'fail';
            $this->output->message = 'Get offline notify fail.';
        }
        else
        {
            $this->output->result = 'success';
            $this->output->users  = array($userID);
            $this->output->data   = $messages;
        }
        $this->output->method = 'notify';
        die($this->app->encrypt($this->output));
    }

    /**
     * Create, edit or delte todo
     * @param  object $todo
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function upsertTodo($todo, $userID = 0)
    {
        $user = $this->chat->getUserByUserID($userID);
        if(is_object($todo))
        {
            if($todo->id)
            {
                if($todo->delete)
                {
                    $todo = $this->loadModel('todo')->getById($todo->id);
                    if($todo->account != $user->account)
                    {
                        $this->output->result  = 'fail';
                        $this->output->message = 'Cannot delete todo item witch not yours.';
                        $this->output->data    = $todo;
                        $this->output->user    = $user;
                    }
                    else
                    {
                        $this->dao->setAutoLang(false)->delete()->from(TABLE_TODO)->where('id')->eq($todo->id)->exec();
                        if(dao::isError())
                        {
                            $this->output->result  = 'fail';
                            $this->output->message = dao::getError();
                        }
                        else
                        {
                            $this->loadModel('action')->create('todo', $todo->id, 'deleted');

                            $this->output->result = 'success';
                            $this->output->data   = $todo;
                        }
                    }
                }
                else
                {
                    $_POST = (array)$todo;
                    $changes = $this->loadModel('todo')->update($todo->id);
                    if(dao::isError())
                    {
                        $this->output->result  = 'fail';
                        $this->output->message = dao::getError();
                    }
                    else
                    {
                        $actionID = $this->loadModel('action')->create('todo', $todo->id, 'edited', 'from xuanxuan.');
                        $this->action->logHistory($actionID, $changes);

                        $this->output->result = 'success';
                        $this->output->data   = $todo;
                    }
                }
            }
            else
            {
                $_POST  = (array)$todo;
                $todoID = $this->loadModel('todo')->create($todo->date, $user->account);
                if(dao::isError())
                {
                    $this->output->result  = 'fail';
                    $this->output->message = dao::getError();
                }
                else
                {
                    $this->loadModel('action')->create('todo', $todoID, 'created');
                    $todo->id = $todoID;

                    $this->output->result = 'success';
                    $this->output->data   = $todo;
                }
            }
        }
        else
        {
            $this->output->message = 'The todo param is not an object.';
            $this->output->result  = 'fail';
        }
        $this->output->users = array($userID);
        die($this->app->encrypt($this->output));
    }

    /**
     * Get todoes list
     *
     * @param  string $mode
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function getTodoes($mode = 'all', $status = 'unclosed', $orderBy = 'date_asc', $recTotal = 0, $recPerPage = 20, $pageID = 1, $userID = 0)
    {
        $user = $this->chat->getUserByUserID($userID);
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        if($mode == 'future')
        {
            $todos = $this->loadModel('todo')->getList('self', $user->account, 'future', empty($status) ? 'unclosed' : $status, $orderBy, $pager);
        }
        else if($mode == 'all')
        {
            $todos = $this->loadModel('todo')->getList('self', $user->account, 'all', empty($status) ? 'all' : $status, $orderBy, $pager);
        }
        else if($mode == 'undone')
        {
            $todos = $this->loadModel('todo')->getList('self', $user->account, 'before', empty($status) ? 'undone' : $status, $orderBy, $pager);
        }
        else
        {
            $todos = $this->loadModel('todo')->getList($mode, $user->account, 'all', empty($status) ? 'unclosed' : $status, $orderBy, $pager);
        }

        $this->output->data   = $todos;
        $this->output->result = 'success';
        $this->output->users  = array($userID);
        die($this->app->encrypt($this->output));
    }

    /**
     * Check user change.
     *
     * @access public
     * @return void
     */
    public function checkUserChange()
    {
        $this->output->result = 'success';
        $this->output->data   = $this->chat->checkUserChange();
        die($this->app->encrypt($this->output));
    }

    /**
     * Get extensions.
     *
     * @param  int    $userID
     * @access public
     * @return void
     */
    public function extensions($userID = 0)
    {
        $this->output->result = 'success';
        $this->output->data   = $this->chat->getExtensionList($userID);
        $this->output->users  = array($userID);
        die($this->app->encrypt($this->output));
    }
}
