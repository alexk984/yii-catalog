<?php

/**
 * This is the model class for table "review".
 *
 * The followings are the available columns in table 'review':
 * @property string $id
 * @property string $good_id
 * @property integer $user_id
 * @property integer $rating
 * @property string $positive
 * @property string $negative
 * @property string $comment
 * @property integer $using_experience
 * @property string $date
 *
 * The followings are the available model relations:
 * @property UserExpDesc $usingExperience0
 * @property Good $good
 * @property Users $user
 * @property RatingDesc $rating0
 */
class Review extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @return Review the static model class
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
        return 'review';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('good_id, user_id, rating, comment, using_experience, date', 'required'),
            array('user_id, rating, using_experience', 'numerical', 'integerOnly' => true),
            array('rating, using_experience', 'numerical', 'min' => 1,
                  'tooSmall' => 'Вы должны указать {attribute}'),
            array('positive, negative, comment, ', 'length', 'min' => 10,
                  'tooShort' => 'Слишком кратко'
            ),
            array('good_id', 'length', 'max' => 11),
            array('positive, negative, comment', 'length', 'max' => 4000),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, good_id, user_id, rating, positive, negative, comment, using_experience, date', 'safe', 'on' => 'search'),
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
            'usingExperience0' => array(self::BELONGS_TO, 'UserExpDesc', 'using_experience'),
            'good' => array(self::BELONGS_TO, 'Good', 'good_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'rating0' => array(self::BELONGS_TO, 'RatingDesc', 'rating'),
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
            'user_id' => 'User',
            'rating' => 'Рейтинг',
            'positive' => 'Преимущества',
            'negative' => 'Недостатки',
            'comment' => 'Комментарий',
            'using_experience' => 'Опыт использования',
            'date' => 'Date',
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
        $criteria->compare('good_id', $this->good_id, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('positive', $this->positive, true);
        $criteria->compare('negative', $this->negative, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('using_experience', $this->using_experience);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }

    /**
     * Save rating if need
     * @return void
     */
    public function afterSave()
    {
        $rating = Rating::model()->findByAttributes(array(
                                                         'good_id' => $this->good_id,
                                                         'user_id' => $this->user_id,
                                                    ));
        if ($rating == null){
            $rating = new Rating;
            $rating->value = $this->rating;
            $rating->good_id = $this->good_id;
            $rating->user_id = $this->user_id;
            $rating->Save();
        }
        elseif ($rating->value != $this->rating){
            $rating->value = $this->rating;
            $rating->Save();
        }
    }

}