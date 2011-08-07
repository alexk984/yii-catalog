<div class="form">

    <?php
            $form = $this->beginWidget('CActiveForm', array(
                                                           'id' => 'review-form',
                                                           'enableAjaxValidation' => true,
                                                           'action' => Yii::app()->createUrl('review/create'),
                                                      ));
    ?>
    <h1>Оставить отзыв</h1>

    <p class="note">Поля, помеченные <span class="required">*</span> обязательны для заполнения</p>

    <?php
        //echo $form->errorSummary($model);
    echo $form->hiddenField($model, 'good_id');
    ?>

    <div class="row">
        <strong><?php echo $form->labelEx($model, 'rating'); ?> </strong>
        <?php echo $form->dropDownList($model, 'rating',
                                       CHtml::listData(RatingDesc::model()->cache(3600)->findAll(), 'id', 'desc'),
                                       array('empty' => 'выбрать...')); ?>
        <?php echo $form->error($model, 'rating'); ?>
    </div>

    <div class="row">
        <p><strong><?php echo $form->labelEx($model, 'positive'); ?></strong></p>
        <?php echo $form->textArea($model, 'positive', array('rows' => 6, 'cols' => 50, 'maxlength' => 4000)); ?>
        <?php echo $form->error($model, 'positive'); ?>
    </div>

    <div class="row">
        <p><strong><?php echo $form->labelEx($model, 'negative'); ?></strong></p>
        <?php echo $form->textArea($model, 'negative', array('rows' => 6, 'cols' => 50, 'maxlength' => 4000)); ?>
        <?php echo $form->error($model, 'negative'); ?>
    </div>

    <div class="row">
        <p><strong><?php echo $form->labelEx($model, 'comment'); ?></strong></p>
        <?php echo $form->textArea($model, 'comment', array('rows' => 6, 'cols' => 50, 'maxlength' => 4000)); ?>
        <?php echo $form->error($model, 'comment'); ?>
    </div>

    <div class="row">
        <strong><?php echo $form->labelEx($model, 'using_experience'); ?> </strong>
        <?php echo $form->dropDownList($model, 'using_experience',
                                       CHtml::listData(UserExpDesc::model()->cache(3600)->findAll(), 'id', 'desc'),
                                       array('empty' => 'выбрать...')); ?>
        <?php echo $form->error($model, 'using_experience'); ?>
    </div>

    <div class="row buttons">
    <?php
        if ($model->isNewRecord)
        echo CHtml::submitButton('Оставить отзыв', array(
                                                        'ajax' => array(
                                                            'type' => 'POST',
                                                            'url' => Yii::app()->createUrl('review/create'),
                                                            'success' => 'function(data) {
                                                            $("#user-input-review").html(data);
                                                            $("#review-form").css("display","block");
                                                            }',
                                                        ),
                                                        'id' => 'create-btn'
                                                   ));
    else
        echo CHtml::submitButton('Обновить', array(
                                                  'ajax' => array(
                                                      'type' => 'POST',
                                                      'url' => Yii::app()->createUrl('review/update'),
                                                      'success' => 'function(data) {
                                                        $("#user-input-review").html(data);
                                                        $("#review-form").css("display","block");
                                                      }',
                                                  ),
                                                  'id' => 'update-btn'
                                             ));
        ?>
    </div>

    <?php $this->endWidget(); ?>
    <div id="test"></div>
</div><!-- form -->