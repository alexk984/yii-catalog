<?php
$this->breadcrumbs=array(
	'Управление Брэндами'
);

$this->menu=array(
	array('label'=>'Добавить брэнд', 'url'=>array('create')),
);

?>
<h1>Управление Брэндами</h1>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.notice.js'); ?>

<div class="form" id="ajaxform">
    <?php $this->renderPartial('ajaxForm',array(
	'model'=>$edit_model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'id',
		'name',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
            'updateButtonOptions'=>array('onclick'=>'EditBrand($(this));return false;'),
		),
	),
)); ?>
