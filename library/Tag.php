<?php

namespace App;

use User\Model\Categories;
use User\Model\User;

/**
 * Class Tag
 * @package App
 */
class Tag extends \Phalcon\Tag
{
    /**
     * Get url by route name and parameters
     *
     * @param $routename
     * @param array $parameters
     * @return string
     */
    public static function url($routename, array $parameters = null)
    {
        if (is_null($parameters)) {
            return self::getUrlService()->get(array(
                'for' => $routename
            ));
        }

        return self::getUrlService()->get(array_merge(
            array(
                'for' => $routename
            ),
            $parameters
        ));
    }

    /**
     * Get url by parameters
     *
     * @param $module
     * @param string $controller
     * @param string $action
     * @return string
     */
    public static function u($module, $controller = null, $action = null)
    {
        /**
         * @todo rewrite with routers
         */
        if ($controller) {
            if ($action) {
                return '/' . $module . '/' . $controller . '/' . $action . '/';
            }

            return '/' . $module . '/' . $controller . '/';
        }

        return self::getUrlService()->get(array(
            'for' => $module
        ));
    }

    public function getCategories(){
        return Categories::find();
    }
    public function getCategoryIdViaUrl($category){
        return Categories::findFirst("url_id = '$category'");
    }

    /**
     * Formats a phonenumber for frontend
     * @param $phone
     * @param $hide_last_4_digits  Hide the last 4 digits
     * @return mixed|string
     */
    public function formatPhonenumber($phone,$hide_last_4_digits){

        if(!empty($phone) && $phone !== null){

            if($hide_last_4_digits){
                $phone = substr($phone, 0, -3) . 'xxxx';;
            }

            $phone = substr_replace($phone,") ",3,0);

            $phone = substr_replace($phone," - ",9,0);

            $phone = "(".$phone;

            return $phone;


        }
    }
}
