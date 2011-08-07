<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->brand->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->brand->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->category->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->category->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<?php echo $data->GetGoodImages('xs'); ?>
	<br />
</div>