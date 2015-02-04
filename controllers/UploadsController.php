<?php

class UploadsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow', // allow authenticated user to perform 'index'
				'actions'=>array('index','fileprocesing'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Check which firms are chosen and uploads price lists selected companies  
	 */
	public function actionIndex(){
            if(isset($_POST['checkbox_list_name'])){        // if there is data from form
                // for each selected firm
                foreach ($_POST['checkbox_list_name'] as $firmName) {      
                
                    /* @todo uncomment this part after test finished
                    // make new record in table 'Uploads'
                    $uploadModel=new Uploads();
                    // get record of current firm from DB
                    $currentFirm=Firm::model()->find('firm_name=:fn',array(':fn'=>$firmName));
                    // if recording in the base is successful
                    
                    if($uploadModel->loadGoodsInBase($currentFirm)>0){
                        $fileName=$currentFirm->file_name;

                        $uploadModel->firm = $firmName;
                        $uploadModel->rows = 100; //loadGoodsInBase($firmName);
                        $uploadModel->size = myFileHelper::getFileSize($fileName);
                        $uploadModel->file_date = date('Y-m-d H:i:s', myFileHelper::getFileModificationTime($fileName));
                        }
                    $uploadModel->save();
                     */

                    $_SESSION['counter'] = array(0, time()+60);
                
                }
            }
            
            $firmModels=Firm::model()->findAll('activity=1');
            foreach ($firmModels as $firmModel) {
                $myArray[$firmModel->firm_name]=$firmModel->firm_name;
            }
                
            $this->render('index',array('myArray'=>$myArray));
        }    

	/**
	*
	* @firmName string value of firm_name will been seak
	* 
	* @return percent of file processing
	*/
	public function actionFileProcesing()
	{
            if (Yii::app()->request->isAjaxRequest) {

                if(isset($_GET['f0'])){
                    foreach ($_SESSION['firm'] as $key=>$value){
                        unset($_SESSION['firm'][$key]);     
                    }

                    $i=0;
 
                    while (isset($_GET['f'.$i])){
                        $firmName=filter_var($_GET['f'.$i], FILTER_VALIDATE_REGEXP, array('options'=>array('regexp'=>'/\w{3,20}/i')));
                        $_SESSION['firm'][$i]=array('name'=>$firmName, 'counter'=>0);  
                        $i++;
                    }
                }    

                $i=0;
                while($_SESSION['firm'][$i]['counter'] >= 100){
                    $i++;
                }
                
                $_SESSION['firm'][$i]['counter']+=3;
                
                if($_SESSION['firm'][$i]['counter'] >= 100){
                    if(isset($_SESSION['firm'][$i+1]['counter'])){
                        $_SESSION['firm'][$i]['counter']=100;
                    }
                    else{
                        $_SESSION['firm'][$i]['counter']=101;
                    }
                }
                
                echo $_SESSION['firm'][$i]['counter']+$i*100;
                
            }    
                
		
//		$model=$this->loadModel($id);	

//		$model->fileProcessing();		

//		throw new CHttpException(500,'end of process.');

	}	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Uploads the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Uploads::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Uploads $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='uploads-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
