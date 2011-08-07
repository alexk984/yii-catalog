<?php

/**
 * This is the model class for table "attr_group".
 *
 * The followings are the available columns in table 'attr_group':
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property integer $pos
 *
 * The followings are the available model relations:
 * @property Attr[] $attrs
 * @property Category $category
 */
class AttrGroup extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @return AttrGroup the static model class
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
        return 'attr_group';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, name', 'required'),
            array('pos', 'numerical', 'integerOnly' => true),
            array('category_id', 'length', 'max' => 10),
            array('name', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, name, pos', 'safe', 'on' => 'search'),
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
            'attrs' => array(self::HAS_MANY, 'Attr', 'attr_group_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'category_id' => 'Категория',
            'name' => 'Название группы',
            'pos' => 'Позиция',
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

        $criteria->compare('id', $this->id, false);
        $criteria->compare('category_id', $this->category_id, false);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('pos', $this->pos);
        //$criteria->with = 'category';
        $criteria->order = 'category_id, pos';

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                              'pagination' => array('pageSize' => 30),
                                                         ));
    }

}