<?php
$this->breadcrumbs=array(
	'Управление группами характеристик'=>array('admin'),
	'Добавить группу характеристик',
);

$this->menu=array(
	array('label'=>'Управление группами характеристик', 'url'=>array('admin')),
);
?>

<h1>Добавить группу характеристик</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>