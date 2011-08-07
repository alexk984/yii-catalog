<?php
$this->breadcrumbs=array(
	'Управление характеристиками товаров'=>array('admin'),
	'Обновить',
);

$this->menu=array(
	array('label'=>'Добавить характеристики', 'url'=>array('create')),
	array('label'=>'Управление характеристиками товаров', 'url'=>array('admin')),
);
?>

<h1>Обновить характеристику товара: <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>