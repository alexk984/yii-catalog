<?php
$this->breadcrumbs=array(
	'Управление Брэндами'
);

$this->menu=array(
	array('label'=>'Добавить брэнд', 'url'=>array('create')),
);

?>

<h1>Управление Брэндами</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array(
			'class'=>'CButtonColumn',
                                                'template' => '{update}{delete}',
		),
	),
)); ?>
