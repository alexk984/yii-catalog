<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brand-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model);
                echo $form->hiddenField($model, 'id');
                ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row buttons">
                <?php if ($model->isNewRecord)
                        echo CHtml::ajaxButton('Добавить', array('/admin/brand/create'), array(
                        'success' => 'function(html){
				$("#cat-result").html(html).css({"opacity":"1"}).animate({opacity: 0,}, 2000);}',
                        'data'=>'js:jQuery(this).parents("form").serialize()',
                        'type'=>'POST',
                ));
                else
                        echo CHtml::ajaxButton('Обновить', array('/admin/brand/updateajax'), array(
                        'success' => 'function(html){
				$("#cat-result").html(html).css({"opacity":"1"}).animate({opacity: 0,}, 2000);}',
                        'data'=>'js:jQuery(this).parents("form").serialize()',
                        'type'=>'POST',
                )); ?>

                <span id="cat-result"></span>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->