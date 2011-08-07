<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
         'components' => array(
             // переопределяем компонент db
             'db' => array(
                 'connectionString' => 'mysql:host=sql-4.ayola.net;dbname=yiicatalog608',
                 'username' => 'yiicatalog608',
                 'password' => 'spntcj50uq',
                 'emulatePrepare' => true,
                 'charset' => 'utf8',
                 'tablePrefix' => '',
                 'enableProfiling' => true,
                 'enableParamLogging' => true,
                 'schemaCachingDuration' => '360000'
             ),
             'cache' => array(
                 'class' => 'system.caching.CFileCache',
//                    'class' => 'system.caching.CDummyCache',
             ),
         ),
         'params' => array(
             'server' => 1,
         ),
    )
);