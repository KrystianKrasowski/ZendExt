<?php

namespace ZendExt\Plugin;

use Zend\Session\Container;

class FormMessenger
{
    const MESSENGER_NAMESPACE = 'form_messenger';

    /**
     * @var Container
     */
    private $sessionContainer;

    public function __construct()
    {
        $this->sessionContainer = new Container(self::MESSENGER_NAMESPACE);
    }

    public function getData()
    {
        return $this->getField('data');
    }


    private function getField($field, $default = array())
    {
        $data = $this->sessionContainer->$field;

        if (!$data) {
            return $default;
        }

        $this->sessionContainer->$field = array();

        return $data;
    }

    public function setData(array $data)
    {
        $this->setField($data, 'data');
    }

    private function setField(array $data, $field)
    {
        $this->sessionContainer->$field = $data;
    }

    public function getMessages()
    {
        return $this->getField('messages');
    }

    public function setMessages(array $messages)
    {
        $this->setField($messages, 'messages');
    }
}