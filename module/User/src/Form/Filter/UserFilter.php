<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserFilter
 *
 * @author MW
 */

namespace User\Form\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Identical;

class UserFilter extends InputFilter{
    //put your code here
    
    public function __construct(Adapter $adapter) {
        
        $name = new Input('name');
        $name->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');        
        $name->getValidatorChain()->addValidator(new NotEmpty())
                ->addValidator(new StringLength(['max' => 120]));        
        $this->add($name);
        
        
        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');        
        $email->getValidatorChain()->addValidator(new NotEmpty())
                ->addValidator(new StringLength(['max' => 255]))
                ->addValidator(new NoRecordExists([
                    'table' => 'users',
                    'field' => 'email',
                    'adapter' => $adapter,
                    'messages' => [
                        'recordFound' => 'Este email já está em uso.'
                    ]
                ]));        
        $this->add($email);
        
        
        $password = new Input('password');
        $password->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');        
        $password->getValidatorChain()->addValidator(new NotEmpty())
                ->addValidator(new StringLength(['max' => 48, 'min' => 5]))
                ->addValidator(new Identical([
                    'token' => 'verifyPassword',
                    'message' => [
                        'notSame' => 'As senhas fornecidas não combinam'
                    ]
                ]));        
        $this->add($password);
        
        
        $verifyPassword = new Input('verifyPassword');
        $verifyPassword->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');        
        $verifyPassword->getValidatorChain()->addValidator(new NotEmpty())
                ->addValidator(new StringLength(['max' => 48, 'min' => 5]));
                        
        $this->add($verifyPassword);
        
    }
}
