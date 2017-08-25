<?php

namespace App\Service;

use Phalcon\Db\RawValue;
use Phalcony\Validator\Exception;
use User\Model\User;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

/**
 * Class Auth
 * @package App\Service
 */
class Pagination extends \Phalcon\Mvc\User\Component
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
    public function get_pagination($current_page,$limit,$model){

        $paginator = new PaginatorModel(
            [
                "data"  => $model,
                "limit" => $limit,
                "page"  => $current_page,
            ]
        );

        // Get the paginated results
        return $paginator->getPaginate();

    }


}
