<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;

$form = new Form();

$form->add(
            new Text(
                'firstName'
            )
        );
        
        $form->add(
            new Text(
                'lastName'
            )
        );
        
        $form->add(
            new Text(
                'creditCardNumber'
            )
        );
        
        $form->add(
            new Text(
                'creditCardCvv'
            )
        );
