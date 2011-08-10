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
$this->widget('ext.QTreeGridView.CQTreeGridView', array(
                                                       'id' => 'category-grid',
                                                       'dataProvider' => $model->search(),
                                                       'filter' => $model,
                                                       'ajaxUpdate' => false,
                                                       'columns' => array(
                                                           'name',
                                                           'alias',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                               'template' => '{update}{delete}',
                                                           ),
                                                       ),
                                                  ));
?>
