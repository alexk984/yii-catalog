<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $root
 * @property string $lft
 * @property string $rgt
 * @property integer $level
 * @property string $name
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property Attr[] $attrs
 * @property Good[] $goods
 */
class Category extends CActiveRecord
{

    public $parentId;

    /**
     * Returns the static model of the specified AR class.
     * @return Category the static model class
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
        return 'category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, alias', 'required'),
            array('level, parentId', 'numerical', 'integerOnly' => true),
            array('root, lft, rgt', 'length', 'max' => 10),
            array('name', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, root, lft, rgt, level, name', 'safe', 'on' => 'search'),
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
            'attrGroups' => array(self::HAS_MANY, 'AttrGroup', 'category_id'),
            'goods' => array(self::HAS_MANY, 'Good', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'level' => 'Level',
            'name' => Yii::t('main-ui', 'Category name'),
            'parentId' => Yii::t('main-ui', 'Parent category'),
            'alias' => 'Урл'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = $this->tree->hasManyRoots
                ? $this->tree->rootAttribute . ', ' . $this->tree->leftAttribute
                : $this->tree->leftAttribute;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('root', $this->root, true);
        $criteria->compare('lft', $this->lft, true);
        $criteria->compare('rgt', $this->rgt, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                              'pagination' => array(
                                                                  'pageSize' => 50,
                                                              ),
                                                              'sort' => array(
                                                                  'defaultOrder' => 'root ASC, lft ASC',
                                                              ),
                                                         ));
    }

    public function behaviors()
    {
        return array(
            'tree' => array(
                'class' => 'ext.trees.ENestedSetBehavior',
                'hasManyRoots'=>true,
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
            ),
        );
    }

    /**
     * Build tree-like array for display in DropDownList
     * using in admin panel
     * @static
     * @param bool $canSelectNonLeaf can user select category that have children
     * @return string[]
     */
    public static function TreeArray($canSelectNonLeaf = true)
    {
        if ($canSelectNonLeaf)
            return self::TreeArrayLeafCanSelected();
        else
            return self::TreeArrayLeafCannotSelected();
    }

    /**
     * Build tree-like array for display in DropDownList
     * Categories that have children cannot be selected
     * using in admin panel
     * @static
     * @return string[]
     */
    public static function TreeArrayLeafCannotSelected()
    {
        $roots = Category::model()->roots()->findAll();
        $res = array();
        foreach ($roots as $root) {
            if ($root->isLeaf())
                $res[$root->id] = $root->name;
            else
                $res[$root->name] = Category::GetChildrenForTreeArrayLeafCannotSelected($root);
        }

        return $res;
    }

    /**
     * Build tree-like array for the category
     * Categories that have children cannot be selected
     * @static
     * @param Category $elem the category for which builds array
     * @return string[]
     */
    private static function GetChildrenForTreeArrayLeafCannotSelected($elem)
    {
        $res = array();
        $roots = $elem->children()->findAll();
        foreach ($roots as $root) {
            if ($root->isLeaf())
                $res[$root->id] = $root->name;
            else
                $res[$root->name] = Category::GetChildrenForTreeArrayLeafCannotSelected($root);
        }
        return $res;
    }

    /**
     * Build tree-like array for display in DropDownList
     * Categories that have children can be selected
     * using in admin panel
     * @static
     * @return string[]
     */
    public static function TreeArrayLeafCanSelected()
    {
        $roots = Category::model()->roots()->findAll();
        $res = array();
        foreach ($roots as $root) {
            $res[$root->id] = $root->GetStringName();
            if (!$root->isLeaf())
                $res = $res + Category::GetChildrenForTreeArrayLeafCanSelected($root, 1);
        }

        return $res;
    }

    /**
     * Build tree-like array for the category
     * Categories that have children can be selected
     * @static
     * @param Category $elem the category for which builds array
     * @param integer $i nesting level
     * @return string[]
     */
    private static function GetChildrenForTreeArrayLeafCanSelected($elem, $i)
    {
        $res = array();
        $roots = $elem->children()->findAll();
        foreach ($roots as $root) {
            $res[$root->id] = $root->GetStringName();
            if (!$root->isLeaf())
                $res = $res + Category::GetChildrenForTreeArrayLeafCanSelected($root, $i + 1);
        }
        return $res;
    }

    /**
     * Return category name for dropDownList with spaces before it for tree-like visual view
     * @return string category name with spaces
     */
    public function GetStringName()
    {
        if ($this->isLeaf())
            return str_repeat('&nbsp', ($this->level - 1) * 4) . $this->name;
        else
            return str_repeat('&nbsp', ($this->level - 1) * 4) . "<b>" . $this->name . "</b>";
    }

    /**
     * @return Attr [] category attributes
     */
    public function GetCategoryAttributes()
    {
        $attrs = array();
        foreach ($this->attrGroups as $group) {
            foreach ($group->attrs as $attr) {
                $attrs[] = $attr;
            }
        }

        return $attrs;
    }
}