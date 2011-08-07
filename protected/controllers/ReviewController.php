<?php

class ReviewController extends Controller
{

    public $layout = '//layouts/column2';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Review;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Review'])) {
            $model->attributes = $_POST['Review'];
            $model->date = getdate();
            $model->user_id = Yii::app()->user->getId();

            if ($model->save()) {
                echo 'Ваш отзыв успешно отправлен';
                return;
            }
        }

        $this->renderPartial('_form', array(
                                           'model' => $model,
                                      ));
    }

    public function actionUpdate()
    {
        $model = Review::model()->findByAttributes(array(
                                                        'good_id' => $_POST['Review']['good_id'],
                                                        'user_id' => Yii::app()->user->id,
                                                   ));

        $this->performAjaxValidation($model);

        if (isset($_POST['Review'])) {
            $model->attributes = $_POST['Review'];
            if ($model->save()) {
                echo 'Ваш отзыв успешно отправлен';
                return;
            }
        }

        $this->render('_form', array(
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
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Review::model()->findByPk((int)$id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'review-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Show all user reviews for good
     */
    public function actionAllReviews()
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['good_id'])) {
            $time_start = microtime();
            if ($this->beginCache('good-reviews-all' . $_POST['good_id'], array(
                                                                               'dependency' => array(
                                                                                   'class' => 'system.caching.dependencies.CDbCacheDependency',
                                                                                   'sql' => 'SELECT MAX(id) FROM review WHERE good_id=' . $_POST['good_id']
                                                                               ),
                                                                               'duration' => 3600,
                                                                          ))
            ) {


                $good = Good::model()->findByPk($_POST['good_id']);
                foreach ($good->reviews as $review) {
                    $this->renderPartial('review', array(
                                                        'review' => $review,
                                                   ));
                }
                $this->endCache();
            }
            $time_end = microtime();
            if (YII_DEBUG) echo $time_end - $time_start;
            $sql_stats = YII::app()->db->getStats();
            if (YII_DEBUG) echo '<div>' . $sql_stats[0] . ' запросов к БД, время выполнения запросов - ' . $sql_stats[1] . '</div>';

        }
    }

    /**
     * Set mark for the good by user
     * @param $good_id
     * @param $rate mark (1-5)
     */
    public function actionSetMark($good_id, $rate)
    {
        if (Yii::app()->user->isGuest) {
            echo 'you are not registered user';
            return;
        }
        $user = Yii::app()->user->id;
        $rating = Rating::model()->with(array('good', 'good.marksCount'))
                ->findByAttributes(array(
                                        'good_id' => $good_id,
                                        'user_id' => $user,
                                   ));
        if (empty($rating)) {
            if ($rate == 'undefined') {
                return;
            }

            $rating = new Rating;
            $rating->good_id = $good_id;
            $rating->user_id = $user;
            $rating->value = $rate;
            if ($rating->save()) {
                $good = $rating->good;
                $good->rating = round($good->rating + ($rate * 100 - $good->rating) / ($good->marksCount + 1));
                $good->save();
                echo 'success';
            }
            else
                echo 'fail saving';
        } else {
            if ($rating->value != $rate) {
                if ($rate == 'undefined') {
                    echo 'rate deleted';
                    $rating->delete();
                    return;
                }
                $old_mark = $rating->value;
                $rating->value = $rate;
                if ($rating->save()) {
                    $good = $rating->good;
                    $good->rating = round($good->rating + ($rate * 100 - $old_mark * 100) / $good->marksCount);
                    $good->save();
                    echo 'success';
                }
                else
                    echo 'fail saving';
            } else
                echo 'no need to change';
        }
    }

    /**
     * Return good rating
     * @return bool success
     */
    public function actionGetRating()
    {
        $good_id = $_GET['good_id'];

        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT rating FROM  good_rating
			WHERE  good_id = ' . $good_id);
        $mark = $command->queryScalar();

        if ($mark == false)
            return false;
        else {
            return $mark;
        }
    }

}