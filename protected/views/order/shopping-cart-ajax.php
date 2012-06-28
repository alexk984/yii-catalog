<thead>
<tr>
    <td width="60%">Наименование товара</td>
    <td>Цена</td>
    <td>Кол-во</td>
    <td>Сумма</td>
    <td>Удалить</td>
</tr>
</thead>
<tbody>
<?php

$positions = Yii::app()->shoppingCart->getPositions();
foreach ($positions as $position) {
    echo '<tr>';
    echo '<td class="good-name">' . $position->GetGoodImage('xs') .
         CHtml::link($position->name, $this->createUrl('good/view', array('id' => $position->id)))
         . '</td>';
    echo '<td><span id="one-price-' . $position->id . '">' . CAlexHelper::GetMoneyFormat($position->getPrice()) . '</span> руб.</td>';
    echo '<td>' . CHtml::textField('good-quantity-' . $position->id, $position->getQuantity(), array(
                                                                                                'onkeyup' => 'SetNewQuantity(' . $position->id . ')',
                                                                                                'maxlength' => '10',
                                                                                                'size' => '3',
                                                                                           )) . '</td>';
    echo '<td><span id="sum-price-' . $position->id . '">' . CAlexHelper::GetMoneyFormat($position->getSumPrice()) . '</span> руб.</td>';
    echo '<td class="remove-good">' . CHtml::link('<img src="/images/delete.png" alt="" />', '', array(
                                                                                                      'onclick' => 'DeleteItem(' . $position->id . ')',
                                                                                                 )) . '</td>';
    echo '</tr>';
}
?>
</tbody>
<tfoot>
<td colspan=5>
    <div class="cart-sum">Итого: <span><?php
        $cost = (string)Yii::app()->shoppingCart->getCost();
        echo CAlexHelper::GetMoneyFormat($cost);
        ?> руб.</span></div>
</td>
</tfoot>
