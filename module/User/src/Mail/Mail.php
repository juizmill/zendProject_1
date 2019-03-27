<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Mail;

use Core\Mail\AbstractCoreMail;
use Zend\View\Model\ViewModel;

/**
 * Description of Mail
 *
 * @author MW
 */
class Mail extends AbstractCoreMail{
    //put your code here
    
    public function renderView($page, array $data) {
        $model = new ViewModel();
        $model->setTemplate($page);
        
        $model->setOption('has_parent', true);
        $model->setVariables(['data' => $data]);
        
        return $this->view->render($model);
    }

}
