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
use Exception;
use User\Model\UserTable;

/**
 * Description of SendRegisterListener
 *
 * @author MW
 */
class SendRecoverPasswordListener extends AbstractListenerAggregate {

    use CurrentUrl;

    private $serviceManager;

    public function __construct(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function attach(EventManagerInterface $events, $priority = 1): void {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
                IndexController::class, 'recoveredPasswordAction.post', [$this, 'onSendRecoveredPassword'], $priority
        );
    }

    public function onSendrecoveRedPassword(EventManager $event) {
        /*
          @var $controller IndexController
         * @var $user \user\Model\User
         * @var $transsport \Zend\Mail\Transport\Smtp
         * @var $userTable \user\Model\UserTable
         */

        $controller = $event->getTarget();
        $email = $event->getParams()['data'];

        try {

            $userTable = $this->serviceManager->get(UserTable::class);
            $user = $userTable->getUserByEmail($email);

            $user = $userTable->save([
                'id' => $user->id,
                'email' => $user->email
            ]);

            $transport = $this->serviceManager->get('core.transport.smtp');
            $view = $this->serviceManager->get('View');

            $data = $user->getArrayCopy();
            $data['ip'] = $controller->getRequest()->getServer('REMOTE_ADDR');
            $data['host'] = $this->getUrl($controller->getRequest());

            $email = new Mail($transport, $view, 'user/mail/recover-password');
            $mail->setSubject('Nova senha, help Desk ZF3 na prática')
                    ->setTo(strtolower(trim($user->email)))
                    ->setData($data)
                    ->prepare()
                    ->send();
            
        } catch (Exception $exception) {
            echo $exception->getTraceAsString();
            die();
        }
    }

}
