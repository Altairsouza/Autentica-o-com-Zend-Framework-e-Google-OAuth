<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        return $this->_helper->redirector('login');
    }

    public function loginAction()
    {
	$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
	$this->view->messages = $this->_flashMessenger->getMessages();
	//Verifica se existem dados de POST
	if ( $this->getRequest()->isPost() ) {
				
			$login = $this->getRequest()->getPost('login');
            $senha = $this->getRequest()->getPost('senha');
			
			$dbAdapter = Zend_Db_Table::getDefaultAdapter();
			//Inicia o adaptador Zend_Auth para banco de dados
			$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
			$authAdapter->setTableName('usuario')
						->setIdentityColumn('login')
						->setCredentialColumn('senha')
						->setCredentialTreatment('SHA1(?)');
			//Define os dados para processar o login
			$authAdapter->setIdentity($login)
						->setCredential($senha);
			//Efetua o login
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authAdapter);
			//Verifica se o login foi efetuado com sucesso
			if ( $result->isValid() ) {
				//Armazena os dados do usuário em sessão, apenas desconsiderando
				//a senha do usuário
				$info = $authAdapter->getResultRowObject(null, 'senha');
				$storage = $auth->getStorage();
				$storage->write($info);
				//Redireciona para o Controller protegido
				return  $this->_helper->redirector('exibir', 'crud');
			} else {
				//Dados inválidos
				$this->_helper->FlashMessenger('Usuário ou senha inválidos!');
				$this->_helper->redirector('login', 'auth');
			}
		 
	}
    }

    public function logoutAction()
{
	\TBS\Auth::getInstance()->clearIdentity();
	$auth = Zend_Auth::getInstance();
	$auth->clearIdentity();
	return $this->_helper->redirector('index');
}


}





