<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property integer $id
 * @property string $firm_name
 * @property integer $activity
 * @property string $rating
 * @property string $file_name
 * @property string $file_type
 * @property string $column_ceparator
 * @property string $text_ceparator
 * @property string $encoding
 * @property string $currency
 * @property string $exchange_rate
 * @property string $delivery_cost_correction
 * @property integer $delivery_time_correction
 *
 * The followings are the available model relations:
 * @property PriceStructure[] $fileStructures
 * @property ProductsData[] $productsDatas
 * @property Uploads[] $uploads
 */
class Firm extends CActiveRecord {

    private $handler;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'firm';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('firm_name, file_name, file_type', 'required'),
            array('firm_name', 'unique'),
            array('activity, delivery_time_correction', 'numerical', 'integerOnly' => true),
            array('activity', 'in', 'range' => Yii::app()->params['activity']),
            array('rating', 'length', 'max' => 4),
            array('firm_name', 'length', 'max' => 50),
            array('file_name', 'length', 'max' => 50),
            array('file_type', 'length', 'max' => 10),
            array('column_ceparator, text_ceparator', 'length', 'max' => 1),
            array('encoding', 'length', 'max' => 20),
            array('currency', 'length', 'max' => 40),
            array('currency', 'in', 'range' => Yii::app()->params['currency']),
            array('exchange_rate', 'length', 'max' => 9),
            array('delivery_cost_correction', 'length', 'max' => 8),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, firm_name, activity, rating, file_name, file_type, encoding, currency', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'fileStructures' => array(self::HAS_ONE, 'PriceStructure', 'firm_name'),
            'productsDatas' => array(self::HAS_MANY, 'ProductsData', 'firm_name'),
            'uploads' => array(self::HAS_MANY, 'Uploads', 'firm_name'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'firm_name' => 'Firm Name',
            'activity' => 'Activity',
            'rating' => 'Rating',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'column_ceparator' => 'Column Ceparator',
            'text_ceparator' => 'Text Ceparator',
            'encoding' => 'Encoding',
            'currency' => 'Currency',
            'exchange_rate' => 'Exchange Rate',
            'delivery_cost_correction' => 'Delivery Cost Correction',
            'delivery_time_correction' => 'Delivery Time Correction',
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

        $criteria->compare('firm_name', $this->firm_name);
        $criteria->compare('activity', $this->activity);
        $criteria->compare('rating', $this->rating, true);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('file_type', $this->file_type, true);
//		$criteria->compare('column_ceparator',$this->column_ceparator,true);
//		$criteria->compare('text_ceparator',$this->text_ceparator,true);
        $criteria->compare('encoding', $this->encoding, true);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('exchange_rate', $this->exchange_rate, true);
        $criteria->compare('delivery_cost_correction', $this->delivery_cost_correction, true);
        $criteria->compare('delivery_time_correction', $this->delivery_time_correction);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return File the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
