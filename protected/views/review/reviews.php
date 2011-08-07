<div class="comments-tree">
	<?php
		$i = 0;
		$criteria = new CDbCriteria;
		$criteria->compare('good_id', $good->id);
		$criteria->order = 'RAND()';
		$reviews = Review::model()->findAll($criteria);
		foreach ($reviews as $review) {
			$this->renderPartial('//review/review', array(
				'review' => $review,
			));
			$i++;
			if ($i >= 2)
				break;
		}
		if (count($good->reviews) > 2){
			echo CHtml::ajaxLink('Все отзывы',
				$this->createUrl('review/allreviews'),
				array(
					'type' => 'POST',
					'data' => 'good_id=' . $good->id,
					'success'=>'function(data){
						$(".comments-tree").html(data);
					}',
			));
		echo ' '.count($good->reviews);}
	?>
</div>