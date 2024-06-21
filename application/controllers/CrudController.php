<?php

class CrudController extends Zend_Controller_Action
{

    public function init()
    {

        $zendAuth = Zend_Auth::getInstance();
        $tbsAuth = TBS\Auth::getInstance();
    
        if ($zendAuth->hasIdentity() || $tbsAuth->hasIdentity()) {
     
            return;
        }

       return $this->rediretor('/');
       


        
    
       
        
    }
    
    public function indexAction()
    {
        return $this->_helper->redirector('criar');
    }

    public function criarAction()
    {
        if ($this->getRequest()->isPost()) {
            
            $autor = $this->getRequest()->getPost('autor');
            $curso = $this->getRequest()->getPost('curso');

           
            $data = array(
                'autor' => $autor,
                'curso' => $curso
            );


            $dbHelper = new Application_Model_Crud();

            $dbHelper->create($data);


            $this->_helper->redirector('exibir', 'crud');
            
        }
    }

    public function exibirAction()
    {
        $dbHelper = new Application_Model_Crud();

        $dados = $dbHelper->readAll();

        $this->view->dados = $dados;
    }

    public function exibiredicaoAction()
    {

        $id = $this->getRequest()->getParam('id');
        if (!$id) {
            
            $this->_helper->redirector('criar', 'crud');
            return;
        }

        $dbHelper = new Application_Model_Crud();

      
        $registro = $dbHelper->read($id);

        
        if (!$registro) {
           
            $this->_helper->redirector('criar', 'crud');
            return;
        }

        $this->view->registro = $registro;
    }

    public function editarAction()
    {

        
        $id = $this->getRequest()->getPost('id');
        
        if (!$id) {
            
            $this->_helper->redirector('criar', 'crud');
            return;
        }
        $dbHelper = new Application_Model_Crud();
        if ($this->getRequest()->isPost()) {
            
            $autor = $this->getRequest()->getPost('autor');
            $curso = $this->getRequest()->getPost('curso');

           
            $data = array(
                'autor' => $autor,
                'curso' => $curso
            );

            $dbHelper->update($id, $data);

            
            $this->_helper->redirector('exibir', 'crud');
        }
    }

    public function excluirAction()
    {
       
        $id = $this->getRequest()->getParam('id');

       
        $dbHelper = new Application_Model_Crud();

        
        $dbHelper->delete($id);

        
        $this->_helper->redirector('exibir', 'crud');
    }
}
