<?php

namespace App\traits;

trait Sanitize{

    protected function sanitize(array $data):array {

        $sanitezed = [];

        foreach ($data as $field => $value){
            $sanitezed[$field] = rtrim(filter_var($value,FILTER_SANITIZE_STRING));
        }

        return $sanitezed;

    }

}
