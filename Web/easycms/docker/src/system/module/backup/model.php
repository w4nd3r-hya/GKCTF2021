<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of backup module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xiragit.com>
 * @package     backup
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class backupModel extends model
{
    /**
     * Backup 
     * 
     * @access public
     * @return void
     */
    public function backupAll()
    {
        $this->backupPath = $this->app->getTmpRoot() . 'backup/';
        if(!is_dir($this->backupPath)) mkdir($this->backupPath, 0777, true);

        set_time_limit(7200);
        $fileName = date('YmdHis') . mt_rand(0, 9);
        $result = $this->backSQL($this->backupPath . $fileName . '.sql.php');
        if(!$result->result) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noWritable, $this->backupPath));
        $this->addFileHeader($this->backupPath . $fileName . '.sql.php');

        if(extension_loaded('zlib'))
        {
            $result = $this->backFile($this->backupPath . $fileName . '.file.zip.php');
            if(!$result->result) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->backupFile, $result->error));
            $result = $this->backTemplate($this->backupPath . $fileName . '.template.zip.php');
            if(!$result->result) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->backupTemplate, $result->error));

            $this->addFileHeader($this->backupPath . $fileName . '.file.zip.php');
        }

        /* Delete expired backup. */
        $backupFiles = glob("{$this->backupPath}*.php");
        if(!empty($backupFiles))
        {
            $time = time();
            foreach($backupFiles as $file)
            {
                if($time - filemtime($file) > $this->config->backup->holdDays * 24 * 3600)
                {
                    if(isset($this->config->backup->reservedFiles))
                    {
                        $baseInfo = explode('.', basename($file));
                        $basename = zget($baseInfo, 0);
                        if(strpos($this->config->backup->reservedFiles, $basename) !== false) continue;
                    }
                    unlink($file);
                }
            }
        }

        return array('result' => 'success', 'message' => $this->lang->backup->success->backup);
    }

    /**
     * Backup SQL 
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function backSQL($backupFile)
    {
        $zdb = $this->app->loadClass('zdb');
        return $zdb->dump($backupFile);
    }

    /**
     * Backup file.
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function backFile($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $this->app->loadClass('pclzip', true);
        $zip = new pclzip($backupFile);
        $zip->create($this->app->getWwwRoot() . 'data/', PCLZIP_OPT_REMOVE_PATH, $this->app->getWwwRoot() . 'data/');
        if($zip->errorCode() != 0)
        {
            $return->result = false;
            $return->error  = $zip->errorInfo();
        }

        return $return;
    }

    /**
     * Backup template.
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function backTemplate($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $this->app->loadClass('pclzip', true);
        $zip = new pclzip($backupFile);
        $zip->create($this->app->getTmpRoot() . 'template/', PCLZIP_OPT_REMOVE_PATH, $this->app->getTmpRoot() . 'template/');
        if($zip->errorCode() != 0)
        {
            $return->result = false;
            $return->error  = $zip->errorInfo();
        }

        return $return;
    }

    /**
     * Restore SQL 
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function restoreSQL($backupFile)
    {
        $zdb = $this->app->loadClass('zdb');
        return $zdb->import($backupFile);
    }

    /**
     * Restore File 
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function restoreFile($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $this->app->loadClass('pclzip', true);
        $zip = new pclzip($backupFile);
        if($zip->extract(PCLZIP_OPT_PATH, $this->app->getWwwRoot() . 'data/') == 0)
        {
            $return->result = false;
            $return->error  = $zip->errorInfo();
        }

        return $return;
    }

    /**
     * Restore File 
     * 
     * @param  string    $backupFile 
     * @access public
     * @return object
     */
    public function restoreTemplate($backupFile)
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';
        $this->app->loadClass('pclzip', true);
        $zip = new pclzip($backupFile);
        if($zip->extract(PCLZIP_OPT_PATH, $this->app->getTmpRoot() . 'template/') == 0)
        {
            $return->result = false;
            $return->error  = $zip->errorInfo();
        }

        return $return;
    }

    public function checkBackupPath()
    {
        $backupPath = $this->config->framework->multiSite ? $this->app->getTmpRoot() . 'backup/' . $this->app->siteCode . '/' :  $this->app->getTmpRoot() . 'backup/';
        
        if(!is_dir($backupPath))
        {
            if(!mkdir($backupPath, 0777, true)) $error = sprintf($this->lang->backup->error->noWritable, dirname($backupPath));
        }
        else
        {
            if(!is_writable($backupPath)) $error = sprintf($this->lang->backup->error->noWritable, $backupPath);
        }

        $return = new stdclass();
        $return->backupPath = $backupPath;
        $return->error      = isset($error) ? $error : '';

        return $return; 
    }

    /**
     * Add file header.
     * 
     * @param  string    $fileName 
     * @access public
     * @return bool
     */
    public function addFileHeader($fileName)
    {
        $firstline = false;
        $die       = "<?php die();?>\n";
        $fileSize  = filesize($fileName);

        $fh    = fopen($fileName, 'c+');
        $delta = strlen($die);
        while(true)
        {
            $offset = ftell($fh);
            $line   = fread($fh, 1024 * 1024);
            if(!$firstline)
            {
                $line = $die . $line;
                $firstline = true;
            }
            else
            {
                $line = $compensate . $line;
            }
            
            $compensate = fread($fh, $delta);
            fseek($fh, $offset);
            fwrite($fh, $line);

            if(ftell($fh) >= $fileSize)
            {
                fwrite($fh, $compensate);
                break;
            }
        }
        fclose($fh);
        return true;
    }

    /**
     * Remove file header.
     * 
     * @param  string    $fileName 
     * @access public
     * @return bool
     */
    public function removeFileHeader($fileName)
    {
        $firstline = false;
        $die       = "<?php die();?>\n";
        $fileSize  = filesize($fileName);

        $fh = fopen($fileName, 'c+');
        while(true)
        {
            $offset = ftell($fh);
            if($firstline and $delta) fseek($fh, $offset + $delta);
            $line = fread($fh, 1024 * 1024);
            if(!$firstline)
            {
                $firstline    = true;
                $beforeLength = strlen($line);
                $line         = str_replace($die, '', $line);
                $afterLength  = strlen($line);
                $delta        = $beforeLength - $afterLength;
                if($delta == 0)
                {
                    fclose($fh);
                    return true;
                }
            }
            fseek($fh, $offset);
            fwrite($fh, $line);

            if(ftell($fh) >= $fileSize - $delta) break;
        }
        ftruncate($fh, ($fileSize - $delta));
        fclose($fh);
        return true;
    }
}
