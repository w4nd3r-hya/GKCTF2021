<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of file module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
class fileModel extends model
{
    public $savePath = '';
    public $webPath  = '';
    public $now      = 0;

    /**
     * The construct function, set the save path and web path.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->now = time();
        $this->setSavePath();
        $this->setWebPath();
    }
    
    /**
     * Get the list of file from database file
     * 
     * @param  void
     * @access public
     * @return array
     */
    public function getList($orderBy, $pager)
    {
        $files = $this->dao->select('*')->from(TABLE_FILE)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        foreach($files as $file)
        {
            if($file->objectType == 'source' or $file->objectType == 'slide')
            {
                $file->existStatus = file_exists($this->app->getDataRoot() .  $this->getRealPathName($file->pathname, $file->objectType)) ? 'yes' : 'no';
            }
            else
            {
                $file->existStatus = file_exists($this->app->getDataRoot() . 'upload/' . $this->getRealPathName($file->pathname)) ? 'yes' : 'no';
            }
            $this->processFile($file);
        }

        return $files;
    }

    /**
     * Get the list of invalid files
     * 
     * @param  void
     * @access public
     * @return array
     */
    public function getInvalidList($pager = null)
    {
        $dataRoot     = $this->app->getDataRoot();
        $uploadFiles  = glob($dataRoot . "/upload/*/*"); 
        $invalidFiles = array();
        foreach($uploadFiles as $uploadFile)
        {
            $name = basename($uploadFile);
            $tag  = substr(substr($name, strpos($name, '_') + 1), 0, strpos($name, '.') - 2);
            if(strlen($tag) < 10) continue;
            if(!$this->checkExistence($tag)) $invalidFiles[] = $uploadFile; 
        }
        
        $unusedFiles = array();
        foreach($invalidFiles as $invalidFile) 
        { 
            $unusedFile               = new stdclass();
            $unusedFile->realPathname = $invalidFile; 
            $unusedFile->pathname     = substr($invalidFile, strlen($this->app->getDataRoot() . 'upload/'));
            $unusedFile->extension    = $this->getExtension($invalidFile);
            $unusedFile->size         = filesize($invalidFile);
            $unusedFile->addedDate    = date("Y-m-d H:i:s", filemtime($invalidFile));
                  
            $unusedFiles[] = $unusedFile;
        }   
        if($pager !== null)
        {
            $pager->recTotal  = count($unusedFiles);
            $pager->pageTotal = ceil($pager->recTotal / $pager->recPerPage);
            $unusedFiles      = array_slice($unusedFiles, ($pager->pageID - 1) * $pager->recPerPage, $pager->recPerPage);
        }

        return $unusedFiles;
    }

    /*
     * Check existence of filename in the database
     *
     * @param  string $fileTag
     * @access public 
     * @return bool
     */
    public function checkExistence($fileTag)
    {
        foreach($this->config->file->tables as $tableInfo)
        {
            list($table, $field) = explode('.', $tableInfo);
            $table = $this->config->db->prefix . $table;
            $searchResult = $this->dao->select("count('*') as count")->from($table)->where($field)->like("%$fileTag%")->fetch('count'); 
            if($searchResult) return true;
        }
        
        return false;
    }

    /* 
     * Delete the unused file 
     */
    public function deleteInvalidFile($pathname) 
    {
        return unlink($pathname);
    }
    
    /**
     * Print files.
     * 
     * @param  object $files 
     * @access public
     * @return void
     * @todo fix style.
     */
    public function printFiles($files)
    {
        if(empty($files)) return false;

        $imagesHtml = '';
        $filesHtml  = '';
        foreach($files as $file)
        {
            if($file->editor and $file->objectType != 'article') continue;
            if($file->isVideo and $file->editor) continue;

            $file->title = $file->title . ".$file->extension";
            $realPath = rtrim($this->app->getWwwRoot(), '/') . $file->fullURL;
            $fileMD5  = file_exists($realPath) ? md5_file($realPath) : '';
            $fileName = explode('.', basename($file->fullURL));
            $fileName = $fileName[0];
            if($file->isImage)
            {
                if($file->objectType == 'product') continue;
                if($file->editor)
                {
                    $imagesHtml .= "<li class='file-image hidden file-{$file->extension}'>" . html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), html::image($this->printFileURL($file, 'smallURL')), "target='_blank' class='$fileName' data-toggle='lightbox' data-img-width='{$file->width}' data-img-height='{$file->height}' title='{$file->title}'") . '</li>';
                }
                else
                {
                    $imagesHtml .= "<li class='file-image file-{$file->extension}'>" . html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), html::image($this->printFileURL($file, 'smallURL')), "target='_blank' class='$fileName' data-toggle='lightbox' data-img-width='{$file->width}' data-img-height='{$file->height}' title='{$file->title}'") . '</li>';
                }
            }
            else
            {
                $filesHtml .= "<li class='file file-{$file->extension}'>";
                $filesHtml .= html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), $file->title, "target='_blank' title='{$file->title}'");
                $filesHtml .= "<span class='file-download'><i class='icon-download'></i> " .  $file->downloads . "</span>";
                $filesHtml .= "<span class='file-md5'>" ;
                $filesHtml .= html::a('javascript:void(0)', 'MD5', "class='label' data-toggle='popover' data-placement='bottom' data-content='$fileMD5'");
                $filesHtml .= '</span></li>';
            }
        }
        echo "<ul class='files-list clearfix'>" . $imagesHtml . $filesHtml . '</ul>';
    }

    /**
     * Get files of an object list.
     * 
     * @param   string  $objectType 
     * @param   mixed   $objectID 
     * @param   bool    $isImage 
     * @access public
     * @return array
     */
    public function getByObject($objectType, $objectID, $isImage = null)
    {
        /* Get files group by objectID. */
        $files = $this->dao->setAutoLang(false)->select('*')
            ->from(TABLE_FILE)
            ->where('objectType')->eq($objectType)
            ->andWhere('objectID')->in($objectID)
            ->beginIf(isset($isImage) and $isImage)->andWhere('extension')->in($this->config->file->imageExtensions)->fi() 
            ->beginIf(isset($isImage) and !$isImage)->andWhere('extension')->notin($this->config->file->imageExtensions)->fi()
            ->orderBy('`order`, editor_desc') 
            ->fetchGroup('objectID');

        /* Process these files. */
        foreach($files as $objectFiles) $this->batchProcessFile($objectFiles);

        /* If object is only an objectID, return it's files, else return all. */
        if(is_numeric($objectID) and !empty($files[$objectID])) return $files[$objectID];
        return $files;
    }

    /**
     * Process images of object list.
     * 
     * @param  array     $objects 
     * @access public
     * @return array
     */
    public function processImages($objects, $type)
    {
        if(empty($objects)) return $objects;
        $idList = array_keys($objects);
        $images = $this->getByObject($type, $idList, $isImage = true);

        foreach($objects as $object)
        {
            if(empty($images[$object->id])) continue;

            $object->image = new stdclass();
            $object->image->list    = $images[$object->id];
            $object->image->primary = $object->image->list[0];
        }

        return $objects;
    }

    /**
     * Get source list. 
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getSourceList($type = '', $orderBy = 'id_desc', $pager = null)
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;

        $this->scanSources($template, $theme);

        $files = $this->dao->setAutoLang(false)->select('*')
            ->from(TABLE_FILE)
            ->where('objectType')->eq('slide')
            ->beginIf($type != '')->andWhere('extension')->in($type)->fi() 
            ->orWhere('objectType')->eq('source')
            ->andWhere('objectID')->eq("{$template}_{$theme}")
            ->beginIf($type != '')->andWhere('extension')->in($type)->fi() 
            ->orderBy($orderBy) 
            ->beginIf($pager != null)->page($pager)->fi()
            ->fetchAll('id');

        /* Process these files. */
        $filePathnames = array();
        foreach($files as $id => $objectFiles)
        {
            $this->processFile($objectFiles);
            $filePathnames[$id] = $objectFiles->pathname;
        }
        $filePathnames = array_unique($filePathnames);
        return $files;
    }

    /**
     * Sync sources and save to file table.
     * 
     * @param  string    $template 
     * @param  string    $theme 
     * @access public
     * @return void
     */
    public function scanSources($template, $theme)
    {
        $fileList = glob($this->app->getDataRoot() . "source/$template/$theme/*");
        $newFiles = array();

        foreach($fileList as $file)
        {
            $info = pathinfo($file);
            if(!isset($info['extension']) or !in_array($info['extension'], $this->config->file->imageExtensions)) continue;
            $file = str_replace($this->app->getDataRoot(), '', $file);
            $filesCount = $this->dao->select('count(*) as count')->from(TABLE_FILE)->where('pathname')->eq($file)->fetch('count');
            if($filesCount) continue;
            $newFiles[] = $file;
        }

        foreach($newFiles as $path)
        {
            $info = pathinfo($path);
            $file = new stdclass();
            $file->pathname   = $path;
            $file->title      = $info['filename'];
            $file->lang       = 'all';
            $file->objectType = 'source';
            $file->objectID   = "{$template}_{$theme}";
            $file->addedDate  = helper::now();
            $file->extension  = $info['extension'];
            $file->size       = filesize($this->app->getDataRoot() . $path);
            $this->dao->insert(TABLE_FILE)->data($file)->exec();
        }

        return true;
    }

    /**
     * processFile just is image and add smallURL and middleURL if necessary.
     *
     * @param  object $file
     * @return object
     */    
    public function processFile($file)
    {
        $file->fullURL   = $this->getWebPath($file->objectType) . $this->getRealPathName($file->pathname, $file->objectType);
        $file->middleURL = '';
        $file->smallURL  = '';
        $file->isImage   = false;
        $file->isVideo   = false;

        if(in_array(strtolower($file->extension), $this->config->file->imageExtensions, true) !== false)
        {
            $file->middleURL = $this->getWebPath($file->objectType) . $this->getRealPathName(str_replace('f_', 'm_', $file->pathname), $file->objectType);
            $file->smallURL  = $this->getWebPath($file->objectType) . $this->getRealPathName(str_replace('f_', 's_', $file->pathname), $file->objectType);
            $file->largeURL  = $this->getWebPath($file->objectType) . $this->getRealPathName(str_replace('f_', 'l_', $file->pathname), $file->objectType);

            if(!file_exists(str_replace($this->getWebPath($file->objectType), $this->savePath, $file->middleURL))) $file->middleURL = $file->fullURL;
            if(!file_exists(str_replace($this->getWebPath($file->objectType), $this->savePath, $file->smallURL)))  $file->smallURL  = $file->fullURL;
            if(!file_exists(str_replace($this->getWebPath($file->objectType), $this->savePath, $file->largeURL)))  $file->largeURL  = $file->fullURL;
            
            $file->isImage = true;
        }

        if(in_array(strtolower($file->extension), $this->config->file->videoExtensions, true) !== false) $file->isVideo = true;

        return $file;
    }
    
    /**
     * batch run processFile function.
     * 
     * @param array $files
     * @return array
     */
    public function batchProcessFile($files)
    {
        foreach($files as &$file) $file = $this->processFile($file);
        return $files;
    }

    /**
     * Get info of a file.
     * 
     * @param string $fileID 
     * @access public
     * @return void
     */
    public function getByID($fileID)
    {
        $file = $this->dao->setAutoLang(false)->findById($fileID)->from(TABLE_FILE)->fetch();
        if(empty($file)) return false;

        $this->setSavePath($file->objectType);

        $realPathName   = $this->getRealPathName($file->pathname, $file->objectType);
        $file->realPath = $this->savePath . $realPathName;
        $file->webPath  = $this->getWebPath($file->objectType) . $realPathName;
        return $this->processFile($file);
    }

    /**
     * Save the files uploaded.
     * 
     * @param string $objectType 
     * @param string $objectID 
     * @param string $extra 
     * @access public
     * @return void
     */
    public function saveUpload($objectType = '', $objectID = '', $extra = '', $htmlTagName = 'files')
    {
        $fileTitles = array();
        $now        = helper::now();
        $files      = $this->getUpload($htmlTagName, $objectType);

        $imageSize = array('width' => 0, 'height' => 0);

        foreach($files as $id => $file)
        {   
            $realPathName = $this->savePath . $this->getSaveName($file['pathname']);
            if($objectType == 'source') $this->config->file->allowed .= ',css,js,';
            if(stripos(',' . trim($this->config->file->allowed, ',') . ',', ',' . $file['extension'] . ',') === false)
            {
                if(!move_uploaded_file($file['tmpname'], $realPathName)) return false;
                $file['pathname'] .= '.txt';
                $file = $this->saveZip($file);
            }
            else
            {
                if(!move_uploaded_file($file['tmpname'], $realPathName)) return false;
            }

            if(strtolower($file['extension']) != 'gif' and in_array(strtolower($file['extension']), $this->config->file->imageExtensions, true))
            {
                if(strpos('source,slide,logo', $objectType) === false)
                {
                    $this->compressImage($realPathName);
                    if(isset($this->config->file->watermark) and $this->config->file->watermark == 'open')
                    {
                        $this->setWatermark($realPathName);
                    }
                }
                $imageSize = $this->getImageSize($realPathName);
            }

            $file['objectType'] = $objectType;
            $file['objectID']   = $objectID;
            $file['addedBy']    = $this->app->user->account;
            $file['addedDate']  = $now;
            $file['extra']      = $extra;
            $file['width']      = $imageSize['width'];
            $file['height']     = $imageSize['height'];
            $file['lang']       = 'all';
            if($objectType == 'logo') $file['lang'] = $this->app->getClientLang();
            unset($file['tmpname']);
            unset($file['id']);
            $this->dao->insert(TABLE_FILE)->data($file)->exec();

            $fileID = $this->dao->lastInsertId();
            $this->dao->update(TABLE_FILE)->set('`order`')->eq($fileID)->where('id')->eq($fileID)->exec();
            $fileTitles[$fileID] = $file['title'];
        }
        $this->loadModel('setting')->setItems('system.common.site', array('lastUpload' => time()));
        return $fileTitles;
    }

    /**
     * Save dangerous files to zip. 
     * 
     * @param  array    $file 
     * @access public
     * @return array
     */
    public function saveZip($file)
    {
        $this->app->loadClass('pclzip', true);
        $pathInfo = pathinfo($file['pathname']);

        $uploadedFile = $this->savePath . $file['pathname'];
        $gbkName      = function_exists('iconv') ? iconv('utf-8', 'gbk', $file['title']) : $file['title'];
        $tmpFile      = $this->app->getCacheRoot() . DS . md5(uniqid()) . DS . $gbkName . '.' . $file['extension'];

        mkdir(dirname($tmpFile));
        copy($uploadedFile, $tmpFile);
        $archive = new PclZip($this->savePath . substr($file['pathname'], 0, -4) . '.zip');
        $list    = $archive->create($tmpFile, PCLZIP_OPT_REMOVE_ALL_PATH);
        if($list != 0)
        {
            unlink($uploadedFile);
            unlink($tmpFile);
            rmdir(dirname($tmpFile));
            $file['pathname']  = substr($file['pathname'], 0, -4) . '.zip';
            $file['extension'] = 'zip';
        }

        return $file;
    }

    /**
     * Get the count of uploaded files.
     * 
     * @access public
     * @return void
     */
    public function getCount()
    {
        return count($this->getUpload());
    }

    /**
     * Check can upload front. 
     * 
     * @access public
     * @return void
     */
    public function canUpload()
    {
       if(RUN_MODE == 'admin') return true;
       if(isset($this->config->site->allowUpload) and $this->config->site->allowUpload == 1) return true;
       if(isset($this->app->user->admin) and $this->app->user->admin == 'super') return true;
       return false;
    }

    /**
     * get uploaded files.
     * 
     * @param string $htmlTagName 
     * @access public
     * @return void
     */
    public function getUpload($htmlTagName = 'files', $objectType = 'upload')
    {
        $files = array();
        if(!isset($_FILES[$htmlTagName])) return $files;
        if(!$this->canUpload()) return $files;
        
        $this->app->loadClass('filter', true);

        $this->app->loadClass('purifier', true);
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        /* The tag if an array. */
        if(is_array($_FILES[$htmlTagName]['name']))
        {
            extract($_FILES[$htmlTagName]);
            foreach($name as $id => $fileName)
            {
                if(empty($fileName)) continue;
                if(!validater::checkFileName($fileName)) continue;
                $file['id']        = $id;
                $file['extension'] = $this->getExtension($fileName);
                $file['title']     = !empty($_POST['labels'][$id]) ? htmlspecialchars($_POST['labels'][$id]) : str_replace('.' . $file['extension'], '', $fileName);
                $file['title']     = $purifier->purify($file['title']);
                $file['size']      = $size[$id];
                $file['tmpname']   = $tmp_name[$id];
                $file['pathname']  = $this->setPathName($file, $objectType);
                $files[] = $file;
            }
        }
        else
        {
            if(empty($_FILES[$htmlTagName]['name'])) return array();
            extract($_FILES[$htmlTagName]);
            if(!validater::checkFileName($name)) return array();;
            $file['id']        = 0;
            $file['extension'] = $this->getExtension($name);
            $file['title']     = !empty($_POST['labels'][0]) ? htmlspecialchars($_POST['labels'][0]) : substr($name, 0, strpos($name, $file['extension']) - 1);
            $file['title']     = $purifier->purify($file['title']);
            $file['size']      = $size;
            $file['pathname']  = $this->setPathName($file, $objectType);
            $file['tmpname']   = $tmp_name;
            return array($file);
        }
        return $files;
    }

    /**
     * Get extension name of a file.
     * 
     * @param string $fileName 
     * @access public
     * @return void
     */
    public function getExtension($fileName)
    {
        $extension = strtolower(trim(pathinfo($fileName, PATHINFO_EXTENSION)));
        if(empty($extension))
        {
            $basename  = strtolower(trim(pathinfo($fileName, PATHINFO_BASENAME)));
            $pathname  = $this->dao->select('pathname')->from(TABLE_FILE)->where('pathname')->like("%{$basename}%")->fetchAll();
            if(empty($pathname)) return '';
            $extension = pathinfo($pathname[0]->pathname, PATHINFO_EXTENSION);
            $this->loadModel('setting')->setItems('system.common.site', array('lastUpload' => time()));
        }
        if(stripos(",{$this->config->file->dangers},", ",{$extension},") !== false) return 'txt';
        if(stripos(",{$this->config->file->allowed},", ",{$extension},") === false) return 'txt';
        return $extension;
    }

    /**
     * Get save name.
     * 
     * @param  string    $pathName 
     * @access public
     * @return string
     */
    public function getSaveName($pathName)
    {
        $fileInfo = pathinfo($pathName);
        if(isset($fileInfo['extension']) and in_array($fileInfo['extension'], $this->config->file->videoExtensions)) return $pathName;
        $saveName = strpos($pathName, '.') === false ? $pathName : substr($pathName, 0, strpos($pathName, '.'));
        return $saveName;
    }

    /**
     * Get real path name.
     * 
     * @param  string    $pathName 
     * @access public
     * @return string
     */
    public function getRealPathName($pathName, $objectType = '')
    {
        $realPath = $this->app->getDataRoot() . 'upload/' . $pathName;
        if($objectType == 'source' or $objectType == 'slide') $realPath = $this->app->getDataRoot() . $pathName;

        if(file_exists($realPath)) return $pathName;

        return $this->getSaveName($pathName);
    }

    /**
     * Get image width and height.
     * 
     * @param  string    $imagePath 
     * @access public
     * @return array
     */
    public function getImageSize($imagePath)
    {
        if(!file_exists($imagePath)) return array('width' => 0, 'height' => 0);

        list($width, $height) = getimagesize($imagePath);
        return array('width' => (int)$width, 'height' => (int)$height);
    }

    /**
     * Set the path name.
     * 
     * @param string $fileID 
     * @param string $extension 
     * @access public
     * @return void
     */
    public function setPathName($file, $objectType = 'upload')
    {
        if(strpos('slide,source,themePackage', $objectType) === false)
        {
            $sessionID  = session_id();
            $randString = substr($sessionID, mt_rand(0, strlen($sessionID) - 5), 3);
            $pathName   = date('Ym/dHis', $this->now) . $file['id'] . mt_rand(0, 10000) . $randString;
        }
        elseif($objectType == 'source') 
        {
            /* Process file path if objectType is source. */
            $template = $this->config->template->{$this->app->clientDevice}->name;
            $theme    = $this->config->template->{$this->app->clientDevice}->theme;
            return "source/{$template}/{$theme}/{$file['title']}.{$file['extension']}";
        }
        elseif($objectType == 'themePackage')
        {
            return "{$file['title']}.{$file['extension']}"; 
        }
        
        /* rand file name more */
        list($path, $fileName) = explode('/', $pathName);
        $fileName = md5(mt_rand(0, 10000) . str_shuffle(md5($fileName)) . mt_rand(0, 10000));
        return $path . '/f_' . $fileName . '.' . $file['extension'];
    }

    /**
     * Set the save path.
     * 
     * @param  string $objectType 
     * @access public
     * @return void
     */
    public function setSavePath($objectType = '')
    {
        $savePath = $this->app->getDataRoot() . "upload/" . date('Ym/', $this->now);
        $this->savePath = dirname($savePath) . '/';

        if($objectType == 'source')
        {
            $template = $this->config->template->{$this->app->clientDevice}->name;
            $theme    = $this->config->template->{$this->app->clientDevice}->theme;
            $savePath = $this->app->getDataRoot() . "source/{$template}/{$theme}/";
            $this->savePath = $this->app->getDataRoot();
        }

        if($objectType == 'slide')
        {
            $savePath = $this->app->getDataRoot() . "slides/";
            $this->savePath = $this->app->getDataRoot();
        }

        if($objectType == 'themePackage')
        {
            $savePath       = $this->app->getTmpRoot() . "package/";
            $this->savePath = $savePath;
        }

        if(!file_exists($savePath)) 
        {
            @mkdir($savePath, 0777, true);
            if(is_writable($savePath) && !file_exists($savePath . DS . 'index.html'))
            {
                $fd = @fopen($savePath . DS . 'index.html', "a+");
                fclose($fd);
                chmod($savePath . DS . 'index.html' , 0755);
            }
        }
    }
    
    /**
     * Set the web path.
     * 
     * @access public
     * @return void
     */
    public function setWebPath()
    {
        $this->webPath = $this->app->getWebRoot() . "data/upload/";
    }

    /**
     * Get the web path.
     * 
     * @param  string $objectType 
     * @access public
     * @return void
     */
    public function getWebPath($objectType = '')
    {
        if(strpos(',slide,source,', ",$objectType,") !== false) return $this->app->getWebRoot() . "data/";
        return $this->app->getWebRoot() . "data/upload/";
    }

    /**
     * Edit file.
     * 
     * @param  int    $fileID 
     * @access public
     * @return void
     */
    public function edit($fileID)
    {
        $this->replaceFile($fileID);
        $fileInfo = fixer::input('post')
            ->remove('pathname')
            ->remove('upFile')
            ->get();
        if(!validater::checkFileName($fileInfo->title)) return false;
        $fileInfo->lang = 'all';
        $this->dao->update(TABLE_FILE)->data($fileInfo)->autoCheck()->batchCheck($this->config->file->require->edit, 'notempty')->where('id')->eq($fileID)->exec();
        $this->dao->setAutoLang(false)->update(TABLE_FILE)->data($fileInfo)->autoCheck()->batchCheck($this->config->file->require->edit, 'notempty')->where('id')->eq($fileID)->exec();
        return !dao::isError();
    }

    /**
     * Replace a file.
     * 
     * @access public
     * @return bool 
     */
    public function replaceFile($fileID, $postName = 'upFile')
    {
        $fileInfo  = $this->dao->setAutoLang(false)->select('pathname, extension, objectType')->from(TABLE_FILE)->where('id')->eq($fileID)->fetch();
        if(empty($fileInfo)) return false;
        $this->setSavePath($fileInfo->objectType);
        $files = $this->getUpload($postName, $fileInfo->objectType);
        if(!empty($files))
        {
            $file      = $files[0];
            $extension = strtolower($file['extension']);

            /* Remove old file. */
            if(file_exists($this->savePath . $fileInfo->pathname)) unlink($this->savePath . $fileInfo->pathname);
            foreach($this->config->file->thumbs as $size => $configure)
            {
                $thumbPath = $this->savePath . str_replace('f_', $size . '_', $fileInfo->pathname);
                if(file_exists($thumbPath)) unlink($thumbPath);
            }

            if($extension != $fileInfo->extension)
            {
                $fileInfo->pathname  = str_replace(".{$fileInfo->extension}", ".$extension", $fileInfo->pathname);
                $fileInfo->extension = $extension;
            }

            $realPathName = $this->savePath . $this->getSaveName($fileInfo->pathname);
            $imageSize    = array('width' => 0, 'height' => 0);
            if(stripos(",{$this->config->file->allowed},", ',' . $extension . ',') === false)
            {
                if(!move_uploaded_file($file['tmpname'], $realPathName)) return false;
                $fileInfo->pathname .= '.txt';
                $this->saveZip($file); 
            }
            else
            {
                if(!move_uploaded_file($file['tmpname'], $realPathName)) return false;
            }

            if(strtolower($file['extension']) != 'gif' and in_array(strtolower($file['extension']), $this->config->file->imageExtensions) and $fileInfo->objectType != 'slide' and $fileInfo->objectType != 'source' )
            {
                $this->compressImage($realPathName);
                if(isset($this->config->file->watermark) and $this->config->file->watermark == 'open')
                {
                    $this->setWatermark($realPathName);
                }
                $imageSize = $this->getImageSize($realPathName);
            }

            $fileInfo->addedBy   = $this->app->user->account;
            $fileInfo->addedDate = helper::now();
            $fileInfo->size      = $file['size'];
            $fileInfo->width     = $imageSize['width'];
            $fileInfo->height    = $imageSize['height'];
            $fileInfo->lang      = 'all';
            $this->dao->setAutoLang(false)->update(TABLE_FILE)->data($fileInfo)->where('id')->eq($fileID)->exec();
            $this->loadModel('setting')->setItems('system.common.site', array('lastUpload' => time()));
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Check title conflict or not.
     * 
     * @param  int     $fileID 
     * @param  string  $filename 
     * @access public
     * @return void
     */
    public function checkSameFile($filename, $fileID = 0)
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;

        return $this->dao->select('*')->from(TABLE_FILE)
            ->where('title')->eq($filename)
            ->andWhere('objectType')->eq('source')
            ->andWhere('objectID')->eq("{$template}_{$theme}")
            ->beginIF($fileID)->andWhere('id')->ne($fileID)->fi()
            ->fetch();
    }

    /**
     * Source edit.  
     * 
     * @param  int    $fileID 
     * @param  string $fileName 
     * @access public
     * @return array
     */
    public function editSource($file, $fileName)
    {
        $files = $this->getUpload('upFile', $file->objectType);
        $uploadPath = $this->app->getDataRoot();
        if(!empty($files))
        {
            /* Use post fileName as file title. */
            $_FILES['upFile']['name'] = $fileName . '.' . $file->extension;

            $replaceResult = $this->replaceFile($file->id, 'upFile');
            if(!$replaceResult) return false;
        }

        if($fileName != $file->title) 
        {
            $file = $this->getByID($file->id);
            if(!file_exists($file->realPath)) return false;
            $newPath = dirname($file->realPath) . DS . $fileName . '.' . $file->extension;
            $result = copy($file->realPath, $newPath);
            if(!$result) return false;
            @unlink($file->realPath);
            
            $newPathname = str_replace($uploadPath, '', $newPath);
            $this->dao->update(TABLE_FILE)->set('title')->eq($fileName)->set('pathName')->eq($newPathname)->where('id')->eq($file->id)->exec();
        }

        return !dao::isError();
    }
 
    /**
     * Save file download log.
     *
     * @param int $file
     * @access public
     * @return bool
     */
    public function log($file)
    {
        $log = new stdClass();
        $log->file    = $file;
        $log->account = $this->app->user->account;
        $log->ip      = helper::getRemoteIP();
        $log->referer = $this->server->http_referer;
        $log->time    = helper::now();

        $this->dao->insert(TABLE_DOWN)->data($log)->exec();
        $this->dao->update(TABLE_FILE)->set('downloads = downloads + 1')->where('id')->eq($file)->exec();

        return !dao::isError();
    }

    /**
     * Delete the record and the file
     * 
     * @param  int    $fileID 
     * @access public
     * @return void
     */
    public function delete($fileID, $null = null)
    {
        $file = $this->getByID($fileID);
        if(file_exists($file->realPath)) unlink($file->realPath);
        if(in_array($file->extension, $this->config->file->imageExtensions))
        {
            foreach($this->config->file->thumbs as $size => $configure)
            {
                $thumbPath = $this->savePath . str_replace('f_', $size . '_', $file->pathname);
                if(file_exists($thumbPath)) unlink($thumbPath);
            }
        }

        $this->dao->delete()->from(TABLE_FILE)
            ->where('id')->eq($file->id)
            ->beginIf(RUN_MODE == 'front' and $this->app->user->admin == 'no')->andWhere('addedBy')->eq($this->app->user->account)->fi()
            ->exec();
        return !dao::isError();
    }

    /**
     * Paste image in kindeditor at firefox and chrome. 
     * 
     * @param  string    $data 
     * @param  string    $uid 
     * @access public
     * @return string
     */
    public function pasteImage($data, $uid)
    {
        if(empty($data)) return ''; 
        $data = str_replace('\"', '"', $data);
        if(!$this->checkSavePath()) return false;

        $dataLength = strlen($data);
        if(ini_get('pcre.backtrack_limit') < $dataLength) ini_set('pcre.backtrack_limit', $dataLength);
        preg_match_all('/<img src="(data:image\/(\S+);base64,(\S+))" .+ \/>/U', $data, $out);
        foreach($out[3] as $key => $base64Image)
        {
            $imageData = base64_decode($base64Image);
            $imageSize = array('width' => 0, 'height' => 0);

            $file['id']        = $key;
            $file['extension'] = $out[2][$key];
            if(!in_array($file['extension'], $this->config->file->imageExtensions)) return false;
            $file['size']      = strlen($imageData);
            $file['addedBy']   = $this->app->user->account;
            $file['addedDate'] = helper::today();
            $file['pathname']  = $this->setPathName($file);
            $file['title']     = basename($file['pathname']);
            $file['editor']    = 1;

            $realPathName = $this->savePath . $this->getSaveName($file['pathname']);
            file_put_contents($realPathName, $imageData);
            $this->compressImage($realPathName);
            if(strtolower($file['extension']) != 'gif' and isset($this->config->file->watermark) and $this->config->file->watermark == 'open')
            {
                $this->setWatermark($realPathName);
            }

            $imageSize      = $this->getImageSize($realPathName);
            $file['width']  = $imageSize['width'];
            $file['height'] = $imageSize['height'];
            $file['lang']   = 'all';

            $this->dao->insert(TABLE_FILE)->data($file)->exec();
            $fileID = $this->dao->lastInsertID();
            $_SESSION['album'][$uid][] = $fileID;

            /* Build file url information */
            $fileURL = array();
            $fileURL['pathname']  = $this->getSaveName($file['pathname']);
            $fileURL['extension'] = $file['extension'];

            $data = str_replace($out[1][$key], $this->printFileURL($fileURL), $data);
        }

        return $data;
    }

    /**
     * Compress image to config configured size.
     * 
     * @param  string    $imagePath 
     * @access public
     * @return void
     */
    public function compressImage($imagePath)
    {
        $this->app->loadClass('phpthumb', true);
        $imageInfo = pathinfo($imagePath);
        if(!is_writable($imageInfo['dirname'])) return false;

        foreach($this->config->file->thumbs as $size => $configure)
        {
            $thumbPath = str_replace('f_', $size . '_', $imagePath);
            if(extension_loaded('gd'))
            {
                $thumb = phpThumbFactory::create($imagePath);
                $thumb->resize($configure['width'], $configure['height']);
                $thumb->save($thumbPath);
            }
            else
            {
                copy($imagePath, $thumbPath);   
            }
        }
    }

    /**
     * Check save path is writeable.
     * 
     * @access public
     * @return void
     */
    public function checkSavePath()
    {
        return is_writable($this->savePath);
    }

    /**
     * Update objectType and objectID for file.
     * 
     * @param  string $uid 
     * @param  int    $objectID 
     * @param  string $bojectType 
     * @access public
     * @return void
     */
    public function updateObjectID($uid, $objectID, $objectType)
    {
        $data = new stdclass();
        $data->objectID   = $objectID;
        $data->objectType = $objectType;
        $data->lang       = 'all';
        if(isset($_SESSION['album'][$uid]) and $_SESSION['album'][$uid])
        {
            $this->dao->setAutoLang(false)->update(TABLE_FILE)->data($data)->where('id')->in($_SESSION['album'][$uid])->exec();
            if(dao::isError()) return false;
            return !dao::isError(); 
        }
    }

    /**
     * Update objectype of file
     *
     * @param  string $objectID
     * @param  string $oldobjectType
     * @param  string $newObjectType
     * @access public
     * @return bool
     */
    public function updateObjectType($objectID, $oldObjectType, $newObjectType)
    {
        $this->dao->update(TABLE_FILE)->set('objectType')->eq($newObjectType)
            ->where('objectID')->eq($objectID)
            ->andWhere('objectType')->eq($oldObjectType)
            ->exec();
        return !dao::isError();
    }
    
    /**
     * Copy file in content from file space.
     * 
     * @param  string $content 
     * @param  int    $objectID 
     * @param  string $bojectType 
     * @access public
     * @return bool
     */
    public function copyFromContent($content, $objectID, $objectType)
    {
        preg_match_all('/<img src="(\/data\/upload\/(\S+)\?fromSpace=y)" .+ \/>/U', $content, $images);

        if(empty($images)) return false;
        foreach($images[2] as $key => $pathname)
        {
            $pathname = str_replace($this->webPath, '', $pathname);
            $pathname = str_replace('\?fromSpace=y', '', $pathname);

            $data = $this->dao->setAutoLang(false)->select('*')->from(TABLE_FILE)->where('pathname')->eq($pathname)->fetch();
            if(!$data) $data = new stdclass();

            $data->pathname   = $pathname;
            $data->extension  = $this->getExtension($pathname);
            $data->objectID   = $objectID;
            $data->objectType = $objectType;
            $data->addedBy    = $this->app->user->account;
            $data->addedDate  = helper::now();
            $data->editor     = 1;
            $data->lang       = 'all';

            $fileExists = $this->dao->setAutoLang(false)->select('count(*) as count')->from(TABLE_FILE)
                ->where('objectType')->eq($objectType)
                ->andWhere('objectID')->eq($objectID)
                ->andWhere('pathname')->eq($pathname)
                ->fetch('count');

            if($fileExists == 0) $this->dao->insert(TABLE_FILE)->data($data, $skip = 'id')->exec();
        }

        return !dao::isError(); 
    }

    /**
     * Send the download header to the client.
     * 
     * @param  string    $fileName 
     * @param  string    $extension 
     * @access public
     * @return void
     */
    public function sendDownHeader($fileName, $fileType, $content, $fileSize = 0)
    {
        /* Set the downloading cookie, thus the export form page can use it to judge whether to close the window or not. */
        setcookie('downloading', 1, 0, '', '', false, true);

        /* Append the extension name auto. */
        $extension = '.' . $fileType;
        if(strpos($fileName, $extension) === false) $fileName .= $extension;

        /* urlencode the fileName for ie. */
        $isIE11 = (strpos($this->server->http_user_agent, 'Trident') !== false and strpos($this->server->http_user_agent, 'rv:11.0') !== false); 
        if(strpos($this->server->http_user_agent, 'MSIE') !== false or $isIE11) $fileName = urlencode($fileName);

        /* Judge the content type. */
        $mimes = $this->config->file->mimes;
        $contentType = isset($mimes[$fileType]) ? $mimes[$fileType] : $mimes['default'];
        if(empty($fileSize) and $content) $fileSize = strlen($content);

        header("Content-type: $contentType");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-length: {$fileSize}");
        header("Pragma: no-cache");
        header("Expires: 0");
        die($content);
    }

    /**
     * get uploaded file from zui.uploader.
     * 
     * @param string $htmlTagName 
     * @param string $objectType 
     * @access public
     * @return void
     */
    public function getUploadFile($htmlTagName = 'file', $objectType = 'upload')
    {
        if(!isset($_FILES[$htmlTagName]) || empty($_FILES[$htmlTagName]['name'])) return;
        if(!$this->canUpload()) return;
        
        $this->app->loadClass('filter', true);
        $this->app->loadClass('purifier', true);
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        extract($_FILES[$htmlTagName]);
        if(!validater::checkFileName($name)) return;
        if($this->post->name) $name = $this->post->name;
        $file = array();
        $file['id'] = 0;
        $file['extension'] = $this->getExtension($name);
        $file['title']     = !empty($_POST['label']) ? htmlspecialchars($_POST['label']) : substr($name, 0, strpos($name, $file['extension']) - 1);
        $file['title']     = $purifier->purify($file['title']);
        $file['size']      = $_POST['size'];
        $file['tmpname']   = $tmp_name;
        $file['uuid']      = $_POST['uuid'];
        $file['pathname']  = $this->setPathName($file, $objectType);
        $file['chunkpath'] = 'chunks' . DS .'f_' . $file['uuid'] . '.' . $file['extension'] . '.part';
        $file['chunks']    = isset($_POST['chunks']) ? intval($_POST['chunks']) : 0;
        $file['chunk']     = isset($_POST['chunk']) ? intval($_POST['chunk']) : 0;

        return $file;
    }

    /**
     * Save uploaded file from zui.uploader.
     * 
     * @param object $file 
     * @param string $objectType 
     * @param string $objectID
     * @param string $extra
     * @access public
     * @return void
     */
    public function saveUploadFile($file, $objectType = 'upload', $objectID = '', $extra = '')
    {
        $now = helper::now();
        if($objectType == 'source') $this->config->file->allowed .= ',css,js,';
        if($objectType == 'themePackage')  $this->config->file->allowed  = ',zip,';
        if(stripos(',' . trim($this->config->file->allowed, ',') . ',', ',' . $file['extension'] . ',') === false)
        {
            $file['pathname'] .= '.txt';
        }

        $realPathName = $this->savePath . $this->getSaveName($file['pathname']);
        if($file['chunks'] > 1)
        {
            $fileSavePath = $this->savePath . $file['chunkpath'];
            if(!file_exists($fileSavePath)) mkdir(dirname($fileSavePath));
            if($file['chunk'] > 0)
            {
                $uploadedFile = fopen($fileSavePath, 'a+b');
                $tmpChunkFile = fopen($file['tmpname'], 'rb');
                while($buff = fread($tmpChunkFile, 4096)) fwrite($uploadedFile, $buff);
                fclose($uploadedFile);
                fclose($tmpChunkFile);
            }
            else
            {
                if(!move_uploaded_file($file['tmpname'], $fileSavePath)) return 'error1';
            }
            if($file['chunk'] == ($file['chunks'] - 1))
            {
                rename($fileSavePath, $realPathName);
            }
        }
        else
        {
            if(!move_uploaded_file($file['tmpname'], $realPathName)) return 'error3';
        }

        if(!$file['chunks'] || $file['chunk'] == ($file['chunks'] - 1))
        {
            if(strtolower($file['extension']) != 'gif' and in_array(strtolower($file['extension']), $this->config->file->imageExtensions, true))
            {
                if($objectType != 'source' and $objectType != 'slide') 
                {
                    $this->compressImage($realPathName);
                    if(isset($this->config->file->watermark) and $this->config->file->watermark == 'open')
                    {
                        $this->setWatermark($realPathName);
                    }
                }
                $imageSize = $this->getImageSize($realPathName);
            }

            $file['objectType'] = $objectType;
            $file['objectID']   = $objectID;
            $file['addedBy']    = $this->app->user->account;
            $file['addedDate']  = $now;
            $file['extra']      = $extra;
            $file['width']      = isset($imageSize['width']) ? $imageSize['width'] : 0;
            $file['height']     = isset($imageSize['height']) ? $imageSize['height'] : 0;
            $file['lang']       = 'all';
            if($objectType == 'logo') $file['lang'] = $this->app->getClientLang();
            unset($file['tmpname']);
            unset($file['id']);
            unset($file['uuid']);
            unset($file['chunks']);
            unset($file['chunk']);
            unset($file['chunkpath']);
            if($objectType != 'themePackage')
            {
                $this->dao->insert(TABLE_FILE)->data($file)->exec();
                $file['id'] = $this->dao->lastInsertId();
            }

            $this->loadModel('setting')->setItems('system.common.site', array('lastUpload' => time()));
        }

        return $file;
    }
    
    /**
     * Set watermark to image according to the config
     * 
     * @param  string    $imagePath 
     * @access public
     * @return void
     */
    public function setWatermark($imagePath)
    {
        $imageInfo = pathinfo($imagePath);
        if(!extension_loaded('gd')) return false;
        if(!is_writable($imageInfo['dirname'])) return false;
        $rawImage = str_replace('f_', '', $imagePath);
        
        if(!file_exists($rawImage)) copy($imagePath, $rawImage); 
        $this->addTextWatermark($rawImage, $imagePath);
        $this->compressImage($imagePath);
    }

    /**
     * Add Text Watermark to file
     * 
     * @param  string    $rawImage 
     * @param  string    $destPath 
     * @access public
     * @return void
     */
    public function addTextWatermark($rawImage, $destPath)
    {
        $imageCreateFunArr = array('image/jpeg' => 'imagecreatefromjpeg', 'image/png' => 'imagecreatefrompng', 'image/gif' => 'imagecreatefromgif');
        $imageOutputFunArr = array('image/jpeg' => 'imagejpeg', 'image/png' => 'imagepng', 'image/gif' => 'imagegif');

        $rawFileInfo   = getimagesize($rawImage);
        $rawFileWidth  = $rawFileInfo[0];
        $rawFileHeight = $rawFileInfo[1];
        $rawFileMime   = $rawFileInfo['mime'];

        if(!isset($imageCreateFunArr[$rawFileMime])) return false;
        if(!isset($imageOutputFunArr[$rawFileMime])) return false;
        $imageCreateFun = $imageCreateFunArr[$rawFileMime];
        $imageOutputFun = $imageOutputFunArr[$rawFileMime];
        
        $color      = helper::hex2Rgb($this->config->file->watermarkColor);
        $opacity    = isset($this->config->file->watermarkOpacity) ? $this->config->file->watermarkOpacity : 60;
        $fontSize   = (isset($this->config->file->watermarkSize) and intval($this->config->file->watermarkSize)) > 0 ? intval($this->config->file->watermarkSize) : 14;
        $text       = $this->config->file->watermarkContent;
        $position   = isset($this->config->file->watermarkPosition) ? $this->config->file->watermarkPosition : 'topLeft';
        $angle      = 0;
        $fontPath   = $this->app->getTmpRoot() . 'fonts' . DS . 'wqy-zenhei.ttc';

        $textInfo   = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textWidth  = $textInfo[2] - $textInfo[0];
        $textHeight = $textInfo[1] - $textInfo[7];

        if($rawFileWidth - $textWidth < 10 or $rawFileHeight - $textHeight < 10) return false;

        if($position == 'topLeft')
        {
            $positionX = 5;
            $positionY = $textHeight;
        }
        elseif($position == 'topMiddle')
        {
            $positionX = $rawFileWidth / 2 - $textWidth / 2;
            $positionY = $textHeight;
        }
        elseif($position == 'topRight')
        {
            $positionX = $rawFileWidth - $textWidth - 5;
            $positionY = $textHeight;
        }
        elseif($position == 'middleLeft')
        {
            $positionX = 5;
            $positionY = $rawFileHeight / 2 + $textHeight / 2;
        }
        elseif($position == 'middleMiddle')
        {
            $positionX = $rawFileWidth / 2 - $textWidth / 2;
            $positionY = $rawFileHeight / 2 + $textHeight / 2;
        }
        elseif($position == 'middleRight')
        {
            $positionX = $rawFileWidth - $textWidth - 5;
            $positionY = $rawFileHeight / 2 + $textHeight / 2;
        }
        elseif($position == 'bottomLeft')
        {
            $positionX = 5;
            $positionY = $rawFileHeight - 5;
        }
        elseif($position == 'bottomMiddle')
        {
            $positionX = $rawFileWidth / 2 - $textWidth / 2;
            $positionY = $rawFileHeight - 5;
        }
        else
        {
            $positionX = $rawFileWidth - $textWidth - 5;
            $positionY = $rawFileHeight - 5;
        }

        $im = $imageCreateFun($rawImage);
        $text_color = imagecolorallocatealpha($im, intval($color['r']), intval($color['g']), intval($color['b']), intval($opacity));
        imagettftext($im, $fontSize, $angle, $positionX, $positionY, $text_color, $fontPath, $text);
        $imageOutputFun($im, $destPath);
        imagedestroy($im);
    }

    /**
     * Scan images uploaded.
     * 
     * @access public
     * @return array
     */
    public function scanImages()
    {
        $files = glob($this->app->getDataRoot() . "upload/*/f_*");
        $logos = $this->dao->select('pathname')
            ->from(TABLE_FILE)
            ->where('objectType')->eq('logo')
            ->fetchAll();

        /* Delete logo  form files. */
        foreach($files as $key => $file)
        {
            foreach($logos as $logo)
            {
                if(strpos($file, substr($logo->pathname, 0, strpos($logo->pathname, '.'))) !== false) unset($files[$key]);
            } 
        }
        $images = array();
        foreach($files as $key => $file)
        {
            $size = getimagesize($file);
            if(substr($size['mime'], 0, 6) != 'image/') continue;
            if(strpos($size['mime'], 'gif') !== false) continue;
            if(strpos($size['mime'], 'ico') !== false) continue;
            $images[] = $file;
        }
        return $images;
    }

    /**
     * Sort the file. 
     * 
     * @access public
     * @return void
     */
    static public function sort($a, $b)
    {
        if(isset($a['is_dir']) && !isset($b['is_dir']))
        {
            return -1;
        }
        elseif(!isset($a['is_dir']) && isset($b['is_dir']))
        {
            return 1;
        }
        else
        {
            if($a['order'] == 'size')
            {
                if($a['filesize'] > $b['filesize']) return 1;
                if($a['filesize'] < $b['filesize']) return -1;
                if($a['filesize'] = $b['filesize']) return 0;
            }
            if($a['order'] == 'type') return strcmp($a['filetype'], $b['filetype']);
            if($a['order'] == 'name') return strcmp($a['filename'], $b['filename']);
        }
    }

    /**
     * Print file URL.
     * 
     * @param  array|object $file
     * @param  string  $size 
     * @access public
     * @return string
     */
    public function printFileURL($file, $size = '')
    {
        if(!is_array($file) and !is_object($file)) return false;
        $file = (array)$file;
        if(empty($file['pathname']) or empty($file['extension'])) return false;

        if(in_array($file['extension'], $this->config->file->videoExtensions))
        {
            return getWebRoot() . 'data/upload/'  . $file['pathname'];
        }

        $objectType = isset($file['objectType']) ? $file['objectType'] : '';
        $version    = isset($this->config->site->lastUpload) ? $this->config->site->lastUpload : '';
        return $this->config->webRoot . "file.php?f={$file['pathname']}&t={$file['extension']}&o={$objectType}&s={$size}&v={$version}";
    }

    /**
     * Get list for ueditor.
     * 
     * @param  int    $start 
     * @access public
     * @return void
     */
    public function getListForUeditor($start = 0)
    {
        $start = $this->get->start ? $this->get->start : 0;
        $count = $this->dao->select('count(*) as count')->from(TABLE_FILE)->where('extension')->in($this->config->file->imageExtensions)->fetch('count');
        $total = $count;
        $files = $this->dao->select('*')->from(TABLE_FILE)->where('extension')->in($this->config->file->imageExtensions)->limit("$start,{$this->config->file->ueditor['imageManagerListSize']}")->fetchAll();
        $fileList = array();
        foreach($files as $file)
        {
            $file = $this->processFile($file);
            $item = new stdclass();
            $item->url   = $this->printFileURL($file, 'm');
            $item->mtime = time($file->addedDate);
            $fileList[]  = $item;
        }
        
        $result = new stdclass();
        $result->state = 'SUCCESS';
        $result->list  = $fileList;
        $result->start = $start;
        $result->total = $total;

        return  $result;
    }
}
