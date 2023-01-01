<?php
namespace App\Classes;

Class Language {
    /**
     * @var array
     */

    static $frToEng = array(
        "Accueil" => "Home",
        "A propos" => "About",
        "Catégorie" => "Category",
        "Contactez-nous" => "Contact us",
        "Inscription" => "Registration",
        "Connexion" => "Login",
        "Recherche" => "Search",
        "Prestataire" => "Providers",
        "Commune" => "Municipality",
        "Localité" => "Locality",
        "Code postal" => "Postal code",
        "Catégorie du mois" => "Category of the month"

    );
    static $engToFr = array(
        "Home" => "Accueil",
        "About"=>"A propos",
        "Category"=>"Catégorie",
        "Contact us"=>"Contactez-nous",
        "Registration"=>"Inscription",
        "Login"=>"Connexion",
        "Search"=> "Recherche",
        "Providers"=>  "Prestataire",
        "Municipality"=>"Commune",
        "Locality"=> "Localité",
        "Postal code"=>"Code postal" ,
        "Category of the month"=>"Catégorie du mois"

    );

    static function langue($lang,$mot){
        if (isset($lang)){
            if ($lang === "fr"){
                $result = self::engTofr($mot);
            }elseif ($lang === "eng"){
                $result = self::frToEng($mot);
            }
        }
        return $result;
    }

    static function frToEng($mot){

        if( isset($mot) ){

            $tableau = self::$frToEng;
            $result  = $mot;
            foreach( $tableau as $key=>$value ){
                if($mot === $key){
                    $result  = $value;
                }
            }
            return $result ;
        }
    }
    static function engTofr($mot){

        if( isset($mot) ){
            $result  = $mot;
            $tableau = self::$engToFr;
            foreach( $tableau as $key=>$value ){
                if($mot === $key){
                    $result  = $value;
                }
            }
            return $result ;
        }
    }
}
?>