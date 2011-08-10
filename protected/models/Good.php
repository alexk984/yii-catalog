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
     * Get one good image with current size
     * @param string $size image size
     * @return string html img tag with image
     */
    public function GetGoodImage($size = null)
    {
        $images = $this->goodImages;
        if (count($images) == 0 && is_null($size))
            return CHtml::image('/images/empty.png');
        elseif (count($images) == 0)
            return CHtml::image('/images/' . $size . '_empty.png');

        if (is_null($size))
            return CHtml::image('/images/goods/' . $images[0]->image);
        else
            return CHtml::image('/images/goods/' . $size . '_' . $images[0]->image);
    }

    /**
     * Builds html code with image list for gallery
     * @param string $size image size
     * @return string html code with images for gallery
     */
    public function GetGoodImagesForGallery($size = null)
    {
        $images = $this->goodImages;
        if (empty($images) || count($images) == 0)
            return '';
        $first_slide = true;
        $res = '';
        $num_slides = 2;
        $num_photos = 0;
        $no_display = '';
        foreach ($images as $image) {
            if ($first_slide) {
                $res .= '<div class="main-gallery-block"><a href="/images/goods/' . $image->image . '" rel="prettyPhoto">' . CHtml::image('/images/goods/' . $size . '_' . $image->image) . '</a>';
                $first_slide = false;
                $num_photos++;
            } else {
                if ($num_slides == 2) {
                    if ($num_photos > 2)
                        $no_display = ' ghide';
                    $res .= '</div><div class="gallery-block' . $no_display . '"><a href="/images/goods/' . $image->image . '" rel="prettyPhoto">' . CHtml::image('/images/goods/xs_' . $image->image) . '</a>';
                    $num_slides = 0;
                }
                else
                    $res .= '<a href="/images/goods/' . $image->image . '" rel="prettyPhoto">' . CHtml::image('/images/goods/xs_' . $image->image) . '</a>';
                $num_photos++;
                $num_slides++;
            }
        }
        $res .= '</div>';
        return $res;
    }

    /**
     * Return main attribute values for the good
     * @return GoodAttrVal[] main good attribute values
     */
    public function GetMainAttributes()
    {
        $features = GoodAttrVal::model()->with(array(
                                                    'attr' => array(
                                                        'select' => 'name, type, template'
                                                    ),
                                                    'attrValue' => array(
                                                        'select' => 'value'
                                                    ),
                                               ))->findAll(array('condition' => 'good_id=' . $this->id .
                                                                                " AND attr.is_main = 1 ",
                                                                'order' => 'attr.global_pos',
                                                                'select' => 'attr_value_id,attr_id, value'
                                                           ));
        foreach ($features as $feature) {
            if ($feature->attr->type == 1)
                $feature->value = $feature->attrValue->value;
        }

        return $features;
    }

    /**
     * Return 3 random goods
     * @return Good[] random goods
     */
    public function similar()
    {
        $goods = Good::model()->with(array('goodImages'))->findAll(array(
                                                                        'condition' => 'price <> 0',
                                                                        'order' => 'RAND()',
                                                                        'limit' => 3));
        return $goods;
    }

    /**
     * Return rating in specific format
     * @return string rating in specific format
     */
    public function GetFormattedRating()
    {
        $rating = $this->rating / 100;
        $rating = number_format(round($rating * 4) / 4, 2);
        $rating = sprintf("%1.2f", $rating);
        $rating = trim(rtrim($rating, "0"), '.');
        return $rating;
    }

    /**
     * Return user mark for the good
     * @return string user mark for the good
     */
    public function GetUserRating()
    {
        $value = Rating::model()->findByAttributes(array(
                                                        'good_id' => $this->id,
                                                        'user_id' => Yii::app()->user->id,
                                                   ));
        //echo $value;
        if (isset($value))
            return sprintf("%d", $value->value);
        else
            return '0';
    }

    /**
     * Get user review for this good
     * @return Review user review for this good
     */
    public function GetReview()
    {
        $review = Review::model()->findByAttributes(array(
                                                         'good_id' => $this->id,
                                                         'user_id' => Yii::app()->user->id));
        return $review;
    }

    /**
     * Show good rating with css styles
     */
    public function ShowRating()
    {
        $good_rating = $this->GetFormattedRating();
        echo '<div class="x-rating x-rate-' . round($good_rating * 4) . '"></div>';
    }
}