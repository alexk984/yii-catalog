<?php

return CMap::mergeArray(
        require(dirname(__FILE__) . '/main.php'), array(
        'components' => array(
                'fixture' => array(
                        'class' => 'system.test.CDbFixtureManager',
                ),
                'db' => array(
                        'connectionString' => 'mysql:host=localhost;dbname=shop-test',
                        'emulatePrepare' => true,
                        'username' => 'root',
                        'password' => '',
                        'charset' => 'utf8',
                        'tablePrefix' => '',
                        'enableProfiling' => true,
                        'enableParamLogging' => true,
                ),
        ),
        )
);
