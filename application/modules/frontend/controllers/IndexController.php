<?php

namespace Frontend\Controller;

use App\Service\Pagination;
use Phalcon\Mvc\Controller;
use User\Model\Categories;
use User\Model\Content;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends Controller
{
     private const validPostKeys = [
         'f_name' => 'First Name', 
         'l_name' => 'Last Name',
         'cc_number' => 'Credit Card Number', 
         'cc_cvv' => 'Credit Card CVV',
     ];
//     https://stackoverflow.com/questions/41421368/php-cannot-access-private-property-inside-class#answer-41544525
    
    public function indexAction()
    {
        $this->view->h2Title = 'Secure Payment Form'; // setting page title volt variable
        
        foreach (self::validPostKeys as $k => $v) { // setting form field volt variables
            
            $tempName = "name_".$k;
            $this->view->{$tempName} = $k;
            
            $tempPHolder = "ph_".$k;
            $this->view->{$tempPHolder} = $v;
        }
    }
    
    public function ajaxAddUserAction()
    {
        if (!$this->request->isAjax()) {
            return $this->response->redirect();
        }
        
        // Set flash message with form's errors
        $this->validate($this->request->post());
    }

}
