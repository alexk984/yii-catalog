<?php

class GroupController extends CAdminController
{

    public $defaultAction = 'admin';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new AttrGroup;
        $model->pos = '1';

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['cat_id']) && isset($_GET['name'])) {

                $alreadyExist = AttrGroup::model()->findByAttributes(array(
                                                                          'name' => $_GET['name'],
                                                                          'category_id' => $_GET['cat_id'],
                                                                     ));

                if (empty($alreadyExist)) {
                    $model->name = $_GET['name'];
                    $model->category_id = $_GET['cat_id'];
                    if (isset($_GET['pos'])) {
                        $model->pos = $_GET['pos'];
                    } else {
                        $groups = AttrGroup::model()->findAllByAttributes(array(
                                                                               'category_id' => $_GET['cat_id'],
                                                                          ));
                        $maxpos = 1;
                        foreach ($groups as $group) {
                            if ($group->pos > $maxpos)
                                $maxpos = $group->pos;
                        }
                        $model->pos = $maxpos + 1;
                    }

                    if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
                        if ($model->save())
                            echo 'success';
                } else {
                    echo 'group already exist';
                }
            }
            return;
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $this->render('create', array(
                                     'model' => $model,
                                ));
    }

    public function actionCatGroups()
    {
        if (isset($_POST['cat_id'])) {
            $groups = AttrGroup::model()->findAll(array(
                                                       'condition' => 'category_id=' . $_POST['cat_id'],
                                                       'order' => 'pos'));

            foreach ($groups as $group) {
                echo $group->pos . " " . $group->name . '<br/>';
            }
        }
    }

    public function actionCatGroups2()
    {
        if (isset($_POST['cat_id'])) {
            $criteria = new CDbCriteria;
            $criteria->compare('category_id', $_POST['cat_id'], true);
            $criteria->order = 'pos';
            $groups = AttrGroup::model()->findAll($criteria);

            foreach ($groups as $group) {
                echo '<option value="' . $group->id . '">' . $group->name . '</option>';
            }
        }
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

        $this->render('update', array(
                                     'model' => $model,
                                ));
    }

    public function actionUpdateAjax()
    {
        if (!isset($_GET['id'])) {
            echo 'error';
            return;
        }
        $id = $_GET['id'];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['cat_id']) && isset($_GET['name']) && isset($_GET['pos'])) {

                $model->name = $_GET['name'];
                $model->category_id = $_GET['cat_id'];
                $model->pos = $_GET['pos'];

                if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
                    if ($model->save())
                        echo 'success';
            }
            return;
        }
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
        $model = new AttrGroup('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['AttrGroup']))
            $model->attributes = $_GET['AttrGroup'];

        $this->render('admin', array(
                                    'model' => $model,
                               ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = AttrGroup::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'attr-group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
