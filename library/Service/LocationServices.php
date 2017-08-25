<?php

namespace App\Service;

use Phalcon\Db\RawValue;
use Phalcony\Validator\Exception;
use User\Model\GeodataUsstates;
use User\Model\User;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

/**
 * Class Auth
 * @package App\Service
 */
class LocationServices extends \Phalcon\Mvc\User\Component
{
    /**
     * Class property for cache getting of User
     *
     * @var User|bool|null
     */
    private $current_page;

    /**
     * @param $current_page
     * @param $limit
     * @param $model
     * @return mixed
     */
    public function getStates(){

        return GeodataUsstates::find();

    }
    public function getStateViaCode($statecode){
        return GeodataUsstates::findFirst("statecode = '$statecode'");
    }
    public function getStateViaUrl($state_url){
        return GeodataUsstates::findFirst("url_id = '$state_url'");
    }
    public function getCitiesViaSate($state){

    }

    /** User Location Services */
    public function getIpLocation($ip){
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        return $details;
    }


}
