<?php
/**
 * @author Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace Frontend;

class Module
{
    public function registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            'Frontend\Controller' => APPLICATION_PATH . '/modules/frontend/controllers/',
            'Frontend\Model' => APPLICATION_PATH . '/modules/frontend/models/',
//             'Frontend\Forms' => APPLICATION_PATH . '/modules/frontend/forms/',
            'Frontend\Validators' => APPLICATION_PATH . '/modules/frontend/validators/',
        ));
        $loader->register();
    }

    public function registerServices($di)
    {
        $dispatcher = $di->get('dispatcher');
        $dispatcher->setDefaultNamespace('Frontend\Controller');

        /**
         * @var $view \Phalcon\Mvc\View
         */
        $view = $di->get('view');
        $view->setLayout('index');
        $view->setViewsDir(APPLICATION_PATH . '/modules/frontend/views/');
        $view->setLayoutsDir('../../common/layouts/');
        $view->setPartialsDir('../../common/partials/');

        $di->set('view', $view);
    }
}
