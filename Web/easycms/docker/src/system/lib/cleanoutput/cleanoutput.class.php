<?php

/**
 * @projectDescription
 * CleanOutput
 * 
 * @description Properly indents XML code
 * @author Jon Gjengset <jon@thesquareplanet.com>
 * @version 2.0 ( 2009 )
 * @copyright This script may be used for any non-violent purpose. Please let me know know if you're using it though, as I, as any other developer, love to hear about how others utilize my work =)
 */
class cleanoutput
{
    private $cleanedXML = '';
    private $cleanedHash = '';
    private $indentBy = '  ';
    
    /**
     * Sets the indentation string
     * @param string $str[optional] Indentation string, defaults to four spaces
     */
    public function setIndentation ( $str = '    ' )
    {
        $this -> indentBy = $str;
    }
    
    /**
     * Properly formats the given XML with proper indentation
     * @return $cleanedXML
     * @param string $xml The XML code to be formatted
     */
    public function clean ( $xml )
    {
        $xml = preg_replace("/^(\s)*\n/", '', $xml);
        if ( md5( $xml ) === $this -> cleanedHash )
        {
            return $this -> cleanedXML;
        }
        
        /**
         * Variables for determining the type of block we're in 
         * 
         * @var $inComment Are we in an HTML/XML comment block?
         * @var $inCode Are we in a code block? ( JavaScript, CSS... )
         * @var $inPreformat Are we in a preformatted block? ( Textarea, pre )
         * @var $inInline Are we inside an inline tag?
         * @var $inSpecial Are we inside doctype, CDATA or similar?
         */
        $inComment = false;
        $inCode = false;
        $inPreformat = false;
        $inInline = false;
        $inSpecial = false;
        
        /**
         * @var $openedInSpecial Count opened tags in special blocks
         */
        $openedInSpecial = 0;
        
        /**
         * Various tag categories
         */
        $inlineTags = array ("a","basefont","bdo","font",
                                "iframe","map","param","q",
                                "span","sub","sup","abbr","acronym",
                                "cite", "del", "dfn", "em", "kbd",
                                "strong", "var", "b", "big", "i",
                                "s", "small", "strike", "tt", "u",
                                "span", "title", "img", 'meta', 'link', 'li');
        $preformatTags = array ( 'pre', 'textarea', 'code' );
        $codeTags = array ( 'script', 'style' );
        
        /**
         * Controls the indentation
         */
        $indentLevel = 0;
        
        /**
         * Have we just begun a new line?
         */
        $newLine = true;
        
        
        /**
         * Tracks newlines in code|preformat|comment
         */
        $startedNewLine = false;
        
        /**
         * Output variable
         */
        $cleanedXML = '';
        
        /**
         * Are we in the opening or closing of a tag?
         */
        $inATag = false;
        
        /**
         * And so it begins.. We now loop through all the characters in our XML
         * Before version 2.0, we used to loop lines and use regular expressions, 
         * but this approach is a lot more versatile
         */
        for ( $char = 0; $char < strlen( $xml ); $char++ )
        {
            /**
             * Case: We're not in a comment, and the next characters is an opening bracket
             * Meaning: An XML tag has just been encountered
             * Action: We figure out what kind of tag has been encountered, and act acordingly 
             */
            if ( $xml[$char] === '<' && !$inComment ) // We're starting or ending a tag
            {
                /**
                 * We find out what kind of tag we have by looping through the following characters
                 * until we encounter a closing bracket or a space. We then take the corresponding
                 * substring.
                 */
                $inTag = 'comment';
                if ( $xml[$char+1] !== '!' ) {
                    $findFirstSpace = strpos( $xml, ' ', $char );
                    $findFirstEnd = strpos( $xml, '>', $char );
                    if ( $findFirstSpace === false )
                        $inTag = trim( substr( $xml, $char + 1, $findFirstEnd - $char - 1 ), '/' );
                    elseif ( $findFirstEnd === false )
                        $inTag = trim( substr( $xml, $char + 1, $findFirstSpace - $char - 1 ), '/' );
                    else
                        $inTag = trim( substr( $xml, $char + 1, min( $findFirstEnd, $findFirstSpace ) - $char - 1 ), '/' );
                }
                
                /**
                 * Case: The first character after the opening bracket is a forward slash
                 * Meaning: We have encountered an XML ending tag
                 * Action: See comments for the if-else block
                 */
                if ( $xml[$char+1] === '/' )
                {
                    /**
                     * If the tag is not an inline tag, we decrease the indentation level
                     * Also, if we're not in a preformat block, we also add a newline and indentation
                     * before we add then ending tag. We then set the newline flag so we will get a new line
                     * after the closing tag.
                     */
                    if ( !in_array( $inTag, $inlineTags ) )
                    {
                        $indentLevel--;
                        if ( !$inPreformat && !($inTag === 'script' && $xml[$char-1] === '>') ) // We want empty <script></script> tags on a single line.
                        {
                            $cleanedXML .= "\n";
                            $cleanedXML .= $this -> getIndentation( $indentLevel, $this -> indentBy );
                        }
                        $cleanedXML .= '</' . $inTag . '>';
                        $newLine = true;
                    }
                    /**
                     * If, on the other hand, we are ending an inline tag, we only append the ending tag
                     * to the output, set the inline flag to false and unset the newline flag in case
                     * it has been set.
                     */
                    else
                    {
                        $cleanedXML .= '</' . $inTag . '>';
                        $inInline = false;
                        $newLine = false;
                    }
                
                    // If we're in a special block, we decrement the counter for opened tags in the block
                    if ( $inSpecial )
                        $openedInSpecial--;
                    
                    // If we're ending a preformat tag, we unset the preformat flag
                    if ( in_array( $inTag, $preformatTags ) )
                        $inPreformat = false;
                    // If we're ending a code tag, we unset the code flag
                    elseif ( in_array ( $inTag, $codeTags ) )
                        $inCode = false;
                    
                    // Since we've already appended the ending tag, we skip that amount of characters from input
                    $char += strlen( '</' . $inTag . '>' ) - 1;
                    
                }
                /**
                 * Case: The first character after the opening bracket is an exclamation mark
                 * Meaning: We're entering a special XML block ( comment, Doctype, CDATA... )
                 * Action: We determine the type of block, and set the appropriate flags.
                 * For special blocks, we also initialize a counter for opened tags in the block
                 * so we know when the block ends ( by looking at when the counter hits zero again )
                 */
                elseif ( $xml[$char+1] === '!' )
                {
                    // Comment
                    if ( $xml[$char+2] === '-' )
                    {
                        $inComment = true;
                    }
                    // Other special blocks
                    else
                    {
                        $inSpecial = true;
                        $openedInSpecial = 0;
                        $inATag = true;
                    }
                    $indentLevel++;
                    $newLine = false;
                    $cleanedXML .= $xml[$char];
                }
                /**
                 * Case: The first character is neither a forward slash or an exclamation mark
                 * Meaning: We're opening a new tag
                 * Action: We find the type of tag we're opening, and act acordingly
                 */
                else
                {
                    /**
                     * We only want to add a new line if we're either entering a block
                     * element OR the $newLine flag has been set.
                     * We then unset the newline flag so that we don't get an extra newline.
                     */
                    //if ( $newLine || !in_array ( $inTag, $inlineTags ) )
                    if ( $newLine || in_array ( $inTag, $inlineTags ) )
                    {
                        $cleanedXML .= "\n";
                        $cleanedXML .= $this -> getIndentation( $indentLevel, $this -> indentBy );
                    }
                    $newLine = false;
                    
                    // Set the inline flag if we're opening an inline tag
                    if ( in_array( $inTag, $inlineTags ) )
                    {
                        $inInline = true;
                    }
                    
                    // If we're opening a preformat tag, we set the appropriate tag
                    if ( in_array( $inTag, $preformatTags ) )
                        $inPreformat = true;
                    // Similarily, we set the code flag if we're opening a code tag
                    elseif ( in_array ( $inTag, $codeTags ) )
                        $inCode = true;
                    
                    // We then add the opening bracket to the output and set the "in a tag" flag
                    $cleanedXML .= '<';
                    $inATag = true;
                    
                    /**
                     * We now need to find out if this is a self closing tag or not.
                     * If it is, we shouldn't increase the indent level, and we should also
                     * Append the tag to output directly and bypass the reading of those
                     * since it will make everything easier for us
                     * 
                     * We also don't want to increase the indentlevel if we're in an inline tag
                     */
                    $endOfTag = strpos ( $xml, '>', $char );
                    if ( $xml[$endOfTag-1] !== '/' && !$inInline ) // Not self closing, and not inline
                    {
                        $indentLevel++;
                        // Remember the counter
                        if ( $inSpecial )
                            $openedInSpecial++;
                    }
                    elseif ( $xml[$endOfTag-1] === '/' ) // Self closing
                    {
                        // We find the complete contents of the tag, output it, increase $char and get on our way
                        $tagContent = substr ( $xml, $char + 1, $endOfTag - $char );
                        $cleanedXML .= $tagContent;
                        $char += strlen ( $tagContent );
                        
                        // If its a block element, we still want a new line
                        if ( !$inInline ) {
                            $newLine = true;
                        } else {
                            $newLine = false;
                        }
                        
                        // We now need to unset some of the flags since the tag has been closed
                        $inInline = false;
                        $inATag = false;
                    }
                }
            }
            /**
             * Case: We're in a comment block, and we've enountered -->
             * Meaning: The comment is ending
             * Action: Skip characters, unset comment flag, add newline and append to output
             */
            elseif ( $inComment && $xml[$char] === '-' && $xml[$char+1] === '-' && $xml[$char+2] === '>' )
            {
                $char += 3 - 1;
                $indentLevel--;
                $inComment = false;
                $cleanedXML .= '-->';
                $newLine = true;
            }
            /**
             * Case: We've encountered a newline, tab or carriage return whithout any "weird" flags set
             * Meaning: We've hit a special character that should not be included in the output
             * Action: Nothing... That's what you do when you skip something
             */
            elseif ( in_array( $xml[$char], array( "\t", "\r", "\n" ) ) && !$inComment && !$inCode && !$inPreformat )
            {}
            /**
             * Case: We've encountered a closing bracket, we're in a special block and the opened tags counter is zero
             * Meaning: We've hit the ending of the special tag
             * Action: Unset the special and in a tag flag, and decrement the indentation counter
             */
            elseif ( $xml[$char] === '>' && $inSpecial && $openedInSpecial === 0 )
            {
                $inSpecial = false;
                $inATag = false;
                $indentLevel--;
                $cleanedXML .= '>';
            }
            /**
             * Case: The next character is a closing bracket, we're in a tag definition, and we're not in a special block
             * Meaning: We've hit the end of an opening tag
             * Action: Unset the in-a-tag flag, and add newline if appropriate
             */
            elseif ( $xml[$char] === '>' && $inATag && !$inSpecial )
            {
                $inATag = false;
                $cleanedXML .= '>';
                // We don't want to add a newline if we've just opened an inline tag or are in preformat mode
                if ( $inInline || $inPreformat )
                    $newLine = false;
                else
                    $newLine = true;
            }
            /**
             * Case: We've hit an ordinary character
             * Meaning: Well.. Nothing special...
             * Action: Get the character to output
             */
            else
            {
                /**
                 * Remember to add a newline if the flag is set.
                 * We don't want to obey the newline flag if the first character on the line is an "empty" character
                 * In that case, we don't do anything, and wait until we hit a non-empty character.
                 */
                if ( $newLine && !in_array( $xml[$char], array ( "\r", "\n", "\t", " " ) ) )
                {
                    $cleanedXML .= "\n" . $this -> getIndentation ( $indentLevel, $this -> indentBy );
                    $newLine = false;
                }
                
                // We're in a code or comment block
                if ( $inCode || $inComment )
                {
                    // Inside code and comment blocks, all newlines should cause the next line to be indented
                    if ( $xml[$char] === "\n")
                    {
                        $cleanedXML .= "\n" . $this -> getIndentation ( $indentLevel, $this -> indentBy );
                        $startedNewLine = true;
                    }
                    // If we've hit a non-empty character, we print it
                    elseif ( !in_array( $xml[$char], array ( "\r", "\t", " " ) ) )
                    {
                        $cleanedXML .= $xml[$char];
                        $startedNewLine = false;
                    }
                    // If we've hit a space, and are not at the beginning of a line, we output it as well
                    elseif ( $xml[$char] === " " && !$startedNewLine )
                    {
                        $cleanedXML .= " ";
                    }
                }
                // We're in a preformatted block, so we jusdt output the character
                elseif ( $inPreformat )
                {
                    $cleanedXML .= $xml[$char];
                }
                // If the previously outputted character was not a newline or the last character in the indentation string
                // And the character is not an empty character, we output it
                elseif ( !in_array( $cleanedXML[ strlen ( $cleanedXML ) - 1 ], array( "\n", $this -> indentBy[ strlen ( $this -> indentBy ) - 1 ] ) ) || 
                         !in_array( $xml[$char], array ( "\r", "\n", "\t", " " ) ) )
                {
                    $cleanedXML .= $xml[$char];
                }
            }
        }
        
        $this -> cleanedHash = md5 ( $xml );
        $this -> cleanedXML = $xml;
        
        // Return!
        return $cleanedXML;
    }
    
    /**
     * Prints a before and after code of the cleaning process in HTML
     * 
     * @return XML for preview of the code before and after cleaning 
     * @param XML $xml THe XML to be cleaned
     * @param bool $return[optional] Should the code be returned or printed?
     */
    public function beforeAfter( $xml, $return = false )
	{
	    ob_start();
		?>
		Before:<br />
		<pre style="border:1px solid black;padding:5px 5px 5px 5px;height:40%;width:90%;overflow:scroll;"><?php echo htmlspecialchars( $xml ); ?></pre>
		<br />
		After:<br />
		<pre style="border:1px solid black;padding:5px 5px 5px 5px;height:40%;width:90%;overflow-x:scroll;"><?php htmlspecialchars( $this -> clean( $xml ) ); ?></pre>
		<br />
		<?php
        $out = ob_get_clean();
        ob_end_clean();
        
        if ( $return )
            return $out;
        else
            echo $out;
	}
    
    /**
     * Returns the cleaned XML with all tags and attributes in lowercase
     * @return XML
     */
    public function lowercaseTags()
	{
		if ( empty( $this -> cleanedXML ) )
        {
		    trigger_error("Output has not yet been cleaned", E_USER_NOTICE);
        }
		
		$this -> cleanedXML = preg_replace("<(\/?)([^<>\s]+)>/Ue", "'<'.'\\1'.lc('\\2').'>'", $this -> cleanedXML );
		$this -> cleanedXML = preg_replace("<(\/?)([^<>\s]+)(\s?[^<>]+)>/Ue", "'<'.'\\1'.lc('\\2').'\\3'.'>'", $this -> cleanedXML );
        
        return $this -> cleanedXML;
	}
    
    /**
     * Prints $indentation $indentLevel times
     * @return string indentstring
     * @param int $indentLevel
     * @param string $indentation
     */
    private function getIndentation ( $indentLevel, $indentation )
    {
        $out = '';
        for ( $i = 0; $i < $indentLevel; $i++ )
        {
            $out .= $indentation;
        }
        return $out;
    }
}
