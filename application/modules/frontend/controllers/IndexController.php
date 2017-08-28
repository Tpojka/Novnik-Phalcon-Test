<?php

namespace Frontend\Controller;

use App\Service\Pagination;
use Phalcon\Mvc\Controller;
use User\Model\Categories;
use User\Model\Content;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

use Frontend\Model\Users;
use Phalcon\Http\Response;

use Phalcon\Filter;

use Frontend\Forms\UsersForm;
use Frontend\Validators\IndexAjaxAddUser;
// use Frontend\Validators\IndexAjaxAddUser;

/**
 * Class IndexController
 * @package Frontend\Controller
 */

class IndexController extends Controller
{
     private const validPostKeys = [// expectingpost keys; should be done with model metadata attributes
         'f_name' => 'First Name', 
         'l_name' => 'Last Name',
         'cc_number' => 'Credit Card Number', 
         'cc_cvv' => 'Credit Card CVV',
     ];
//     properties are not allowed
//     https://stackoverflow.com/questions/41421368/php-cannot-access-private-property-inside-class#answer-41544525
    
    /**
     * @return mixed|void
     * @throws Exception
     */
    public function indexAction()
    {
        $usersForm = new UsersForm;
        
        $this->view->usersForm = $usersForm->render('csrf');
        
        $this->view->h2Title = 'Secure Payment Form'; // setting page title volt variable
        
        foreach (self::validPostKeys as $k => $v) { // setting form field volt variables
            
            $tempName = "name_".$k;
            $this->view->{$tempName} = $k;
            
            $tempPHolder = "ph_".$k;
            $this->view->{$tempPHolder} = $v;
        }
    }
    
    
    /**
     * Inserts new User model data
     * @param string serialized string of POST data
     * @return bool false|string JSON string of newly inserted model
     */    
    public function ajaxAddUserAction()
    {
        $response = new Response;
        
        if (!$this->request->isAjax() || !$this->request->isPost()) { // redirect non-AJAX or non-POST requests to form page
            
            return $response->redirect();
        }
        
        
        $indexAjaxAddUser = new IndexAjaxAddUser();
        
        $messages = $indexAjaxAddUser->validate($this->request->getPost()); // sanitize and validate POST data
        
        if (count($messages)) {// we don't have valid input post data, get back to form
            
            foreach ($messages as $k => $v) {
                if ($k == 0) {
                    $response->setContent($v);
                } else {
                    $response->appendContent($v);
                }
            }
            
            $response->setStatusCode(400, 'Bad Request'); 
            $response->send();
            
            exit;
        }
        
        $user = new Users(); // Here we create model for new record
        
        $user->f_name = $this->request->getPost('f_name');
        
        $user->l_name = $this->request->getPost('l_name');
        
        $user->cc_number = $this->request->getPost('cc_number');
        
        $user->cc_cvv = $this->request->getPost('cc_cvv');
        
        $savingError = false;
        
        $saved = $user->save();
        
        if ($saved === false) {// DB error
            
            $response->setStatusCode(500, 'Internal Server Error');
            $response->setContent(json_encode('Saving failed.'));
        } else {
            $response->setStatusCode(201, 'Created');
            $response->setContent(json_encode($saved));
        }
        
        $response->send();
        
        $this->view->disable(); // whole method is ajax response so we don't need volt
        
    }
    
    
    /**
     * List of all existing users
     * @return object $users resultSet
     */
    
    public function ourClientsAction()
    {
        $users = Users::find(); // get users from DB
        
        $this->view->ourClients = "Our Clients";
        $this->view->users = $users; // we bind results to volt variables
        
        foreach (self::validPostKeys as $k => $v) { // setting form field volt variables
            
            $tableHeader = $k;
            $this->view->{$tableHeader} = $v; // dynamically set table header 
        }
    }
    
    
    /**
     * Validate POST data
     * @param array $posted array from $_POST
     * @return boolean whether validate passed or failed 
     */
    
    private function validateInput($posted)
    {
        
    }

}
