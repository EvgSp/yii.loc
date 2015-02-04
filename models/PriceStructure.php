<?php

/**
 * This is the model class for table "file_structure".
 *
 * The followings are the available columns in table 'file_structure':
 * @property integer $id
 * @property string $firm
 * @property integer $item_id
 * @property integer $name
 * @property integer $description
 * @property integer $availability
 * @property integer $price
 * @property integer $bonus
 * @property integer $shipping_cost
 * @property integer $product_page
 * @property integer $sourse_page
 *
 * The followings are the available model relations:
 * @property Firm $file
 */
class PriceStructure extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'price_structure';
    }

    /**
     * var is used for search filter
     */
    public $fileNameSearch;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('firm, name, price', 'required'),
            array('id, firm', 'unique'),
            array('item_id, name, description, availability, price, bonus, shipping_cost, product_page, sourse_page', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, firm, item_id, name, description, availability, price, bonus, shipping_cost, product_page, sourse_page, fileNameSearch', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'file' => array(self::BELONGS_TO, 'Firm', 'firm'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'firm' => 'Firm Name',
            'item_id' => 'Item Id',
            'name' => 'Item Name',
            'description' => 'Description',
            'availability' => 'Availability',
            'price' => 'Price',
            'bonus' => 'Bonus',
            'shipping_cost' => 'Delivery Cost',
            'product_page' => 'Product Page URL',
            'sourse_page' => 'Sourse URL',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

//		$criteria->together=true;
//		$criteria->with=array('file');

        $criteria->compare('id', $this->id);
        $criteria->compare('firm', $this->firm);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('name', $this->name);
        $criteria->compare('description', $this->description);
        $criteria->compare('availability', $this->availability);
        $criteria->compare('price', $this->price);
        $criteria->compare('bonus', $this->bonus);
        $criteria->compare('shipping_cost', $this->shipping_cost);
        $criteria->compare('product_page', $this->product_page);
        $criteria->compare('sourse', $this->sourse_page);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * make an array from current row of file_structure table of DB
     * each key is the string which is constructed by combining the value of record and 'c' letter. 
     * each value is the name of table fild   
     * @return array 
     */
    public function getColumnNames() {
        $result = array();

        if ($this) {

            $i = 0;
            foreach ($this as $key => $value) {
                if ($i > 1) {
                    if ($value > 0) {
                        $result[$value . 'c'] = $key;
                    }
                }
                $i++;
            }
        }

        return $result;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PriceStructure the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
