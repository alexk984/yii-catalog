<?php

class CategoryController extends CAdminController
{
    public $CQtreeGreedView = array(
        'modelClassName' => 'Category', //название класса
        'adminAction' => 'admin' //action, где выводится QTreeGridView.
    );

    public $defaultAction = 'admin';

    public function accessRules()
    {
        return array(
            array('allow',
                  'actions' => array('create', 'update', 'admin', 'delete', 'moveNode', 'makeRoot'),
                  'users' => array('admin'),
            ),
            array('deny', // deny all users
                  'users' => array('*'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'create' => 'ext.QTreeGridView.actions.Create',
            'update' => 'ext.QTreeGridView.actions.Update',
            'delete' => 'ext.QTreeGridView.actions.Delete',
            'moveNode' => 'ext.QTreeGridView.actions.MoveNode',
            'makeRoot' => 'ext.QTreeGridView.actions.MakeRoot',
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Category;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
            if (Yii::app()->request->isAjaxRequest) {
                if ($_POST['Category']['parent_id'] == '0') {
                    $model = new Category();
                    $model->name = $_POST['Category']['name'];
                    $model->alias = $_POST['Category']['alias'];

                    if ($model->saveNode())
                        echo 'success';
                } else {
                    $parent = $this->loadModel($_POST['Category']['parent_id']);
                    $model = new Category();
                    $model->name = $_POST['Category']['name'];
                    $model->alias = $_POST['Category']['alias'];

                    if ($parent->append($model)) {
                        $model->refresh();
                        echo 'success';
                    }
                }
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

        if ($model->getParent() === null)
            $model->parentId = null;
        else
            $model->parentId = $model->getParent()->id;
        
        $this->render('update', array(
                                     'model' => $model,
                                ));
    }

    public function actionUpdateAjax()
    {
        if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
            if (Yii::app()->request->isAjaxRequest) {
                $model = $this->loadModel($_POST['Category']['id']);
                if ($_POST['Category']['parent_id'] == $model->parent()->id) {
                    $model->name = $_POST['Category']['name'];
                    $model->alias = $_POST['Category']['alias'];

                    if ($model->saveNode())
                        echo 'success updated';
                    else
                        echo 'error while updating';
                } else {
                    $model->deleteNode();
                    $model->refresh();
                    $parent = $this->loadModel($_POST['Category']['parent_id']);

                    if ($parent->append($model)) {
                        $model->refresh();
                        echo 'success moved';
                    }
                    else
                        echo 'error while moving';

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
                $this->loadModel($id)->tree->delete();

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
        $model = new Category('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Category']))
            $model->attributes = $_GET['Category'];

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
        $model = Category::model()->findByPk((int)$id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
