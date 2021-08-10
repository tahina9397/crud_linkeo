
<?php
 
interface Zend_Request_Interface
{
    public function setParam($key, $value);
    public function getParam($key);
    public function getParams();
    public function setParams(array $params);
}