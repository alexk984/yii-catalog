<?php
    $this->breadcrumbs = array(
    'Управление характеристиками товаров',
);

$this->menu = array(
    array('label' => 'Добавить характеристики', 'url' => array('create')),
);
?>

<h1>Управление характеристиками товаров</h1>

<?php
$this->widget(
    'zii.widgets.grid.CGridView',
    array(
         'id' => 'attr-grid',
         'dataProvider' => $model->search(),
         'filter' => $model,
         'columns' => array(
             'name',
             array(
                 'name' => 'category',
                 'type' => 'raw',
                 'filter' => CHtml::listData(Category::model()->findAll(), 'id', 'name'),
                 'value' => '$data->attrGroup->category->name'
             ),
             array(
                 'name' => 'attr_group_id',
                 'type' => 'raw',
                 'value' => '$data->attrGroup->name',
                 'filter' => (isset($_GET['Attr']['category'])) ?
                         CHtml::listData(AttrGroup::model()->findAll(
                                             'category_id=' . $_GET['Attr']['category']), 'id', 'name')
                         :
                         CHtml::listData(AttrGroup::model()->findAll(), 'id', 'name')
             ),
             array(
                 'name' => 'is_main',
                 'filter' => array('1' => 'Да', '0' => 'Нет'),
                 'value' => '$data->is_main == 1 ? "Да" : "Нет"',
                 'header' => 'в краткое описание'
             ),
             array(
                 'name' => 'type',
                 'type' => 'raw',
                 'filter' => array('1' => 'string', '2' => 'boolean', '3' => 'integer'),
                 'value' => '$data->GetType()'
             ),
             'pos',
             array(
                 'name' => 'filter',
                 'filter' => array('1' => 'Да', '0' => 'Нет'),
                 'value' => '$data->filter == 1 ? "Да" : "Нет"',
                 'header' => 'в фильтр'
             ),
             'global_pos',
             'template',
             array(
                 'class' => 'CButtonColumn',
             ),
         ),
    ));
?>
