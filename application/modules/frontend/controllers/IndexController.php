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

/**
 * Class IndexController
 * @package Frontend\Controller
 */

class IndexController extends Controller
{
     private const validPostKeys = [// expecting post keys; should be done with model metadata attributes
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
        if (!$this->request->isAjax() || !$this->request->isPost()) { // redirect non-AJAX or non-POST requests to form page
            
            return $this->response->redirect();
            
            exit;
        }
        
        $postedData = []; 
        
        foreach (self::validPostKeys as $k => $v) { // forming array of filtered / sanitized data
            switch ($k) {
                case 'f_name':
                case 'l_name':
                    $postedData[$k] = $this->request->getPost($k, ["striptags", "alphanum", "trim", "string"]);
                    break;
                case 'cc_number':
                case 'cc_cvv':
                    $postedData[$k] = $this->request->getPost($k, ["striptags", "alphanum", "trim", "int"]);
            }
        }
        
        $validatedData = $this->validateFilteredData($postedData); 
        
        if (!$validatedData) { // validation failed In this case we are using 
            
            $this->response->setStatusCode(400, 'Bad Request'); // we have already set content (if any) in validate method 
            $this->response->send();
            exit;
        } else {
            $validatedData = $postedData;
        }
        
        $user = new Users(); // Here we create model for new record
        
        foreach ($validatedData as $k => $v) {
            $user->{$k} = $v;
        }
        
        
        try {
            $saved = $user->save();
        } catch (\Exception $e) {
            $dbError = $e->getMessage();
        }
        
        $response = new Response;
        
        if ($saved === false) {// DB error
            
            $response->setStatusCode(500, 'Internal Server Error');
            $response->setContent($dbError); // @todo tpojka just for dev, not for production
        } else {
            $response->setStatusCode(201, 'Created');
            $response->setContent('User created');
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
    
    private function filterData($postedData) // @todo for some reason this doesn't work https://docs.phalconphp.com/en/3.2/api/Phalcon_Filter
    {
        $filter = new Filter();
                
        foreach ($postedData as $k => $field) {
            
            switch ($k) {
                case 'f_name':
                case 'l_name':
                    $filter->sanitize($field, ['trim', 'alphanum', 'striptags', 'string']);
                    break;
                case 'cc_number':
                case 'cc_cvv':
                    $filter->sanitize($field, ['trim', 'alphanum', 'striptags', 'int']);
                    break;
            }
        }
        
        return $postedData;
    }
    
    
    /**
     * Validate already filtered data from POST
     * @param array 
     * @return boolean whether validate passed or failed
     */
    
    private function validateFilteredData($filteredData)
    {
        $validate = false; // always set init to be bullet/dummy proof
        
        $indexAjaxAddUser = new IndexAjaxAddUser();
        
        $messages = $indexAjaxAddUser->validate($filteredData); // sanitize and validate POST data
        
        if (count($messages)) {// we don't have valid input post data, get back to form
            
            foreach ($messages as $k => $v) {
                if ($k == 0) {
                    $this->response->setContent($v);
                } else {
                    $this->response->appendContent($v);
                }
            }
        } else {
            
            $validate = true;
        }
        
        return $validate;
    }

}
