<?php if ($this->beginCache('good-full-desc1' . $good->id, array(
	'duration'=>3600,
	'dependency'=>array(
        'class'=>'system.caching.dependencies.CDbCacheDependency',
        'sql'=>'SELECT count(id) FROM rating WHERE good_id='.$good->id),
	))) { ?>
		<div class="good-description">
			<h1><?= $good->name ?></h1>
			<div class="photo"><?php
		echo $good->GetGoodImagesForGallery('s');
		Yii::import('ext.jqPrettyPhoto');

		$options = array(
			'slideshow' => 5000,
			'autoplay_slideshow' => false,
			'show_title' => false
		);
		jqPrettyPhoto::addPretty('.photo a', jqPrettyPhoto::PRETTY_GALLERY, jqPrettyPhoto::THEME_FACEBOOK, $options);
?><br clear="both"/></div>
	<div class="defText clearfix">
		<div class="prices price-inf">
			<div>Цена: </div>
			<div class="price">
                <?php if ($good->price == 0): ?>
                <span class="b-prices__num">Нет в продаже</span>
                <?php else: ?>
				<span class="b-prices__num"><?= CAlexHelper::GetMoneyFormat($good->price) ?></span>
				<span class="b-prices__currency">руб.</span>
                <?php endif ?>
			</div>
		</div>
		<div class="b-rating__with_text">
        <?php $this->endCache();} ?>
		<?php
			$good->ShowRating();
			echo '<span>&nbsp;&nbsp; '.$good->marksCount.' '
				.CAlexHelper::GetFormatWord('оценка', $good->marksCount).'</span>'
			?>

		</div>
		<div class="b-rating__with_text">
			<?php
					if (!Yii::app()->user->isGuest){
						$this->widget('CStarRating', array(
							'name' => 'user-input-rating',
							'minRating' => '1',
							'maxRating' => '5',
							'value' => $good->GetUserRating(),
							'starWidth'=>'15',
							'ratingStepSize' => '1',
							'titles'=>  CHtml::listData(RatingDesc::model()->cache(3600)->findAll(),'id','desc'),
							'allowEmpty'=>false,
							'callback' => 'function(value) {SetRating(value, ' . $good->id . ');}',
                            'cssFile'=>'/css/rating/jquery.rating.css',
						));
					echo '<span>&nbsp;&nbsp;оцените модель</span>';}
					?>
		</div>
		<ul>
			<li><?php
		if (Yii::app()->shoppingCart->contains($good->id)) {
			echo 'Этот товар уже есть в вашей корзине <br>';
			echo CHtml::link('Добавить еще', '#', array(
				'ajax' => array(
					'url' => $this->createUrl('order/addtocard', array(
					)),
					'type' => 'POST',
					'data' => 'id=' . $good->id,
					'success' => 'function(data){UpdateShoppingCart();}',
				)
			));
		}
		else
			echo CHtml::link('Добавить в корзину', '#', array(
				'ajax' => array(
					'url' => $this->createUrl('order/addtocard', array(
					)),
					'type' => 'POST',
					'data' => 'id=' . $good->id,
					'success' => 'function(data){UpdateShoppingCart();}',
				)
			));
?></li>
			</ul>
		</div>

		<?php if ($this->beginCache('good-full-desc-features' . $good->id, array('duration'=>3600))) { ?>
		<table class="b-properties">
			<tbody>
			<?php
                    $group_id = 0;
                    foreach ($good->goodAttrVals as $goodAttrValue){
                        if ($group_id != $goodAttrValue->attr->attr_group_id){
                            echo '  <tr>
            <th class="b-properties__title" colspan="2">' . $goodAttrValue->attr->attrGroup->name . '</th>
        </tr>';
                            $group_id = $goodAttrValue->attr->attr_group_id;
                        }
                        $value = $goodAttrValue->GetAttrValue();
                        if (empty($value))
								continue;
							echo '  <tr><th class="b-properties__label b-properties__label-title"><span>'
                                 . $goodAttrValue->attr->name . '</span></th>
		<td class="b-properties__value">' . $goodAttrValue->attr->GetValue($value) . '</td>
	</tr>';
                    }
			?>
				</tbody>
			</table>
			<br clear="both"/>
			<?php $this->endCache();} ?>
			<div>
				<?php echo CHtml::link('Оставить отзыв', '#', array(
					'onclick'=>'$("#review-form").css("display","block");return false;',
				)); ?>
				<div id="user-input-review">
					<?php
						if (Yii::app()->user->isGuest){
							echo '<p id="review-form">Вы должны авторизоваться чтобы оставить отзыв</p>';
						}else{
						$review = $good->GetReview();
						if ($review == null){
							$review = new Review;
							$review->good_id = $good->id;
						}
						$review->rating = $good->GetUserRating();
						$this->renderPartial('//review/_form', array(
							'model' => $review,
						));
						}
						?>
				</div>
			</div>
			<div id="user-reviews" class="clearfix">
				<h1>Отзывы</h1>
		<?php
					$cs = Yii::app()->getClientScript();
					$cs->registerScriptFile('/js/rating.js');

					$this->renderPartial('//review/reviews', array(
						'good' => $good,
					));
		?>
				</div>
				<div id="similar-goods" class="clearfix">
					<h1>Случайные товары</h1>
		<?php
					$similar_goods = $good->similar();

					foreach ($similar_goods as $similar_good) {
						$this->renderPartial('good_xs_view', array(
							'good' => $similar_good,
						));
					}
		?>
				</div>
			</div>