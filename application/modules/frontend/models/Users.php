<?php

namespace Frontend\Model;

use Phalcon\Mvc\Model;

use Phalcon\Db\Column;
use Phalcon\Mvc\Model\MetaData;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\CreditCard;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

class Users extends Model
{
    
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", length=19, nullable=false)
     */
    public $cc_number;
    
    /**
     * @Column(type="string", length=32, nullable=false)
     */
    public $f_name;
    
    /**
     * @Column(type="string", length=32, nullable=false)
     */
    public $l_name;
    
    /**
     * @Column(type="integer", length=4, nullable=false)
     */
    public $cc_cvv;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
//         $this->setSchema("test_Db");
         $this->setSource("user");
    }
    
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }
    
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    
    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    public function metaData()
    {
        return array(
            // Every column in the mapped table
            MetaData::MODELS_ATTRIBUTES => [
                'f_name',
                'l_name',
                'cc_number',
                'cc_cvv',
            ],
            
            // Every column part of the primary key
            MetaData::MODELS_PRIMARY_KEY => [
                'cc_number',
            ],
            
            // Every column that isn't part of the primary key
            MetaData::MODELS_NON_PRIMARY_KEY => [
                'f_name',
                'l_name',
                'cc_cvv',
            ],
            
            // Every column that doesn't allows null values
            MetaData::MODELS_NOT_NULL => [
                'f_name',
                'l_name',
                'cc_number',
                'cc_cvv',
            ],
            
            // Every column and their data types
            MetaData::MODELS_DATA_TYPES => [
                'cc_number'   => Column::TYPE_INTEGER,
                'f_name' => Column::TYPE_VARCHAR,
                'l_name' => Column::TYPE_VARCHAR,
                'cc_cvv' => Column::TYPE_INTEGER,
            ],
            
            // The columns that have numeric data types
            MetaData::MODELS_DATA_TYPES_NUMERIC => [
                'cc_number'   => true,
                'cc_cvv' => true,
            ],
            
            // The identity column, use boolean false if the model doesn't have
            // an identity column
            MetaData::MODELS_IDENTITY_COLUMN => 'cc_number',
            
            // How every column must be bound/casted
            MetaData::MODELS_DATA_TYPES_BIND => [
                'cc_number'   => Column::BIND_PARAM_INT,
                'f_name' => Column::BIND_PARAM_STR,
                'l_name' => Column::BIND_PARAM_STR,
                'cc_cvv' => Column::BIND_PARAM_INT,
            ],
            
            // Fields that must be ignored from INSERT SQL statements
            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [
//                 'year' => true,
            ],
            
            // Fields that must be ignored from UPDATE SQL statements
            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [
//                 'year' => true,
            ],
            
            // Default values for columns
            MetaData::MODELS_DEFAULT_VALUES => [
//                 'year' => '2015',
            ],
            
            // Fields that allow empty strings
            MetaData::MODELS_EMPTY_STRING_VALUES => [
                'f_name' => false,
                'l_name' => false,
                'cc_number' => false,
                'cc_cvv' => false,
            ],
        );
    }
    
    /**
     * Making validation of passed data
     *
     * @param mixed $parameters
     * @return boolean|array
     */
    public function validation()
    {
        $validator = new Validation();
        
        $validator->add( // first name is not blank
            'f_name',
            new PresenceOf(
                [
                    'message' => 'First name is required',
                ]
                )
            );
        
        $validator->add( // first last is not blank
            'l_name',
            new PresenceOf(
                [
                    'message' => 'Last name is required',
                ]
                )
            );
        
        $validator->add( // cc number is not blank
            'cc_number',
            new PresenceOf(
                [
                    'message' => 'Credit card number is required.',
                ]
                )
            );
        
        $validator->add( // cc cvv is not blank
            'cc_cvv',
            new PresenceOf(
                [
                    'message' => 'Code is required.',
                ]
                )
            );
        
        $validator->add(
            'cc_number',
            new CreditCard( // cc number is valid card number
                [
                    'message' => 'Valid credit card number is required.',
                ]
                )
            );
        
        $validator->add( // cc cvv is number
            'cc_cvv',
            new Digit(
                [
                    'message' => 'Valid number is required.',
                ]
                )
            );
        
        $validator->add( // cc cvv is unique number
            'cc_number',
            new Uniqueness(
                [
                    'message' => 'Invalid card number.', // don't let know it is registered
                    'model' => $this,
                ]
                )
            );
        
        return $this->validate($validator); // Validate data
    }
    
}
