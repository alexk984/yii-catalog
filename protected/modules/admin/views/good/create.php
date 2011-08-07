<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	'Добавить товар',
);

$this->menu=array(
	array('label'=>'Список товаров', 'url'=>array('index')),
	array('label'=>'Управление товарами', 'url'=>array('admin')),
);
?>

<h1>Добавить товар</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>