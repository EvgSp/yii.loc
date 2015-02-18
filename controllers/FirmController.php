<?php

class FirmController extends Controller
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
				'actions'=>array('index','view','FileProcesing'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'fileprocesing'),
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
		$model=$this->loadModel($id);
		
                $handler = myFileHelper::getFilePointer($model->file_name);                
                $model->attachBehavior('fileProcess', [ 
                    'class' => 'application.components.behaviors.csvFileProcessBehavior',
                    'handler' => $handler,
                    'numberOfRows' => 40,
                ]);
		$fileContent=$model->getCvsFileContent($model);
                $model->detachBehavior('fileProcess');
		
		if($fileContent) 
			$dataProvider=new CArrayDataProvider($fileContent, array('pagination'=>false, 'keyField' => false,));
		$this->render('view',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'id'=>$id,
		));		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Firm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Firm']))
		{
			$model->attributes=$_POST['Firm'];
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

		if(isset($_POST['Firm']))
		{
			$model->attributes=$_POST['Firm'];
			if($model->save()){
				Yii::app()->user->setFlash('successDataSave', "Сохранение прошло успешно!");	
			}
			else{
				Yii::app()->user->setFlash('successDataSave', "Ошибка при сохранении данных!");
			}	

		}
		
                $handler = myFileHelper::getFilePointer($model->file_name);                
                $model->attachBehavior('fileProcess', [ 
                    'class' => 'application.components.behaviors.csvFileProcessBehavior',
                    'handler' => $handler,
                    'numberOfRows' => 40,
                ]);
                $fileContent=$model->getCvsFileContent($model);		// get the file contents
                $model->detachBehavior('fileProcess');
		
		if($fileContent) 
			$dataProvider=new CArrayDataProvider($fileContent, array('pagination'=>false, 'keyField' => false, ));
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
		$dataProvider=new CActiveDataProvider('Firm');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Firm('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Firm']))
			$model->attributes=$_GET['Firm'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Firm the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Firm::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Firm $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
