<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<?php echo CHtml::link('Catalog', $this->createUrl('site/catalog'));?>