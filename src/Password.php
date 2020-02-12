<?php


namespace Core;


class Password
{
    /**
     * Retorna a Senha Encriptada
     * @param $password
     * @return string
     */
    public static function make($password):string{

        return  password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
    }

    /**
     * Verifica a Senha Encriptada
     * @param $password
     * @return bool
     */
    public static function verify($password,$hash):bool{

        return password_verify($password,$hash);
    }
}