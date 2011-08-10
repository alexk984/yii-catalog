<div class="form">

    <?php
            $form = $this->beginWidget('CActiveForm', array(
                                                           'id' => 'attr-group-form',
                                                           'enableAjaxValidation' => false,
                                                      ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model);
    echo $form->hiddenField($model, 'id');
    ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'category_id'); ?>
    <?php
                    echo $form->dropDownList($model, 'category_id', Category::TreeArray(false),
                                             array(
                                                  'empty' => 'выберите категорию',
                                                  'encode' => false,
                                                  'ajax' => array(
                                                      'type' => 'POST',
                                                      'url' => $this->createUrl('group/CategoryGroupsList'),
                                                      'data' => 'js:{"cat_id":this.value}',
                                                      'cache' => false,
                                                      'success' => 'function(data){
                                        $("#cat-groups").html(data);
                                }',
                                                  ),
                                             ));
        ?>
        <?php echo $form->error($model, 'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
    <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                               'model' => $model,
                                                               'attribute' => 'name',
                                                               'name' => 'attr-group-name',
                                                               'source' => AttrGroup::GetGroupNames(),
                                                               'options' => array(
                                                                   'minLength' => '1',
                                                               ),
                                                               'htmlOptions' => array(
                                                                   'style' => 'width:400px;'
                                                               ),
                                                          ));
        ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'pos'); ?>
        <?php echo $form->textField($model, 'pos', array('size' => 3, 'maxlength' => 3)); ?>
        <?php echo $form->error($model, 'pos'); ?>
    </div>

<div class="row buttons">
    <?php
                    if ($model->isNewRecord)
    echo CHtml::ajaxButton('Добавить',
                           $this->createUrl('group/create'),
                           array(
                                'data' => 'js:{"cat_id":$("#AttrGroup_category_id").val(), "name":$("#attr-group-name").val(), "pos":$("#AttrGroup_pos").val()}',
                                'success' => 'function(html){
                                        $(".ajax-result").html(html).css({"opacity":"1"}).animate({
                                        opacity: 0,
                                        }, 3000);
                                        $("#cat-groups").append($("#attr-group-name").val()+"<br>");}',
                           ));
else
    echo CHtml::ajaxButton('Обновить',
                           $this->createUrl('group/updateajax'),
                           array(
                                'data' => 'js:{"cat_id":$("#AttrGroup_category_id").val(), "name":$("#attr-group-name").val(),
                                        "pos":$("#AttrGroup_pos").val(), "id":$("#AttrGroup_id").val()}',
                                'success' => 'function(html){
                                                $(".ajax-result").html(html).css({"opacity":"1"}).animate({
                                    opacity: 0,
                                }, 3000);}',
                           ));
    ?>
        <div class="ajax-result">
            <?php if (!$model->isNewRecord) : ?>
            <?php echo $this->GetCategoryGroupsList($model->category_id); ?>
            <?php endif; ?>
        </div>
    </div>

    <div id="cat-groups"></div>

    <?php $this->endWidget(); ?>

</div><!-- form -->