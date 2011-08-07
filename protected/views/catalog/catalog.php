<div class="categories">
    <?php
    if (isset($cat)) {

    if ($cat->isRoot()) {
        //echo CHtml::link('Весь каталог', $this->createUrl('site/index'));
    } else {
        $parent = $cat->parent();
        echo CHtml::link($parent->name, $this->createUrl('catalog/view', array('name'=>$parent->alias)));
    }
    echo '<h1>' . $cat->name . '</h1>';
}

    foreach ($models as $model) {
        $this->renderPartial('catalog-item', array(
                                                  'model' => $model,
                                             ));
    }
    ?>
    <div class="clearfix"></div>
</div>