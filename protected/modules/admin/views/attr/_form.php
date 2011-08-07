<div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'attr-form',
                        'enableAjaxValidation' => false,
                ));
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir . DIRECTORY_SEPARATOR . 'assets');
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($assets . '/attr.js');
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model);
        echo $form->hiddenField($model, 'id');
        ?>

        <div class="row">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
                <?php CHtml::label('Category', 'category_id_select'); ?>
                <?php
                echo CHtml::dropDownList(null, 'category_id', array('0' => Yii::t('main-ui', 'Корневой раздел')) + Category::GetArrayForDropDownList2(), array(
                        'encode' => false,
                        'onchange' => 'GetCategoryGroups(this.value, \'' . $this->createUrl('group/catgroups2') . '\')',
                        'id' => 'category_id_select',
                ));
                ?>
                <?php //echo $form->error($model->attrGroup, 'category_id');  ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'attr_group_id'); ?>
                <?php
                echo $form->dropDownList($model, 'attr_group_id', array(), array(
                        'onchange' => 'GetGroupAttributes(this.value);',
                ));
                ?>
                <?php echo $form->error($model, 'attr_group_id'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'is_main'); ?>
                <?php echo $form->checkBox($model, 'is_main'); ?>
                <?php echo $form->error($model, 'is_main'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'filter'); ?>
                <?php echo $form->checkBox($model, 'filter'); ?>
                <?php echo $form->error($model, 'filter'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'type'); ?>
                <?php
                echo $form->radioButtonList($model, 'type', array(
                        '1' => 'строковая', '2' => 'булева (да, нет)', '3' => 'целочисленная'
                        ), array('template' => '{label}{input}', 'separator' => ' '));
                ?>
                <?php echo $form->error($model, 'type'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'template'); ?>
                <?php echo $form->textField($model, 'template', array('size' => 60, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'template'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'pos'); ?>
                <?php echo $form->textField($model, 'pos'); ?>
                <?php echo $form->error($model, 'pos'); ?>
        </div>

        <div class="row">
                <?php echo $form->labelEx($model, 'global_pos'); ?>
                <?php echo $form->textField($model, 'global_pos'); ?>
                <?php echo $form->error($model, 'global_pos'); ?>
        </div>

        <div class="row buttons">
                <?php
                if ($model->isNewRecord)
                        echo CHtml::ajaxButton('Добавить', array('create'), array(
                                'success' => 'function(html){
                                                $(".ajax-result").html(html).css({"opacity":"1"}).animate({
                                    opacity: 0,
                                }, 3000);
                                GetGroupAttributes($("#Attr_attr_group_id").val());}',
                                'data' => 'js:jQuery(this).parents("form").serialize()',
                                'type' => 'POST',
                        ));
                else
                        echo CHtml::ajaxButton('Обновить', $this->createUrl('attr/updateajax'), array(
                                'data'=>'js:jQuery(this).parents("form").serialize()',
                                'success' => 'function(html){
                                                $(".ajax-result").html(html).css({"opacity":"1"}).animate({
                                    opacity: 0,
                                }, 3000);}',
                        ));
                ?>
                <span class="ajax-result"></span>
        </div>

        <div id="group-attr"></div>
        <?php $this->endWidget(); ?>

</div><!-- form -->