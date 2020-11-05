<?php
namespace App;

/**
 * Class Autoloader
 */
class Autoload{

    /**
     * Enregistre notre autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */
    static function autoload($class){

        $nameSpace = explode('\\', $class);
        foreach($nameSpace as $key =>  $value){
            $ref = array_keys($nameSpace);
            if(end($ref) !== $key){
                $nameSpace[$key] = ucfirst($value);
            }
        }
        $class = implode('/', $nameSpace);
        require $class.'.php';
    }

}
