<?php

/**
 * Retrieving instances of user's model
 * 
 * 
 */

namespace Frontend\Model;

use Phalcon\Mvc\Model;

class Users extends Model
{
    /**
     * @property f_name
     *
     */
    
    public $f_name;
    
    /**
     * @property l_name
     *
     */
    
    public $l_name;
    
    /**
     * @property cc_number
     *
     */
    
    public $cc_number;
    
    /**
     * @property cc_cvv
     *
     */
    
    public $cc_cvv;
    
    /**
     * @intial class invoked once at start of request
     * 
     * Here we set table name which is set to singular now by DB scheme
     *
     */
    
    public function initialize()
    {
        $this->setSource('user');
    }
    
    public function onConstruct()
    {
        //
    }
    
    /**
     * @method for getting property f_name
     *
     * @return string
     */
    
    public function getFName()
    {
        return $this->f_name;
    }
    
    
    /**
     * @method for setting property f_name
     * 
     * @param string
     * 
     * @return void
     */
    
    public function setFName($fName)
    {
        $this->f_name = $fName;
    }
    
    
    /**
     * @method for getting property l_name
     *
     * @return string
     */
    
    public function getLName()
    {
        return $this->l_name;
    }
    
    
    /**
     * @method for setting property l_name
     *
     * @param string
     *
     * @return void
     */
    
    public function setLName($lName)
    {
        $this->l_name = $lName;
    }
    
    
    /**
     * @method for getting property cc_number
     *
     * @return int of constraint up to {19}
     */
    
    public function getCcNumber()
    {
        return $this->cc_number;
    }
    
    
    /**
     * @method for setting property cc_number
     *
     * @param int of constraint up to {19}
     *
     * @return void
     */
    
    public function setCcNumber($ccNumber)
    {
        $this->cc_number = $ccNumber;
    }
    
    
    /**
     * @method for getting property cc_cvv
     *
     * @return int of constraint up to {4}
     */
    
    public function getCcCvv()
    {
        return $this->cc_cvv;
    }
    
    
    /**
     * @method for setting property cc_cvv
     *
     * @param int of constraint up to {4}
     *
     * @return void
     */
    
    public function setCcCvv($ccCvv)
    {
        $this->cc_cvv = $ccCvv;
    }
}