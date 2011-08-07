<?php
$this->breadcrumbs=array(
	'Управление Брэндами'=>array('admin'),
	'Изменить брэнд',
);

$this->menu=array(
	array('label'=>'Добавить брэнд', 'url'=>array('create')),
	array('label'=>'Управление Брэндами', 'url'=>array('admin')),
);
?>

<h1>Изменить брэнд <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>