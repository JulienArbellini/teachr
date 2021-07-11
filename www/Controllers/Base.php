<?php

namespace App;

use App\Core\Security;
use App\Core\View;
use App\Core\Database;
use App\Models\Article;
use App\Core\Form;
use App\Models\User;
use App\Core\Mailer;
use App\Models\Page;


class Base{


	public function defaultAction(){

		//Je vais cherche en bdd le pseudo du user
		$pseudo = "Prof";

		//Affiche moi la vue home;
		$view = new View();
		$view->assign("pseudo", $pseudo);
		$view->assign("age", 17);
		$view->assign("genre", "h");

		//envoyer le pseudo à la vue
	}




	//Must be connected
	public function dashboardAction(){
		
		$security = new Security(); 
		if(!$security->isConnected()){
			die("Error not authorized");
		}


		//Affiche moi la vue dashboard;
		$view = new View("dashboard", "back");

		$page = new Page();

		$page->definirPageAccueil();		
	
	}

	public function articlesAction(){
		$view = new View("articles", "back");
		$article = new Article();
		
		$article->deleteArticle();

		$donnees = $article->getArticle();
		$view->assign("donnees", $donnees);

	}

	public function editArticleAction(){
		$view = new View("edit-article", "back");
		$article = new Article();
		// $donnees = $article->getArticle();
		// $view->assign("donnees", $donnees);

		$data = $article->getContent();
		$view->assign("data", $data);

		if(!empty($_POST)){ 
			//echo "coucou";
			$article->setId($_GET['idArticle']);
			$article->setTitle($_POST["titre_article"]);
			$article->setSlug($_POST["slug_article"]);
			$article->setContent($_POST["contenu_article"]);
			$article->setCreatedAt(date("Y-m-d H:i:s"));
			$article->save();
	   }
	}
	public function registerAction(){
		$view = new View("register", "back");
	}

	public function usersAction(){
		$view = new View("users", "back");
		$userSelect = new User();
		$mailer = new Mailer();

		$donnees = $userSelect->requestRole();
		$view->assign("donnees", $donnees);
		
		$userSelect->userDelete();

		$data = $userSelect->roleShow();
		$view->assign("data", $data);

		$form = $userSelect->buildFormAddUser();
		$view->assign("form", $form);
		

		if(empty($_GET["updateId"])){

			if(!empty($_POST)){
				$errors = Form::validatorAddUserForm($_POST, $form);

				if(empty($errors)){
					$userSelect->setFirstname($_POST["firstname"]);
					$userSelect->setLastname($_POST["lastname"]);
					$userSelect->setEmail($_POST["email"]);
					$userSelect->setPseudo($_POST["pseudo"]);
					$userSelect->setPwd($_POST["password"]);
					//password_hash($_POST["password"], PASSWORD_BCRYPT)
					$userSelect->setRole($_POST["role"]);
					$userSelect->save();
					$test = $userSelect->userMail();
					$mailer->sendMailUser();
				}else{
					$view->assign("formErrors", $errors);
				}
			}
		}
		
		else{
			if(!empty($_POST)){
				$userSelect->setId($_GET["updateId"]);
				$userSelect->setLastname($_POST["lastname"]);
				$userSelect->setFirstname($_POST["firstname"]);
				$userSelect->setRole($_POST["role"]);
				$userSelect->updateUser();
			}
		}
	}

	public function displayArticleAction(){
		$view = new View("displayArticle", "back");
		$article = new Article();

		$data = $article->getContent();
		$view->assign("data", $data);
	}

	public function pagesAction(){
		$view = new View("pages", "back");
		$page = new Page();

		$page->deletePage();

		if(!empty($_POST)){
			//var_dump($_POST);
			$page->setTitle($_POST["add-page-title"]);
			$page->setSlug($_POST["add-page-slug"]);
			$page->setCreatedAt(date("Y-m-d H:i:s"));
			$page->save();
		}

		$donnees = $page->getPage();
		$view->assign("donnees", $donnees);

	}

	public function displayPageAction(){
		$view = new View("displayPage", "back");
		$page = new Page();

		$data = $page->getContentPage();
		$view->assign("data", $data);
	}

	public function apparenceAction(){
		$view = new View("apparence", "front");
		$page = new Page();

		if(!empty($_POST) && !empty($_GET['idPage'])){ 
			//echo "coucou";
			$page->setId($_GET['idPage']);
			$page->setTitle($_POST["titre_page"]);
			$page->setSlug($_POST["slugPage"]);
			$page->setContent($_POST["affichage-page"]);
			// $page->setPageAccueil($_POST["pageAccueil"]);

			if(!empty($_POST['pageAccueil'])){
				$page->setPageAccueil("1");
			}
			else{
				$page->setPageAccueil("0");
			}
			$page->save();

			$page->updatePageAccueil();

			// $page->checkboxState();
	   }

	//    if(!empty($_GET['idPage'])){
	// 		$page->checkboxState();
	//    }

	//    $page->checkboxState();

	   if(!empty($_POST) && empty($_GET['idPage'])){

			$page->setTitle($_POST["titre_page"]);
			$page->setSlug($_POST["slugPage"]);
			$page->setContent($_POST["affichage-page"]);
			// $page->setPageAccueil($_POST["pageAccueil"]);

			if(!empty($_POST['pageAccueil'])){
				$page->setPageAccueil("1");
			}
			else{
				$page->setPageAccueil("0");
			}
			$page->save();

			$page->updatePageAccueil();

			// $page->checkboxState();
	   }

	   $page->checkboxState();

	   $page->definirPageAccueil();

	   $data = $page->getContentPage();
	   $view->assign("data", $data);


	}

	public function routesPagesArticlesAction(){
		$article = new Article();
		$article->routingPagesArticles();
	}

}