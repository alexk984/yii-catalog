<?php

/**
 * This is the model class for table "attr".
 *
 * The followings are the available columns in table 'attr':
 * @property string $id
 * @property string $name
 * @property string $attr_group_id
 * @property integer $is_main
 * @property integer $type
 * @property integer $pos
 * @property string $template
 * @property integer $global_pos
 * @property integer $filter
 *
 * The followings are the available model relations:
 * @property AttrGroup $attrGroup
 * @property AttrValue[] $attrValues
 * @property GoodAttrVal[] $goodAttrVals
 */
class Attr extends CActiveRecord {

	public $category;
	public $attr_group_name;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Attr the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	protected function afterConstruct(){
		//$this->category = $this->attrGroup->category_id;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'attr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('name, attr_group_id', 'required'),
				array('is_main, filter, type, pos, global_pos', 'numerical', 'integerOnly' => true),
				array('name, template', 'length', 'max' => 250),
				array('attr_group_id', 'length', 'max' => 10),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, name, attr_group_id, attr_group_name, is_main, type, pos, template, global_pos, category', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'attrGroup' => array(self::BELONGS_TO, 'AttrGroup', 'attr_group_id'),
				'attrValues' => array(self::HAS_MANY, 'AttrValue', 'attr_id'),
				'goodAttrVals' => array(self::HAS_MANY, 'GoodAttrVal', 'attr_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'name' => 'Название',
				'attr_group_id' => 'Группа характеристик',
				'is_main' => 'Отображать в кратком описании',
				'type' => 'Тип',
				'pos' => 'Позиция',
				'template' => 'Шаблон',
				'global_pos' => 'Глобальная позиция',
				'filter'=>'Осуществлять поиск по характеристике',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, false);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('attr_group_id', $this->attr_group_id, false);
		$criteria->compare('is_main', $this->is_main);
		$criteria->compare('type', $this->type);
		$criteria->compare('pos', $this->pos);
		$criteria->compare('template', $this->template, true);
		$criteria->compare('global_pos', $this->global_pos);
		$criteria->compare('filter', $this->filter);
		$criteria->compare('attrGroup.category_id', $this->category);
		$criteria->compare('attrGroup.name', $this->attr_group_name, true);
		$criteria->with = 'attrGroup';

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
				'pagination' => array('pageSize' => 30),
		));
	}

    /**
     * Return attribute type description
     * @return string attribute type
     */
	public function GetType() {
		if ($this->type == 1)
			return "string";
		if ($this->type == 2)
			return "boolean";
		if ($this->type == 3)
			return "integer";
	}

    /**
     * Return attribute value showing to user, formed by template or yes/no for boolean
     * @param string $value attribute value from database
     * @return string attribute value showing to user
     */
	public function GetValue($value) {
		if ($this->type == '2') {
			if ($value == '1')
				return 'да';
			if ($value == '2')
				return 'нет';
		}elseif (empty($this->template))
			return $value;

		if (strpos($this->template, '{val}'))
			return str_replace('{val}', $value, $this->template);
		else
			return $value . $this->template;
	}

}