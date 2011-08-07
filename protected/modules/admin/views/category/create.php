<?php
$this->breadcrumbs=array(
	'Управление категориями товаров'=>array('admin'),
	'Добавить категорию',
);

$this->menu=array(
	array('label'=>'Управление категориями товаров', 'url'=>array('admin')),
);
?>

<h1>Добавить категорию</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>