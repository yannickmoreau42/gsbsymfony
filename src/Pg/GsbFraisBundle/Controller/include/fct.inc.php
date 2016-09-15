﻿<?php
/** 
 * Fonctions pour l'application GSB
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 */
 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
 */
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

function estConnecte($session){
  //return isset($_SESSION['idVisiteur']);
//    $request = Request::createFromGlobals();
//    $session = $request->getSession();
      return $session->getFlashBag()->has('id');
}
/**
 * Enregistre dans une variable session les infos d'un visiteur
 
 * @param $id 
 * @param $nom
 * @param $prenom
 */
function connecter($session, $id,$nom,$prenom){
//	$_SESSION['idVisiteur']= $id; 
//	$_SESSION['nom']= $nom;
////	$_SESSION['prenom']= $prenom;
//     $request = Request::createFromGlobals();
//    $session = $request->getSession();
    $session->getFlashBag()->add('id',$id);
     $session->getFlashBag()->add('nom',$nom);
      $session->getFlashBag()->add('prenom',$prenom);
     
}
/**
 * Détruit la session active
 */
function deconnecter(){
	session_destroy();
}
/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
 
 * @param $madate au format  jj/mm/aaaa
 * @return la date au format anglais aaaa-mm-jj
*/
function dateFrancaisVersAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}
/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa 
 
 * @param $madate au format  aaaa-mm-jj
 * @return la date au format format français jj/mm/aaaa
*/
function dateAnglaisVersFrancais($maDate){
   @list($annee,$mois,$jour)=explode('-',$maDate);
   $date="$jour"."/".$mois."/".$annee;
   return $date;
}
/**
 * retourne le mois au format aaaamm selon le jour dans le mois
 
 * @param $date au format  jj/mm/aaaa
 * @return le mois au format aaaamm
*/
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}

/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 
 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	foreach($tabEntiers as $unEntier){
		if(!estEntierPositif($unEntier)){
		 	$ok=false; 
		}
	}
	return $ok;
}
/**
 * Vérifie si une date est inférieure d'un an à la date actuelle
 
 * @param $dateTestee 
 * @return vrai ou faux
*/
function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
}
/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa 
 
 * @param $date 
 * @return vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques 
 
 * @param $lesFrais 
 * @return vrai ou faux
*/
function lesQteFraisValides($lesFrais){
	return estTableauEntiers($lesFrais);
}
/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais et le montant 
 
 * des message d'erreurs sont ajoutés au tableau des erreurs
 
 * @param $dateFrais 
 * @param $libelle 
 * @param $montant
 */
//function valideInfosFrais($session,$dateFrais,$libelle,$montant){
//	if($dateFrais==""){
//		ajouterErreur($session,"Le champ date ne doit pas être vide");
//	}
//	else{
//		if(!estDatevalide($dateFrais)){
//			ajouterErreur($session,"Date invalide");
//		}	
//		else{
//			if(estDateDepassee($dateFrais)){
//				ajouterErreur($session,"date d'enregistrement du frais dépassé, plus de 1 an");
//			}			
//		}
//	}
//	if($libelle == ""){
//		ajouterErreur($session,"Le champ description ne peut pas être vide");
//	}
//	if($montant == ""){
//		ajouterErreur($session,"Le champ montant ne peut pas être vide");
//	}
//	else
//		if( !is_numeric($montant) ){
//			ajouterErreur($session,"Le champ montant doit être numérique");
//		}
//}


function valideInfosFrais($dateFrais,$libelle,$montant){
    $lesErreurs = array();	
    if($dateFrais==""){
		$lesErreurs[] = "Le champ date ne doit pas être vide";
	}
	else{
		if(!estDatevalide($dateFrais)){
			$lesErreurs[] = "Date invalide";
		}	
		else{
			if(estDateDepassee($dateFrais)){
				$lesErreurs[] = "date d'enregistrement du frais dépassé de plus de 1 an";
			}			
		}
	}
	if($libelle == ""){
		$lesErreurs[] = "Le champ description ne peut pas être vide";
	}
	if($montant == ""){
		$lesErreurs[] = "Le champ montant ne peut pas être vide";
	}
	else
		if( !is_numeric($montant) ){
			$lesErreurs[] = "Le champ montant doit être numérique";
		}
                echo "erreurs:";
                var_dump($lesErreurs);
        return $lesErreurs;        
}

/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 
 
 * @param $msg : le libellé de l'erreur 
 */
function ajouterErreur($session, $msg){
  
 

    $session->getFlashBag()->add('erreurs',$msg);
    
}
function existeErreurs($session){
    
    return $session->getFlashBag()->has('erreurs');
}
function getLesErreurs($session){
    
    return  $session->getFlashBag()->get('erreurs');
}
/**
 * Retoune le nombre de lignes du tableau des erreurs 
 
 * @return le nombre d'erreurs
 */
//function nbErreurs(){
//    $request = Request::createFromGlobals();
//    $erreurs = $request->getSession()->get('erreurs');
//  
//	   return count($erreurs);
//	
//}
?>