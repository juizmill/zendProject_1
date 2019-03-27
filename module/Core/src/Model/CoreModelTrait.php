<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Model;

use Zend\Hydrator\Reflection;

/**
 * Description of CoreModelTrait
 *
 * @author MW
 */
trait CoreModelTrait {
    
    public function exchangeArray(array $data) {
        (new Reflection())->hydrate($data, $this);
    }
    
    public function getArrayCopy() {
        return (new Reflection())->extract($this);
    }
    
}
