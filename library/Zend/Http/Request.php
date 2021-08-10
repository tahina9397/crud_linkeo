
<?php
 
/** Zend_Request_Interface */
require_once 'Zend/Request/Interface.php';
 
class Zend_Http_Request implements Zend_Request_Interface
{
    protected $_requestUri;
    protected $_baseUrl;
    protected $_basePath;
    protected $_pathInfo;
    protected $_params  = array();
    protected $_aliases = array();
     
    /**
     * Access values contained in the superglobals as public members
     * Order of precedence: 1. GET, 2. POST, 3. COOKIE, 4. SERVER, 5. ENV
     * 
     * http://msdn.microsoft.com/en-us/library/system.web.httprequest.item.aspx
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        } elseif (isset($_POST[$key])) {
            return $_POST[$key];
        } elseif (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        } elseif (isset($_SERVER[$key])) {
            switch ($key) {
                case 'REQUEST_URI' : return $this->getRequestUri();
                case 'PATH_INFO'   : return $this->getPathInfo();
                default            : return $_SERVER[$key];
            }
        } elseif (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
         
        return null;
    }
     
    public function getQuery($key)
    {
        return (isset($_GET[$key])) ? $_GET[$key] : null;
    }
     
    public function getPost($key)
    {
        return (isset($_POST[$key])) ? $_POST[$key] : null;
    }
     
    public function getCookie($key)
    {
        return (isset($_COOKIE[$key])) ? $_COOKIE[$key] : null;
    }
     
    public function getServer($key)
    {
        return (isset($_SERVER[$key])) ? $_SERVER[$key] : null;
    }
     
    public function getEnv($key)
    {
        return (isset($_ENV[$key])) ? $_ENV[$key] : null;
    }
     
    public function setRequestUri($requestUri = null)
    {
        if ($requestUri === null) {
            if (isset($_SERVER['REQUEST_URI'])) {
                $requestUri = $_SERVER['REQUEST_URI'];
            } elseif (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
                $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
            } else {
                return false;
            }
        }
         
        $this->_requestUri = $requestUri;
    }
     
    /**
     * Returns the REQUEST_URI taking into account
     * platform differences between Apache and IIS
     *
     * @return string
     */
    public function getRequestUri()
    {
        if ($this->_requestUri === null) {
            $this->setRequestUri();
        }
         
        return $this->_requestUri;
    }
     
    public function setBaseUrl($baseUrl = null)
    {
        if ($baseUrl === null) {
            $filename = basename($_SERVER['SCRIPT_FILENAME']);
             
            if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
                $baseUrl = $_SERVER['SCRIPT_NAME'];
            } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
                $baseUrl = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
                $baseUrl = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
            } else {
                return false;
            }
             
            if (($requestUri = $this->getRequestUri()) === null) {
                return false;
            }
             
            // If using mod_rewrite or ISAPI_Rewrite strip the script filename out of baseUrl
            // $pos !== 0 makes sure it is not matching a value from PATH_INFO or QueryString
            if (($pos = strpos($requestUri, $baseUrl)) === false || $pos !== 0) {
                $baseUrl = dirname($baseUrl);
            }
        }
         
        $this->_baseUrl = rtrim($baseUrl, '/');
    }
 
    /**
     * Everything in REQUEST_URI before PATH_INFO
     * <form action="<?=$baseUrl?>/news/submit" method="POST"/>
     *
     * @return string
     */
    public function getBaseUrl()
    {
        if ($this->_baseUrl === null) {
            $this->setBaseUrl();
        }
         
        return $this->_baseUrl;
    }
     
    public function setBasePath($basePath = null)
    {
        if ($basePath === null) {
            $filename = basename($_SERVER['SCRIPT_FILENAME']);
             
            if (($baseUrl = $this->getBaseUrl()) === null) {
                return false;
            }
             
            if (basename($baseUrl) === $filename) {
                $basePath = dirname($baseUrl);
            } else {
                $basePath = $baseUrl;
            }
        }
             
        $this->_basePath = rtrim($basePath, '/');
    }
     
    /**
     * Everything in REQUEST_URI before PATH_INFO not including the filename
     * <img src="<?=$basePath?>/images/zend.png"/>
     *
     * @return string
     */
    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $this->setBasePath();
        }
         
        return $this->_basePath;
    }
     
    public function setPathInfo($pathInfo = null)
    {
        if ($pathInfo === null) {
            if (($baseUrl = $this->getBaseUrl()) === null) {
                return false;
            }
             
            if (($requestUri = $this->getRequestUri()) === null) {
                return false;
            }
             
            // Remove the query string from REQUEST_URI
            if ($pos = strpos($requestUri, '?')) {
                $requestUri = substr($requestUri, 0, $pos);
            }
             
            if (($pathInfo = substr($requestUri, strlen($baseUrl))) === false) {
                // If substr() returns false then PATH_INFO is set to an empty string
                $pathInfo = '';
            }
        }
         
        $this->_pathInfo = $pathInfo;
    }
 
    /**
     * Returns everything between the BaseUrl and QueryString.
     * This value is calculated instead of reading PATH_INFO
     * directly from $_SERVER due to cross-platform differences.
     *
     * @return string
     */
    public function getPathInfo()
    {
        if ($this->_pathInfo === null) {
            $this->setPathInfo();
        }
         
        return $this->_pathInfo;
    }
     
    public function setParam($key, $value)
    {
        $keyName = (($alias = $this->getAlias($key)) !== null) ? $alias : $key;
        $this->_params[$keyName] = $value;
    }
     
    public function getParam($key)
    {
        $keyName = (($alias = $this->getAlias($key)) !== null) ? $alias : $key;
         
        if (isset($this->_params[$keyName])) {
            return $this->_params[$keyName];
        } elseif ((isset($_GET[$keyName]))) {
            return $_GET[$keyName];
        } elseif ((isset($_POST[$keyName]))) {
            return $_POST[$keyName];
        }
         
        return null;
    }
     
    public function getParams()
    {
        return $this->_params + $_GET + $_POST;
    }
     
    public function setParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->setParam($key, $value);
        }
    }
     
    public function setAlias($name, $target)
    {
        $this->_aliases[$name] = $target;
    }
     
    public function getAlias($name)
    {
        if (isset($this->_aliases[$name])) {
            return $this->_aliases[$name];
        }
         
        return null;
    }
     
    public function getAliases()
    {
        return $this->_aliases;
    }
}