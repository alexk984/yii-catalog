<?php
$this->breadcrumbs=array(
	'Управление характеристиками товаров'=>array('admin'),
	'Добавить характеристики',
);

$this->menu=array(
	array('label'=>'Управление характеристиками товаров', 'url'=>array('admin')),
);
?>

<h1>Добавить характеристики</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>