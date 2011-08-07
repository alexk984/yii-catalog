<?php
	if ($this->beginCache('good-review-' . $review->id, array('duration'=>3600))) { ?>

<?php
	$timestamp = CDateTimeParser::parse($review->date, 'yyyy-MM-dd');
	$dateFormatter = new CDateFormatter('ru');
	$date = $dateFormatter->format('d MMMM yyyy', $timestamp);
	$user = $review->user->username;
?>
<div class="b-grade comment left0">
		<div class="data">
			<div class="grade-title">
				<div class="user">
					<span class="b-user"><b class="b-user"><?= $user ?></b></span>&nbsp;
				</div>
				<div class="date"><?= $date ?></div>
				<div class="clearfix"></div>
			</div>
			<div class="b-lr-container">
				<div class="grade left">
				<?php
					$r = $review->rating;
					echo '<div class="x-rating x-rate-'.round($r*4).'"></div>';

					/*$this->widget('CStarRating', array(
						'name' => 'rating' . $review->id,
						'minRating' => '1',
						'maxRating' => '5',
						'value' => $review->rating,
						'readOnly' => true,
						'starWidth'=>'15',
						'starCount' => '5',
						'ratingStepSize' => '1',
						'htmlOptions' => array(
							'id' => 'good-rating',
						)
					));*/ ?>
					<span class="grade-label"><?= $review->rating0->desc ?></span>
					<div class="fix"></div>
				</div>
				<div class="right">Опыт использования: <?= $review->usingExperience0->desc ?></div>
			</div>
			<p class="user-opinion">
				<b>Достоинства: </b>
			<?= $review->positive; ?>
				</p>
				<p class="user-opinion">
					<b>Недостатки: </b>
			<?= $review->negative; ?>
				<p>
					<b>Комментарий: </b>
			<?= $review->comment; ?>
		</p>
	</div>
	<div class="line"></div>
</div>
<?php $this->endCache();}