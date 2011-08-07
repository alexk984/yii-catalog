<?php
	$id = 'feature[' . $attr->id.']';
	echo CHtml::radioButtonList($id, '2', array('1'=>'есть', '0'=>'нет', '2'=>'неважно'), array(
		'onchange' => 'SendSearchReg()',
	));
?>
