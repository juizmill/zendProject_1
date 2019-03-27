<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractCoreMail
 *
 * @author MW
 */

namespace Core\Mail;

use Zend\View\View;
use Zend\Stdlib\Message;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\Mail\Transport\Smtp as SmtTransport;


Abstract class AbstractCoreMail {
    
    protected $transport;
    protected $view;
    protected $body;
    protected $message;
    protected $subject;
    protected $to;
    protected $replyTo;
    protected $data;
    protected $page;
    protected $cc;
    
    
    
    public function __construct(SmtTransport $transport, View $view, $page) {
        $this->transport = $transport;
        $this->view = $view;
        $this->page = $page;
    }
    
       

    function setTransport($transport) {
        $this->transport = $transport;
        
        return $this;
    }

    function setView($view) {
        $this->view = $view;
    }

    function setBody($body) {
        $this->body = $body;
        
        return $this;
    }

    function setMessage($message) {
        $this->message = $message;
        
        return $this;
    }

    function setSubject($subject) {
        $this->subject = $subject;
        
        return $this;
    }

    function setTo($to) {
        $this->to = $to;
        
        return $this;
    }

    function setReplyTo($replyTo) {
        $this->replyTo = $replyTo;
        
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        
        return $this;
    }

    function setPage($page) {
        $this->page = $page;
        
        return $this;
    }

    function setCc($cc) {
        $this->cc = $cc;
        
        return $this;
    }
    
    //Classe abstrata para renderizar view
    abstract public function renderView($page, array $data);


    public function prepare() {
        
        $html = new MimePart($this->renderView($this->page, $this->data));
        $html->type = 'text/html';
        
        $body = new MimeMessage();
        $body->setParts([$html]);
        $this->body = $body;
        
        $config = $this->transport->getOptions()->toArray();
        
        $this->message = new Message();
        $this->message->addFrom($config['connection_config']['from'])
                ->addTo($this->to)
                ->setSubject($this->subject)
                ->setBody($this->body);
        
        if($this->cc) {
            $this->message->addcc($this->cc);
        }
        
        if($this->replayTo) {
            $this->message->addcc($this->replyTo);
        }
        
        return $this;
        
    }
    
    public function send() {
        $this->transport->send($this->message);
    }


    
}
