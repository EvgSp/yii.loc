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
