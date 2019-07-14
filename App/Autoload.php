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

        var_dump('HELLO AUTOLOAD');
        $nameSpace = explode('\\', $class);

        foreach($nameSpace as $key =>  $value){
            if(end(array_keys($nameSpace)) !== $key){
                $nameSpace[$key] = ucfirst($value);
            }
        }
        $class = implode('/', $nameSpace);
        require $class.'.php';
    }

}