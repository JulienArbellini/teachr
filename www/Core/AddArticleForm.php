<?php

namespace App\Core;

class AddArticleForm{

    public static function validatorAddArticle($data, $config){
		$errors = [];
        $nb_input = count($config["input"]);
        $nb_textarea = count($config["textarea"]);
        $total_keys = $nb_input + $nb_textarea;

		if( count($data) == $total_keys){

			foreach ($config["input"] as $name => $configInput) {
				
				if( !empty($configInput["lengthMin"]) 
					&& is_numeric($configInput["lengthMin"]) 
					&& strlen($data[$name])<$configInput["lengthMin"] ){
					
					$errors[] = $configInput["error"];

				}

			}
            foreach ($config["textarea"] as $name => $configTextArea) {
				
				if( !empty($configTextArea["lengthMin"]) 
					&& is_numeric($configTextArea["lengthMin"]) 
					&& strlen($data[$name])<$configTextArea["lengthMin"] ){
					
					$errors[] = $configTextArea["error"];

				}

			}
        }else{
			$errors[] = "Tentative de Hack (Faille XSS)";
		 }

		return $errors; //tableau des erreurs
	}


    public static function showFormAddArticle($form){

        $html = "<div class=\"row col-m-10 col-m-up-3 container-article\">";
        $html .= "<form class='".($form["config"]["class"]??"")."' method='".( $form["config"]["method"] ?? "GET" )."' action='".( $form["config"]["action"] ?? "" )."'>";
        $html .= "<div class=\"col-m-7 col-m-padding-1 col-m-center form__field_articles_input\">";

        foreach ($form["input"] as $name => $dataInput) {

            $html .= "<div class=\"col-m-12\">";
            $html .= "<input
                        id='".$name."'
                        class='".($dataInput["class"]??"")."'
                        name='".$name."'
                        type='".($dataInput["type"] ?? "text")."'
                        placeholder='".($dataInput["placeholder"] ?? "")."'
                        ".((!empty($dataInput["required"]))?"required='required'":"")."
                        >";
            $html .= "</div>";
            
        }
        $html .= "</div>";

        foreach ($form["textarea"] as $name => $dataInput) {
            $html .= "<div class=\"col-m-12 col-m-up-5 col-m-center\">";
            $html .= "<textarea
                            id='".$name."'
                            class='".($dataInput["class"]??"")."'
                            name='".$name."'
                            placeholder='".($dataInput["placeholder"] ?? "")."'
                            ".((!empty($dataInput["required"]))?"required='required'":"")."
                            ></textarea>";
            $html .= "</div>";
        }
        $html .= "<div class=\"col-m-2 col-m-center col-m-padding-down-2\">";
        $html .= "<script> CKEDITOR.replace( 'contenu'); </script>";
        $html .= "<input type='submit' class=\"button\" value='".( $form["config"]["Submit"])."'></form>";
        $html .= "</div>";
        $html .= "</div>";

        echo $html;
    }
}