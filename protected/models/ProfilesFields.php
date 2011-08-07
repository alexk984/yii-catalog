<?php

/**
 * This is the model class for table "profiles_fields".
 *
 * The followings are the available columns in table 'profiles_fields':
 * @property integer $id
 * @property string $varname
 * @property string $title
 * @property string $field_type
 * @property integer $field_size
 * @property integer $field_size_min
 * @property integer $required
 * @property string $match
 * @property string $range
 * @property string $error_message
 * @property string $other_validator
 * @property string $default
 * @property string $widget
 * @property string $widgetparams
 * @property integer $position
 * @property integer $visible
 *
 * The followings are the available model relations:
 */
class ProfilesFields extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProfilesFields the static model class
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
		return 'profiles_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('varname, title, field_type', 'required'),
			array('field_size, field_size_min, required, position, visible', 'numerical', 'integerOnly'=>true),
			array('varname, field_type', 'length', 'max'=>50),
			array('title, match, range, error_message, other_validator, default, widget', 'length', 'max'=>255),
			array('widgetparams', 'length', 'max'=>5000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, varname, title, field_type, field_size, field_size_min, required, match, range, error_message, other_validator, default, widget, widgetparams, position, visible', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'varname' => 'Varname',
			'title' => 'Title',
			'field_type' => 'Field Type',
			'field_size' => 'Field Size',
			'field_size_min' => 'Field Size Min',
			'required' => 'Required',
			'match' => 'Match',
			'range' => 'Range',
			'error_message' => 'Error Message',
			'other_validator' => 'Other Validator',
			'default' => 'Default',
			'widget' => 'Widget',
			'widgetparams' => 'Widgetparams',
			'position' => 'Position',
			'visible' => 'Visible',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('varname',$this->varname,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('field_type',$this->field_type,true);
		$criteria->compare('field_size',$this->field_size);
		$criteria->compare('field_size_min',$this->field_size_min);
		$criteria->compare('required',$this->required);
		$criteria->compare('match',$this->match,true);
		$criteria->compare('range',$this->range,true);
		$criteria->compare('error_message',$this->error_message,true);
		$criteria->compare('other_validator',$this->other_validator,true);
		$criteria->compare('default',$this->default,true);
		$criteria->compare('widget',$this->widget,true);
		$criteria->compare('widgetparams',$this->widgetparams,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('visible',$this->visible);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}