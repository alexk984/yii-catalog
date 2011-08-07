<?php

/**
 * This is the model class for table "good_attr_val".
 *
 * The followings are the available columns in table 'good_attr_val':
 * @property string $id
 * @property string $good_id
 * @property string $attr_value_id
 * @property string $attr_id
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property Attr $attr
 * @property AttrValue $attrValue
 * @property Good $good
 */
class GoodAttrVal extends CActiveRecord
{
    public $tableAlias = 'attrValue';
	/**
	 * Returns the static model of the specified AR class.
	 * @return GoodAttrVal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'good_attr_val';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('good_id', 'required'),
			array('value', 'numerical', 'integerOnly'=>true),
			array('good_id', 'length', 'max'=>11),
			array('attr_value_id, attr_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, good_id, attr_value_id, attr_id, value', 'safe', 'on'=>'search'),
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
			'attrValue' => array(self::BELONGS_TO, 'AttrValue', 'attr_value_id'),
			'good' => array(self::BELONGS_TO, 'Good', 'good_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'good_id' => 'Good',
			'attr_value_id' => 'Attr Value',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('good_id',$this->good_id,true);
		$criteria->compare('attr_value_id',$this->attr_value_id,true);
		$criteria->compare('attr_id',$this->attr_id,true);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Return good attribute value
     * @return string attribute value
     */
    public function GetAttrValue(){
        if (!empty($this->value))
            return $this->value;
        if ($this->attr_value_id !== null)
            return $this->attrValue->value;
        else
            return '';
    }
}