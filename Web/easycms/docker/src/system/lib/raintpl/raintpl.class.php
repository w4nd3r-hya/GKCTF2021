<?php
/**
 *  RainTPL
 *  -------
 *  Realized by Federico Ulfo & maintained by the Rain Team
 *  Distributed under the MIT license http://www.opensource.org/licenses/mit-license.php
 *
 *  @version 2.7.2
 */
class RainTPL
{
    /**
     * Template directory
     *
     * @var string
     */
    static $tplDir = "tpl/";

    /**
     * Cache directory. Is the directory where RainTPL will compile the template and save the cache
     *
     * @var string
     */
    static $cacheDir = "tmp/";

    /**
     * Template base URL. RainTPL will add this URL to the relative paths of element selected in $pathReplaceList.
     *
     * @var string
     */
    static $baseUrl = null;

    /**
     * Template extension.
     *
     * @var string
     */
    static $tplExt = "html";

    /**
     * Path replace is a cool features that replace all relative paths of images (<img src="...">), stylesheet (<link href="...">), script (<script src="...">) and link (<a href="...">)
     * Set true to enable the path replace.
     *
     * @var unknown_type
     */
    static $pathReplace = true;

    /**
     * You can set what the pathReplace method will replace.
     * Avaible options: a, img, link, script, input
     *
     * @var array
     */
    static $pathReplaceList = array();

    /**
     * You can define in the black list what string are disabled into the template tags
     *
     * @var unknown_type
     */
    //static $blackList = array('\$this', 'raintpl::', 'self::', '_SESSION', '_SERVER', '_ENV', 'exec', 'unlink', 'rmdir');
    static $blackList = array();

    /**
     * outputFunctions
     *
     * @static
     * @var string
     * @access public
     */
    static $outputFunctions = ',a,var_dump,var_export,printf,print,print_r,';

    static $echoFunctions = array('html', '');

    /**
     * Check template.
     * true: checks template update time, if changed it compile them
     * false: loads the compiled template. Set false if server doesn't have write permission for cacheDirectory.
     *
     */
    static $checkTemplateUpdate = true;

    /**
     * PHP tags <? ?>
     * True: php tags are enabled into the template
     * False: php tags are disabled into the template and rendered as html
     *
     * @var bool
     */
    static $phpEnabled = false;

    /**
     * Debug mode flag.
     * True: debug mode is used, syntax errors are displayed directly in template. Execution of script is not terminated.
     * False: exception is thrown on found error.
     *
     * @var bool
     */
    static $debug = false;

    /**
     * Path for the root directory
     *
     * @var string
     */
    static $rootDir = '';

    /**
     * Is the array where RainTPL keep the variables assigned
     *
     * @var array
     */
    public $var = array();

    protected $tpl     = array();    // variables to keep the template directories and info
    protected $cache   = false;      // static cache enabled / disabled
    protected $cacheID = null;       // identify only one cache

    protected static $configNameSum = array();   // takes all the config to create the md5 of the file

    const CACHE_EXPIRE_TIME = 3600; // default cache expire time = hour
    const PHP_START         = '<?php'; // default cache expire time = hour
    const PHP_END           = '?>'; // default cache expire time = hour

    /**
     * Assign variable
     * eg. 	$t->assign('name', 'mickey');
     *
     * @param mixed $variable_name Name of template variable or associative array name/value
     * @param mixed $value value assigned to this variable. Not set if variable_name is an associative array
     */
    public function assign($variable, $value = null)
    {
        if(is_array($variable))
        {
            $this->var = $variable + $this->var;
        }
        else
        {
            $this->var[ $variable ] = $value;
        }
    }

    /**
     * Draw the template
     * eg. 	$html = $tpl->draw('demo', TRUE); // return template in string
     * or 	$tpl->draw($tplName);             // echo the template
     *
     * @param string $tpl_name  template to load
     * @param boolean $return_string  true=return a string, false=echo the template
     * @return string
     */
    function draw($tplName, $returnString = false)
    {
        global $app;
        $this->app = $app;

        try
        {
            $this->compileFile($tplName);
        }
        catch(RainTpl_Exception $e)
        {
            die($this->printDebug($e));
        }

        if(!$this->cache && !$returnString)
        {
            extract($this->var);
            include $this->tpl['compiledFile'];
            unset($this->tpl);
        }
        else
        {
            ob_start();
            extract($this->var);
            include $this->tpl['compiledFile'];
            $contents = ob_get_clean();

            if($this->cache) file_put_contents($this->tpl['cacheFile'], "<?php if(!class_exists('raintpl')){exit;}" . self::PHP_END . $contents);
            unset($this->tpl);

            if($returnString) return trim($contents);
            echo $contents;
        }
    }

    /**
     * If exists a valid cache for this template it returns the cache
     *
     * @param string $tpl_name Name of template (set the same of draw)
     * @param int $expiration_time Set after how many seconds the cache expire and must be regenerated
     * @return string it return the HTML or null if the cache must be recreated
     */
    function cache($tplName, $expireTime = self::CACHE_EXPIRE_TIME, $cacheID = null)
    {
        /* Set the cacheID. */
        $this->cacheID = $cacheID;

        if(!$this->prepareCompile($tplName) && file_exists($this->tpl['cacheFile']) && (time() - filemtime($this->tpl['cacheFile']) < $expireTime))
        {
            /* return the cached file as HTML. It remove the first 43 character, which are a PHP code to secure the file <?php if(!class_exists('raintpl')){exit;}? >*/
            return substr(file_get_contents($this->tpl['cacheFile']), 43);
        }
        else
        {
            /* Delete the cache of the selected template. */
            if(file_exists($this->tpl['cacheFile'])) unlink($this->tpl['cacheFile']);
            $this->cache = true;
        }
    }

    /**
     * Configure the settings of RainTPL
     *
     * @param  array|function    $setting
     * @param  mix               $value
     * @static
     * @access public
     * @return void
     */
    static function configure($setting, $value = null)
    {
        if(is_array($setting))
        {
            foreach($setting as $key => $value) self::configure($key, $value);
        }
        elseif(property_exists(__CLASS__, $setting))
        {
            self::$$setting = $value;
            self::$configNameSum[$setting] = $value; // take trace of all config
        }
    }

    /**
     * Prepare compile params.
     *
     * @param  string    $tplName
     * @access public
     * @return array
     */
    public function prepareCompile($tplName)
    {
        if(!isset($this->tpl['checked']))
        {
            $tplBasename = basename($tplName);                                               // template basename
            $tplBasedir  = (strpos($tplName, "/") !== false) ? dirname($tplName) . '/' : null; // template basedirectory

            $this->tpl['templateDir'] = self::$tplDir . $tplBasedir;
            $this->tpl['templateDir'] = dirname($tplName) . DS;

            $this->tpl['tplFile']     = self::$rootDir . $this->tpl['templateDir'] . $tplBasename . '.' . self::$tplExt;    // template file name

            /* If tplFile is not exists append extension to it. */
            if(!file_exists($this->tpl['tplFile'])) $this->tpl['tplFile'] = dirname($this->tpl['tplFile']) . DS . basename($this->tpl['tplFile'], "." . self::$tplExt);

            //$this->tpl['tplFile'] = str_replace(DS . 'tmp' . DS . 'template' . DS, DS . 'template' . DS, $this->tpl['tplFile']);
            $tempCmpiledFile = str_replace(TPL_ROOT, self::$rootDir . self::$cacheDir, $this->tpl['tplFile']);
            if(strpos($tplName, DS . 'tmp' . DS . 'template' . DS) !== false)
            {
                $tempCmpiledFile = str_replace($this->app->getBasePath() . 'tmp' . DS . 'template' . DS, self::$rootDir . self::$cacheDir, $this->tpl['tplFile']);
            }
            elseif(strpos($tplName, TPL_ROOT) === false)
            {
                $tempCmpiledFile = str_replace($this->app->getBasePath() . 'module' . DS, self::$rootDir . self::$cacheDir, $this->tpl['tplFile']);
            }

            if(!is_dir(dirname($tempCmpiledFile))) mkdir(dirname($tempCmpiledFile), 0777, true);
            $this->tpl['compiledFile'] = $tempCmpiledFile;
            $this->tpl['cacheFile']    = $tempCmpiledFile . 'cache.rtpl.php';
            $this->tpl['checked']      = true;

            /* If the template doesn't exist and is not an external source throw an error. */
            if(self::$checkTemplateUpdate && !file_exists($this->tpl['tplFile']) && !preg_match('/http/', $tplName))
            {
                $this->app->triggerError("Template {$this->tpl['tplFile']} not found!", __FILE__, __LINE__, true);
            }

            $compileSetting = array();
            if(preg_match('/http/', $tplName))
            {
                /* We check if the template is not an external source. */
                $compileSetting['baseName']     = '';
                $compileSetting['baseDir']      = '';
                $compileSetting['tplFile']      = $tplName;
                $compileSetting['cacheDir']     = self::$cacheDir;
                $compileSetting['compiledFile'] = $this->tpl['compiledFile'];

            }
            elseif(!file_exists($this->tpl['compiledFile']) || (self::$checkTemplateUpdate && filemtime($this->tpl['compiledFile']) < filemtime($this->tpl['tplFile'])))
            {
                /* file doesn't exist, or the template was updated, Rain will compile the template. */
                $compileSetting['baseName']     = $tplBasename;
                $compileSetting['baseDir']      = $tplBasedir;
                $compileSetting['tplFile']      = $this->tpl['tplFile'];
                $compileSetting['cacheDir']     = self::$rootDir . self::$cacheDir;
                $compileSetting['compiledFile'] = $this->tpl['compiledFile'];
            }
            return $compileSetting;
        }

        return false;
    }

    /**
     * Compile and write the compiled template file.
     *
     * @param  string    $tplName
     * @access protected
     * @return void
     */
    protected function compileFile($tplName)
    {
        $compileSetting = $this->prepareCompile($tplName);
        if(!$compileSetting) return true;
        extract($compileSetting);

        /* Read template file. */
        $this->tpl['source'] = $templateCode = file_get_contents($tplFile);
        if(strpos($templateCode, self::PHP_START) !== false)
        {
            $tplType  = (strpos($tplName, DS . 'block' . DS) !== false) ? 'model' : 'control';
            $compiledCode = $this->compiledPHPCode($templateCode, $tplType);
            file_put_contents($compiledFile, $compiledCode);
            return true;
        }

        /* Xml substitution. */
        $templateCode = preg_replace("/<\?xml(.*?)" . "\?" . ">/s", "##XML\\1XML##", $templateCode);

        /* Disable php tag. */
        if(!self::$phpEnabled) $templateCode = str_replace(array("<?", self::PHP_END), array("&lt;?","?&gt;"), $templateCode);

        /* Xml re-substitution. */
        $templateCode = preg_replace_callback ("/##XML(.*?)XML##/s", array($this, 'xml_reSubstitution'), $templateCode);

        /* Compile template. */
        $templateCompiled = self::PHP_START . " if(!class_exists('raintpl')){exit;}" . self::PHP_END . $this->compileTemplate($templateCode, $baseDir);

        /* Fix the php-eating-newline-after-closing-tag-problem. */
        $templateCompiled = str_replace(self::PHP_END . "\n", self::PHP_END . "\n\n", $templateCompiled);

        /* Create directories. */
        if(!is_dir($cacheDir)) mkdir($cacheDir, 0755, true);

        if(!is_writable($cacheDir))
        {
            $message = 'Cache directory ' . $cacheDir . 'doesn\'t have write permission. Set write permission or set RAINTPL_CHECK_TEMPLATE_UPDATE to false. More details on https://feulf.github.io/raintpl';
            $this->app->triggerError($message, __FILE__, __LINE__, true);
        }

        /* Write compiled file. */
        file_put_contents($compiledFile, $templateCompiled);
    }

    /**
     * Get Tag patterns.
     *
     * @access public
     * @return void
     */
    public function getTagPatterns()
    {
        $tagPatterns = array();
        $tagPatterns['loop']          = '(\{loop(?: name){0,1}="\${0,1}[^"]*"\})';
        $tagPatterns['break']	      = '(\{break\})';
        $tagPatterns['continue']      = '(\{continue\})';
        $tagPatterns['loop_close']    = '(\{\/loop\})';
        $tagPatterns['if']            = '(\{if(?: condition){0,1}="[^"]*"\})';
        $tagPatterns['if']            = '(\{if\(.*\)\})';
        $tagPatterns['foreach']       = '(\{foreach\(.*\)\})';
        $tagPatterns['for']           = '(\{for\(.*\)\})';
        $tagPatterns['elseif']        = '(\{elseif(?: condition){0,1}="[^"]*"\})';
        $tagPatterns['elseif']        = '(\{elseif\(.*\)\})';
        $tagPatterns['else']          = '(\{else\})';
        $tagPatterns['if_close']      = '(\{\/if\})';
        $tagPatterns['foreach_close'] = '(\{\/foreach\})';
        $tagPatterns['for_close']     = '(\{\/for\})';
        $tagPatterns['function']      = '(\{function="[^"]*"\})';
        $tagPatterns['noparse']       = '(\{noparse\})';
        $tagPatterns['noparse_close'] = '(\{\/noparse\})';
        $tagPatterns['ignore']        = '(\{ignore\}|\{\*)';
        $tagPatterns['ignore_close']  = '(\{\/ignore\}|\*\})';
        $tagPatterns['include']       = '(\{include\s+.+\})';
        $tagPatterns['template_info'] = '(\{\$template_info\})';
        $tagPatterns['function']      = '(\{!(\w*?)(?:.*?)\})';
        $tagPatterns['call']          = '(\{@(\w*?)(?:.*?)\})';

        return $tagPatterns;
    }

    /**
     * Compile template code.
     *
     * @param  string    $templateCode
     * @param  string    $tplBasedir
     * @access protected
     * @return string
     */
    protected function compileTemplate($templateCode, $tplBasedir)
    {
        $templateCode = $this->compileInlineIf($templateCode);
        $templateCode = $this->compileInlineFor($templateCode);

        $tagPatterns = $this->getTagPatterns();
        $tagRegexp   = "/" . join("|", $tagPatterns) . "/";

        /* Replace start mark and end mark of text. */
        $templateCode = str_replace("{{", "SOT_MARK", $templateCode);
        $templateCode = str_replace("}}", "EOT_MARK", $templateCode);

        $templateCode = preg_split($tagRegexp, $templateCode, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $compiledCode = $this->compileCode($templateCode);

        $compiledCode = str_replace("SOT_MARK", "{", $compiledCode);
        $compiledCode = str_replace("EOT_MARK", "}", $compiledCode);

        return $compiledCode;
    }

    /**
     * Compile the code
     *
     * @param  array     $parsedCode
     * @access protected
     * @return string
     */
    protected function compileCode($parsedCode)
    {
        if(!$parsedCode) return "";

        /* Variables initialization. */
        $compiledCode = $openIf = $commentIsOpen = $ignoreIsOpen = null;
        $loopLevel    = 0;

        /* Ead all parsed code. */
        foreach($parsedCode as $html)
        {
            /* Close ignore tag. */
            if(!$commentIsOpen && (strpos($html, '{/ignore}') !== FALSE || strpos($html, '*}') !== FALSE))
            {
                $ignoreIsOpen = false;
            }
            elseif($ignoreIsOpen)
            {

            }
            elseif(strpos($html, '{/noparse}') !== FALSE)
            {
                $commentIsOpen = false;
            }
            elseif($commentIsOpen)
            {
                $html = str_replace("SOT_MARK", "{{", $html);
                $html = str_replace("EOT_MARK", "}}", $html);
                $compiledCode .= $html;
            }
            elseif(strpos($html, '{ignore}') !== FALSE || strpos($html, '{*') !== FALSE)
            {
                $ignoreIsOpen = true;
            }
            elseif(strpos($html, '{noparse}') !== FALSE)
            {
                $commentIsOpen = true;
            }
            elseif(preg_match('/\{foreach(\()(.*)\}/', $html, $code))
            {
                $compiledCode .= $this->compileForeach($html, $code);
            }
            elseif(preg_match('/\{for(\()(.*)\}/', $html, $code))
            {
                $compiledCode .= $this->compileFor($html, $code);
            }
            elseif(preg_match('/\{include(\s+)(.*)\}/', $html, $code))
            {
                $compiledCode .= $this->compileInclude($html, $code);
            }
            elseif(strpos($html, '{break}') !== FALSE)
            {
                $compiledCode .=  self::wrapPHP('break;');
            }
            elseif(strpos($html, '{continue}') !== FALSE)
            {
                $compiledCode .=  self::wrapPHP('continue;');
            }
            elseif(strpos($html, '{/loop}') !== FALSE)
            {
                //close loop tag
                $counter = "\$counter$loopLevel";

                //decrease the loop counter
                $loopLevel--;

                //close loop code
                $compiledCode .= self::wrapPHP('}');
            }
            elseif(strpos($html, '{/for}') !== FALSE)
            {
                $compiledCode .= self::wrapPHP('endfor;');
            }
            elseif(strpos($html, '{/foreach}') !== FALSE)
            {
                $compiledCode .= self::wrapPHP('endforeach;');
            }
            elseif(preg_match('/\{if(?: condition){0,1}="([^"]*)"\}/', $html, $code))
            {
                //increase open if counter (for intendation)
                $openIf++;

                //tag
                $tag = $code[0];

                //condition attribute
                $condition = $code[1];

                // check if there's any function disabled by blackList
                $this->checkFunction($tag);

                //variable substitution into condition (no delimiter into the condition)
                $parsedCondition = $this->replaceVar($condition, $tagLeft = null, $tagRight = null, $phpLeft = null, $phpRight = null, $loopLevel);

                //if code
                $compiledCode .= self::wrapPHP("if($parsedCondition){");

            }
            elseif(preg_match('/\{if\((.*)\)\}/', $html, $code))
            {
                //increase open if counter (for intendation)
                $openIf++;

                //tag
                $tag = $code[0];

                //condition attribute
                $condition = $code[1];

                // check if there's any function disabled by blackList
                $this->checkFunction($tag);

                //variable substitution into condition (no delimiter into the condition)
                $parsedCondition = $this->replaceVar($condition, $tagLeft = null, $tagRight = null, $phpLeft = null, $phpRight = null, $loopLevel);

                //if code
                $compiledCode .= self::wrapPHP("if($parsedCondition){");

            }
            elseif(preg_match('/\{elseif(?: condition){0,1}="([^"]*)"\}/', $html, $code))
            {
                //tag
                $tag = $code[0];

                //condition attribute
                $condition = $code[1];

                //variable substitution into condition (no delimiter into the condition)
                $parsedCondition = $this->replaceVar($condition, $tagLeft = null, $tagRight = null, $phpLeft = null, $phpRight = null, $loopLevel);

                //elseif code
                $compiledCode .= self::wrapPHP("}elseif($parsedCondition){");
            }
            elseif(preg_match('/\{elseif\((.*)\)\}/', $html, $code))
            {
                $tag       = $code[0];       //tag
                $condition = $code[1]; //condition attribute

                /* Variable substitution into condition (no delimiter into the condition) */
                $parsedCondition = $this->replaceVar($condition, $tagLeft = null, $tagRight = null, $phpLeft = null, $phpRight = null, $loopLevel);

                //elseif code
                $compiledCode .= self::wrapPHP("}elseif($parsedCondition){");
            }
            elseif(strpos($html, '{else}') !== FALSE)
            {
                //else code
                $compiledCode .= self::wrapPHP('}else{');

            }
            //close if tag
            elseif(strpos($html, '{/if}') !== FALSE)
            {
                //decrease if counter
                $openIf--;

                // close if code
                $compiledCode .= self::wrapPHP('}');

            }
            elseif(preg_match('/\{!(\w*)(.*?)\}/', $html, $code))
            {

                $tag      = $code[0];
                $function = $code[1];

                $this->checkFunction($tag);

                if(empty($code[2]))
                {
                    $parsed_function = $function . "()";
                }
                else
                {
                    $parsed_function = $function . $this->replaceVar($code[2], $tagLeft = null, $tagRight = null, $phpLeft = null, $phpRight = null, $loopLevel);
                }

                /* Add echo if neccesory. */
                if($function != 'echo' and strpos(self::$outputFunctions, ",$function,") === false)
                {
                    $parsed_function = 'echo ' . $parsed_function;
                }
                $compiledCode .= self::wrapPHP("$parsed_function;");
            }
            elseif(preg_match('/\{@(\w*)(.*?)\}/', $html, $code))
            {

                $tag      = $code[0];
                $function = $code[1];

                $this->checkFunction($tag);

                if(empty($code[2]))
                {
                    $parsed_function = $function . "()";
                }
                else
                {
                    $parsed_function = $function . $this->replaceVar($code[2], $tagLeft = null, $tagRight = null, $phpLeft = null, $phpRight = null, $loopLevel);
                }

                $compiledCode .= self::wrapPHP("$parsed_function;");
            }

            elseif(strpos($html, '{$template_info}') !== FALSE)
            {
                $tag = '{$template_info}';
                $compiledCode .= self::wrapPHP('echo "<pre>"; print_r($this->var); echo "</pre>";');
            }
            else
            {
                //variables substitution (es. {$title})
                $html = $this->replaceVar($html, $left_delimiter = '\{', $right_delimiter = '\}', self::PHP_START . ' ', $phpRight = ';' . self::PHP_END, $loopLevel, $echo = true);
                //const substitution (es. {#CONST#})
                $html = $this->replaceConst($html, $left_delimiter = '\{', $right_delimiter = '\}', self::PHP_START . ' ', $phpRight = ';' . self::PHP_END, $loopLevel, $echo = true);
                //functions substitution (es. {"string"|functions})
                $compiledCode .= $this->replaceFunc($html, $left_delimiter = '\{', $right_delimiter = '\}', self::PHP_START . ' ', $phpRight = ';' . self::PHP_END, $loopLevel, $echo = true);
            }
        }

        if($openIf > 0)
        {
            $message = 'Error! You need to close an {if} tag in ' . $this->tpl['tplFile'] . ' template';
            $this->app->triggerError($message, __FILE__, __LINE__, true);
        }
        return $compiledCode;
    }

    /**
     * Compile foreach sentence.
     *
     * @param  string    $html
     * @access public
     * @return string
     */
    public function compileForeach($html = '', $code)
    {
        if(!isset($code[2])) return $html;
        return self::wrapPHP('foreach(' .  $code[2] . ':');
    }

    /**
     * Compile for sentence.
     *
     * @param  string    $html
     * @access public
     * @return string
     */
    public function compileFor($html = '', $code)
    {
        if(!isset($code[2])) return $html;
        return self::wrapPHP('for(' .  $code[2] . ':');
    }

    /**
     * Compile include sentence.
     *
     * @param  int    $html
     * @param  int    $code
     * @access public
     * @return void
     */
    public function compileInclude($html, $code = null)
    {
        if(preg_match("/http/", $code[1])) return file_get_contents($code[1]);

        /* Variables substitution. */
        $include_var = $this->replaceVar($code[2], $left_delimiter = null, $right_delimiter = null, $phpLeft = '".' , $phpRight = '."');
        $include_var = $code[2];

        /* Get the included template. */
        $include_template = $include_var;

        /* Reduce the path. */
        $include_template = $this->reduce_path($include_template);
        $include_template = trim($include_template, ';');
        /* If the cache is active. */
        if(isset($code[2]))
        {
            return self::PHP_START . ' $tpl = new RainTPL;' .
                '$tpl->assign($this->var);' .
                '$tpl->draw(' . $include_template . ');'
                . self::PHP_END;
        }
    }

    /**
     * Compile inline for.
     *
     * @param  string    $code
     * @access public
     * @return string
     */
    public function compileInlineFor($code)
    {
        preg_match_all('/\{for\(.*\{\/for\}/', $code, $ifLines);
        foreach($ifLines[0] as $line)
        {
            if(preg_match('/\}\s*\{/', $line))
            {
                $compiledLine = preg_replace('/\}\s*\{/', "}\n{", $line);
                $code         = str_replace($line, $compiledLine, $code);
            }
            else
            {
                $code = str_replace(')}', ")}\n", $code);
            }
        }

        preg_match_all('/\}\s*\{\/for\}/', $code, $ifLines);
        foreach($ifLines[0] as $line)
        {
            if(preg_match('/\}\s*\{/', $line))
            {
                $compiledLine = preg_replace('/\}\s*\{/', "}\n{", $line);
                $code         = str_replace($line, $compiledLine, $code);
            }
            else
            {
                $code = str_replace(')}', ")}\n", $code);
            }
        }

        return $code;
    }


    /**
     * CompileInlineIf
     *
     * @param  string    $code
     * @access public
     * @return string
     */
    public function compileInlineIf($code)
    {
        preg_match_all('/\{if\(.*\{\/if\}/', $code, $ifLines);
        foreach($ifLines[0] as $line)
        {
            if(preg_match('/\}\s*\{/', $line))
            {
                $compiledLine = preg_replace('/\}\s*\{/', "}\n{", $line);
                $code         = str_replace($line, $compiledLine, $code);
            }
            else
            {
                $code = str_replace(')}', ")}\n", $code);
            }
        }

        preg_match_all('/\}\s*\{\/if\}/', $code, $ifLines);
        foreach($ifLines[0] as $line)
        {
            if(preg_match('/\}\s*\{/', $line))
            {
                $compiledLine = preg_replace('/\}\s*\{/', "}\n{", $line);
                $code         = str_replace($line, $compiledLine, $code);
            }
            else
            {
                $code = str_replace(')}', ")}\n", $code);
            }
        }

        return $code;
    }

    /**
     * wrapPHP
     *
     * @param  int    $code
     * @access public
     * @return void
     */
    public function wrapPHP($code)
    {
        return self::PHP_START . ' ' . $code . ' ' . self::PHP_END;
    }

    /**
     * Execute stripslaches() on the xml block. Invoqued by preg_replace_callback function below
     *
     * @param  array      $capture
     * @access protected
     * @return string
     */
    protected function xml_reSubstitution($capture)
    {
        return self::PHP_START . " echo '<?xml " . stripslashes($capture[1]) . self::PHP_END . self::PHP_END;
    }

    /**
     * Reduce a path, eg. www/library/../filepath//file => www/filepath/file
     * @param type $path
     * @return type
     */
    protected function reduce_path($path)
    {
        $path = str_replace("://", "@not_replace@", $path);
        $path = preg_replace("#(/+)#", "/", $path);
        $path = preg_replace("#(/\./+)#", "/", $path);
        $path = str_replace("@not_replace@", "://", $path);

        while(preg_match('#\.\./#', $path))
        {
            $path = preg_replace('#\w+/\.\./#', '', $path);
        }
        return $path;
    }

    /**
     * Replace URL according to the following rules:
     * http://url => http://url
     * url# => url
     * /url => base_dir/url
     * url => path/url (where path generally is baseUrl/template_dir)
     * (The last one is => base_dir/url for <a> href)
     *
     * @param string $url Url to rewrite.
     * @param string $tag Tag in which the url has been found.
     * @param string $path Path to prepend to relative URLs.
     * @return string rewritten url
     */
    protected function rewrite_url($url, $tag, $path)
    {
        // If we don't have to rewrite for this tag, do nothing.
        if(!in_array($tag, self::$pathReplaceList))
        {
            return $url;
        }

        // Make protocol list. It is a little bit different for <a>.
        $protocol = 'http|https|ftp|file|apt|magnet';
        if ($tag == 'a')
        {
            $protocol .= '|mailto|javascript';
        }

        // Regex for URLs that should not change (except the leading #)
        $no_change = "/(^($protocol)\:)|(#$)/i";
        if (preg_match($no_change, $url))
        {
            return rtrim($url, '#');
        }

        // Regex for URLs that need only base url (and not template dir)
        $base_only = '/^\//';
        if ($tag == 'a' or $tag == 'form')
        {
            $base_only = '//';
        }
        if (preg_match($base_only, $url))
        {
            return rtrim(self::$baseUrl, '/') . '/' . ltrim($url, '/');
        }

        // Other URLs
        return $path . $url;
    }

    /**
     * replace one single path corresponding to a given match in the `pathReplace` regex.
     * This function has no reason to be used anywhere but in `pathReplace`.
     * @see pathReplace
     *
     * @param array $matches
     * @return replacement string
     */
    protected function single_pathReplace ($matches)
    {
        $tag  = $matches[1];
        $_    = $matches[2];
        $attr = $matches[3];
        $url  = $matches[4];
        $new_url = $this->rewrite_url($url, $tag, $this->path);

        return "<$tag$_$attr=\"$new_url\"";
    }

    /**
     * replace the path of image src, link href and a href.
     * @see rewrite_url for more information about how paths are replaced.
     *
     * @param  string   $html
     * @param  string   $tplBasedir
     * @access protected
     * @return string
     */
    protected function pathReplace($html, $tplBasedir)
    {
        return $html;
        if(self::$pathReplace)
        {
            $tplDir = self::$baseUrl . self::$tplDir . $tplBasedir;

            // Prepare reduced path not to compute it for each link
            $this->path = $this->reduce_path($tplDir);

            /* Allow " inside {} for cases in which url contains {function="foo()"} */
            $url = '(?:(?:\\{.*?\\})?[^{}]*?)*?';

            $exp = array();

            $tags = array_intersect(array("link", "a"), self::$pathReplaceList);
            $exp[] = '/<(' . join('|', $tags) . ')(.*?)(href)="(' . $url . ')"/i';

            $tags = array_intersect(array("img", "script", "input"), self::$pathReplaceList);
            $exp[] = '/<(' . join('|', $tags) . ')(.*?)(src)="(' . $url . ')"/i';

            $tags = array_intersect(array("form"), self::$pathReplaceList);
            $exp[] = '/<(' . join('|', $tags) . ')(.*?)(action)="(' . $url . ')"/i';
            return preg_replace_callback($exp, 'self::single_pathReplace', $html);
        }
        return $html;
    }

    /**
     * replace const
     *
     * @param  string    $html
     * @param  string    $tagLeft
     * @param  string    $tagRight
     * @param  string    $phpLeft
     * @param  string    $phpRight
     * @param  string    $loopLevel
     * @param  string    $echo
     * @access public
     * @return string    $html
     */
    function replaceConst($html, $tagLeft, $tagRight, $phpLeft = null, $phpRight = null, $loopLevel = null, $echo = null)
    {
        return preg_replace('/\{\#(\w+)\#{0,1}\}/', $phpLeft . ($echo ? " echo " : null) . '\\1' . $phpRight, $html);
    }

    /**
     * Replace functions/modifiers on constants and strings
     *
     * @param  string    $html
     * @param  string    $tagLeft
     * @param  string    $tagRight
     * @param  string    $phpLeft
     * @param  string    $phpRight
     * @param  string    $loopLevel
     * @param  string    $echo
     * @access public
     * @return html
     */
    function replaceFunc($html, $tagLeft, $tagRight, $phpLeft = null, $phpRight = null, $loopLevel = null, $echo = null)
    {
        preg_match_all('/' . '\{\#{0,1}(\"{0,1}.*?\"{0,1})(\|\w.*?)\#{0,1}\}' . '/', $html, $matches);

        for($i=0, $n=count($matches[0]); $i<$n; $i++)
        {
            //complete tag ex: {$news.title|substr:0,100}
            $tag = $matches[ 0 ][ $i ];

            //variable name ex: news.title
            $var = $matches[ 1 ][ $i ];

            //function and parameters associate to the variable ex: substr:0,100
            $extraVar = $matches[ 2 ][ $i ];

            // check if there's any function disabled by blackList
            $this->checkFunction($tag);

            $extraVar = $this->replaceVar($extraVar, null, null, null, null, $loopLevel);


            // check if there's an operator = in the variable tags, if there's this is an initialization so it will not output any value
            $is_init_variable = preg_match("/^(\s*?)\=[^=](.*?)$/", $extraVar);
            if(!$is_init_variable) $is_init_variable = preg_match("/^(\s)*\.=(.*?)$/", $extraVar);
            if(!$is_init_variable) $is_init_variable = preg_match("/^(\s)*\+=(.*?)$/", $extraVar);
            if(!$is_init_variable) $is_init_variable = preg_match("/^\[.*\].*=.*$/", $extraVar);

            //function associate to variable
            $function_var = ($extraVar and $extraVar[0] == '|') ? substr($extraVar, 1) : null;

            //variable path split array (ex. $news.title o $news[title]) or object (ex. $news->title)
            $temp = preg_split("/\.|\[|\-\>/", $var);

            //variable name
            $varName = $temp[ 0 ];

            //variable path
            $variablePath = substr($var, strlen($varName));

            //parentesis transform [ e ] in [" e in "]
            $variablePath = str_replace('[', '["', $variablePath);
            $variablePath = str_replace(']', '"]', $variablePath);

            //transform .$variable in ["$variable"]
            $variablePath = preg_replace('/\.\$(\w+)/', '["$\\1"]', $variablePath);

            //transform [variable] in ["variable"]
            $variablePath = preg_replace('/\.(\w+)/', '["\\1"]', $variablePath);

            //if there's a function
            if($function_var)
            {
                // check if there's a function or a static method and separate, function by parameters
                $function_var = str_replace("::", "@double_dot@", $function_var);

                // get the position of the first :
                if($dot_position = strpos($function_var, ":"))
                {
                    // get the function and the parameters
                    $function = substr($function_var, 0, $dot_position);
                    $params   = substr($function_var, $dot_position+1);
                }
                else
                {
                    //get the function
                    $function = str_replace("@double_dot@", "::", $function_var);
                    $params   = null;
                }

                // replace back the @double_dot@ with ::
                $function = str_replace("@double_dot@", "::", $function);
                $params   = str_replace("@double_dot@", "::", $params);
            }
            else
            {
                $function = $params = null;
            }

            $phpVariable = $varName . $variablePath;

            // compile the variable for php
            if(isset($function))
            {
                if($phpVariable)
                {
                    $phpVariable = $phpLeft . (!$is_init_variable && $echo ? 'echo ' : null) . ($params ? "($function($phpVariable, $params))" : "$function($phpVariable)") . $phpRight;
                }
                else
                {
                    $phpVariable = $phpLeft . (!$is_init_variable && $echo ? 'echo ' : null) . ($params ? "($function($params))" : "$function()") . $phpRight;
                }
            }
            else
            {
                $phpVariable = $phpLeft . (!$is_init_variable && $echo ? 'echo ' : null) . $phpVariable . $extraVar . $phpRight;
            }

            $html = str_replace($tag, $phpVariable, $html);
        }
        return $html;
    }

    /**
     * replaceVar
     *
     * @param  string    $html
     * @param  string    $tagLeft
     * @param  string    $tagRight
     * @param  string    $phpLeft
     * @param  string    $phpRight
     * @param  string    $loopLevel
     * @param  string    $echo
     * @access public
     * @return string
     */
    function replaceVar($html, $tagLeft, $tagRight, $phpLeft = null, $phpRight = null, $loopLevel = null, $echo = null)
    {
        //all variables
        if(preg_match_all('/' . $tagLeft . '\$(\w+(?:\.\${0,1}[A-Za-z0-9_]+)*(?:(?:\[\${0,1}[A-Za-z0-9_]+\])|(?:\-\>\${0,1}[A-Za-z0-9_]+))*)(.*?)' . $tagRight . '/', $html, $matches))
        {
            for($parsed=array(), $i=0, $n=count($matches[0]); $i<$n; $i++)
            {
                $parsed[$matches[0][$i]] = array('var'=>$matches[1][$i],'extraVar'=>$matches[2][$i]);
            }

            foreach($parsed as $tag => $array)
            {
                //variable name ex: news.title
                $var = $array['var'];

                //function and parameters associate to the variable ex: substr:0,100
                $extraVar = $array['extraVar'];

                // check if there's any function disabled by blackList
                $this->checkFunction($tag);

                $extraVar = $this->replaceVar($extraVar, null, null, null, null, $loopLevel);

                // check if there's an operator = in the variable tags, if there's this is an initialization so it will not output any value
                $is_init_variable = preg_match("/^[a-z_A-Z\.\[\](\-\>)]*(\s)*(=){1}[^=]*.*$/", $extraVar);
                if(!$is_init_variable) $is_init_variable = preg_match("/^(\s)*\.=(.*?)$/", $extraVar);
                if(!$is_init_variable) $is_init_variable = preg_match("/^(\s)*\+=(.*?)$/", $extraVar);
                if(!$is_init_variable) $is_init_variable = preg_match("/^\[.*\].*=.*$/", $extraVar);

                //function associate to variable
                $function_var = ($extraVar and $extraVar[0] == '|') ? substr($extraVar, 1) : null;

                //variable path split array (ex. $news.title o $news[title]) or object (ex. $news->title)
                $temp = preg_split("/\.|\[|\-\>/", $var);

                //variable name
                $varName = $temp[0];

                //variable path
                $variablePath = substr($var, strlen($varName));

                //parentesis transform [ e ] in [" e in "]
                $variablePath = str_replace('[', '["', $variablePath);
                $variablePath = str_replace(']', '"]', $variablePath);

                //transform .$variable in ["$variable"] and .variable in ["variable"]
                $variablePath = preg_replace('/\.(\${0,1}\w+)/', '["\\1"]', $variablePath);

                // if is an assignment also assign the variable to $this->var['value']
                if($is_init_variable)
                {
                    if(strpos($var, '[') === false and strpos($var, '->') === false) $extraVar = "=\$this->var['{$varName}']{$variablePath}" . $extraVar;
                    if(strpos($array['extraVar'], '[') === 0)
                    {
                        $objectVar = '$this->var' . "['$varName'] = " . '$' . $varName;
                        $extraVar  = $array['extraVar'] . ';' . $objectVar;
                    }
                    if(strpos($var, '->') !== false)
                    {
                        $objectVar = '$this->var' . "['$varName'] = " . '$' . $varName;
                        $extraVar  = $extraVar . ';' . $objectVar;
                    }
                }

                //if there's a function
                if($function_var)
                {
                    // check if there's a function or a static method and separate, function by parameters
                    $function_var = str_replace("::", "@double_dot@", $function_var);

                    // get the position of the first :
                    if($dot_position = strpos($function_var, ":"))
                    {
                        // get the function and the parameters
                        $function = substr($function_var, 0, $dot_position);
                        $params   = substr($function_var, $dot_position+1);

                    }
                    else
                    {
                        //get the function
                        $function = str_replace("@double_dot@", "::", $function_var);
                        $params   = null;

                    }

                    // replace back the @double_dot@ with ::
                    $function = str_replace("@double_dot@", "::", $function);
                    $params   = str_replace("@double_dot@", "::", $params);
                }
                else
                {
                    $function = $params = null;
                }

                //if it is inside a loop
                if($loopLevel)
                {
                    //verify the variable name
                    if($varName == 'key')
                    {
                        $phpVariable = '$key' . $loopLevel;
                    }
                    elseif($varName == 'value')
                    {
                        $phpVariable = '$value' . $loopLevel . $variablePath;
                    }
                    elseif($varName == 'counter')
                    {
                        $phpVariable = '$counter' . $loopLevel;
                    }
                    else
                    {
                        $phpVariable = '$' . $varName . $variablePath;
                    }
                }
                else
                {
                    $phpVariable = '$' . $varName . $variablePath;
                }
                // compile the variable for php
                if(isset($function))
                {
                    $phpVariable = $phpLeft . (!$is_init_variable && $echo ? 'echo ' : null) . ($params ? "($function($phpVariable, $params))" : "$function($phpVariable)") . $phpRight;
                }
                else
                {
                    $phpVariable = $phpLeft . (!$is_init_variable && $echo ? 'echo ' : null) . $phpVariable . $extraVar . $phpRight;
                }

                $html = str_replace($tag, $phpVariable, $html);
            }
        }

        return $html;
    }

    /**
     * Check if function is in black list (sandbox)
     *
     * @param string $code
     * @param string $tag
     */
    protected function checkFunction($code)
    {
        $preg = '#(\W|\s)' . implode('(\W|\s)|(\W|\s)', self::$blackList) . '(\W|\s)#';

        // check if the function is in the black list (or not in white list)
        if(count(self::$blackList) && preg_match($preg, $code, $match))
        {
            // find the line of the error
            $line = 0;
            $rows = explode("\n",$this->tpl['source']);
            while(!strpos($rows[$line], $code)) $line++;

            // stop the execution of the script
            $message = 'Unallowed syntax in ' . $this->tpl['tplFile'] . ' template';
            $this->app->triggerError($message, $this->tpl['tplFile'], $line, true);
        }
    }

    /**
     * Compiled php view code. 
     * 
     * @param  string    $templateCode 
     * @param  string    $tplType 
     * @access private
     * @return string
     */
    private function compiledPHPCode($templateCode, $tplType)
    {
        $compiledCode = str_replace('$this->', '$' . $tplType . '->', $templateCode);
        $includePreg  = '/ include\s+(.+);/';
        preg_match_all($includePreg, $compiledCode, $matches);
        foreach($matches[1] as $key => $code)
        {
            $raintplCode =  " \$tpl = new RainTPL; \$tpl->assign(\$this->var);" . "\$tpl->draw($code);";
            $compiledCode = str_replace($matches[0][$key], $raintplCode, $compiledCode);
        }

        $includePreg  = '/ include\s+(.+)\s+\?\>/';
        preg_match_all($includePreg, $compiledCode, $matches);
        foreach($matches[1] as $key => $code)
        {
            $raintplCode =  " \$tpl = new RainTPL;\$tpl->assign(\$this->var);" . "\$tpl->draw($code);" . self::PHP_END;
            $compiledCode = str_replace($matches[0][$key], $raintplCode, $compiledCode);
        }

        return $compiledCode;
    }
}
