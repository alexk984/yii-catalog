<?php

class CatalogController extends Controller
{
    /**
     * Render root catalog page
     */
    public function actionIndex()
    {
        $models = Category::model()->roots()->findAll();
        $this->render('catalog', array(
                                      'models' => $models,
                                 ));
    }

    /**
     * Render Category Page
     * @throws CHttpException category not found
     * @param $name
     */
    public function actionView($name)
    {
        $model = Category::model()->findByAttributes(array(
                                                          'alias' => $name,
                                                     ));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if ($model->isLeaf()) {
            $category = Category::model()->with(array(
                                                     'attrGroups' => array(
                                                         'select' => 'id'
                                                     ),
                                                     'attrGroups.attrs' => array(
                                                         'select' => 'name,type,template',
                                                         //'condition' => ' filter=1 '
                                                     ),
                                                     'attrGroups.attrs.attrValues' => array(
                                                         'select' => 'value',
                                                         'order' => 'value'
                                                     )
                                                ))->find(array(
                                                              'condition' => 'alias="' . $name . '"',
                                                              'select' => 'id,name',
                                                              'order' => 'attrs.global_pos'
                                                         ));

            $this->render('goods', array(
                                        'category' => $category,
                                        'brands' => Brand::GetCategoryBrands($category->id)
                                   ));
        } else {
            $models = $model->children()->findAll();
            $this->render('catalog', array(
                                          'models' => $models,
                                          'cat' => $model,
                                     ));
        }
    }

    /**
     * Search goods
     */
    public function actionSearch()
    {
        if (!isset($_POST['feature'])) {
            echo 'Категория пуста';
            return;
        }
        //print_r($_POST);

        $catId = $_POST['category_id'];
        if (isset($_POST['brand'])) {
            foreach ($_POST['brand'] as $key => $value) {
                $brands [] = $key;
            }
        }
        $price = $_POST['price'];

        $res = array();
        $first_step = true;
        foreach ($_POST['feature'] as $featureId => $feature) {
            if (!empty($feature) || $feature == '0') {
                $attr = Attr::model()->cache(3600)->findByPk($featureId);
                if ($attr->type == '2' && $feature == '2')
                    continue;
                if ($attr->type == '3' && empty($feature['min']) && empty($feature['max']))
                    continue;

                $criteria = new CDbCriteria;
                $criteria->compare('category_id', $catId, false);
                if (!empty($brands)) {
                    $criteria->compare('brand_id', $brands, false);
                }
                if (!empty($price) && !empty($price['min']))
                    $criteria->condition .= ' AND price >= ' . $price["min"];
                if (!empty($price) && !empty($price['max']))
                    $criteria->condition .= ' AND price <= ' . $price["max"];
                $criteria->join = 'left join good_attr_val v ON v.good_id=t.id';

                if ($attr->type == '1') {
                    $values = array();
                    foreach ($feature as $key => $value) {
                        if ($value == '1')
                            $values [] = $key;
                    }
                    $criteria->compare('v.attr_value_id', $values);
                }
                if ($attr->type == '2') {
                    $criteria->condition .= ' AND v.value=' . $feature . ' and v.attr_id=' . $attr->id;
                }
                if ($attr->type == '3') {

                    if (!empty($feature['min']) && !empty($feature['max']))
                        $criteria->condition .= ' AND v.value>=' . $feature['min'] .
                                                ' AND v.value<=' . $feature['max'] . ' AND v.attr_id =' . $attr->id;
                    elseif (!empty($feature['min']) && empty($feature['max']))
                        $criteria->condition .= ' AND v.value>=' . $feature['min'] .
                                                ' AND v.attr_id =' . $attr->id;
                    elseif (empty($feature['min']) && !empty($feature['max']))
                        $criteria->condition .= ' AND v.value<=' . $feature['max'] .
                                                ' AND v.attr_id =' . $attr->id;
                }

                $goods = Good::model()->with(array('goodImages'))->findAll($criteria);
                $good_ids = array();
                foreach ($goods as $good) {
                    $good_ids [] = $good->id;
                }

                //echo 'id=' . $featureId . '<br>';
                if (empty($res) && $first_step) {
                    //print_r($good_ids);echo '<br>';
                    $res = $good_ids;
                    if (empty($res) && !$first_step) {
                        echo 'Ничего не найдено по этим критериям';
                        return;
                    }
                    $first_step = FALSE;
                    continue;
                }

                if (empty($good_ids)) {
                    echo 'Ничего не найдено по этим критериям';
                    return;
                }

                foreach ($res as $good_id) {
                    if (!in_array($good_id, $good_ids))
                        unset($res[array_search($good_id, $res)]);
                }
            }
        }

        if ($first_step) {
            $criteria = new CDbCriteria;
            $criteria->compare('category_id', $catId, false);
            if (!empty($brands))
                $criteria->compare('brand_id', $brands, false);
            if (!empty($price) && !empty($price['min']))
                $criteria->condition .= ' AND price >= ' . $price["min"];
            if (!empty($price) && !empty($price['max']))
                $criteria->condition .= ' AND price <= ' . $price["max"];
            if (!empty($_POST['order']))
                $criteria->order = $_POST['order'] . ' ';

            $count = Good::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 10;
            $pages->setCurrentPage($_POST['page']);
            $pages->applyLimit($criteria);
            $goods = Good::model()->with(array('goodImages'))->findAll($criteria);
        } else {
            if (count($res) == 0) {
                echo 'Ничего не найдено по этим критериям';
                return;
            }

            $new_res = array();
            foreach ($res as $value) {
                $new_res [] = $value;
            }
            $count = count($new_res);
            $criteria = new CDbCriteria;
            $pages = new CPagination($count);
            $pages->pageSize = 10;
            $pages->setCurrentPage($_POST['page']);
            $pages->applyLimit($criteria);
            $criteria->compare('id', $new_res);
            if (!empty($_POST['order']))
                $criteria->order = $_POST['order'] . ' ';
            $goods = Good::model()->with(array('goodImages'))->findAll($criteria);
        }

        $this->renderPartial('search-result', array(
                                                   'goods' => $goods,
                                                   'pages' => $pages,
                                                   'count' => $count,
                                              ));
    }

}