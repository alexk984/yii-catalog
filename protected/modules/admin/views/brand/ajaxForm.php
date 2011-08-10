<?php $form = $this->beginWidget('CActiveForm', array(
                                                     'id' => 'brand-form',
                                                     'enableClientValidation' => true,
                                                     'enableAjaxValidation' => false,
                                                     'clientOptions' => array('validateOnSubmit' => true),
                                                )); ?>

<?php //echo $form->errorSummary($smodel); ?>
<?php echo $form->hiddenField($model, 'id'); ?>

<div class="row">
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('size' => '60')); ?>
    <?php echo $form->error($model, 'name'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::AjaxButton(
    $model->isNewRecord ? 'Добавить' : 'Изменить',
    $this->createUrl('brand/ajax'),
    array(
         'type' => 'POST',
         'success' => 'function(data) {
                                $("#ajaxform").html(data);
                                $.fn.yiiGridView.update("brand-grid");
                        }'
    ),
    array(
         'id' => 'edit-brand-button'
    )
); ?>
    <?php echo CHtml::link('отмена', '#', array(
                                               'id' => 'cancel-edit',
                                               'class' => $model->isNewRecord ? 'invis' : '',
                                               'onclick' => '$("#Brand_id").val("");
                                          $("#edit-brand-button").val("Добавить");
                                          $("#cancel-edit").addClass("invis");
                                          $("#Brand_name").val("");
                                          return false;'
                                          )) ?>
    <?php
                $message = Yii::app()->user->getFlash('notice');
    if (isset($message) && !empty($message)) : ?>
        <script>$.noticeAdd({
            text: "<?php echo $message; ?>",
            stay: false
        });</script>
        <?php endif; ?>
</div>

<?php $this->endWidget(); ?>
