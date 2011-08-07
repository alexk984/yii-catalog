<?php
$this->breadcrumbs=array(
	'Управление категориями товаров'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить категорию',
);

$this->menu=array(
	array('label'=>'Добавить категорию', 'url'=>array('create')),
	array('label'=>'Управление категориями товаров', 'url'=>array('admin')),
);
?>

<h1>Изменить категорию <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>