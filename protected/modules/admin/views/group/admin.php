<?php
$this->breadcrumbs = array(
    'Управление группами характеристик',
);

$this->menu = array(
        array('label' => 'Добавить группу характеристик', 'url' => array('create')),
);
?>

<h1>Управление группами характеристик</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'attr-group-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
                array(
                        'name' => 'category_id',
                        'type' => 'raw',
                        'filter' => Category::TreeArray(false),
                        'value' => '$data->category->name',
                ),
                'name',
                'pos',
                array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}{delete}',
                ),
        ),
));
?>
