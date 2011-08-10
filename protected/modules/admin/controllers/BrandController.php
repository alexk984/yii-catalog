<?php

class BrandController extends CAdminController
{
    public $defaultAction = 'index';
    public $layout = 'column1';

    public function actionIndex()
    {
        $model = new Brand('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Brand']))
            $model->attributes = $_GET['Brand'];

        $edit_model = new Brand;

        $this->render('index', array(
                                    'model' => $model, 'edit_model' => $edit_model
                               ));
    }

    public function actionAjax()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Brand']['id']) && !empty($_POST['Brand']['id'])) {
                $model = $this->loadModel($_POST['Brand']['id']);
                $model->attributes = $_POST['Brand'];

                if ($model->validate()) {
                    if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT || $_POST['Brand']['id'] > 60) {
                        if ($model->save()) {
                            $this->setNotice('Запись успешно обновлена');
                            $model = new Brand();
                        }
                        else
                            $this->setNotice('Fail');
                    } else
                        $this->setNotice('You cant edit data on this site');
                }
            } else {
                $model = new Brand();
                $model->attributes = $_POST['Brand'];

                if ($model->validate()) {
                    if ($model->save()) {
                        $this->setNotice('Запись успешно добавлена');
                        $model = new Brand();
                    }
                    else
                        $this->setNotice('Fail');
                }
            }
            $this->renderPartial('ajaxForm', array(
                                                  'model' => $model,
                                             ));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT || $id > 60)
                $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Brand
     */
    public function loadModel($id)
    {
        $model = Brand::model()->findByPk((int)$id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'brand-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
