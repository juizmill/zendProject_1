<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace Core\Stdlib;

use Zend\Stdlib\RequestInterface;
/**
 * Description of CurrentUrl
 *
 * @author MW
 */
trait CurrentUrl {
    //put your code here
    
    public function getUrl(RequestInterface $request) {
        $protocol = 'http://';
        
        if($request->getServer('HTTPS') !== null) {
            $protocol = 'https://';
        }
        
        return $protocol.$request->getServer('HTTP_HOST');
    }
}
