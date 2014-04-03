<?php
class TestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        echo 'ns: ' . __NAMESPACE__;
        echo '<br />';
        echo 'class: ' . __CLASS__;
        echo '<br />';
        echo 'function: ' . __FUNCTION__;
        echo '<br />';
        echo 'file: ' . __FILE__;
        echo '<br />';
        echo 'dir: ' . __DIR__;
        echo '<br />';
        echo 'line: ' . __LINE__;
        echo '<br />';
        echo 'method: ' . __METHOD__;
        echo '<br />';
        exit;
    }
    
    

}