<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Model\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use User\Model\UserTable;

/**
 * Description of UserTableFactory
 *
 * @author MW
 */
class UserTableFactory implements FactoryInterface{
    //put your code here
    
    
    public function __invoke(ContainerInterface $container, $requestedName, mixed $options = null): object {
        $adapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User());
        
        $tableGateway = new TableGateway('users', $adapter, null, $resultSetPrototype);
        
        return new UserTable($tableGateway);
    }

}
