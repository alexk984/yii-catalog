<?php

/**
 * This is the model class for table "attr_value".
 *
 * The followings are the available columns in table 'attr_value':
 * @property string $id
 * @property string $attr_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Attr $attr
 * @property GoodAttrVal[] $goodAttrVals
 */
class AttrValue extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @return AttrValue the static model class
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
        return 'attr_value';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('attr_id, value', 'required'),
            array('attr_id', 'length', 'max' => 10),
            array('value', 'length', 'max' => 1500),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, attr_id, value', 'safe', 'on' => 'search'),
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
            'attr' => array(self::BELONGS_TO, 'Attr', 'attr_id'),
            'goodAttrVals' => array(self::HAS_MANY, 'GoodAttrVal', 'attr_value_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'attr_id' => 'Attr',
            'value' => 'Value',
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
        $criteria->compare('attr_id', $this->attr_id, true);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }
}