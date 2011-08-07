<label><?php echo Yii::t('main-ui', 'Good features'); ?><br /></label>
<?php
foreach ($model->category->attrGroups as $attr_group) {
        echo CHtml::openTag('div', array('class' => 'attr_group'));
        echo "<h3>" . $attr_group->name . "</h3>";

        foreach ($attr_group->attrs as $attr) {
                echo CHtml::label($attr->name, $attr->id);
                if ($attr->type == '1') {
                        echo CHtml::dropDownList(
                                'Good[feature][normal][' . $attr->id . ']', $model->findAttrValue($attr), array('0' => ' ') + CHtml::listData(
                                        AttrValue::model()->findAllByAttributes(array(
                                                'attr_id' => $attr->id)), 'id', 'value'));
                        echo CHtml::textField(
                                'Good[feature][new][' . $attr->id . ']', '', array(
                                'class' => 'own-attr-value',
                                'size' => '50',
                        ));
                } else if ($attr->type == '2') {
                        echo CHtml::dropDownList(
                                'Good[feature][normal][' . $attr->id . ']', $model->findAttrValue($attr), array('0' => ' ', '1' => 'yes', '2' => 'no'));
                } else if ($attr->type == '3') {
                        echo CHtml::textField(
                                'Good[feature][normal][' . $attr->id . ']', $model->findAttrValue($attr), array(
                                'size' => '10',
                        ));
                }
                echo '<br>';
        }

        echo CHtml::closeTag('div');
}
?>
