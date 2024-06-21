<?php
class Conexao
{
    protected $dbAdapter;

    public function __construct($env = 'development')
    {
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');

    
        $this->dbAdapter = $bootstrap->getResource('db');
    }

    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }
}
