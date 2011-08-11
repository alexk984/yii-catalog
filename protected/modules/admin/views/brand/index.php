<?php
$this->breadcrumbs=array(
	'Управление Брэндами'
);

?>
<script type="text/javascript">
    function EditBrand(link){
        $("#Brand_id").val(link.parent('td').parent('tr').find('td').html());
        $("#Brand_name").val(link.parent('td').parent('tr').find('td').next('td').html());
        $("#edit-brand-button").val("Изменить");
        $("#cancel-edit").removeClass("invis");
    }
</script>
<h1>Управление Брэндами</h1>

<div class="form" id="ajaxform">
    <?php $this->renderPartial('ajaxForm',array(
	'model'=>$edit_model,
)); ?>
</div>
<p>Редактирование работает для элементов с id > 60</p>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'id',
		'name',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
            'updateButtonOptions'=>array('onclick'=>'EditBrand($(this));return false;'),
		),
	),
)); ?>
