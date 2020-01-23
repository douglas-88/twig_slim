<?php


namespace Core;

use App\traits\Validations;
use App\traits\Sanitize;

/**
 * Class Validate
 * @package Core
 */
class Validate
{
    use Validations,Sanitize;

    public function validate($rules){


        foreach($rules as $field => $validations){

            flash("post_".$field,$_POST[$field]);
            $validations = $this->validatingWithParameters($field,$validations);

            if($this->hasOneValidation($validations)){
               $this->$validations($field);
            }

            if($this->hasTwoOrMoreValidation($validations)){
                $validations = explode(":",$validations);
                foreach ($validations as $validation) {
                    $this->$validation($field);
                }
            }
        }

        return $this->sanitize($_POST);

    }

    private function hasOneValidation($validation){
        return substr_count($validation,":") == 0;
    }

    private function hasTwoOrMoreValidation($validation){
        return substr_count($validation,":") >= 1;
    }

    private function validatingWithParameters($field,$validations){
        if(substr_count($validations,"@") > 0){
            $validation = explode(":",$validations);

            foreach ($validation as $key => $value) {
                if(substr_count($value,"@") > 0){
                    list($method,$param) = explode("@",$value);
                    $this->$method($field,$param);
                    unset($validation[$key]);
                    $validations = implode(":",$validation);
                }
            }

        }

        return $validations;
    }


}