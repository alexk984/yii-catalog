<?php

class OrderController extends Controller
{
    /**
     * Add item to shopping card
     */
    public function actionAddToCard()
    {
        if (!isset($_POST['id'])) {
            echo 'fail';
            return;
        }
        $good = Good::model()->findByPk($_POST['id']);
        Yii::app()->shoppingCart->put($good);
        echo 'success';
    }

    /**
     * Set good quantity in shopping card
     */
    public function actionSetGoodQuantity()
    {
        if (!isset($_POST['good_id']) || !isset($_POST['quantity'])) {
            echo 'fail';
            return;
        }
        $good = Good::model()->findByPk($_POST['good_id']);
        Yii::app()->shoppingCart->update($good, $_POST['quantity']);
        echo 'success';
    }

    /**
     * get items count in shopping card
     */
    public function actionGetCartQuantity()
    {
        $count = Yii::app()->shoppingCart->getItemsCount();
        $cost = CAlexHelper::GetMoneyFormat(Yii::app()->shoppingCart->getCost());
        echo $count . ',' . $cost;
    }

    /**
     * Delete item from shopping card
     */
    public function actionDeleteItem()
    {
        if (!isset($_POST['good_id'])) {
            echo 'fail';
            return;
        }
        Yii::app()->shoppingCart->remove($_POST['good_id']);
        echo 'success';
    }

    /**
     * Render shopping card page
     */
    public function actionIndex()
    {
        $this->render('shopping-cart', array(
                                       ));
    }

    /**
     * Render shopping card
     */
    public function actionCartAjax()
    {
        $this->renderPartial('shopping-cart-ajax', array(
                                                   ));
    }
}

?>
