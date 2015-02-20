<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of myFileHelper
 *
 * @author evg
 */
class myFileHelper extends CFileHelper {

    /**
     * get pointer of file with name $fileName
     * 
     * @param string $fileName
     * @return file handler
     */
    public static function getFilePointer($fileName) {
        $path = self::getPathToPrices() . $fileName;

        if (!file_exists($path))
            return NULL; // file dos't exist		
        if (!($handle = fopen($path, "r")))
            return NULL;   // file open error	

        return $handle;
    }
    
    /*
     * @param file pointer resourse $handler
     * @return integer Number of lines in the file pointed to by the pointer
     */
    public static function getNumberOfLines($f){
    // go to the start of file    
        rewind($f);
        
        $lines = 0;

        while (!feof($f)) {
            $lines += substr_count(fread($f, 8192), "\n");
        }
        
        rewind($f);
        
        return $lines;        
    }    

    /** 
     * @param string $filePath Full or shot path of the file or jast name of file
     * @return integer Size of the file in bytes 
     */
    public static function getFileSize($filePath) {
       // take the last component from the path. It should be name of the file  
        $fileName=  basename($filePath);
       // form full filename
        $path = self::getPathToPrices() . $fileName;

        if(file_exists($path)){ return filesize($path); }
        else {return 0;}        
    }

    /** 
     * @param string $filePath Full or shot path of the file or jast name of file
     * @return date and time the file was last modified in format "Y-m-d H:i:s" 
     */
    public static function getFileTime($filePath) {
       // take the last component from the path. It should be name of the file  
        $fileName=  basename($filePath);
       // form full filename
        $path = self::getPathToPrices() . $fileName;

        if(file_exists($path)){ return date("Y-m-d H:i:s", filemtime($path)); }
        else {return 0;}        
    }
   
    /**
     * Return the list of the uploaded files
     * @return array where the keys and values are the names of files. 
     */
    public static function getListFiles($dirPath='') {
        
        if(!$dirPath){
            $dirPath = Yii::app()->params['priceFileDirectory'];
        }

        $absoluteDirPath = Yii::app()->basePath . $dirPath;
        
        $listOfFiles = self::findFiles($absoluteDirPath, array('fileTypes'=>array('csv'), 'level'=>0,));

        $i = 0;
        $arrSize = sizeof($listOfFiles);
        while ($i < $arrSize) {
            $fileName=basename($listOfFiles[$i]);
            $listOfFiles[$fileName] = $fileName;
            unset($listOfFiles[$i]);
            $i++;
        }

        return $listOfFiles;
    }
    
    /**
     * @return path to the default directiry for the prices 
     * /
     */
    protected function getPathToPrices(){
        return Yii::app()->basePath . Yii::app()->params['priceFileDirectory'] . DIRECTORY_SEPARATOR;
    }
    }
