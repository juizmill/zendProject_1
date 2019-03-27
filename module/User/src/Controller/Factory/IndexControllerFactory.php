<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexControllerFactory
 *
 * @author MW
 */

namespace User\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use User\Form\UserForm;
use Zend\Db\Adapter\Adapter;
use User\Model\UserTable;
use User\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface{
    //put your code here
    public function __invoke(ContainerInterface $container, $requestedName, mixed $options = null): object {
        $adapter = $container->get(Adapter::class);
        
        $userForm = new UserForm($adapter);
        $userTable = $container->get(UserTable::class);
        
        return new IndexController($userForm, $userTable);
    }

}
