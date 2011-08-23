<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="loader"></div>
<?php
        ?>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?>
            <div class="shopping-cart">
                <ul>
                    <li>Товаров: <span id="cart-quantity">0</span></li>
                    <li>На сумму: <span id="cart-price">0</span> руб.</li>
                    <li><?php echo CHtml::link('Перейти в корзину', $this->createUrl('/order/index')); ?></li>
                </ul>
            </div>
            <div class="fix"></div>
<?php
                        $cs = Yii::app()->getClientScript();
            $cs->registerCoreScript('jquery');
            $cs->registerScriptFile('/js/shopping-cart.js');
            $cs->registerScript("cartCountStart", "UpdateShoppingCart();");
            $cs->registerCssFile('/css/jquery.loading.css');
            $cs->registerScript('ajax-loading-icon', '$("#loader").ajaxStart(function(){
   $(this).show();
});
$("#loader").ajaxStop(function(){
   $(this).hide();
});');
            ?>
        </div>
    </div>
    <!-- header -->

    <div id="mainmenu">
<?php
                        $this->widget('zii.widgets.CMenu', array(
                                                                'items' => array(
                                                                    array('label' => 'Каталог', 'url' => array('/catalog/')),
                                                                    array('label' => 'Обо мне', 'url' => array('/pages/contacts')),
                                                                    array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'visible' => Yii::app()->user->isGuest),
                                                                    array('url' => Yii::app()->getModule('user')->registrationUrl, 'label' => Yii::app()->getModule('user')->t("Register"), 'visible' => Yii::app()->user->isGuest),
                                                                    array('url' => Yii::app()->getModule('user')->profileUrl, 'label' => Yii::app()->getModule('user')->t("Profile"), 'visible' => !Yii::app()->user->isGuest),
                                                                    array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout") . ' (' . Yii::app()->user->name . ')', 'visible' => !Yii::app()->user->isGuest),
                                                                    array('url' => array('/admin/'), 'label' => 'Admin Panel', 'visible' => Yii::app()->getModule('user')->isAdmin()),
                                                                ),
                                                           ));
    ?>
    </div>
    <!-- mainmenu -->

<?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                                                                       'links' => $this->breadcrumbs,
                                                                  ));
?><!-- breadcrumbs -->

    <?php echo $content; ?>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by Kireev Alex.<br/>
        <?php echo Yii::powered(); ?>
        <div>
<?php
                            $this->widget('PerformanceStatisticWidget', array(
                                                                             'memory' => false,
                                                                        ));
    ?>

        </div>
        <div>Вы можете войти в панель администрирования (admin:admin)</div>
    </div>
    <!-- footer -->

</div>
<!-- page -->

</body>
</html>