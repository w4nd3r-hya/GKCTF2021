<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of file module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id: control.php 1042 2010-08-19 09:02:39Z yuren_@126.com $
 * @link        http://www.chanzhi.org
 */
class file extends control
{
    /**
     * The management of files.
     * 
     * @param  void
     * @access public
     * @return void
     */
    public function admin($type = 'valid', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 6,  $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $files = $type == 'valid' ? $this->file->getList($orderBy, $pager) : $this->file->getInvalidList($pager);

        $this->lang->menuGroups->file = 'attachment'; 
        
        $this->view->title = $this->lang->file->admin;
        $this->view->type  = $type;
        $this->view->files = $files;
        $this->view->pager = $pager;
        $this->display();
    }
    
    /**
     * Delete the invalid file
     *
     * @access public
     * @param  string
     * @return array
     */ 
    public function deleteInvalidFile($pathname)
    {
        $pathname = urldecode($pathname);
        $pathname = realpath($this->app->getDataRoot() . 'upload/' . $pathname); 
        if($pathname === false) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        if(strpos($pathname, $this->app->getDataRoot() . 'upload') === false)
        {
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        
        $result = $this->file->deleteInvalidFile($pathname);
        if($result) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Batch delete invalid files.
     * 
     * @access public
     * @return void
     */
    public function batchDeleteInvalid()
    {
        if($_POST)
        {
            $fileList = $_POST['fileList'];
            foreach($fileList as $pathname)
            {
                $pathname = urldecode($pathname);
                $pathname = realpath($this->app->getDataRoot() . 'upload/' . $pathname); 
                if($pathname === false) $this->send(array('result' => 'fail', 'message' => dao::getError()));
                if(strpos($pathname, $this->app->getDataRoot() . 'upload') === false)
                {
                    $this->send(array('result' => 'fail', 'message' => dao::getError()));
                }
                $this->file->deleteInvalidFile($pathname);
            }
            $this->send(array('result' => 'success', 'message' =>$this->lang->deleteSuccess, 'locate' => inlink('admin', 'type=invalid')));
        }
        $this->send(array('result' => 'success', 'locate' => inlink('admin', 'type=invalid')));
    }

    /**
     * Delete all the invalid file
     *
     * @access public
     * @param  string
     * @return array
     */ 
    public function deleteAllInvalid()
    {
        $files  = $this->file->getInvalidList();
        foreach($files as $file)
        {
            $result = $this->file->deleteInvalidFile($file->realPathname);
            if(!$result)
            {
                $this->send(array('result' => 'fail', 'message' => dao::getError()));
                break;
            }
        }
        $this->send(array('result' => 'success', 'locate' => inlink('admin', 'type=invalid')));
    }
    
    /**
     * Build the upload form.
     * 
     * @param int $fileCount 
     * @param float $percent 
     * @access public
     * @return void
     */
    public function buildForm($fileCount = 2, $percent = 0.9)
    {
        if(!$this->file->canUpload()) return;
        $this->view->writeable = $this->file->checkSavePath();
        $this->view->fileCount = $fileCount;
        $this->view->percent   = $percent;
        $this->display();
    }

    /**
     * Build the list part of files.
     * 
     * @param array $files
     * @access public
     * @return string
     */
    public function buildList($files)
    {
        $this->view->files = $files;
        $this->display();
    }

    /**
     * AJAX: get upload request from the web editor.
     *
     * @access public
     * @return void
     */
    public function apiForUeditor($uid = '')
    {
        if($this->get->action == 'config') die(json_encode($this->config->file->ueditor));
        if($this->get->action == '') die(json_encode($this->file->getListForUeditor()));

        $file = $this->file->getUpload('upfile');

        $file = $file[0];
        if($file)
        {
            if($file['size'] == 0) die(json_encode(array('state' => $this->lang->file->errorFileUpload)));
            $saveName = $this->file->getSaveName($file['pathname']);
            $realPathName = $this->file->savePath . $saveName;

            if(@move_uploaded_file($file['tmpname'], $realPathName))
            {
                if(strtolower($file['extension']) != 'gif' and in_array(strtolower($file['extension']), $this->config->file->imageExtensions) !== false)
                {
                    /* Compress image for jpg and bmp. */
                    $this->file->compressImage($this->file->savePath . $this->file->getSaveName($file['pathname']));
                    if(isset($this->config->file->watermark) and $this->config->file->watermark == 'open')
                    {
                        $this->file->setWatermark($realPathName);
                    }
                    $imageSize = $this->file->getImageSize($realPathName);
                    $file['width']  = $imageSize['width'];
                    $file['height'] = $imageSize['height'];
                }
                $file['addedBy']   = $this->app->user->account;
                $file['addedDate'] = helper::today();
                $file['editor']    = 1;
                $file['lang']      = 'all';
                unset($file['tmpname']);
                $this->dao->insert(TABLE_FILE)->data($file)->exec();

                $fileID = $this->dao->lastInsertID();
                $file   = $this->file->getById($fileID);
                $url    = $this->file->printFileURL($file, 'full');
                if($uid) $_SESSION['album'][$uid][] = $fileID;
                die(json_encode(array('state' => 'SUCCESS', 'url' => $url)));
            }
            else
            {
                $error = strip_tags(sprintf($this->lang->file->errorCanNotWrite, $this->file->savePath, $this->file->savePath));
                die(json_encode(array('state' => $error)));
            }
        }
    }

    /**
     * AJAX: the api to recive the file posted through ajax.
     * 
     * @param  string $uid 
     * @access public
     * @return array
     */
    public function ajaxUpload($uid)
    {
        if(RUN_MODE == 'front' and !commonModel::isAvailable('forum') and !commonModel::isAvailable('submission')) exit;
        if(!$this->loadModel('file')->canUpload())  $this->send(array('error' => 1, 'message' => $this->lang->file->uploadForbidden));
        $file = $this->file->getUpload('imgFile');
        $file = $file[0];
        if($file)
        {
            if(!$this->file->checkSavePath()) $this->send(array('error' => 1, 'message' => $this->lang->file->errorUnwritable));
            if(!in_array(strtolower($file['extension']), $this->config->file->editorExtensions)) $this->send(array('error' => 1, 'message' => $this->lang->fail));

            $saveName = $this->file->getSaveName($file['pathname']);
            $realPathName = $this->file->savePath . $saveName;
            move_uploaded_file($file['tmpname'], $realPathName);

            if(strtolower($file['extension']) != 'gif' and in_array(strtolower($file['extension']), $this->config->file->imageExtensions) !== false)
            {
                $this->file->compressImage($realPathName);
                if(isset($this->config->file->watermark) and $this->config->file->watermark == 'open')
                {
                    $this->file->setWatermark($realPathName);
                }
                $imageSize = $this->file->getImageSize($realPathName);
                $file['width']  = $imageSize['width'];
                $file['height'] = $imageSize['height'];
            }

            $file['addedBy']   = $this->app->user->account;
            $file['addedDate'] = helper::now();
            $file['editor']    = 1;
            $file['lang']      = 'all';
            unset($file['tmpname']);
            $this->dao->insert(TABLE_FILE)->data($file)->exec();

            $fileID = $this->dao->lastInsertID();

            /* Build file url information */
            $fileURL = array();
            $fileURL['pathname']  = $saveName;
            $fileURL['extension'] = $file['extension'];

            $url = $this->file->printFileURL($fileURL);
            $_SESSION['album'][$uid][] = $fileID;
            $this->loadModel('setting')->setItems('system.common.site', array('lastUpload' => time()));
            die(json_encode(array('error' => 0, 'url' => $url)));
        }
    }

    /**
     * The list page of an object
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @param  bool   $isImage 
     * @access public
     * @return void
     */
    public function browse($objectType, $objectID, $isImage = null)
    {
        $this->view->title    = "<i class='icon-paper-clip'></i> " . ($isImage ? $this->lang->file->imageList : $this->lang->file->browse);
        $this->view->files    = $this->file->getByObject($objectType, $objectID, $isImage);
        $this->view->showSort = true;

        if($objectType == 'product' and $isImage) $this->view->title .= "<span class='text-danger'> （{$this->lang->file->productTip}）</span>";
        
        if($objectType == 'source')
        {
            $this->view->title    = "<i class='icon-paper-clip'></i> " . $this->lang->file->sourceList;
            $this->view->files    = array();
            $this->view->showSort = false;
        }

        $this->view->modalWidth = 800;
        $this->view->writeable  = $this->file->checkSavePath();
        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->view->users      = $this->loadModel('user')->getPairs();
        $this->view->isImage    = $isImage;
        $this->display();
    }
  
    /**
     * Edit for the file
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @access public
     * @return void
     */
    public function edit($fileID)
    {
        $file = $this->file->getById($fileID);

        if(!empty($_POST))
        {
            if(!$this->file->checkSavePath()) $this->send(array('result' => 'fail', 'message' => $this->lang->file->errorUnwritable));
            $this->file->edit($fileID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }
        $this->view->title      = $this->lang->file->edit;
        $this->view->modalWidth = 800;
        $this->view->file       = $file;
        $this->display();
    }

    /**
     * The list page of an object
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $pageID       current page id
     * @access public
     * @return void
     */
    public function browseSource($type = '', $orderBy = 'id_desc', $pageID = 1)
    {
        $this->file->setSavePath('source');
        $this->lang->menuGroups->file = 'ui';

        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, 10, $pageID);

        $this->view->title     = $this->lang->file->source;
        $this->view->writeable = $this->file->checkSavePath();
        $this->view->type      = $type;
        $this->view->files     = $this->file->getSourceList($type, $orderBy, $pager);
        $this->view->users     = $this->loadModel('user')->getPairs();
        $this->view->pager     = $pager;
        $this->view->uiHeader  = true;
        $this->display();
    }

    /**
     * Edit for the source file. 
     * 
     * @param  int $fileID 
     * @access public
     * @return void
     */
    public function editSource($fileID)
    {
        $this->file->setSavePath('source');
        $file = $this->file->getById($fileID);
        if(!empty($_POST))
        {
            if(!$this->file->checkSavePath()) $this->send(array('result' => 'fail', 'message' => $this->lang->file->errorUnwritable));
            if($this->post->filename == false or $this->post->filename == '') $this->send(array('result' => 'fail', 'message' => $this->lang->file->nameEmpty));

            $filename = $this->post->filename;
            if(!validater::checkFileName($filename)) $this->send(array('result' => 'fail', 'message' => $this->lang->file->evilChar));

            if(!$this->post->continue)
            {
                $extension    = $this->file->getExtension($_FILES['upFile']['name']);
                $sameUpFile   = $this->file->checkSameFile(str_replace('.' . $extension, '', $_FILES['upFile']['name']), $fileID);
                $sameFilename = $this->file->checkSameFile($this->post->filename, $fileID);
                if(!empty($sameUpFile) or !empty($sameFilename))$this->send(array('result' => 'fail', 'message' => $this->lang->file->sameName));
            }

            $result = $this->file->editSource($file, $filename);
            if($result) $this->send(array('result' => 'success','message' => $this->lang->saveSuccess, 'locate' => $this->createLink('file', 'browseSource')));
            $this->send(array('result' => 'fail', 'message' => dao::getError() ));
        }
        $this->view->title      = $this->lang->file->edit;
        $this->view->modalWidth = 500;
        $this->view->file       = $file;
        $this->display();
    }

    /**
     * Upload files for an object.
     * 
     * @param  string $objectType 
     * @param  string $objectID 
     * @access public
     * @return void
     */
    public function upload($objectType, $objectID)
    {

        $this->file->setSavePath($objectType);
        if(!$this->file->checkSavePath()) die(json_encode(array('result' => 'fail', 'message' => $this->lang->file->errorUnwritable)));

        if($objectType == 'source' and !$this->post->continue)
        {
            foreach($_FILES['files']['name'] as $id => $name)
            {
                $extension    = $this->file->getExtension($name);
                $filename     = !empty($_POST['labels'][$id]) ? htmlspecialchars($_POST['labels'][$id]) : str_replace('.' . $extension, '', $name);
                $sameFilename = $this->file->checkSameFile($filename);
                if(!empty($sameFilename)) die(json_encode(array('result' => 'fail', 'message' => $this->lang->file->sameName)));
            }
        }

        $files = $this->file->getUpload('files', $objectType);
        if($files) $this->file->saveUpload($objectType, $objectID);

        die(json_encode(array('result' => 'success', 'message' => $this->lang->saveSuccess)));
    }

    /**
     * Upload file with zui.uploader for an object.
     * 
     * @param  string $objectType 
     * @param  string $objectID 
     * @access public
     * @return void
     */
    public function uploadFile($objectType, $objectID)
    {
        $this->file->setSavePath($objectType);
        if(!$this->file->checkSavePath()) die(json_encode(array('result' => 'fail', 'message' => $this->lang->file->errorUnwritable)));
        
        if($objectType == 'source')
        {
            $name         = $_FILES['file']['name'];
            $extension    = $this->file->getExtension($name);
            $filename     = !empty($_POST['label']) ? htmlspecialchars($_POST['label']) : str_replace('.' . $extension, '', $name);
            $sameFilename = $this->file->checkSameFile($filename);
            if(!empty($sameFilename)) die(json_encode(array('result' => 'fail', 'file' => $name, 'message' => $filename . '.' . $extension . $this->lang->file->sameName)));
        }

        $file = $this->file->getUploadFile('file', $objectType);
        if($file) $file = $this->file->saveUploadFile($file, $objectType, $objectID);

        $url = $this->file->printFileURL($file);
        die(json_encode(array('result' => 'success', 'file' => $file, 'message' => $this->lang->saveSuccess, 'url' => $url)));
    }

    /**
     * Down a file.
     * 
     * @param  int    $fileID 
     * @param  string $mouse 
     * @access public
     * @return void
     */
    public function download($fileID, $mouse = '')
    {
        $file = $this->file->getById($fileID);

        /* Change savePath if objectType is source or slide. */
        if(strpos(',slide,source,', ",{$file->objectType},") !== false)
        {
            $this->file->setSavePath('source');
            $file = $this->file->getById($fileID);
        }
        /* Judge the mode, down or open. */
        $mode  = 'down';
        $fileTypes = 'txt|jpg|jpeg|gif|png|bmp|xml|html';
        if(stripos($fileTypes, $file->extension) !== false and $mouse == 'left') $mode = 'open';

        if(!$file->public && $this->app->user->account == 'guest') $this->locate($this->createLink('user', 'login'));

        /* If the mode is open, locate directly. */
        if($mode == 'open')
        {
            if(file_exists($file->realPath) or (isset($file->syncStatus) and $file->syncStatus == 'synced'))
            {
                $mime = zget($this->config->file->mimes, $file->extension, 'default');
                header("content-type: $mime");

                $handle = fopen($file->realPath, "r");
                if($handle)
                {
                    while(!feof($handle)) echo fgets($handle);
                    fclose($handle);
                }
                exit;
            }
            $this->app->triggerError("The file you visit $fileID not found.", __FILE__, __LINE__, true);
        }
        else
        {
            /* Down the file. */
            if(file_exists($file->realPath) or (isset($file->syncStatus) and $file->syncStatus == 'synced'))
            {
                $fileName = $file->title . '.' . $file->extension;
                $fileData = file_get_contents($file->realPath);
                $fileSize = file_exists($file->realPath) ? filesize($file->realPath) : $file->size;

                /* Recording download times, downloads of this file plus one. */
                $this->file->log($fileID);

                $this->file->sendDownHeader($fileName, $file->extension, $fileData, $fileSize);

            }
            else
            {
                $this->app->triggerError("The file you visit $fileID not found.", __FILE__, __LINE__, true);
            }
        }
    }

    /**
     * Allow a file to public.
     * 
     * @param  int  $fileID 
     * @access public
     * @return void
     */
    public function allow($fileID)
    {
        $this->dao->update(TABLE_FILE)->set('public')->eq(1)->where('id')->eq($fileID)->exec();
        $this->send(array( 'result' => 'success', 'message' => $this->lang->setSuccess));
    }

    /**
     * Deny a file from public.
     * 
     * @param  int  $fileID 
     * @access public
     * @return void
     */
    public function deny($fileID)
    {
        $this->dao->update(TABLE_FILE)->set('public')->eq(0)->where('id')->eq($fileID)->exec();
        $this->send(array( 'result' => 'success', 'message' => $this->lang->setSuccess));
    }

    /**
     * Order image.
     * 
     * @access public
     * @return void
     */
    public function sort()
    {
        if($_POST)
        {   
            $orders = $_POST;
            foreach($orders as $id => $order)
            {        
                $this->dao->update(TABLE_FILE)->set('order')->eq($order)->where('id')->eq($id)->exec();
            }        

            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }
    }

    /**
     * Export as csv format.
     * 
     * @access public
     * @return void
     */
    public function export2CSV()
    {
        $this->view->fields = $this->post->fields;
        $this->view->rows   = $this->post->rows;
        $output = $this->parse('file', 'export2csv');

        /* If the language is zh-cn, convert to gbk. */
        $clientLang = $this->app->getClientLang();
        if($clientLang == 'zh-cn')
        {
            if(function_exists('mb_convert_encoding'))
            {
                $output = @mb_convert_encoding($output, 'gbk', 'utf-8');
            }
            elseif(function_exists('iconv'))
            {
                $output = @iconv('utf-8', 'gbk', $output);
            }
        }

        $this->file->sendDownHeader($this->post->fileName, 'csv', $output);
    }

    /**
     * Delet a file.
     *
     * @param  int  $fileID
     * @return void
     */
    public function delete($fileID)
    {
        $this->dao->delete()->from(TABLE_FILE)->where('id')->eq($fileID)->exec();
        if(!dao::isError()) $this->send(array('result' => 'success')); 
        $this->send(array('result' => 'fail', 'message' => dao::getError())); 
    }

    /**
     * Delet a file.
     *
     * @param  int  $fileID
     * @return void
     */
    public function deleteSource($fileID)
    {
        $this->file->setSavePath('source');
        $file = $this->file->getByID($fileID);
        if(file_exists($file->realPath)) @unlink($file->realPath);
        $this->dao->delete()->from(TABLE_FILE)->where('id')->eq($fileID)->exec();
        if(!dao::isError()) $this->send(array('result' => 'success')); 
        $this->send(array('result' => 'fail', 'message' => dao::getError())); 
    }

    /**
     * Paste image in kindeditor at firefox and chrome. 
     * 
     * @param  string uid
     * @access public
     * @return void
     */
    public function ajaxPasteImage($uid)
    {
        if($_POST)
        {
            echo $this->file->pasteImage($this->post->editor, $uid);
        }
    }

    /**
     * Get file from file directory in kindeditor. 
     * 
     * @access public
     * @return void
     */
    public function fileManager()
    {
        $fileTypes = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
        $order = $this->get->order ? strtolower($this->get->order) : 'name';

        if(empty($_GET['path']))
        {
            $currentPath    = $this->file->savePath;
            $currentUrl     = $this->file->webPath;
            $currentDirPath = '';
            $moveupDirPath  = '';
        }
        else
        {
            $currentPath    = rtrim($this->file->savePath, '/') . '/' . $this->get->path;
            $currentUrl     = rtrim($this->file->webPath, '/') . '/' . $this->get->path;
            $currentDirPath = $this->get->path;
            $moveupDirPath  = preg_replace('/(.*?)[^\/]+\/$/', '$1', $currentDirPath);
        }

        if(preg_match('/\.\./', $currentPath)) die($this->lang->file->noAccess);
        if(!preg_match('/\/$/', $currentPath)) die($this->lang->file->invalidParameter);
        if(!file_exists($currentPath) || !is_dir($currentPath)) die($this->lang->file->unWritable);

        $files = $this->dao->select('*')->from(TABLE_FILE)->where('pathname')->like("{$this->get->path}%")->fetchAll();

        $fileList = array();
        if($fileDir = opendir($currentPath))
        {
            $i = 0;
            while(($filename = readdir($fileDir)) !== false)
            {
                if($filename{0} == '.') continue;
                $file = $currentPath . $filename;
                $fileList[$i]['filename'] = $filename;
                if(is_dir($file))
                {
                    $fileList[$i]['is_dir']   = true;
                    $fileList[$i]['has_file'] = (count(scandir($file)) > 2);
                    $fileList[$i]['filesize'] = 0;
                    $fileList[$i]['is_photo'] = false;
                    $fileList[$i]['filetype'] = '';
                }
                else
                {
                    $fileExtension = $this->file->getExtension($file);
                    if($fileExtension == 'txt')
                    {
                        foreach($files as $fileInfo)
                        {
                            if(strpos($fileInfo->pathname, $filename) !== false)
                            {
                                $fileExtension = $fileInfo->extension;
                                break;
                            }
                        }
                    }

                    if(!in_array($fileExtension, $this->config->file->editorExtensions, true))
                    {
                        unset($fileList[$i]);
                        continue;
                    }

                    $imageSize = 'fullURL';
                    if(strpos($filename, 's_') !== false) $imageSize = 'smallURL';
                    if(strpos($filename, 'm_') !== false) $imageSize = 'middleURL';
                    if(strpos($filename, 'l_') !== false) $imageSize = 'largeURL';

                    if(strpos($filename, '.') !== false)
                    {
                        $pathname = $this->get->path . str_replace(array('s_', 'm_', 'l_'), 'f_', substr($filename, 0, strpos($filename, '.'))) . '.' . $fileExtension;
                    }
                    else
                    {
                        $pathname = $this->get->path . $filename . '.' . $fileExtension;
                    }

                    $fileList[$i]['is_dir']    = false;
                    $fileList[$i]['has_file']  = false;
                    $fileList[$i]['filesize']  = filesize($file);
                    $fileList[$i]['dir_path']  = '';
                    $fileList[$i]['is_photo']  = in_array($fileExtension, $fileTypes);
                    $fileList[$i]['filetype']  = $fileExtension;
                    $fileList[$i]['pathname']  = $pathname;
                    $fileList[$i]['imagesize'] = $imageSize;
                    $fileList[$i]['filename']  = $filename . "?fromSpace=y";

                    /* Build file url information */
                    $fileURL = array();
                    $fileURL['pathname']  = $pathname;
                    $fileURL['extension'] = $fileExtension;
                    $fileList[$i]['fileurl']   = $this->file->printFileURL($fileURL);
                }

                $fileList[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file));
                $fileList[$i]['order']    = $order;
                $i++;
            }
            closedir($fileDir);
        }

        usort($fileList, "fileModel::sort");

        $result = array();
        $result['moveup_dir_path']  = $moveupDirPath;
        $result['current_dir_path'] = $currentDirPath;
        $result['current_url']      = $currentUrl;
        $result['total_count']      = count($fileList);
        $result['file_list']        = $fileList;

        die(json_encode($result));
    }

    /**
     * Select file. 
     * 
     * @param  string $path 
     * @param  string $type 
     * @param  string $callback 
     * @access public
     * @return void
     */
    public function selectImage($callback = '', $id = '')
    {
        $callback = $callback == '' ? "''" : "$callback()";
        $result   = array();
        $files    = $this->file->getSourceList();
        foreach($files as $key => $file) if($file->isImage) $result[$key] = $file; 

        $this->view->title    = $this->lang->file->source;
        $this->view->files    = $result;
        $this->view->callback = $callback;
        $this->view->id       = $id;
        $this->display();
    }

    /**
     * Set score for file. 
     * 
     * @access public
     * @return void
     */
    public function score()
    {
        foreach($this->post->scores as $fileID => $score)
        {
            if($score) $this->dao->update(TABLE_FILE)->set('score')->eq($score)->set('public')->eq(0)->where('id')->eq($fileID)->exec();
        }
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
    }

    /**
     * Rebuild thumb images.
     * 
     * @param  int    $imageDirKey 
     * @param  int    $lastImage 
     * @access public
     * @return void
     */
    public function rebuildThumbs($imageDirKey = 0, $lastImage = 0, $completed = 0, $total = 0)
    {
        $imageDirs = glob($this->app->getDataRoot() . "upload/*");
        if($total == 0)
        {
            foreach($imageDirs as $dir)
            {
                $images = glob($dir . '/f_*');
                $total  += count($images);
            }
        }
        $rate = round($completed / $total * 100) . $this->lang->percent;

        $imageDir   = $imageDirs[$imageDirKey];
        $images     = glob($imageDir . '/f_*');
        $imageCount = count($images);
        $limit      = $imageCount - $lastImage >= 10 ? 10 : $imageCount - $lastImage; 
        $rawImages  = array_slice($images, $lastImage, $limit);
        $completed += $limit;

        foreach($rawImages as $image)
        {
            $extension = $this->file->getExtension($image);
            if(in_array(strtolower($extension), $this->config->file->imageExtensions, true) === false) continue;
            $this->file->compressImage($image);
        }

        if($lastImage + $limit == $imageCount)
        { 
            if($imageDirKey == count($imageDirs) - 1) $this->send(array('result' => 'finished', 'message' => $this->lang->createSuccess));
            if($imageDirKey < count($imageDirs) - 1)
            {
                $imageDirKey = $imageDirKey + 1;
                $this->send(array('result' => 'unfinished', 'next' => inlink('rebuildThumbs', "imageDirKey=$imageDirKey&lastImage=0&completed=$completed&total=$total"), 'completed' => sprintf($this->lang->file->rebuildThumbs, $rate)));
            }
        }
        else
        {
            $lastImage = $lastImage + $limit;
            $this->send(array('result' => 'unfinished', 'next' => inlink('rebuildthumbs', "imageDirKey=$imageDirKey&lastImage=$lastImage&completed=$completed&total=$total"), 'completed' => sprintf($this->lang->file->rebuildThumbs, $rate)));
        }
    }

    /**
     * Batch delete files.
     * 
     * @access public
     * @return void
     */
    public function batchDelete()
    {
        if($_POST)
        {
            $fileList = $_POST['fileList'];
            foreach($fileList as $fileID)
            {
                $this->file->delete($fileID);
            }
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' =>$this->lang->deleteSuccess, 'locate' => inlink('admin')));
        }
        $this->send(array('result' => 'success', 'message' =>$this->lang->deleteSuccess, 'locate' => inlink('admin')));
    }
    
    /**
     * Rebuild file watermark 
     * 
     * @param  int    $imageDirKey 
     * @param  int    $lastImage 
     * @param  int    $completed 
     * @param  int    $total 
     * @access public
     * @return void
     */
    public function rebuildWatermark($last = 0, $total = 0)
    {
        $images = $this->file->scanImages();
        if($total == 0) $total = count($images);
        $limit      = $total - $last >= 10 ? 10 : $total - $last; 
        $rawImages  = array_slice($images, $last, $limit);
        $last       += $limit;
        $progress   = round($last / $total * 100) . $this->lang->percent;
        
        foreach($rawImages as $image) $this->file->setWatermark($image);
        
        if($last >= $total) $this->send(array('result' => 'finished', 'message' => $this->lang->createSuccess));
        $this->send(array('result' => 'unfinished', 'next' => inlink('rebuildWatermark', "last=$last&total=$total"), 'completed' => sprintf($this->lang->file->rebuildWatermarks, $progress)));
    }
}
