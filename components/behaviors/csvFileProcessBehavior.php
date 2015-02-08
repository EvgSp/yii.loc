<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * containes functionality for working with csv files
 *
 * @author evg
 */
class csvFileProcessBehavior extends CBehavior {
//    public $firmName;
//    public $fileName;   
//    public $numberOfRows;

    /**
     * put $qty lines of the file into array
     * handler of the file is global variable 
     * therefore, processing begins with the string pointed to by the handler 
     * @param file handler
     * @return array
     */
    protected function csvFileToArray($handler, $columnSeparator, $textSeparator, $qty = 20) {
        if (!$handler) {  //if the handler is empty
            throw new CHttpException(500, 'File not found.');
        }

        // read the file line by line. Treatment depends on the input parametrs
        if ($columnSeparator) {
            if ($textSeparator) {
                for ($i = 0; $i < $qty; $i++) {
                    if (($row = fgetcsv($handler, 1000, $columnSeparator, $textSeparator)) !== FALSE)
                        $fileContent[] = $row;  // add line as new row in $fileContent array
                }
            }
            else {
                for ($i = 0; $i < $qty; $i++) {
                    if (($row = fgetcsv($handler, 1000, $columnSeparator)) !== FALSE)
                        $fileContent[] = $row;  // add line as new row in $fileContent array
                }
            }
        }
        else {
            for ($i = 0; $i < $qty; $i++) {
                if (($row = fgets($handler, 1000)) !== FALSE)
                    $fileContent[][0] = $row;  //add line as new row in $fileContent array
            }
        }

        $this->owner->handler = $handler;  //save handler in global variable

        return $fileContent;
    }

    /**
     * change the names of fileContent columns .
     * The new column names is taken from the second parametr of this function i.e. columnNames 
     * and change encoding to UTF8
     * 
     * @param array input array 
     * @param array ColumnName => NumberOfColumn
     * @return array output array
     */
    protected function fillColumnNames($fileContent, $columnNames, $encoding) {
        foreach ($fileContent as &$row) {
            for ($i = 0; $i < sizeof($row); $i++) {
                $row[$i] = iconv($encoding, 'UTF-8', $row[$i]); // change encoding to UTF-8
                $key = ($i + 1) . 'c';

                if (isset($columnNames[$key])) {
                    $row[$columnNames[$key]] = $row[$i];
                } else {
                    $row[$key] = $row[$i];
                }

                unset($row[$i]);
            }
        }
        return $fileContent;
    }

    /**
     * remove columns with uninformative names
     * uninformative name is the name with a digital in the title
     * 
     * @param array 
     * @return array
     */
    protected function removeUnnamedColumns($fileContent) {
        foreach ($fileContent as &$arrayValue) {
            foreach ($arrayValue as $key => $value) {
                $intKey = $key;
                settype($intKey, "integer");
                if ($intKey > 0) {
                    unset($arrayValue[$key]);
                }
            }
        }

        return $fileContent;
    }


}
