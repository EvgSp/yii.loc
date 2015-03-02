<?php

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

        $firmModels = Firm::model()->findAll('activity=1');
        foreach ($firmModels as $firmModel) {
            $myArray[$firmModel->firm_name] = $firmModel->firm_name;
        }

        $this->render('index', array('myArray' => $myArray));
    }

    /**
     * process ajax request, manage loading data from prices to the DB
     * data between requests are saved in the superglobal variable $_SESSION
     * 
     * @return josn string with the firm name and the percent of current file processing
     */
    public function actionFileProcesing() {
        if (Yii::app()->request->isAjaxRequest) {
            // if there is GET request into Ajax request, save names of firms should be processed
            if (isset($_GET['f0'])) {
                $this->saveFirmIntoSessionVar();
            }    

        // if the position of the file pointer equal or more then 0
            if ( $_SESSION['firm']['position'] >= 0 ) { 
            
                $linesProcessed = $this->processFile();
                $_SESSION['firm']['counter'] += $linesProcessed;
            }
            
        // if current file is finished
            if ($_SESSION['firm']['counter'] == $_SESSION['firm']['lines']) {
                $_SESSION['firm']['counter'] += 1;
            // if number of lines in the file more then 1, save info about loading parameters in the DB
                if ( $_SESSION['firm']['lines'] > 1 ) {
                    $model=new Uploads;
                    $model->firm = $_SESSION['firm']['name'];
                    $model->rows = $_SESSION['firm']['lines'];
                    $model->size = myFileHelper::getFileSize( $this->getFileName( $_SESSION['firm']['name'] ) );
                    $model->file_date = myFileHelper::getFileTime( $this->getFileName( $_SESSION['firm']['name'] ) );
                    $model->save();
                }
            }
 
            echo json_encode(array(
                'name' => $_SESSION['firm']['name'], 
                'counter' => $_SESSION['firm']['counter']*100/$_SESSION['firm']['lines'],
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
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }    
        return $model;
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

    /*
     * clear $_SESSION variable and fill it by information from the GET
     * $_SESSION['firm'][$i]['name'] - name of firm
     * $_SESSION['firm'][$i]['position'] - position of the file pointer. Initial value is "0". 
     *      File opening error coding by "-1" 
     * $_SESSION['firm'][$i]['lines'] - number of lines in the file
     * $_SESSION['firm'][$i]['counter'] - number of lines which was processed. Initial value is "0"
     *      or "1" if error happened
     */
    protected function saveFirmIntoSessionVar() {
    // delete old information in $_SESSION['firm']
        $this->clearSessionVar();
 
    // assign initial values
        $filePosition = -1;
        $numberOfLines = $counter = 1;
        
    // use the filter for incoming data
        $firmName = filter_var( 
                $_GET['f0'], 
                FILTER_VALIDATE_REGEXP, 
                array( 'options' => array( 'regexp' => '/\w{3,20}/i', ), ) 
        );

    // get the current $firmName
        $fileName = $this->getFileName( $firmName );
    // if success    
        if( $fileName ){
        // check if there is info about the file with current name and time in the DB     
            $currentFileTime = \myFileHelper::getFileTime( $fileName );
            $firmUploaded = Uploads::model()->find(
                    'firm=:fn AND file_date=:fd',
                    array( ':fn'=>$firmName, ':fd'=>$currentFileTime, )
            );    
        // if such info isn't present 
            if ( !$firmUploaded ) {
            // change initial values    
                $filePosition = 0;
                $numberOfLines = \myFileHelper::getNumberOfLines( \myFileHelper::getFilePointer($fileName) );
                $counter = 0;
            }
        }
        
        $_SESSION['firm'] = array(
            'name' => $firmName, 
            'position' => $filePosition,
            'lines' => $numberOfLines,
            'counter' => $counter,
        );
    }
    
    /*
     * return name of the file for firm which is passed by argument
     * 
     * @param string name of current firm
     * @return string name of the price file for current firm 
     */
    protected function getFileName($firmName) {
        return Firm::model()->find('firm_name=:fn',array(':fn'=>$firmName))->file_name;
    }

   /*
     * delete all elements into $_SESSION[firm] array
     */
    protected function clearSessionVar() {
       if (isset($_SESSION['firm'])) {
            foreach ($_SESSION['firm'] as $key => $value) {
                unset($_SESSION['firm'][$key]);
            }
        }        
    }

    /**
     * read data from the file of the current firm. The name of the firm is taken from $_SESSION['firm']['name']
     * check out if the DB contains the current data
     * write new data in the DB
     * 
     * @return integer number of lines been processed
     */
    protected function processFile() {
        $firmName = $_SESSION['firm']['name'];
        
        $this->attachBehavior('fileProcess', [ 
            'class' => 'application.components.behaviors.csvFileProcessBehavior',
            'position' => $_SESSION['firm']['position'],
            'numberOfRows' => 1000, 
        ]);
        $fileContent = $this->getCvsFileContent($firmName);
        $_SESSION['firm']['position'] = $this->position;
        $this->detachBehavior('fileProcess');
       
        $linesProcessed = $this->saveFileContentInDB($firmName, $fileContent);
        
        return $linesProcessed;
    }
    
    protected function saveFileContentInDB(&$firmName, &$fileContent) {
        $linesProcessed = 0;
    //    $connection = Yii::app()->db;
    //    $transaction =$connection->beginTransaction();
        
    // one row contains the data for one product and must be recorded in one record in the database
        foreach ($fileContent as $row) {  // take row
            $linesProcessed += 1;

        // prepare price parameter, remove whitespace and replace possible delimiters by "."
            $row['price'] = str_replace(" " , "", $row['price']);
            $row['price'] = str_replace(array(",", "-"), ".", $row['price']);
        // if price = 0, it isn't line of a product
            if( $row['price'] == 0 ) {
                continue;                
            }
        
        // get the record with current ID and name from the DB. If it dos't exist make new record
            $record = $this->getProduct($firmName, $row);

        // assign values
            if( $record ) {
                $record->attributes = $row;
                $record->change_date = new CDbExpression('NOW()');
                $record->firm = $firmName;
                $record->save();
            }
        }
        
    //    $transaction->commit();
        
        return $linesProcessed;
    }    

    protected function getProduct( &$firmName, &$row ) {
        
        $criteria = new CDbCriteria();
        $criteria->condition = 'firm=:firm';
        $criteria->params = array(':firm'=>$firmName);
        
        $itemId = isset($row['item_id']) ? $row['item_id'] : '' ;
        
        if( $itemId ) {
            $criteria->addCondition('item_id=:itemId');
            $criteria->params[':itemId'] = $itemId;
        } else {
            $criteria->addCondition('item_id IS NULL');
        }

        if( $row['name'] ) {
            $criteria->addCondition('name=:name');
            $criteria->params[':name'] = $row['name'];
        }

        $record = ProductsData::model()->find($criteria);

        // if record for current product exist    
        if( $record ) {
        // compare values from DB and values from file
            $flag = 0;
            foreach ($row as $key => $value) {
                if($record->$key != $value ) {
                // if have find difference
                    $flag = 1;
                    break;
                }
            }
        // if there are not difference between base and file - continue loop     
            if( $flag == 0 ) {
                $record = '';
            }
        } else {
            $record = new ProductsData;
        }        
        
        return $record;
    }
          
}
