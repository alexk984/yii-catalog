<?php if ($this->beginCache('good_xs_view_' . $good->id, array('duration' => 3600))) { ?>
<div class="good-xs-view">
    <div class="small-photo">
        <?php
        if ($good->goodImages !== null && count($good->goodImages)>0)
            $image = $good->goodImages[0];
        else
            $image = null;
        if ($image !== null)
            $img = CHtml::image('/images/goods/xs_' . $image->image);
        else
            $img = CHtml::image('/images/xs_empty.jpg');
        echo CHtml::link($img, $this->createUrl('good/view', array('id' => $good->id)));
        ?>
    </div>
    <div class="good_desc">
        <?php
                    echo CHtml::link($good->name, $this->createUrl('good/view', array('id' => $good->id)));
            echo '<div class="sm-price">' . CAlexHelper::GetMoneyFormat($good->price) . ' руб.</div>';
            ?>
    </div>
</div>
<?php $this->endCache();
} ?>