<?php


namespace Core;

use App\traits\Validations;

/**
 * Class Validate
 * @package Core
 */
class Validate
{
    use Validations;

    public function validate($rules){

        foreach($rules as $field => $validations){

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

    }

    private function hasOneValidation($validation){
        return substr_count($validation,":") == 0;
    }

    private function hasTwoOrMoreValidation($validation){
        return substr_count($validation,":") >= 1;
    }


}