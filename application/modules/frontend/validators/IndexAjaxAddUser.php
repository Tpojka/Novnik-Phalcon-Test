<?php
namespace Frontend\Validators;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\CreditCard;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Frontend\Model\Users;

class IndexAjaxAddUser extends Validation
{
    public function initialize()
    {
        $this->add( // first name is not blank
            'f_name',
            new PresenceOf(
                [
                    'message' => "First name is required.\n",
                ]
                )
            );
        
        $this->add( // first last is not blank
            'l_name',
            new PresenceOf(
                [
                    'message' => "Last name is required.\n",
                ]
                )
            );
        
        $this->add( // cc number is not blank
            'cc_number',
            new PresenceOf(
                [
                    'message' => "Credit card number is required.\n",
                ]
                )
            );
        
        $this->add( // cc cvv is not blank
            'cc_cvv',
            new PresenceOf(
                [
                    'message' => "Code is required.\n",
                ]
                )
            );
        
        $this->add(
            'cc_number',
            new CreditCard( // cc number is valid card number
                [
                    'message' => "Valid credit card number is required.\n",
                ]
                )
            );
        
        $this->add( // cc cvv is number
            'cc_cvv',
            new Digit(
                [
                    'message' => "Valid number is required.\n",
                ]
                )
            );
        
        $this->add( // cc cvv is unique number
            'cc_number',
            new Uniqueness( 
                [
                    'message' => "Invalid card number.\n", // don't let know it is registered
                    'model' => new Users,
                ]
                )
            );
    }
}

