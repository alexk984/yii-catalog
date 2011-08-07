<?php

class AttrController extends CAdminController
{

    public $defaultAction = 'admin';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Attr;
        $model->pos = '1';
        $model->type = '1';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Attr'])) {
            $model->attributes = $_POST['Attr'];
            if ($_POST['Attr']['pos'] == '1') {
                $groups = Attr::model()->findAllByAttributes(array(
                                                                  'attr_group_id' => $_POST['Attr']['attr_group_id'],
                                                             ));
                $maxpos = 0;
                foreach ($groups as $group) {
                    if ($group->pos > $maxpos)
                        $maxpos = $group->pos;
                }
                $model->pos = $maxpos + 1;
            }

            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
                if ($model->save())
                    echo 'success';
            return;
        }

        $this->render('create', array(
                                     'model' => $model,
                                ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Attr'])) {
            $model->attributes = $_POST['Attr'];
            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
                if ($model->save())
                    echo 'success';
        }

        $this->render('update', array(
                                     'model' => $model,
                                ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
                $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Attr('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Attr']))
            $model->attributes = $_GET['Attr'];

        $this->render('admin', array(
                                    'model' => $model,
                               ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Attr
     */
    public function loadModel($id)
    {
        $model = Attr::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'attr-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGroupAttr()
    {
        if (isset($_POST['group_id'])) {
            $criteria = new CDbCriteria;
            $criteria->compare('attr_group_id', $_POST['group_id'], true);
            $criteria->order = 'pos';
            $groups = Attr::model()->findAll($criteria);

            foreach ($groups as $group) {
                echo $group->name . '<br/>';
            }
        }
    }

    public function actionUpdateAjax()
    {
        if (!isset($_GET['Attr']['id'])) {
            echo 'error';
            return;
        }
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_GET['Attr']['id'];
            $model = $this->loadModel($id);
            $model->attributes = $_GET['Attr'];
            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
                if ($model->save())
                    echo 'success';
            return;
        }
    }

}
