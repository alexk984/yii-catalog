<div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category-form',
                        'enableAjaxValidation' => false,
                ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); 
        echo $form->hiddenField($model, 'id');
        ?>

        <div class="row">
                <?php echo $form->labelEx($model, 'parent_id'); ?>
                <?php
                echo $form->dropDownList($model, 'parent_id', array('0'=>Yii::t('main-ui', 'Корневой раздел')) + Category::GetArrayForDropDownList2(), array(
                        'encode'=>false,
                ));
                ?>
                <?php echo $form->error($model, 'parent_id'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'alias'); ?>
                <?php echo $form->textField($model, 'alias', array('size' => 60, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'alias'); ?>
        </div>

        <div class="row buttons">
                <?php if ($model->isNewRecord)
                        echo CHtml::ajaxButton('Добавить', array('/admin/category/create'), array(
                        'data'=>'js:jQuery(this).parents("form").serialize()',
                        'type'=>'POST',
                        'success' => 'function(html){
				$("#cat-result").html(html).css({"opacity":"1"}).animate({opacity: 0,}, 2000);}',
                ));
                else
                        echo CHtml::ajaxButton('Обновить', array('/admin/category/updateajax'), array(
                        'data'=>'js:jQuery(this).parents("form").serialize()',
                        'type'=>'POST',
                        'success' => 'function(html){
				$("#cat-result").html(html).css({"opacity":"1"}).animate({opacity: 0,}, 2000);}',
                )); ?>

                <div id="cat-result"></div>
        </div>
        

        <?php $this->endWidget(); ?>
        

</div><!-- form -->