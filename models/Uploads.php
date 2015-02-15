<?php

/**
 * This is the model class for table "uploads".
 *
 * The followings are the available columns in table 'uploads':
 * @property string $id
 * @property string $firm
 * @property integer $rows
 * @property integer $size
 * @property integer $file_date
 * @property integer $upload_date
 *
 * The followings are the available model relations:
 * @property Firm $firm0
 */
class Uploads extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'uploads';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('firm, rows, size, file_date', 'required'),
            array('rows, size', 'numerical', 'integerOnly' => true),
            array('file_date', 'safe'),
            array('id, size', 'length', 'max' => 10),
            array('firm', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, firm, rows, size, file_date, upload_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'firm0' => array(self::BELONGS_TO, 'Firm', 'firm'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'firm' => 'Firm',
            'rows' => 'Rows',
            'size' => 'Size',
            'file_date' => 'File Date',
            'upload_date' => 'Upload Date',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('firm', $this->firm, true);
        $criteria->compare('rows', $this->rows);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('file_date', $this->file_date, true);
        $criteria->compare('upload_date', $this->upload_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Uploads the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
