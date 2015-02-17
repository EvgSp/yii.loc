<?php

/*
 * take firm for processing from ajax request
 * find file for this firm
 * open file
 * save file handler in the $_SESSION variable
 * read the first 100 lines of the file and store the data in the DB
 * save file handler in the $_SESSION variable
 * calculate the procent of the file processing
 * send procent of processing to the client
 * 
 * if get another ajax request
 * read file handler from $_SESSION
 * read next 100 lines from the file
 * store the data in the DB
 * save file handler in the $_SESSION
 * calculate the procent of processing
 * send this prosent to the client
 * 
 * if file processing is finished
 * close file fandler
 * send to the client value 101 
 
 * if there was a failure
 * send to the client value 0 
 * 
 */

class UploadsController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'index'
                'actions' => array('index', 'fileprocesing'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Check which firms are chosen and uploads price lists selected companies  
     */
    public function actionIndex() {
        if (isset($_POST['checkbox_list_name'])) {        // if there is data from form
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

                $_SESSION['counter'] = array(0, time() + 60);
            }
        }

        $firmModels = Firm::model()->findAll('activity=1');
        foreach ($firmModels as $firmModel) {
            $myArray[$firmModel->firm_name] = $firmModel->firm_name;
        }

        $this->render('index', array('myArray' => $myArray));
    }

    /**
     *
     * @firmName string value of firm_name will been seak
     * 
     * @return percent of file processing
     */
    public function actionFileProcesing() {
        if (Yii::app()->request->isAjaxRequest) {
            // if there is GET request into Ajax request, save names of firms should be processed
            if (isset($_GET['f0'])) {
                $this->saveFirmIntoSessionVar();
            }

            //sleep(0.1);
            //$_SESSION['firm']['counter']+=3;
            $linesProcessed = $this->processFile(
                $handler = $_SESSION['firm']['handler'], 
                $_SESSION['firm']['name']    
            );
            $_SESSION['firm']['counter'] += $linesProcessed;
            
        // if current file is finished
            if ($_SESSION['firm']['counter'] == $_SESSION['firm']['lines']) {
                $_SESSION['firm']['counter'] += 1;
            // save in the DB parameters of the current file     
                $model=new Uploads;
                $model->firm = $_SESSION['firm']['name'];
                $model->rows = $_SESSION['firm']['lines'];
                $model->size = myFileHelper::getFileSize( $this->getFileName( $_SESSION['firm']['name'] ) );
                $model->file_date = myFileHelper::getFileTime( $this->getFileName( $_SESSION['firm']['name'] ) );
                $model->save();
            }
 
            echo json_encode(array(
                'name' => $_SESSION['firm']['name'], 
                'counter' => $_SESSION['firm']['counter']/$_SESSION['firm']['lines'],
            ));
        }
    }

     /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Uploads the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Uploads::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
     * fills $_SESSION variable information from the GET
     * for each firm from GET fill $_SESSION['firm'][$i]['name'] by name of firm
     * and put in $_SESSION['firm'][$i]['counter'] initial value for counter - "0"
     */
    protected function saveFirmIntoSessionVar() {
    // delete old information in $_SESSION['firm']
        clearSessionVar();
 
    // assign initial values
        $fileHahdler = '';
        $numberOfLines = 0;
        $counter = 0;
        
    // use the filter for incoming data
        $firmName = filter_var($_GET['f0'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/\w{3,20}/i')));

    // if there is a record in the DB for current $firmName
        $fileName = getFileName($firmName);
        if( $fileName ){
        // obtain the date/time of the file that was loaded the last 
            $lastLoadedFileTime = Uploads::model()->find('firm=:fn',[':fn'=>$firmName])->file_date;
        // if the current file is diffirent from the time of the last loaded file    
            if( $lastLoadedFileTime != myFileHelper::getFileTime($fileName)) {
                $fileHahdler = myFileHelper::getFilePointer($fileName);
                $numberOfLines = myFileHelper::getNumberOfLines($fileHahdler);
            }
            else{
                $numberOfLines = 1;
                $counter = 1;
            }
        }
        
        $_SESSION['firm'] = [
            'name' => $firmName, 
            'handler' => $fileHahdler,
            'lines' => $numberOfLines,
            'counter' => 0,
        ];
    }
    
    /*
     * @param string name of current firm
     * @return string name of the price file for current firm 
     */
    protected function getFileName($firmName) {
        return Firm::model()->find('firm_name=:fn',array(':fn'=>$firmName))->file_name;
    }

   /*
     * delete all elemenrs into $_SESSION[firm]
     */
    protected function clearSessionVar() {
       if (isset($_SESSION['firm'])) {
        // if file has been opened - close it    
            if(is_resource($_SESSION['firm']['handler']))
                fclose($_SESSION['firm']['handler']);
            foreach ($_SESSION['firm'] as $key => $value) {
                unset($_SESSION['firm'][$key]);
            }
        }        
    }

    /**
     * read data from the file
     * check out if the DB contains the current data
     * write new data in the DB
     * @param file pointer resourse $handler
     * @param string $firmName the name of the current firm
     * @return integer number of lines been processed
     */
    protected function processFile($handler, $firmName) {
        
        $this->attachBehavior('fileProcess', 'csvFileProcessBehavior' );
        $fileContent = $this->getCvsFileContent($handler, $firmName);
        $this->detachBehavior('fileProcess');
        
    // one row contains the data for one product and must be recorded in one record in the database	
        foreach ($fileContent as $row) {  // take row
            $model = new ProductsData;
        // check if the record exists in the DB. Loking for strict compliance
            $oldRecord = $model->isProductExist($firmName, $row );
            if( $oldRecord ) {
            // if the record exists, update it
                if( $row['description']) {
                    $oldRecord->description = $row['description'];
                }        
                
                if( $row['availability']) {
                    $oldRecord->availability = $row['availability'];
                }        

                if( $row['bonus']) {
                    $oldRecord->bonus = $row['bonus'];
                }        

                if( $row['shipping_cost']) {
                    $oldRecord->shipping_cost = $row['shipping_cost'];
                }        

                if( $row['product_page']) {
                    $oldRecord->product_page = $row['product_page'];
                }        

                if( $row['sourse_page']) {
                    $oldRecord->sourse_page = $row['sourse_page'];
                }        
                
                $oldRecord->price = $row['price'];
                
                $oldRecord->save();
            }

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
     * Performs the AJAX validation.
     * @param Uploads $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'uploads-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
