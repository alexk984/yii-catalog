<?php
$this->breadcrumbs = array(
        'Товары' => array('index'),
        'Управление товарами',
);

$this->menu = array(
        array('label' => 'Список товаров', 'url' => array('index')),
        array('label' => 'Добавить товар', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('good-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление товарами</h1>

<p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'good-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
                'id',
                'name',
		'price',
                array(
                        'name' => 'brand_id',
                        'type' => 'raw',
                        'filter' => CHtml::listData(Brand::model()->findAll(), 'id', 'name'),
                        'value' => '$data->brand->name',
                ),
                array(
                        'name' => 'category_id',
                        'type' => 'raw',
                        'filter' => Category::TreeArray(false),
                        'value' => '$data->category->name',
                ),
                array(
                        'name' => 'image',
                        'type' => 'raw',
                        'value' => 'count($data->goodImages)',
                ),
                array(
                        'class' => 'CButtonColumn',
                ),
        ),
));
?>
