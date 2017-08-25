<?php

namespace Frontend\Controller;

use App\Service\Pagination;
use Phalcon\Mvc\Controller;
use User\Model\Categories;
use User\Model\Content;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

use Phalcon\Http\Request;

class IndexController extends Controller
{
    public function indexAction()
    {
        //empty
        
        $this->view->h2Title = 'Secure Payment Form';
        $this->view->firstName = 'First Name';
        $this->view->lastName = 'Last Name';
        $this->view->creditCardNumber = 'Credit Card Number';
        $this->view->creditCardCvv = 'Credit Card CVV';
    }
    
    public function addCreditCardAction()
    {
        $request = new Request();
        // Check if request has made with POST
        if (!$request->isPost()) {
            return $this->response->redirect('default')->send();
        }
            // Access POST data
        $firstName = $this->request->getPost('firstName');
        $lastName = $this->request->getPost('lastName');
        
        var_dump($firstName);
    }

}
