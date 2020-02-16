<?php


namespace Core;


/**
 * Class Load
 * Description: Retorna o DOCUMENT_ROOT do Projeto
 * @package Core
 *
 */
class Load
{
    public static function file($file){

        $file = path().$file;

        if(!file_exists($file)){
            throw new \Exception("Este arquivo não existe: {$file}");
        }

        return require($file);

    }
}