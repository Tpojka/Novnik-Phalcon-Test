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
        $this->setFilters('f_name', ['trim', 'striptags', 'string']); // Sanitize data
        $this->setFilters('l_name', ['trim', 'striptags', 'string']);
        $this->setFilters('cc_number', ['trim', 'striptags', 'int']);
        $this->setFilters('cc_cvv', ['trim', 'striptags', 'int']);
         
        
        $this->add( // first name is not blank
            'f_name',
            new PresenceOf(
                [
                    'message' => 'First name is required',
                ]
                )
            );
        
        $this->add( // first last is not blank
            'l_name',
            new PresenceOf(
                [
                    'message' => 'Last name is required',
                ]
                )
            );
        
        $this->add( // cc number is not blank
            'cc_number',
            new PresenceOf(
                [
                    'message' => 'Credit card number is required.',
                ]
                )
            );
        
        $this->add( // cc cvv is not blank
            'cc_cvv',
            new PresenceOf(
                [
                    'message' => 'Code is required.',
                ]
                )
            );
        
        $this->add(
            'cc_number',
            new CreditCard( // cc number is valid card number
                [
                    'message' => 'Valid credit card number is required.',
                ]
                )
            );
        
        $this->add( // cc cvv is number
            'cc_cvv',
            new Digit(
                [
                    'message' => 'Valid number is required.',
                ]
                )
            );
        
        $this->add( // cc cvv is unique number
            'cc_number',
            new Uniqueness( 
                [
                    'message' => 'Invalid card number.', // don't let know it is registered
                    'model' => new Users,
                ]
                )
            );
    }
}

