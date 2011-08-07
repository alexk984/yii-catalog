<?php

class GoodController extends Controller
{

    /**
     * Show good info
     * @param $id good id
     */
    public function actionView($id)
    {
        $good = Good::model()->with(array(
                                         'category' => array(
                                             'select' => 'id,name,alias'
                                         ),
                                         'goodAttrVals' => array(
                                             'select' => 'value,attr_value_id,attr_id'
                                         ),
                                         'goodAttrVals.attrValue',
                                         'goodAttrVals.attr' => array(
                                             'select' => 'name,type,template,attr_group_id'
                                         ),
                                         'goodAttrVals.attr.attrGroup',
                                         'ratings' => array(
                                             'select' => 'id,value'
                                         ),
                                         'goodImages'
                                    ))->findByPk($id, '', array('order' => 'attrGroup.pos, attr.pos'));
        $this->render('good', array(
                                   'good' => $good,
                              ));
    }

}