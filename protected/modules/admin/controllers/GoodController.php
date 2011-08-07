<?php

class GoodController extends CAdminController
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
                                   'model' => $this->loadModel($id),
                              ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Good;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Good'])) {
            $model->attributes = $_POST['Good'];
            $model->date = date("Y-m-d");
            //echo $model->date;
            $i = 1;
            foreach ($_POST['Good']['image'] as $image) {
                $model->image [] = CUploadedFile::getInstance($model, 'image[' . $i . ']');
                $i++;
            }

            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
            if ($model->save()) {
                $model->refresh();
                $model->SaveImages();
                $model->SaveFeatures($_POST['Good']['feature']);
                $this->redirect(array('view', 'id' => $model->id));
                return;
            }
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

        if (isset($_POST['Good'])) {
            $model->attributes = $_POST['Good'];
            $i = 1;
            foreach ($_POST['Good']['image'] as $image) {
                $model->image [] = CUploadedFile::getInstance($model, 'image[' . $i . ']');
                $i++;
            }
            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
            if ($model->save()) {

                //delete images if needed
                if (isset($_POST['Good']['updatedimage']))
                    foreach ($_POST['Good']['updatedimage'] as $imageId => $image) {
                        if ($image == 1) {
                            GoodImage::model()->findByPk($imageId)->delete();
                        }
                    }
                $model->SaveImages();
                $model->SaveFeatures($_POST['Good']['feature']);

                $this->redirect(array('view', 'id' => $model->id));
            }
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

            $images = GoodImage::model()->findAllByAttributes(array('good_id' => $id));
            if (isset($images))
                foreach ($images as $image) {
                    $image->delete();
                }
            if (Yii::app()->params['server'] == CAlexHelper::DEVELOPMENT)
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionFeatureList()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['id']) && isset($_POST['cat_id'])) {
                if ($_POST['id'] != '0') {
                    $model = $this->loadModel($_POST['id']);
                    $model->category_id = $_POST['cat_id'];
                    $this->renderPartial('features', array(
                                                          'model' => $model,
                                                     ));
                } else {
                    $model = new Good;
                    $model->category_id = $_POST['cat_id'];
                    $this->renderPartial('features', array(
                                                          'model' => $model,
                                                     ));
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Good');
        $this->render('index', array(
                                    'dataProvider' => $dataProvider,
                               ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Good('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Good']))
            $model->attributes = $_GET['Good'];

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
        $model = Good::model()->findByPk((int)$id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'good-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
