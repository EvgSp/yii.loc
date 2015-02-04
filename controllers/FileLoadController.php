<?php

class FileLoadController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @var string the default action for this controller
     */
    public $defaultAction = 'load';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
//			'postOnly + load', // we only allow loading via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('load', 'create'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Select file and load it.
     */
    public function actionLoadOne() {
        // choose model
        $model = new FileLoad('fileLoad');

       //define $isLoaded and $fileName
        $isLoaded = '';

    // if i _POST['fileload'] is defined
        if (isset($_POST['FileLoad'])) {
            $model->attributes = $_POST['FileLoad'];
            if ($model->validate()) {
                $model->fileName = CUploadedFile::getInstance($model, 'fileName');
                if ($model->fileName) {
                    $path = Yii::getPathOfAlias('webroot') . '/data/' . $model->fileName->getName();
                    $isLoaded = $model->fileName->saveAs($path);
                }
            }
        }

        $this->render('loadform_1', array('model' => $model, 'isLoaded' => $isLoaded, 'fileName' => $model->csvFile));
    }

    /*
    * Rendering form for loading multiple files and load selected files.
    */
    public function actionLoad() {
        $model = new FileLoad;
        $isLoaded = '';
        $fileName = '';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Upload'])) {
            $priceFiles = CUploadedFile::getInstances($model, 'csvFile');
            $model->csvFile = $priceFiles;

            if ($model->validate()) {            
                if (isset($priceFiles) && count($priceFiles) > 0) {
                    foreach ($priceFiles as $key => $priceFile) {
                        $isLoaded=$priceFile->saveAs(Yii::app()->basePath . 
                                Yii::app()->params['priceFileDirectory'] . 
                                DIRECTORY_SEPARATOR . $priceFile->name);
                    }
                }
            }
        }
        $this->render('loadform', array(
            'model' => $model,
            'isLoaded' => $isLoaded,
            'fileName' => $model->csvFile,    
        ));
    }

}
