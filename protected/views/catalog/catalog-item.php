<?php if($this->beginCache('cat-list-'.$model->id, array('duration'=>60))) { ?>

<div class="supcat guru">
		<a href="<?= $this->createUrl('catalog/view', array('name' => $model->alias)) ?>">
			<img height="16" border="0" width="16" src="/images/duru.gif" title="Каталог товаров" alt="*!*"><?= $model->name ?></a>
		<span style="font-size: 87%;"><?php
	$cat = Category::model()->findByPk($model->id);
	if ($cat->isLeaf()) {
		echo Good::model()->count('category_id=' . $cat->id);
	} else {
		$categories = $cat->descendants()->findAll();
		$sum = 0;
		foreach ($categories as $category) {
			if ($category->isLeaf()) {
				$sum = $sum + Good::model()->count('category_id=' . $category->id);
			}
		}
		echo $sum;
	}
?></span>
	<div class="subcat">
		<?php
			if (!$cat->isLeaf()) {
				$categories = $cat->children()->findAll();
				$i=0;
				foreach ($categories as $category) {
					echo CHtml::link($category->name, $this->createUrl('catalog/view',
                                                                       array('name' => $category->alias)));
					$i++;
					if ($i > 7){
						echo ' ...';
						break;
					}elseif ($i < count($categories)){
						echo ', ';
					}

				}
			}
		?>
	</div>
</div>
<?php $this->endCache(); } ?>