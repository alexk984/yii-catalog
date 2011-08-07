<?php
$this->breadcrumbs=array(
	'Управление Брэндами'=>array('admin'),
	'Добавить брэнд',
);

$this->menu=array(
	array('label'=>'Управление Брэндами', 'url'=>array('admin')),
);
?>

<h1>Добавить брэнд</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>