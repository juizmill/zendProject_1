<?php


namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\UserForm;
use User\Model\UserTable;

class IndexController extends AbstractActionController
{
    
    private $userForm;
    private $userTable;
    
    public function __construct(UserForm $userForm, UserTable $userTable) {
        $this->userForm = $userForm;
        $this->userTable = $userTable;
    }
    
    public function registerAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        
        if($this->getRequest()->isPost()) {
            die('POST');
        }
        
        return new ViewModel([
            'form' => $this->userForm->prepare()
        ]);
    }
    
    public function recoveredPasswordAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        return new ViewModel();
    }
    
    public function newPasswordAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        return new ViewModel();
    }
    
    public function confirmedEmailAction()
    {
        return new ViewModel();
    }
}
