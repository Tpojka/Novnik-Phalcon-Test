<?php

namespace Frontend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;

class UsersForm extends Form
{
    /**
     * This method returns the default value for field 'csrf'
     */
    public function getCsrf()
    {
//         return $this->security->getToken();
    }
    
    public function initialize()
    {
        // Set the same form as entity
        $this->setEntity($this);
        
        // Add a text element to put a hidden CSRF
        $this->add(
            new Hidden(
                'csrf'
                )
            );
    }
}