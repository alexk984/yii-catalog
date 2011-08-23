<?php

/**
 * This is the model class for table "brand".
 *
 * The followings are the available columns in table 'brand':
 * @property string $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Good[] $goods
 */
class Brand extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Brand the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'brand';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 250),
            array('name', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'goods' => array(self::HAS_MANY, 'Good', 'brand_id'),
            'goodsCount' => array(self::STAT, 'Good', 'brand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Производитель',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        //$criteria->order = 'name';

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                              'pagination' => array('pageSize' => 15,),
                                                         ));
    }

    public function defaultScope()
    {
        return array(
            //'order' => 'name',
        );
    }

    /**
     * @static Return brands list for category, sorted by brand goods count
     * @param $category_id
     * @return Brand[] brands, whose goods belongs to the category
     */
    public static function GetCategoryBrands($category_id)
    {
        $brands = Brand::model()->with(array('goodsCount' =>
                                       array('condition' => 'category_id=' . $category_id,
                                       )))->findAll();
        foreach ($brands as $i => $brand)
            if ($brand->goodsCount == 0)
                unset($brands[$i]);

        usort($brands, 'CAlexHelper::CompareGoodsCount');

        return $brands;
    }

}