<?php
$this->breadcrumbs = array(
        'Товары' => array('index'),
        $model->name,
);

$this->menu = array(
        array('label' => 'Список товаров', 'url' => array('index')),
        array('label' => 'Добавить товар', 'url' => array('create')),
        array('label' => 'Изменить товар', 'url' => array('update', 'id' => $model->id)),
        array('label' => 'Удалить товар', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => 'Управление товарами', 'url' => array('admin')),
);
?>

<h1>Посмотреть товар #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
                'id',
                'name',
                'category.name',
                'brand.name',
		'price',
                 array(
            'label'=>'Photo',
            'type'=>'raw',
            'value'=>$model->GetGoodImages('s'),
        ),
        ),
));
?>
<br>
<h3>Характеристики</h3>

<?php
$features = GoodAttrVal::model()->findAllByAttributes(array('good_id' => $model->id));
foreach ($features as $feature) {
        if (isset($feature->attrValue)) {
                if ($feature->attrValue->attr->type == '1')
                        echo $feature->attrValue->attr->name . ' : ' . $feature->attrValue->value;
        }
        elseif (isset($feature->attr)) {
                if ($feature->attr->type == '2') {
                        if ($feature->value == '1')
                                echo $feature->attr->name . ' : ' . 'yes';
                        elseif ($feature->value == '0')
                                echo $feature->attr->name . ' : ' . 'no';
                }
                elseif ($feature->attr->type == '3')
                        echo $feature->attr->name . ' : ' . $feature->value;
        }
        echo '<br>';
}
?>