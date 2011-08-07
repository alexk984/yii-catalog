<?php
if ($_SERVER['HTTP_HOST'] == 'yii-catalog') {
    $yii = dirname(__FILE__) . '/../../yii/framework/YiiBase.php';

    class Yii extends YiiBase
    {
        /**
         * @static
         * @return CWebApplication
         */
        public static function app()
        {
            return parent::app();
        }
    }

    $config = dirname(__FILE__) . '/protected/config/dev.php';
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}
else {
    define('YII_DEBUG', false);
    $yii = dirname(__FILE__) . '/../framework/yii.php';
    $config = dirname(__FILE__) . '/protected/config/production.php';
}

require_once($yii);
Yii::createWebApplication($config)->run();
