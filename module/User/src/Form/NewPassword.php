<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element\Email;
use Zend\Form\Element\Csrf;
use User\Form\Filter\NewPasswordFilter;


/**
 * Description of NewPassword
 *
 * @author MW
 */
class NewPassword extends Form{
    //put your code here
    
    public function __construc(){
        parent::__construct('new-password', []);
        
        $this->setInputFilter(new NewPasswordFilter());
        $this->setAttributes(['method' => 'POST']);
        
        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'Email',
            'class' => 'form-control',
            'maxlength' => 255,
        ]);
        $this->add($email);
        
        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timeout' => 600
            ]
        ]);
        
        $this->add($csrf);
    }
}
