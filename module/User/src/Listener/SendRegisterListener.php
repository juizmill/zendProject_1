<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;
use User\Controller\IndexController;
use Zend\EventManager\EventManager;
use User\Mail\Mail;


/**
 * Description of SendRegisterListener
 *
 * @author MW
 */
class SendRegisterListener extends AbstractListenerAggregate{
    
    use CurrentUrl;
    
    private $serviceManager;
    
    public function __construct(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }
    
    
    public function attach(EventManagerInterface $events, $priority = 1): void {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
                IndexController::class, 
                'registerAction.post', 
                [$this, 'onSendRegister'],
                $priority
        );
    }
    
    public function onSendRegister(EventManager $event) {
        /*
           @var $controller IndexController
         * @var $user \user\Model\User
         * @var $transsport \Zend\Mail\Transport\Smtp
        */
        
        $controller = $event->getTarget();
        $user = $event->getParams()['data'];
        
        $transport = $this->serviceManager->get('core.transport.smtp');
        $view = $this->serviceManager->get('View');
        
        $data = $user->getArrayCopy();
        $data['ip'] = $controller->getRequest()->getServer('REMOTE_ADDR');
        $data['host'] = $this->getUrl($controller->getRequest());
        
        $email = new Mail($transport, $view, 'user/mail/register');
        $mail->setSubject('Cadastro help Desk ZF3 na prática')
                ->setTo(strtolower(trim($user->email)))
                ->setData($data)
                ->prepare()
                ->send();
    }

}
