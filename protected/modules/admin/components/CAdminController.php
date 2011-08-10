<?php

class CAdminController extends Controller
{
    public $layout = 'column2';

    public function accessRules()
    {
        return array(
            array('allow',
                  'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'
                  , 'updateajax', 'featurelist', 'catgroups', 'catgroups2', 'groupattr', 'ajax'),
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

    // флеш-нотис пользователю
    public function setNotice($message)
    {
        return Yii::app()->user->setFlash('notice', $message);
    }

    // флеш-ошибка пользователю
    public function setError($message)
    {
        return Yii::app()->user->setFlash('error', $message);
    }
}
