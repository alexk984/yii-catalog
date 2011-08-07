
<?php
	$id = 'feature_' . $attr->id . '_' . $attrValue->id;
	$checkbox = CHtml::checkBox('feature[' . $attr->id . '][' . $attrValue->id . ']', false, array(
				'onchange' => 'SendSearchReg()',
			));
?>
		<label for="<?= $id ?>">
			<?= $checkbox ?>
			<span><?= $attrValue->value ?></span><br>
		</label>
