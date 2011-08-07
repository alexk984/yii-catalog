<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список товаров', 'url'=>array('index')),
	array('label'=>'Добавить товар', 'url'=>array('create')),
	array('label'=>'Посмотреть товар', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление товарами', 'url'=>array('admin')),
);
?>

<h1>Изменить товар <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>