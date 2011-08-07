<?php

/**
 * 
 */
class CatalogTest extends CDbTestCase {

        public $fixtures = array(
                'category' => 'Category',
                'brand' => 'Brand',
                'attr' => 'Attr',
                'good' => 'Good',
                'attr_value' => 'AttrValue',
                'category_has_Attr' => 'CategoryHasAttr',
                'good_Attr_Val' => 'GoodAttrVal',
        );

        /*public function testAddAttrValueId() {
                $good = Good::model()->findByPk('1');
                $this->assertEquals('LG Flatron W2343S', $good->name);
                $this->assertTrue($good->AddAttr('2'));

                $model = GoodAttrVal::model()->findByAttributes(array(
                                'attr_value_id' => '2',
                                'good_id' => '1',
                        ));
                $this->assertNotNull($model);
        }

        public function testAddNewAttrValue() {
                $good = Good::model()->findByPk('1');
                $this->assertTrue($good->AddNewAttr('1', '19'));
                $newAttrVal = AttrValue::model()->findByAttributes(array(
                        'attr_id'=>'1',
                        'value'=>'19'
                ));
                $this->assertNotNull($newAttrVal);
                $model = GoodAttrVal::model()->findByAttributes(array(
                                'attr_value_id' => $newAttrVal->id,
                                'good_id' => '1',
                        ));
                $this->assertNotNull($model);
        }*/
        
        public function testGetArrayForDropDownList(){
                $res = Category::GetArrayForDropDownList();
                $testArr = array(
                        'Computers'=>array(
                                '2'=>'Monitors',
                                '3'=>'Notebooks',
                        ),
                );
                $this->assertEquals($res, $testArr);
        }

        public function testGetArrayForDropDownList2(){
                $res = Category::GetArrayForDropDownList2();
                $testArr = array(
                        '1'=>'Computers',
                        '2'=>'--Monitors',
                        '3'=>'--Notebooks',
                );
                $this->assertEquals($res, $testArr);
        }
}

?>
