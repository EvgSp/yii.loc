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
    public $handler;
    public $numberOfRows = 100;


    /**
     * Returns the first $numberOfRows rows of CSV file encoded in UTF-8
     * @param either string or AR instance $firmName name of the current firm 
     * or instance AR class Firm
     * @return array
     */
    public function getCvsFileContent($firmName) {
    // check what passed in the second paramerer
        if( \is_string( $firmName ) ) {
            $firm = Firm::model()->find('firm_name=:fn',array(':fn'=>$firmName));
        }
        else {
            $firm = $firmName;
        }
    
    // take data from DB    
        $columnNames = PriceStructure::model()->findByAttributes([ 'firm' => $firm->firm_name ])->getColumnNames();

    // take 100 lines from file that indicates the handler
        $aaa = $firm->column_separator;
        $fileContent = $this->csvFileToArray($firm->column_separator, $firm->text_separator, $this->numberOfRows);
    // rename columns in $fileContent by corresponding names from $columnNames
        $fileContent = $this->fillColumnNames($fileContent, $columnNames, $firm->encoding);
    // remove unnamed columns    
        $fileContent = $this->removeUnnamedColumns($fileContent);

        return $fileContent;
    }
    
    /**
     * put $qty lines of the file into array
     * @param file handler
     * @return array
     */
    protected function csvFileToArray($columnSeparator, $textSeparator, $qty = 20) {
        if (!$this->handler) {  //if the handler is empty
            throw new CHttpException(500, 'File not found.');
        }

        // read the file line by line. Treatment depends on the input parametrs
        if ($columnSeparator) {
            if ($textSeparator) {
                for ($i = 0; $i < $qty; $i++) {
                    if (($row = fgetcsv($this->handler, 1000, $columnSeparator, $textSeparator)) !== FALSE)
                        $fileContent[] = $row;  // add line as new row in $fileContent array
                }
            }
            else {
                for ($i = 0; $i < $qty; $i++) {
                    if (($row = fgetcsv($this->handler, 1000, $columnSeparator)) !== FALSE)
                        $fileContent[] = $row;  // add line as new row in $fileContent array
                }
            }
        }
        else {
            for ($i = 0; $i < $qty; $i++) {
                if (($row = fgets($this->handler, 1000)) !== FALSE)
                    $fileContent[][0] = $row;  //add line as new row in $fileContent array
            }
        }

        if(isset($this->owner->handler)) {
            $this->owner->handler = $this->handler;  //save handler in global variable
        }

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
