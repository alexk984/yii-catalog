<?php

class CAdminController extends Controller
{
    public $layout = 'column2';

    public function accessRules()
    {
        return array(
            array('allow',
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

    public function setNotice($message)
    {
        return Yii::app()->user->setFlash('notice', $message);
    }

    public function setError($message)
    {
        return Yii::app()->user->setFlash('error', $message);
    }
}
