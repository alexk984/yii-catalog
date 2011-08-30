<?php if ($this->beginCache('category-filter' . $category->id, array('duration' => 3600))) { ?>
		<div class="col1">
									sending request...
		</div>
		<div class="col2">
			<div class="clearfix">
				<ul style="float: left;" class="b-switcher">
					<li class="b-switcher__item b-switcher__caption">Сортировать&nbsp;по: </li>
					<li class="b-switcher__item b-switcher__sort" id="sort-price">
				<?php
					echo CHtml::link('цене', '', array(
						'onclick' => '$("#order_price").val("price");
							$("#sort-price").addClass("b-switcher__current_light");
							$("#sort-popular").removeClass("b-switcher__current_light");
							$("#sort-newer").removeClass("b-switcher__current_light");
							SendSearchReg();',
						'class' => 'b-switcher__link',
					));
				?>
				</li>
				<li class="b-switcher__item b-switcher__sort b-switcher__current_light" id="sort-popular">
				<?php
					echo CHtml::link('популярности', '', array(
						'onclick' => '$("#order_price").val("rating desc");
							$("#sort-price").removeClass("b-switcher__current_light");
							$("#sort-popular").addClass("b-switcher__current_light");
							$("#sort-newer").removeClass("b-switcher__current_light");
							SendSearchReg();',
						'class' => 'b-switcher__link',
					));
				?>
				</li>
				<li class="b-switcher__item b-switcher__sort" id="sort-newer">
				<?php
					echo CHtml::link('новизне', '', array(
						'onclick' => '$("#order_price").val("date desc");
							$("#sort-price").removeClass("b-switcher__current_light");
							$("#sort-popular").removeClass("b-switcher__current_light");
							$("#sort-newer").addClass("b-switcher__current_light");
							SendSearchReg();',
						'class' => 'b-switcher__link',
					));
				?>
			</ul>
		</div>
	<?php
					$cs = Yii::app()->getClientScript();
					$cs->registerCoreScript('jquery');
					$cs->registerScriptFile('/js/search.js');
					$cs->registerScript("search1", "SendSearchReg();");
					$cs->registerCssFile('/css/pager.css');

					echo CHtml::form('', 'post', array(
						'id' => 'search-from',
						'name' => 'Feature',
					));

					echo CHtml::hiddenField('category_id', $category->id);
					echo CHtml::hiddenField('page', '0');
					echo CHtml::hiddenField('order', 'rating desc', array('id' => 'order_price'));
	?>
					<li class="filter">
						<div class="name-text">Цена:</div>
						<span class="inputs"><nobr>&nbsp;&nbsp;от&nbsp;
				<?php echo CHtml::textField('price[min]', '', array('onchange' => 'SendSearchReg()', 'size' => '10')); ?>
					<span>&nbsp;до&nbsp;
                <?php echo CHtml::textField('price[max]', '', array('onchange' => 'SendSearchReg()', 'size' => '10')); ?>
					</span>
					&nbsp;руб.</nobr>
			</span>
			<br><br>
		</li>
	<?php
						echo '<h4>Производители</h4>';
						foreach ($brands as $brand)
								echo '<label class="filter-brand">' .
                                     CHtml::checkBox('brand[' . $brand->id . ']', false, array(
									'onchange' => 'SendSearchReg()',
								)) . '<span>' . $brand->name . '</span></label>';
						echo '<div class="clearfix"></div>';

						foreach ($category->attrGroups as $attrGroup) {
							foreach ($attrGroup->attrs as $attr) {
								if ($attr->type == '1') {
									$this->renderPartial('filter-item', array(
										'attr' => $attr,
									));
								} elseif ($attr->type == '2') {
									$this->renderPartial('filter-item', array(
										'attr' => $attr,
									));
								} elseif ($attr->type == '3') {
									$this->renderPartial('filter-item', array(
										'attr' => $attr,
									));
								}
							}
						}

						echo CHtml::endForm();
	?>
					</div>
<?php $this->endCache();
					}
?>