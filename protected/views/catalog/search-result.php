<?php
	echo 'Найдено ' . $count . ' товаров';
	foreach ($goods as $good) {
		$this->renderPartial('good_small_view', array(
			'good' => $good,
		));
	}

	$this->widget('CAlexPager', array(
		'pages' => $pages,
	));
//	if (YII_DEBUG)
        echo '<div>время генерации: ' . sprintf('%0.5f', Yii::getLogger()->getExecutionTime()) . ' с.</div>';
	$sql_stats =YII::app()->db->getStats();
//	if (YII_DEBUG)
        echo '<div>'. $sql_stats[0].' запросов к БД, время выполнения запросов - '.sprintf('%0.5f', $sql_stats[1]).' c.</div>';

?>
