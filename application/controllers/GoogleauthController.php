<?php

class GoogleauthController extends Zend_Controller_Action
{
    public function loginAction()
    {

        
        if ($this->getRequest()->getParam('code')) {
            // Autenticação do Google
            $auth = TBS\Auth::getInstance();
            $adapter = new TBS\Auth\Adapter\Google($this->_getParam('code'));
            $result = $auth->authenticate($adapter);

            // Verifica se a autenticação foi bem-sucedida
            if ($result->isValid()) {
                $this->_helper->redirector('criar', 'crud');
                
            } else {
                // Tratar caso a autenticação falhe
                throw new Zend_Controller_Action_Exception('Google login failed');
            }
        } else {
            // Redirecionar para o Google OAuth URL de autorização
            $this->view->googleAuthUrl = TBS\Auth\Adapter\Google::getAuthorizationUrl();
        }
    }
    public function connectAction()
    {
        $auth = TBS\Auth::getInstance();
        if (!$auth->hasIdentity()) {
            throw new Zend_Controller_Action_Exception('Not logged in!', 404);
        }
        $this->view->providers = $auth->getIdentity();
    }

    public function logoutAction()
    {
        \TBS\Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
    
}
