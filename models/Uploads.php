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
     * open this file for reading
     * read the file content to array
     * write array to daroduct_data table
     * @param object $firm the instance of the 'Firm' model class
     * @return
     */
    public function loadGoodsInBase($firm) {
        // 	
        $dbConnention = Yii::app()->db;
        $dbCommand = new CDbCommand($dbConnention);

        $handler = myFileHelper::getFilePointer($firm->file_name);

        $columnNames = PriceStructure::model()->findByAttributes(array('firm' => $firm->firm_name))->getColumnNames();

        while (!feof($handler)) {  // cycle to the end of file
            // make an array where keys are the names of the fields in DB and values are the corresponding data from the file  	
            $fileContent = $this->csvFileToArray($handler, 100);  // selection by 100 rows
            $fileContent = $this->fillColumnNames($fileContent, $columnNames);
            $fileContent = $this->removeUnnamedColumns($fileContent);

            // one row contains the data for one product and mast be recorded in one record in the database	
            foreach ($fileContent as $arrayValue) {  // take row
                // check if there is such record in the DB
                $sql = "SELECT * FROM products_data WHERE firm = '" . $firm->firm_name . "'";
                if ($arrayValue['item_id'])
                    $sql.=" AND item_id = '" . mysql_real_escape_string($arrayValue['item_id']) . "'";
                if ($arrayValue['name'])
                    $sql.=" AND name = '" . mysql_real_escape_string($arrayValue['name']) . "'";

                $sql.=" LIMIT 1";

                $dbCommand->text = $sql;

                // if the record does not exist, make new record	
                if (!$dbCommand->queryRow()) {
                    $insertPart = '';
                    $valuePart = '';
                    // prepare data for the query

                    foreach ($arrayValue as $key => $value) {
                        if ($key == 'name') {   // name mast be more then 4 symbols
                            if (strlen($value) < 4)
                                continue 2;
                        }

                        if ($key == 'price') {   // price mast be greate then 0
                            settype($value, "float");
                            if ($value <= 0)
                                continue 2;
                        }

                        $insertPart.=", " . $key;
                        $valuePart.=", '" . mysql_real_escape_string($value) . "'";
                    }

                    if (!strpos($insertPart, 'name'))  //if there is not 'name' column in the file
                        continue;
                    if (!strpos($insertPart, 'price'))  //if there is not 'price' column in the file
                        continue;

                    $insertPart = substr($insertPart, 2);  // remove thirst comma and whitespace			
                    $valuePart = substr($valuePart, 2);

                    // make new query string	
                    $dbCommand->text = "INSERT INTO products_data (firm, " . $insertPart . ") VALUES ('" . $this->firm_name . "', " . $valuePart . ')';
                    // write data to the DB	
                    $dbCommand->execute();
                }
            }
        }
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
