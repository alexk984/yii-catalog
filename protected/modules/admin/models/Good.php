<?php

/**
 * This is the model class for table "good".
 *
 * The followings are the available columns in table 'good':
 * @property string $id
 * @property string $name
 * @property string $brand_id
 * @property string $category_id
 * @property string $price
 * @property string $date
 * @property integer $rating
 *
 * The followings are the available model relations:
 * @property Brand $brand
 * @property Category $category
 * @property GoodAttrVal[] $goodAttrVals
 * @property GoodImage[] $goodImages
 * @property Rating[] $ratings
 * @property Review[] $reviews
 */
class Good extends CActiveRecord implements IECartPosition
{

    public $image;

    /**
     * Returns the static model of the specified AR class.
     * @return Good the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function getId()
    {
        return $this->id;
    }

    function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'good';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, brand_id, category_id', 'required'),
            array('rating', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 250),
            array('brand_id', 'length', 'max' => 11),
            array('category_id, price', 'length', 'max' => 10),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, brand_id, category_id, price, date, rating', 'safe', 'on' => 'search'),
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
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'goodAttrVals' => array(self::HAS_MANY, 'GoodAttrVal', 'good_id'),
            'goodImages' => array(self::HAS_MANY, 'GoodImage', 'good_id'),
            'ratings' => array(self::HAS_MANY, 'Rating', 'good_id'),
            'marksCount' => array(self::STAT, 'Rating', 'good_id'),
            'reviews' => array(self::HAS_MANY, 'Review', 'good_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название товара',
            'brand_id' => 'Брэнд',
            'category_id' => 'Категория товара',
            'price' => 'Цена',
            'date' => 'Дата добавления',
            'rating' => 'Рейтинг',
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
        $criteria->compare('brand_id', $this->brand_id, false);
        $criteria->compare('category_id', $this->category_id, false);
        $criteria->compare('price', $this->price, false);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('rating', $this->rating, false);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }

    /**
     * Add attribute to good
     * @param int $attr_val_id attribute value id
     * @return bool success
     */
    public function AddAttr($attr_val_id)
    {
        $attr = new GoodAttrVal();
        $attr->attr_value_id = $attr_val_id;
        $attr->good_id = $this->id;
        return $attr->save();
    }

    /**
     * Add attribute to good
     * @param int $attr_id attribute id
     * @param string $value value
     * @return bool success
     */
    public function AddNewAttr($attr_id, $value)
    {
        $attr_value = new AttrValue;
        $attr_value->setAttributes(array(
                                        'attr_id' => $attr_id,
                                        'value' => $value,
                                   ));
        if (!$attr_value->save())
            new CDbException('error while creating new attribute value');

        $attr = new GoodAttrVal();
        $attr->attr_value_id = $attr_value->id;
        $attr->good_id = $this->id;
        return $attr->save();
    }

    /**
     * Return html code with good image list
     * @param string $size size of good images
     * @return string html code with image list
     */
    public function GetGoodImages($size = null)
    {
        $images = $this->goodImages;
        $html = '';
        foreach ($images as $image) {
            if (is_null($size))
                $html .= CHtml::image('/images/goods/' . $image->image);
            else
                $html .= CHtml::image('/images/goods/' . $size . '_' . $image->image);
        }
        return $html;
    }

    /**
     * Builds html code with image list with checkboxes
     * @param string $size image size
     * @return string html code with images and chekboxes
     */
    public function GetGoodImagesWithCheckbox($size = null)
    {
        $images = GoodImage::model()->findAllByAttributes(array('good_id' => $this->id));
        $html = '';
        foreach ($images as $image) {
            $name = 'Good[updatedimage][' . $image->id . ']';
            if (is_null($size))
                $html .= CHtml::checkBox($name, FALSE) . CHtml::image('/images/goods/' . $image->image);
            else
                $html .= CHtml::checkBox($name, FALSE) . CHtml::image('/images/goods/' . $size . '_' . $image->image);
        }
        return $html;
    }

    /**
     * Find good attribute value
     * @param Attr $attr attribute
     * @return string
     */
    public function findAttrValue($attr)
    {
        $res = GoodAttrVal::model()->findByAttributes(array('good_id' => $this->id, 'attr_id' => $attr->id));
        if (!isset($res))
            return '';
        if ($attr->type == '1')
            return $res->attr_value_id;
        elseif ($attr->type == '2' || $attr->type == '3') {
            return $res->value;
        }
    }

    /**
     * Save good images
     */
    public function SaveImages()
    {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/goods/';

        $i = 1;
        foreach ($this->image as $file) {
            if ($file === null)
                continue;
            $name = $this->id . '_' . substr(md5(microtime()), 0, 5) . '.' . $file->extensionName;
            while (file_exists($imagePath . $name))
                $name = $this->id . '_' . substr(md5(microtime()), 0, 5) . '.' . $file->extensionName;

            if (!empty($file)) {
                $file->saveAs($imagePath . $name);
                $i++;
                $image = new GoodImage();
                $image->good_id = $this->id;
                $image->image = $name;
                if ($image->save()) {
                    //create Thumbnails
                    $image = Yii::app()->image->load($imagePath . $name);
                    $image->resize(200, 200, Image::AUTO);
                    $image->save($imagePath . 's_' . $name);
                    $image = Yii::app()->image->load($imagePath . $name);
                    $image->resize(100, 100, Image::AUTO);
                    $image->save($imagePath . 'xs_' . $name);
                    $image = Yii::app()->image->load($imagePath . $name);
                    $image->resize(400, 400, Image::AUTO);
                    $image->save($imagePath . 'l_' . $name);
                }
            }
        }
    }

    /**
     * Save good attribute values from array
     * @param $data array with good attribute values
     */
    public function SaveFeatures($data)
    {
        //save good features
        if (!isset($data))
            return;
        //check exist good features first
        $featureValues = GoodAttrVal::model()->findAllByAttributes(array('good_id' => $this->id));

        foreach ($featureValues as $featureValue) {
            if (isset($featureValue->attrValue)) {
                if ($featureValue->attrValue->attr->type == '1') { //if feature is string type
                    if (empty($data['normal'][$featureValue->attrValue->attr->id]))
                        $featureValue->delete();
                    elseif ($data['normal'][$featureValue->attrValue->attr->id] !=
                            $featureValue->attr_value_id
                    ) {
                        if ($data['normal'][$featureValue->attrValue->attr->id] == '0')
                            $featureValue->attr_value_id = $data['new'][$featureValue->attrValue->attr->id];
                        else
                            $featureValue->attr_value_id = $data['normal'][$featureValue->attrValue->attr->id];
                        $featureValue->save();
                    }
                }
            } elseif (isset($featureValue->attr)) {
                if ($featureValue->attr->type == '2') { //if feature is boolean type
                    if ($data['normal'][$featureValue->attr->id] == '0')
                        $featureValue->delete();
                    elseif ($data['normal'][$featureValue->attr->id] != $featureValue->value) {
                        $featureValue->value = $data['normal'][$featureValue->attr->id];
                        $featureValue->save();
                    }
                } elseif ($featureValue->attr->type == '3') { //if feature is numeric type
                    if (empty($data['normal'][$featureValue->attr->id]))
                        $featureValue->delete();
                    elseif ($data['normal'][$featureValue->attr->id] != $featureValue->value) {
                        $featureValue->value = $data['normal'][$featureValue->attr->id];
                        $featureValue->save();
                    }
                }
            }
        }

        $newFeature = TRUE;
        foreach ($data['normal'] as $featureId => $feature) {
            foreach ($featureValues as $featureValue) {
                if ($featureValue->attrValue !== null && $featureValue->attrValue->attr_id == $featureId)
                    $newFeature = FALSE;
                if ($featureValue->attr->id == $featureId)
                    $newFeature = FALSE;
            }
            if ($newFeature) {
                $attr = Attr::model()->findByPk($featureId);

                $newGoodFeature = new GoodAttrVal;
                $newGoodFeature->good_id = $this->id;
                if ($attr->type == '1') {
                    if ($feature == '0' && !empty($data['new'][$featureId])) {
                        //add new attribute value
                        $newAttrValue = new AttrValue();
                        $newAttrValue->attr_id = $attr->id;
                        $newAttrValue->value = $data['new'][$featureId];
                        $newAttrValue->save();
                        $newAttrValue->refresh();
                        $newGoodFeature->attr_value_id = $newAttrValue->id;
                        $newGoodFeature->save();
                    } elseif ($feature != '0') {
                        $newGoodFeature->attr_value_id = $feature;
                        $newGoodFeature->save();
                    }
                } elseif ($attr->type == '2' && $feature != '0') {
                    $newGoodFeature->value = $feature;
                    $newGoodFeature->attr_id = $featureId;
                    $newGoodFeature->save();
                } elseif ($attr->type == '3' && !empty($feature)) {
                    $newGoodFeature->value = $feature;
                    $newGoodFeature->attr_id = $featureId;
                    $newGoodFeature->save();
                }
            }
            $newFeature = TRUE;
        }
    }

}