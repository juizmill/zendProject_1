<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * Description of AbstractCoreModelTable
 *
 * @author MW
 */
Abstract class AbstractCoreModelTable {
    //put your code here
    
    protected $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getBy(array $params) {
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        
        if(!$row) {
            throw new RuntimeException('Could not find row');
        }
        
        return $row;
    }
    
    public function save(array $data) {
        
        if(isset($data['id'])) {
            $id = (int) $data['id'];
            
            if(!$this->getBy(['id' => $id])) {
                throw new RuntimeException(sprintf(
                   'Cannot update identifier %d; does not exist',
                   $id
                ));
            }
            
            $this->tableGateway->update($data, ['id' => $id]);
            
            return $this->getBy(['id' => $id]);
        }
        
        $this->tableGateway->insert($data);
        
        return $this->getBy(['id' => $this->tableGateway->getLastInsertValue()]);
        
    }
    
    
    public function delete($id) {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
