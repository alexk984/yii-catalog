<?php

class CAdminController extends Controller
{
    public $layout = 'column2';

    public function accessRules()
    {
        return array(
            array('allow',
                  'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'
                  , 'updateajax', 'featurelist', 'catgroups', 'catgroups2', 'groupattr'),
                  'users' => array('admin'),
            ),
            array('deny', // deny all users
                  'users' => array('*'),
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }


}
