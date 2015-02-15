<?php

/**
 * This is the model class for table "products_data".
 *
 * The followings are the available columns in table 'products_data':
 * @property integer $id
 * @property string $firm
 * @property string $change_date
 * @property string $item_id
 * @property string $name
 * @property string $description
 * @property string $availability
 * @property string $price
 * @property string $bonus
 * @property string $shipping_cost
 * @property string $product_page
 * @property string $sourse_page
 *
 * The followings are the available model relations:
 * @property Intersections[] $intersections
 * @property Firm $firm0
 */
class ProductsData extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firm, change_date, name, price', 'required'),
			array('firm, availability', 'length', 'max'=>50),
			array('item_id', 'length', 'max'=>25),
			array('name', 'length', 'max'=>150),
			array('description', 'length', 'max'=>250),
			array('price, bonus, shipping_cost', 'length', 'max'=>9),
			array('product_page, sourse_page', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firm, change_date, item_id, name, description, availability, price, bonus, shipping_cost, product_page, sourse_page', 'safe', 'on'=>'search'),
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
			'intersections' => array(self::HAS_MANY, 'Intersections', 'data_id'),
			'firm0' => array(self::BELONGS_TO, 'Firm', 'firm'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firm' => 'Firm',
			'change_date' => 'Date of change',
			'item_id' => 'Item',
			'name' => 'Name',
			'description' => 'Description',
			'availability' => 'Availability',
			'price' => 'Price',
			'bonus' => 'Bonus',
			'shipping_cost' => 'Shipping Cost',
			'product_page' => 'Product Page',
			'sourse_page' => 'Sourse Page',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('firm',$this->firm,true);
		$criteria->compare('change_date',$this->change_date,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('availability',$this->availability,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('bonus',$this->bonus,true);
		$criteria->compare('shipping_cost',$this->shipping_cost,true);
		$criteria->compare('product_page',$this->product_page,true);
		$criteria->compare('sourse_page',$this->sourse_page,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    /**
     * read data from the file
     * check out if the DB contains the current data
     * write new data in the DB
     * @param file pointer resourse $handler
     * @param string $firmName the name of the current firm
     * @return 
     */
    public function processFile($handler, $firmName) {
       
        $fileContent = $this->getCvsFileContent($handler, $firmName);
        
    // one row contains the data for one product and must be recorded in one record in the database	
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

    /**
     * Returns the first $numberOfRows rows of CSV file encoded in UTF-8
     * @param file pointer resourse $handler
     * @param string $firmName name of the current firm 
     * @return array
     */
    public function getCvsFileContent($handler, $firmName) {
        $numberOfRows=100;
        
        $this->attachBehavior('fileProcessing', new csvFileProcessBehavior);
    
    // take data from DB    
        $columnNames = PriceStructure::model()->findByAttributes([ 'firm' => $firmName ])->getColumnNames();
        $firm = Firm::model()->find('firm_name=:fn',array(':fn'=>$firmName));

    // take 100 lines ffrom file that indicates the handler
        $fileContent = $this->csvFileToArray($handler, $firm->column_separator, $firm->text_separator, $numberOfRows);
    // rename columns in $fileContent by corresponding names from $columnNames
        $fileContent = $this->fillColumnNames($fileContent, $columnNames);
    // remove unnamed columns    
        $fileContent = $this->removeUnnamedColumns($fileContent);
        
        $this->detachBehaviors('fileProcessing');

        return $fileContent;
    }     

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductsData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
