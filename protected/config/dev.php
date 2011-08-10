<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
         'components' => array(
             // переопределяем компонент db
             'cache' => array(
					'class' => 'system.caching.CMemCache',
                    'servers' => array(
                        array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 60),
                    ),
//                 'class' => 'system.caching.CDummyCache',
             ),
         ),
         'params' => array(
             'server' => 2,
         ),
    )
);