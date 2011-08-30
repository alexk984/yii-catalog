
<?php
	$input1 = CHtml::textField('feature[' . $attr->id . '][min]', '', array('onchange' => 'SendSearchReg()', 'size' => '10'));
	$input2 = CHtml::textField('feature[' . $attr->id . '][max]', '',array('onchange' => 'SendSearchReg()', 'size' => '10'));
	if (!empty($attr->template)) $measurement = $attr->template;
?>
<span class="inputs"><nobr>&nbsp;&nbsp;от&nbsp;
		<?php echo $input1 ?>
		<span>&nbsp;до&nbsp;
			<?php echo $input2 ?>
		</span>
		&nbsp;<span><?php echo $measurement ?></span></nobr>
</span>