<?php 
class Application_Controller_Plugin_Compress extends Zend_Controller_Plugin_Abstract
{
    public function postDispatch(Zend_Controller_Request_Abstract $request){}

    public function dispatchLoopShutdown() 
	{ 
        $response = $this->getResponse();
        $body = $response->getBody();
        $body = $this->_compress($body);
        // $body = $this->_slib_compress_script($body);
        $response->setBody($body);
	}

    protected function _compress($buffer){
	    $re = '%# Collapse whitespace everywhere but in blacklisted elements.
	        (?>             # Match all whitespans other than single space.
	          [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
	        | \s{2,}        # or two or more consecutive-any-whitespace.
	        ) # Note: The remaining regex consumes no text at all...
	        (?=             # Ensure we are not in a blacklist tag.
	          [^<]*+        # Either zero or more non-"<" {normal*}
	          (?:           # Begin {(special normal*)*} construct
	            <           # or a < starting a non-blacklist tag.
	            (?!/?(?:textarea|pre|script)\b)
	            [^<]*+      # more non-"<" {normal*}
	          )*+           # Finish "unrolling-the-loop"
	          (?:           # Begin alternation group.
	            <           # Either a blacklist start tag.
	            (?>textarea|pre|script)\b
	          | \z          # or end of file.
	          )             # End alternation group.
	        )  # If we made it here, we are not in a blacklist tag.
	        %Six';

	    $new_buffer = preg_replace($re, " ", $buffer);

	    // We are going to check if processing has working
	    if ($new_buffer === null){
	        $new_buffer = $buffer;
	    }
	 
	    return $new_buffer;
    }

    protected function _slib_compress_script( $buffer ) {

	  // JavaScript compressor by John Elliot <jj5@jj5.net>

	  $replace = array(
	    '#\'([^\n\']*?)/\*([^\n\']*)\'#' => "'\1/'+\'\'+'*\2'", // remove comments from ' strings
	    '#\"([^\n\"]*?)/\*([^\n\"]*)\"#' => '"\1/"+\'\'+"*\2"', // remove comments from " strings
	    '#/\*.*?\*/#s'            => "",      // strip C style comments
	    '#[\r\n]+#'               => "\n",    // remove blank lines and \r's
	    '#\n([ \t]*//.*?\n)*#s'   => "\n",    // strip line comments (whole line only)
	    '#([^\\])//([^\'"\n]*)\n#s' => "\\1\n",
	                                          // strip line comments
	                                          // (that aren't possibly in strings or regex's)
	    '#\n\s+#'                 => "\n",    // strip excess whitespace
	    '#\s+\n#'                 => "\n",    // strip excess whitespace
	    '#(//[^\n]*\n)#s'         => "\\1\n", // extra line feed after any comments left
	                                          // (important given later replacements)
	    '#/([\'"])\+\'\'\+([\'"])\*#' => "/*" // restore comments in strings
	  );

	  $search = array_keys( $replace );
	  $script = preg_replace( $search, $replace, $buffer );

	  $replace = array(
	    "&&\n" => "&&",
	    "||\n" => "||",
	    "(\n"  => "(",
	    ")\n"  => ")",
	    "[\n"  => "[",
	    "]\n"  => "]",
	    "+\n"  => "+",
	    ",\n"  => ",",
	    "?\n"  => "?",
	    ":\n"  => ":",
	    ";\n"  => ";",
	    "{\n"  => "{",
		"}\n"  => "}",
	    "\n]"  => "]",
	    "\n)"  => ")",
	    "\n}"  => "}",
	    "\n\n" => "\n",
	    "<script>\n" => "<script>"
	  );

	  $search = array_keys( $replace );
	  $script = str_replace( $search, $replace, $script );

	  return trim( $script );
	}
}