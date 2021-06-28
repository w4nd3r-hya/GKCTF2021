<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of backup of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xiragit.com>
 * @package     backup
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class backup extends control
{

    /**
     * __construct 
     * 
     * @access public
     * @return void
     */
    public function __construct($moduleName = '', $methodName = '')
    {
        parent::__construct($moduleName, $methodName);
        $result = $this->loadModel('backup')->checkBackupPath();
        $this->backupPath = $result->backupPath;
        if($result->error) $this->view->error = $result->error;
    }

    /**
     * Index 
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->lang->menuGroups->backup = 'site';
        
        $backups = array();
        if(empty($this->view->error))
        {
            $sqlFiles = glob("{$this->backupPath}*.sql.php");
            if(!empty($sqlFiles))
            {
                foreach($sqlFiles as $file)
                {
                    $backupFile = new stdclass();
                    $backupFile->time  = filemtime($file);
                    $backupFile->name  = str_replace('.sql.php', '', basename($file));
                    $backupFile->files[$file] = abs(filesize($file));
                    if(file_exists($this->backupPath . $backupFile->name . '.file.zip.php'))
                    {
                        $backupFile->files[$this->backupPath . $backupFile->name . '.file.zip.php'] = abs(filesize($this->backupPath . $backupFile->name . '.file.zip.php'));
                    }

                    if(file_exists($this->backupPath . $backupFile->name . '.template.zip.php'))
                    {
                        $backupFile->files[$this->backupPath . $backupFile->name . '.template.zip.php'] = abs(filesize($this->backupPath . $backupFile->name . '.template.zip.php'));
                    }

                    $backups[$backupFile->name] = $backupFile;
                }
            }
        }
        krsort($backups);

        $this->view->title   = $this->lang->backup->common;
        $this->view->backups = $backups;
        $this->display();
    }

    /**
     * Backup 
     * 
     * @access public
     * @return void
     */
    public function backup()
    {
        $this->send($this->backup->backupAll());
    }

    /**
     * Restore 
     * 
     * @param  string $fileName 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function restore($fileName, $confirm = 'no')
    {
        if($confirm == 'no') $this->send(array('result' => 'fail', 'message' => $this->lang->backup->confirmRestore));

        set_time_limit(7200);

        /* Restore database. */
        $this->backup->removeFileHeader($this->backupPath . $fileName . '.sql.php');
        $result = $this->backup->restoreSQL($this->backupPath . $fileName . '.sql.php');
        $this->backup->addFileHeader($this->backupPath . $fileName . '.sql.php');
        if(!$result->result)
        {
            $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreSQL, $result->error)));
        }

        /* Restore attatchments. */
        if(file_exists($this->backupPath . $fileName . '.file.zip.php'))
        {
            $this->backup->removeFileHeader($this->backupPath . $fileName . '.file.zip.php');
            $result = $this->backup->restoreFile($this->backupPath . $fileName . '.file.zip.php');
            $this->backup->addFileHeader($this->backupPath . $fileName . '.file.zip.php');
            if(!$result->result)
            {
                $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreFile, $result->error)));
            }
        }

        /* Restore templates. */
        if(file_exists($this->backupPath . $fileName . '.template.zip.php'))
        {
            $this->backup->removeFileHeader($this->backupPath . $fileName . '.template.zip.php');
            $result = $this->backup->restoreTemplate($this->backupPath . $fileName . '.template.zip.php');
            $this->backup->addFileHeader($this->backupPath . $fileName . '.template.zip.php');
            if(!$result->result)
            {
                $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreTemplate, $result->error)));
            }
        }

        $this->send(array('result' => 'success', 'message' => $this->lang->backup->success->restore));
    }

    /**
     * Delete 
     * 
     * @param  string $fileName 
     * @access public
     * @return void
     */
    public function delete($fileName)
    {
        /* Delete database file. */
        if(file_exists($this->backupPath . $fileName . '.sql.php') and !unlink($this->backupPath . $fileName . '.sql.php'))
        {
            $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.sql.php')));
        }

        /* Delete attatchments file. */
        if(file_exists($this->backupPath . $fileName . '.file.zip.php') and !unlink($this->backupPath . $fileName . '.file.zip.php'))
        {
            $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.file.zip.php')));
        }

        $this->dao->delete()->from(TABLE_CONFIG)
            ->where('module')->eq('backup')
            ->andWhere('section')->eq('note')
            ->andWhere('`key`')->eq($fileName)
            ->exec();

        if(isset($this->config->backup->reservedFiles) and strpos($this->config->backup->reservedFiles, $fileName) !== false)
        {
            $newReservedFiles = str_replace(',' . $fileName, '', $this->config->backup->reservedFiles);
            $this->loadModel('setting')->setItem('system.backup.reservedFiles', $newReservedFiles);
        }
        $this->send(array('result' => 'success', 'locate' => inlink('index')));
    }

    /**
     * Change hold days. 
     * 
     * @access public
     * @return void
     */
    public function change()
    {
        if($_POST)
        {
            $data = fixer::input('post')->get();
            $this->loadModel('setting')->setItem('system.backup.holdDays', $data->holdDays);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('index')));
        }
        $this->view->title = $this->lang->backup->change;
        $this->display();
    }
    
    /**
     * Add the backup a note. 
     * 
     * @access public
     * @return void
     */
    public function note($fileName)
    {
        if($_POST)
        {
            $data = fixer::input('post')->get();
            $this->loadModel('setting')->setItem('system.backup.note.' . $fileName, $data->note);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('index')));
        }
        $this->view->title    = $this->lang->backup->note;
        $this->view->fileName = $fileName;
        $this->display();
    }
    
    /**
     * Reserve the backup. 
     * 
     * @access public
     * @return void
     */
    public function reserve($fileName)
    {
        $reservedFiles = isset($this->config->backup->reservedFiles) ? $this->config->backup->reservedFiles : '';
        $this->loadModel('setting')->setItem('system.backup.reservedFiles', $reservedFiles . ',' . $fileName);
        $this->send(array('result' => 'success', 'locate' => inlink('index')));
    }
}
