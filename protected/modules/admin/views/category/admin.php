<?php
$this->breadcrumbs = array(
        'Управление Категориями товаров'
);

$this->menu = array(
        array('label' => Yii::t('main-ui', 'Добавить категорию'), 'url' => array('create')),
);
?>

<h1>Управление категориями товаров</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'category-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
                array(// display 'create_time' using an expression
                        'name' => 'name',
                        'type' => 'html',
                        'value' => '$data->GetStringName()',
                ),
		'alias',
                array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}{delete}',
                ),
        ),
));
?>
