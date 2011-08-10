<div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'good-form',
                        'enableAjaxValidation' => false,
                        'htmlOptions' => array(
                                'enctype' => 'multipart/form-data'),
                ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'price'); ?>
                <?php echo $form->textField($model, 'price', array('size' => 20, 'maxlength' => 30)); ?>
                <?php echo $form->error($model, 'price'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'brand_id'); ?>
                <?php echo $form->dropDownList($model, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name')); ?>
                <?php echo $form->error($model, 'brand_id'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'category_id'); ?>
                <?php
                if (isset($model->id)) $id = $model->id;else $id = '0';
                echo $form->dropDownList($model, 'category_id', array('0' => Yii::t('main-ui', 'Корневой раздел')) + Category::GetArrayForDropDownList2(), array(
                        'encode' => false,
                        'ajax' => array(
                                'type'=>'POST',
                                'url' => $this->createUrl('good/featurelist'),
                                'data' => 'js:{"id":'.$id.', "cat_id":this.value}',
                                'success'=>'function(html){
                                        $("#good-features").html(html);
                                }',
                        ),
                ));
                ?>
<?php echo $form->error($model, 'category_id'); ?>
        </div>

        <div class="row">
                <?php
                if (!$model->isNewRecord) {
                        echo Yii::t('main-ui', 'Check picture if delete'); 
                        echo $model->GetGoodImagesWithCheckbox('s');
                }
                ?><br/><br/>
        </div>

        <div class="row" id="image-inputs">
                <label><?php echo Yii::t('main-ui', 'Load good photos'); ?><br /></label>
                <?php echo $form->fileField($model, 'image[1]', array('size' => '100')); ?>
                <?php echo $form->fileField($model, 'image[2]', array('size' => '100')); ?>
                <?php echo $form->fileField($model, 'image[3]', array('size' => '100')); ?>
<?php echo $form->fileField($model, 'image[4]', array('size' => '100')); ?>
<?php echo $form->error($model, 'image'); ?>
        </div>

        <div class="row" id="good-features">
                <?php
                if (isset($model->category))
                $this->renderPartial('features', array(
                                        'model' => $model,
                                ));
                ?>
        </div>

        <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->