<li class="filter fclose" id="<?= 'attrs-' . $attr->id ?>">
	<div class="name-text">
		<span onclick="ShowAttrList('#attrs-<?= $attr->id ?>');" class="fname">
			<i>&nbsp;</i><?php
	echo $attr->name;
?>
		</span>
	</div>
	<div class="filter-content" id="<?= 'attrs-' . $attr->id ?>">
		<?php
			if ($attr->type == '1') {
				foreach ($attr->attrValues as $attrValue) {
					$this->renderPartial('filter-content', array(
						'attr' => $attr,
						'attrValue' => $attrValue,
					));
				}
			} elseif ($attr->type == '3') {
				$this->renderPartial('filter-content3', array(
					'attr' => $attr,
				));
			} elseif ($attr->type == '2') {
				$this->renderPartial('filter-content2', array(
					'attr' => $attr,
				));
			}
		?>
	</div>
</li>