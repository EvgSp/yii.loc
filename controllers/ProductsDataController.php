<?php

class ProductsDataController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
		);
	}

/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('processing'),
				'users'=>array('@'),
			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* select file
	* open file
	* add file content in array
	* save array in DB
	* 
	* Text_Highlighter_Renderer_BB@return
	*/
	public function actionProcessing()
	{		
	
		// if get variable fileload
		if(isset($_POST['Firm'])){
                        $firmName=$_POST['Firm'];
			$modelFile=Firm::model()->findByAttributes(array('firm_name'=>$firmName));
			$modelStructure=PriceStructure::model()->findByAttributes(array('firm'=>$firmName));
			
			
			if($model->validate()){
				$model->fileName=CUploadedFile::getInstance($model,'fileName');
				if($model->fileName){
					$path=Yii::getPathOfAlias('webroot').'/upload/'.$model->fileName->getName();
					$isLoaded=$model->fileName->saveAs($path);
				}
			}
		}				
		
		$this->render('index');
	}

}