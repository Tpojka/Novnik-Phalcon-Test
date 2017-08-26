<?php

namespace Frontend\Model;

class Users extends \Phalcon\Mvc\Model
{
    
    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=false)
     */
    public $f_name;
    
    /**
     *
     * @var string
     * @Column(type="string", length=32, nullable=false)
     */
    public $l_name;
    
    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $cc_number;
    
    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $cc_cvv;
    
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test_Db");
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
    
}
