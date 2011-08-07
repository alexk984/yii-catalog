<?php
$this->breadcrumbs=array(
	'Управление группами характеристик'=>array('admin'),
	'Изменить группу характеристик',
);

$this->menu=array(
	array('label'=>'Добавить группу характеристик', 'url'=>array('create')),
	array('label'=>'Управление группами характеристик', 'url'=>array('admin')),
);
?>

<h1>Изменить группу характеристик <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>