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
use Zend\InputFilter\Input;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class NewPasswordFilter extends InputFilter{
    //put your code here
    
    public function __construct() {
        
        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('StripTags');        
        $email->getValidatorChain()->addValidator(new NotEmpty())
                ->addValidator(new StringLength(['max' => 255]));        
        $this->add($email);
        
    }
}
