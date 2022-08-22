<?php

use App\Models\Groupe_form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\Input;



	//	**************************************************	//
	//						SUCCESS
	//	**************************************************	//

	if(!function_exists('custom_success')){
		function custom_success($nuero_success)
		{
			$message = '';
			switch ($nuero_success) {
				case 0:
					$message = "I000: Groupe ajouté avec succes !";
					break;
				case 1:
					$message = "I001: Utilisateur ajouté avec succes !";
					break;
				case 2:
					$message = "I002: Groupe Supprimé avec succes !";
					break;
				case 3:
					$message = "I003: Utilisateur Supprimé avec succes !";
					break;
				case 4:
					$message = "I004: Groupe Modifié avec succes !";
					break;
				case 5:
					$message = "I005: Utilisateur Modifié avec succes !";
					break;
				case 6:
					$message = "I007: Employé Ajouté avec succes !";
					break;
				case 7:
					$message = "I008: Employé Modifié avec succes !";
					break;
				case 999:
					$message = "I999: Opération éffectuée avec succes !";
					break;
			
				default:
					# code...
					break;
			}
			return $message;
		}

	}

	if(!function_exists('afficherSuccess')){
		function afficherSuccess($code_success)
		{
			if( !session()->has('error') AND !session()->has('warning') ){
				session()->put('success',$code_success);
			}
		}

	}


	//	**************************************************	//
	//						ERRORS
	//	**************************************************	//

	if(!function_exists('custom_error')){
		function custom_error($erreurException)
		{
			$message = '';
			if ( substr($erreurException, 0, 15) == 'SQLSTATE[23000]' ) {
				$message = "*** ERREUR [E003] : Cet élément existe déjà dans la Base de Données. Si vous ne le voyez pas dans la liste, c\'est qu\'il a été supprimé.                     *** SOLUTION : Changer le nom ou l'email";
				//$message = ob_get_contents();
			} 
			elseif( strcmp($erreurException, ' The email has already been taken.') == 0){
				$message = "*** ERREUR [E001] : Cet email est déjà utilisé!                     *** SOLUTION : Changer d'adresse mail !";
			}elseif(substr($erreurException, 0, 15) == 'SQLSTATE[23000]'){
				$message = 'E002: Cette opération ne peut pas être éffectuée car ce groupe contient des utilisateurs !';
			}elseif($erreurException == 'E004'){
				$message = "*** E004: Un employé avec cet email existe déjà dans la base de données !                     *** SOLUTION : Changer d'adresse mail !";
			}elseif($erreurException == 'E005'){
				$message = "*** E005: Problème lors de l'enregistrement de l'employé!                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E006'){
				$message = "*** E006: Problème lors de l'enregistrement des documents de l'employé dans la base de données!                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E007'){
				$message = "*** E007: Problème lors de l'enregistrement du poste de l'employé!                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E008'){
				$message = "*** E008: Problème lors de l'enregistrement des permis!                     *** SOLUTION : Contactez l'administrateur !";
			}
			elseif($erreurException == 'E009'){
				$message = "*** E009: Problème lors de l'enregistrement des urgences!                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E010'){
				$message = "*** E010: Problème lors de l'enregistrement des l'enfant!                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E011'){
				$message = "*** E011: Problème lors de l'édition des l'enfant!                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E012'){
				$message = "*** E012: Problème lors de l'enregistrement de la demande d'abscence.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E013'){
				$message = "*** E013: Problème lors de l'enregistrement de l'autorisation de congé.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E014'){
				$message = "*** E014: Problème lors de l'enregistrement de l'ordre de mission.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E015'){
				$message = "*** E015: Problème lors de l'enregistrement du justificatif.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E016'){
				$message = "*** E016: Problème lors de la génération du la demande PDF.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E017'){
				$message = "*** E017: Problème lors de la création du Workflow.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E018'){
				$message = "*** E018: Problème lors de la MAJ du Workflow.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E019'){
				$message = "*** E019: Problème lors de la MAJ du Workflow FINAL.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E020'){
				$message = "*** E020: Problème lors de la Réactivation du Workflow.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E021'){
				$message = "*** E021: Problème lors de la Suppresion du Processus.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E022'){
				$message = "*** E022: Problème lors de l'archivage du Processus.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E023'){
				$message = "*** E023: Problème lors de la modification du véhicule.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E024'){
				$message = "*** E024: Problème lors de l'ajout.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E025'){
				$message = "*** E025: Problème lors de la suppression du Document.                     *** SOLUTION : Contactez l'administrateur !";
			}elseif($erreurException == 'E026'){
				$message = "*** E026: Problème lors de la modification du Document.                     *** SOLUTION : Contactez l'administrateur !";
			}
			else {
				# code...
			}
			return $message;
		}

	}


	//	**************************************************	//
	//						WARNING
	//	**************************************************	//

	if(!function_exists('custom_warning')){
		function custom_warning($nuero_warning)
		{
			$message = '';
			switch ($nuero_warning) {
				case 'W000':
					$message = "W000: Vous n'avez pas le droit d'acceder à cette section !";
					break;
				case 'W001':
					$message = 'W001: Cette opération ne peut pas être éffectuée car ce groupe contient des utilisateurs';
					break;
				case 'W002':
					$message = "W002: Certains champs ne sont pas correctement remplis!";
					break;
				case 'W003':
					$message = "W003: Selectionnez les utilisateurs des workflows, par ordre de validation!";
					break;
				case 'W004':
					$message = "W004: Vous demandez plus de jours de congés que vous possedez!  Réduisez la durée de votre congé";
					break;
				case 'W005':
					$message = "W005: Vous n'avez pas atteint les 24 jours nécessaires pour le congé annuel";
					break;
				case 'W006':
					$message = "W006: La date de retour de mission ne peut pas être inférieure à la date de départ";
					break;
				case 'W007':
					$message = "W007: Vous n'avez pas encorre de Worklow! Contacter l'administrateur";
					break;
				case 'W008':
					$message = "W008: Vous devez obligatoirement entrer le motif du refus.";
					break;
				case 'W009':
					$message = "W009: Une direction avec ce Code existe déjà.";
					break;
				case 'W010':
					$message = "W010: Une direction avec ce Libellé existe déjà.";
					break;
				case 'W011':
					$message = "W011: Cette direction contient des départements. Elle ne peut pas être supprimée !";
					break;
				case 'W012':
					$message = "W012: Un département avec ce Code existe déjà.";
					break;
				case 'W013':
					$message = "W013: Un département avec ce Libellé existe déjà.";
					break;
				case 'W014':
					$message = "W014: Ce département contient des services. Il ne peut pas être supprimé !";
					break;
				case 'W015':
					$message = "W015: Ce Service existe déjà dans ce département !";
					break;
				case 'W016':
					$message = "W016: Ce service contient des postes. Il ne peut pas être supprimé !";
					break;
				case 'W017':
					$message = "W017: Ce Poste existe déjà !";
					break;
				case 'W018':
					$message = "W018: Des employés sont à ce poste. Il ne peut donc pas être supprimé !";
					break;
				case 'W021':
					$message = "W021: L'employé lié à cet utilisateur n'existe pas. Créez le avant de pouvoir l'éditer !";
					break;
				case 'W022':
					$message = "W022: Cet utilisateur n'est pas un employé";
					break;
				case 'W023':
					$message = "W023: Cette demande ne peut être initiée. Vous avez une action programée durant cette période !";
					break;
				case 'W024':
					$message = "W024: Un pays avec ce Code existe déjà.";
					break;
				case 'W025':
					$message = "W025: Un pays avec ce Libellé existe déjà.";
					break;
				case 'W026':
					$message = "W026: Ce pays contient des villes. Il ne peut pas être supprimé !";
					break;
				case 'W027':
					$message = "W027: Cette ville existe déjà.";
					break;
				case 'W028':
					$message = "W028: Les droits sur cette section ne sont pas définis. Contactez l'admnistrateur";
					break;
				case 'W029':
					$message = "W029: Vous n'avez pas chargé le fichier !";
					break;
				case 'W030':
					$message = "W030: Un processus avec ces informations existe déjà !";
					break;
				case 'W031':
					$message = "W031: Vous avez changé de FIP, la version du processus doit obligatoirement être modifiée. Si la FIP actuelle est la bonne, laissez le fichier vide!";
					break;
				case 'W032':
					$message = "W032: Vous avez changé de Version, la FIP du processus doit obligatoirement être modifiée !";
					break;
				case 'W033':
					$message = "W033: Cette Reférence existe déjà !";
					break;
				case 'W034':
					$message = "W034: Vous avez changé de Fiche, la version de la procedure doit obligatoirement être modifiée. Si la Fiche actuelle est la bonne, laissez le fichier vide!";
					break;
				case 'W035':
					$message = "W035: Vous avez changé de Version, la Fiche de la procedure doit obligatoirement être modifiée !";
					break;
				case 'W036':
					$message = "W036: Supprimez tout d'abord ses procedures avant de réduire le nombre de procedures de ce processus !";
					break;
				case 'W037':
					$message = "W037: Ce Libellé existe déjà !";
					break;
				case 'W038':
					$message = "W038: Cette Abréviation existe déjà !";
					break;
				case 'W039':
					$message = "W039: La réference n'est pas conforme !";
					break;
				case 'W040':
					$message = "W040: Un véhicule avec ce matricule existe déjà ! Utilisez un autre matricule";
					break;
				case 'W041':
					$message = "W041: Un véhicule avec ce numéro de série existe déjà ! Utilisez un autre numéro de série";
					break;
				case 'W042':
					$message = "W042: Un véhicule avec ce matricule n'existe pas ! Utilisez le bon matricule";
					break;
				case 'W043':
					$message = "W043: Ce véhicule n'était pas encore mis en circulation ! Revoyez vos informations ";
					break;
				case 'W044':
					$message = "W044: Le kilometrage ne peut pas diminuer. Contacter l'administrateur si nécessaire ! ";
					break;
				case 'W045':
					$message = "W045: La valeur de l'alerte 1 ne peut pas être inférieure à celle de l'alerte 2";
					break;
				case 'W046':
					$message = "W046: Ce Moniteur existe déjà.";
				case 'W047':
					$message = "W047: Des enregistrements avec cet élément existent. Supprimez-les avant !";		
				case 'W048':
					$message = "W048: Le document existe déjà. Modifiez-le !";
						
			
				default:
					# code...
					break;
			}
			return $message;
		}

	}


?>