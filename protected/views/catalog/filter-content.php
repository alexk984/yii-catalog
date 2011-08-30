
<?php
	$id = 'feature_' . $attr->id . '_' . $attrValue->id;
	$checkbox = CHtml::checkBox('feature[' . $attr->id . '][' . $attrValue->id . ']', false, array(
				'onchange' => 'SendSearchReg()',
			));
?>
		<label for="<?php echo $id ?>">
			<?php echo $checkbox ?>
			<span><?php echo $attrValue->value ?></span><br>
		</label>
