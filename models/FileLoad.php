<?php

// @TODO: remove 'jpg' extension from function 'rules'

/**
 * FileInfo class.
 * FileInfo is the structure for uploading files into server 
 * and receaving information from the file
 */
class FileLoad extends CFormModel {

    public $csvFile;
    /**
     * Declares the validation rules.
     * The rules state that csvFile is required,
     * The file extension can only be 'csv'.
     */
    public function rules() {
        return array(
            array('csvFile', 'file', 'types' => array('csv', 'jpg'), 'safe' => 'true', 'maxFiles' => 10,),
        );
    }
}
