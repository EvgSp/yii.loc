<?php

class PriceStructureController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
		$firmName=$this->loadModel($id)->firm;
		$fileId=Firm::model()->findByAttributes(array('firm_name'=>$firmName));

                $fileId->attachBehavior('fileProcess', [ 
                    'class' => 'application.components.behaviors.csvFileProcessBehavior',
                    'numberOfRows' => 40,
                ]);                
		$fileContent=$fileId->getCvsFileContent($fileId);
                $fileId->detachBehavior('fileProcess');
		
		if($fileContent) 
			$dataProvider=new CArrayDataProvider($fileContent, array('pagination'=>false, 'keyField' => false,));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'dataProvider'=>$dataProvider,
		));

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PriceStructure;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PriceStructure']))
		{
			$model->attributes=$_POST['PriceStructure'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PriceStructure']))
		{
			$model->attributes=$_POST['PriceStructure'];
			if($model->save()){
				Yii::app()->user->setFlash('successDataSave', "Сохранение прошло успешно!");	
			}
			else{
				Yii::app()->user->setFlash('successDataSave', "Ошибка при сохранении данных!");
			}
		}

		$firmName=$this->loadModel($id)->firm;
		$fileId=Firm::model()->findByAttributes(array('firm_name'=>$firmName));

                $fileId->attachBehavior('fileProcess', [ 
                    'class' => 'application.components.behaviors.csvFileProcessBehavior',
                    'numberOfRows' => 40,
                ]);                
		$fileContent=$fileId->getCvsFileContent($fileId);
                $fileId->detachBehavior($fileId);
				
		if($fileContent) 
			$dataProvider=new CArrayDataProvider($fileContent, array('pagination'=>false, 'keyField' => false,));
		$this->render('update',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PriceStructure');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PriceStructure('search');
//		$model=$model->model()->with('file');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PriceStructure']))
			$model->attributes=$_GET['PriceStructure'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PriceStructure the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PriceStructure::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PriceStructure $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-structure-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
