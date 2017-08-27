<?php

namespace Frontend\Controller;

use App\Service\Pagination;
use Phalcon\Mvc\Controller;
use User\Model\Categories;
use User\Model\Content;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

use Frontend\Model\Users;
use Phalcon\Http\Response;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\CreditCard;
use Phalcon\Validation\Validator\PresenceOf;


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
        if (!$this->request->isAjax()) { // redirect non-AJAX requests
            return $this->response->redirect();
        }

        $posted = $this->request->getPost();
        
        if (!$this->validateInput($posted)) { // Validator used to check post
            return $this->response->redirect(); // should be set flash message
        }

        $user = new Users();
        
        $user->f_name = trim($posted['f_name']);
        
        $user->l_name = trim($posted['l_name']);
        
        $user->cc_number = trim($posted['cc_number']);
        
        $user->cc_cvv = trim($posted['cc_cvv']);
        
        if ($user->save() === false) {
            $errorMessage = "Saving data failed. Please contact our <a href=\"mailto:admin@novnik.com?Subject=Alert:%20Data%20insert%20failed\" target=\"_top\">administrator</a> to help you with issue.";
        }
        
        $response = new Response;
        
        $response->setStatusCode(200, 'OK');

        $this->view->disable();
        
        $response->setContent(json_encode($errorMessage))->send();
    }
    
    public function ourClientsAction()
    {
        $users = Users::find(); // get users from DB
        
        $this->view->ourClients = "Our Clients";
        $this->view->users = $users;
        
        foreach (self::validPostKeys as $k => $v) { // setting form field volt variables
            
            $tableHeader = $k;
            $this->view->{$tableHeader} = $v;
        }
    }
    
    private function validateInput($posted)
    {
        if (!$this->checkInputKeys($posted)) { // keys are not ones we are expecting
            return false;
        }
        
        $validation = new Validation();
        
        $validation->add(
            'f_name',
            new PresenceOf(
                [
                    'message' => 'First name is required',
                ]
                )
            );
        
        $validation->add(
            'l_name',
            new PresenceOf(
                [
                    'message' => 'Last name is required',
                ]
                )
            );
        
        $validation->add(
            'cc_number',
            new PresenceOf(
                [
                    'message' => 'Credit card number is required.',
                ]
                )
            );
        
        $validation->add(
            'cc_cvv',
            new PresenceOf(
                [
                    'message' => 'Code is required.',
                ]
                )
            );
        
        $validation->add(
            'cc_number',
            new CreditCard(
                [
                    'message' => 'Valid credit card number is required.',
                ]
                )
            );
        
        $validation->add(
            'cc_cvv',
            new Digit(
                [
                    'message' => 'Valid number is required.',
                ]
                )
            );
        
        $messages = $validation->validate($posted);
        
        if (count($messages)) { // some field didn't pass validation
            foreach ($messages as $message) { 
//                 echo $message, '<br>'; // message should be set into flash messages
            }
            
            return false; // no more mister nice guy
        }
    }
    
    private function checkInputKeys($posted)
    {
        $diffKeys = array_diff_key($posted, self::validPostKeys);
        
        if (count($diffKeys)) { // posted keys doesn't belong to DB keys
            
            $diffKeys = [];
            
            return false;
        }
        
        $diffKeys = array_diff_key(self::validPostKeys, $posted);
        
        if (count($diffKeys)) { // posted keys are not sufficient
            
            $diffKeys = [];
            
            return false;
        }
    }

}
