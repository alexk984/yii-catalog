<?php if ($this->beginCache('good_small_view_' . $good->id, array('duration' => 3600))) { ?>
<div class="good-small-view clearfix">
    <div class="photo">
        <?php
        $images = $good->goodImages;
        if ($images !== null && count($images) > 0)
            $img = CHtml::image('/images/goods/xs_' . $images[0]->image);
        else
            $img = CHtml::image('/images/xs_empty.jpg');

        echo CHtml::link($img, $this->createUrl('good', array('id' => $good->id)));
        ?>
    </div>
    <div class="good_desc">
        <?php
            echo CHtml::link($good->name, $this->createUrl('good/view', array('id' => $good->id)));
            $good->ShowRating();
            echo '<div class="fix">';

            $main_features = $good->GetMainAttributes();
            foreach ($main_features as $main_feature) {
                echo $main_feature->attr->GetValue($main_feature->value);
                if (end($main_features) != $main_feature)
                    echo ', ';
            }
            if ($good->price !== null && $good->price != 0)
                echo '</div><div class="sm-price">Цена: ' . CAlexHelper::GetMoneyFormat($good->price) . ' руб.</div>';
            else
                echo '</div><div><b>Нет в продаже</b></div>';
            ?>
    </div>
</div>
<?php $this->endCache();
} ?>