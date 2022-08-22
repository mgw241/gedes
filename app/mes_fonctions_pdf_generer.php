<?php
use setasign\Fpdi\Fpdi;

if(!function_exists('pdf_frais_mission')){
    function pdf_frais_mission($mission, $frais)
    {
        		/*				13 				*/
        // Create new Portrait PDF
        $pdf = new FPDI('p');

        // Reference the PDF you want to use (use relative path)
        $pagecount = $pdf->setSourceFile("../public/".config('app.DOSSIER_DOCUMENTS_storage')."Fiche des frais de mission model.pdf");

        // Import the first page from the PDF and add to dynamic PDF
        $tpl = $pdf->importPage(1);
        $pdf->AddPage();

        // Use the imported page as the template
        $pdf->useTemplate($tpl);

        // Set the default font to use
        $pdf->SetFont('Helvetica');
        $pdf->SetFont('Helvetica', 'B', 16);
        //Setting the text color 
        $pdf->SetTextColor(6, 56, 184);

        // adding a Cell using:
        // $pdf->Cell( $width, $height, $text, $border, $fill, $align);
        // DATE DE FICHE

        //  Nom
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(43.5, 32.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->nom), 0, 0, 'L'); // add the text, align to Center of cell
        //  Prenom
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(43.5, 36); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->prenom), 0, 0, 'L'); // add the text, align to Center of cell


        //  DIRECTION
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(126.5, 32.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->direct), 0, 0, 'L'); // add the text, align to Center of cell
        //  DEPARTEMENT
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(145, 32.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252','/ '.$mission[0]->dept), 0, 0, 'L'); // add the text, align to Center of cell
        //  SERVICE
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(126.5, 36); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->poste), 0, 0, 'L'); // add the text, align to Center of cell


        // OBJET
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(60, 43); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->objet), 0, 0, 'L'); // add the text, align to Center of cell

        // VILLE
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(60, 55); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->ville), 0, 0, 'L'); // add the text, align to Center of cell

        // DU
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(126.5, 55); // set the position of the box
        $pdf->Cell(0, 10, "Du ".date("d/m/Y", strtotime($mission[0]->date_debut)), 0, 0, 'L'); // add the text, align to Center of cell

        // AU
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(155, 55); // set the position of the box
        $pdf->Cell(0, 10, "au ".date("d/m/Y", strtotime($mission[0]->date_retour)), 0, 0, 'L'); // add the text, align to Center of cell

        // DUREE
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(126.5, 65.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->duree." jour (s)"), 0, 0, 'L'); // add the text, align to Center of cell


        $pdf->SetFillColor(6, 56, 184);

        switch ($mission[0]->transport) {
            case 'Avion':
                //	Avion
                $pdf->Rect(80, 77, 3, 3, 'F');
                break;
            case 'Train':
                //	Train
                $pdf->Rect(114.5, 77, 3, 3, 'F');
                break;
            case 'Bateau':
                //	Bateau
                $pdf->Rect(161.5, 77, 3, 3, 'F');
                break;
            case 'Véhicule personnelle':
                //	Perso
                $pdf->Rect(80, 85.5, 3, 3, 'F');
                break;
            case 'Véhicule location':
                //	Location
                $pdf->Rect(114.5, 85.5, 3, 3, 'F');
                break;
            case 'Véhicule société':
                //	Societe
                $pdf->Rect(161.5, 85.5, 3, 3, 'F');
                break;
            
            default:
                # code...
                break;
        }


        /*
        // Numero Vehicule
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(80, 90.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',"33 27X"), 0, 0, 'L'); // add the text, align to Center of cell
        // TYPE Vehicule
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(145, 90.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',"TOYOTA YARIS"), 0, 0, 'L'); // add the text, align to Center of cell

        */

        // HEBERGEMENT
        $pdf->SetFillColor(6, 56, 184);
        if ($mission[0]->nbrj_hebergement > 0) {
            //	OUI
            $pdf->Rect(80, 101.5, 3, 3, 'F');
        }else{
            //	NON
            $pdf->Rect(114.5, 101.5, 3, 3, 'F');
            //	AUTRE
            $pdf->Rect(161.5, 101.5, 3, 3, 'F');
        }
        
        

        /*			Montant Unitaire			*/
        // REPAS
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(70, 124); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$frais[0]->restauration ), 0, 0, 'L'); // add the text, align to Center of cell
        // HEBERGEMENT
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(70, 130); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$frais[0]->hebergement), 0, 0, 'L'); // add the text, align to Center of cell
        // TRANSPORT A-R
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(70, 136); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'L'); // add the text, align to Center of cell
        // AUTRE
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(70, 141.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$frais[0]->divers), 0, 0, 'L'); // add the text, align to Center of cell
        // DIVERS
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(70, 147); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$frais[0]->divers), 0, 0, 'L'); // add the text, align to Center of cell

        /*			Nbr Jours			*/
        // REPAS
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(106, 124); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->nbrj_repas), 0, 0, 'L'); // add the text, align to Center of cell
        // HEBERGEMENT
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(106, 130); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->nbrj_hebergement), 0, 0, 'L'); // add the text, align to Center of cell
        // TRANSPORT A-R
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(106, 136); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'L'); // add the text, align to Center of cell
        // AUTRE
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(106, 141.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->nbrj_autre), 0, 0, 'L'); // add the text, align to Center of cell
        // DIVERS
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(106, 147); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'L'); // add the text, align to Center of cell


        /*			TOTAl			*/
        // REPAS
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(-125, 124); // set the position of the box
        $pdf->Cell(55, 10, iconv('UTF-8', 'windows-1252',$mission[0]->nbrj_repas*$frais[0]->restauration), 0, 0, 'R'); // add the text, align to Center of cell
        // HEBERGEMENT
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(-125, 130); // set the position of the box
        $pdf->Cell(55, 10, iconv('UTF-8', 'windows-1252',$mission[0]->nbrj_hebergement*$frais[0]->hebergement), 0, 0, 'R'); // add the text, align to Center of cell
        // TRANSPORT A-R
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(-125, 136); // set the position of the box
        $pdf->Cell(55, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'R'); // add the text, align to Center of cell
        // AUTRE
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(-125, 141.5); // set the position of the box
        $pdf->Cell(55, 10, iconv('UTF-8', 'windows-1252',$mission[0]->nbrj_autre*$frais[0]->divers), 0, 0, 'R'); // add the text, align to Center of cell
        // DIVERS
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(-125, 147); // set the position of the box
        $pdf->Cell(55, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'R'); // add the text, align to Center of cell


        /*			TOTAl AVANCE EN CFA			*/
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(125, 152); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'L'); // add the text, align to Center of cell
        /*			TOTAl A JUSTIIER		*/
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(125, 156.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'L'); // add the text, align to Center of cell
        /*			TOTAl AVANCE EN DEVISE			*/
        $pdf->SetFontSize('11'); // set font size
        $pdf->SetXY(125, 161.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',""), 0, 0, 'L'); // add the text, align to Center of cell


        // render PDF to browser
        //$pdf->Output();

        $date = str_replace(' ', '', $mission[0]->created_at);
        $date = str_replace(':', '',$date);
        $date = str_replace('-', '',$date);
        $pdfFile = "missionF"."-".$mission[0]->code_emp."_".$date.".pdf";

        // Store file
        $pdf->Output("../public/".config('app.DOSSIER_EMPLOYES_storage').$mission[0]->code_emp."/".$pdfFile
            ,"F");

        return $pdfFile;
    }
}

if(!function_exists('pdf_ordre_mission')){
    function  pdf_ordre_mission  ($mission)
    {
        		/*				13 				*/
        // Create new Portrait PDF
        $pdf = new FPDI('p');

        // Reference the PDF you want to use (use relative path)
        $pagecount = $pdf->setSourceFile("../public/".config('app.DOSSIER_DOCUMENTS_storage')."Ordre_de_missionGEDES.pdf");


        // Import the first page from the PDF and add to dynamic PDF
        $tpl = $pdf->importPage(1);
        $pdf->AddPage();

        // Use the imported page as the template
        $pdf->useTemplate($tpl);

        // Set the default font to use
        $pdf->SetFont('Helvetica');

        // adding a Cell using:
        // $pdf->Cell( $width, $height, $text, $border, $fill, $align);
        // DATE DE FICHE


        // DEPART
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(156, 45.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', date("d/m/Y", strtotime($mission[0]->date_of_day))), 0, 0, 'L'); // add the text, align to Center of cell

        $genre = "";
        if($mission[0]->genre == "Homme"){
            $genre = 'Monsieur';
        }else{
            $genre = 'Madame';
        }
        //  Nom
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(26.5, 95); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$genre." ".$mission[0]->nom." ".$mission[0]->prenom).",", 0, 0, 'L'); // add the text, align to Center of cell

         //  POSTE
         $pdf->SetFontSize('14'); // set font size
         $pdf->SetXY(26.5, 104); // set the position of the box
         $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->poste), 0, 0, 'L'); // add the text, align to Center of cell
 
        // VILLE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(80, 115); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->ville), 0, 0, 'L'); // add the text, align to Center of cell

        // OBJET
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(85, 126.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->objet), 0, 0, 'L'); // add the text, align to Center of cell

        // DUREE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(85, 135.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->duree." jour (s)"), 0, 0, 'L'); // add the text, align to Center of cell

        // DU
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(65, 144); // set the position of the box
        $pdf->Cell(0, 10, date("d/m/Y", strtotime($mission[0]->date_debut)), 0, 0, 'L'); // add the text, align to Center of cell

        // AU
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(110, 144); // set the position of the box
        $pdf->Cell(0, 10, date("d/m/Y", strtotime($mission[0]->date_retour)), 0, 0, 'L'); // add the text, align to Center of cell

        // PRISE EN CHARGE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(45, 164); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', ""), 0, 0, 'L'); // add the text, align to Center of cell

        // render PDF to browser
        //$pdf->Output();

        $date = str_replace(' ', '', $mission[0]->created_at);
        $date = str_replace(':', '',$date);
        $date = str_replace('-', '',$date);
        $pdfFile = "missionO"."-".$mission[0]->code_emp."_".$date.".pdf";

        // Store file
        $pdf->Output("../public/".config('app.DOSSIER_EMPLOYES_storage').$mission[0]->code_emp."/".$pdfFile
            ,"F");    
        return $pdfFile;
    }
}

if(!function_exists('pdf_ordre_mission')){
    function  pdf_ordre_mission  ($mission)
    {
        		/*				13 				*/
        // Create new Portrait PDF
        $pdf = new FPDI('p');

        // Reference the PDF you want to use (use relative path)
        $pagecount = $pdf->setSourceFile("../public/".config('app.DOSSIER_DOCUMENTS_storage')."Ordre_de_missionGEDES.pdf");


        // Import the first page from the PDF and add to dynamic PDF
        $tpl = $pdf->importPage(1);
        $pdf->AddPage();

        // Use the imported page as the template
        $pdf->useTemplate($tpl);

        // Set the default font to use
        $pdf->SetFont('Helvetica');

        // adding a Cell using:
        // $pdf->Cell( $width, $height, $text, $border, $fill, $align);
        // DATE DE FICHE


        // DEPART
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(156, 45.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', date("d/m/Y", strtotime($mission[0]->date_of_day))), 0, 0, 'L'); // add the text, align to Center of cell

        $genre = "";
        if($mission[0]->genre = "Homme"){
            $genre = 'Monsieur';
        }else{
            $genre = 'Madame';
        }
        //  Nom
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(26.5, 95); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$genre." ".$mission[0]->nom." ".$mission[0]->prenom).",", 0, 0, 'L'); // add the text, align to Center of cell

         //  POSTE
         $pdf->SetFontSize('14'); // set font size
         $pdf->SetXY(26.5, 104); // set the position of the box
         $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->poste), 0, 0, 'L'); // add the text, align to Center of cell
 
        // VILLE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(80, 115); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->ville), 0, 0, 'L'); // add the text, align to Center of cell

        // OBJET
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(85, 126.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->objet), 0, 0, 'L'); // add the text, align to Center of cell

        // DUREE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(85, 135.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$mission[0]->duree." jour (s)"), 0, 0, 'L'); // add the text, align to Center of cell

        // DU
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(65, 144); // set the position of the box
        $pdf->Cell(0, 10, date("d/m/Y", strtotime($mission[0]->date_debut)), 0, 0, 'L'); // add the text, align to Center of cell

        // AU
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(110, 144); // set the position of the box
        $pdf->Cell(0, 10, date("d/m/Y", strtotime($mission[0]->date_retour)), 0, 0, 'L'); // add the text, align to Center of cell

        // PRISE EN CHARGE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(45, 164); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', ""), 0, 0, 'L'); // add the text, align to Center of cell

        // render PDF to browser
        //$pdf->Output();

        $date = str_replace(' ', '', $mission[0]->created_at);
        $date = str_replace(':', '',$date);
        $date = str_replace('-', '',$date);
        $pdfFile = "missionO"."-".$mission[0]->code_emp."_".$date.".pdf";

        // Store file
        $pdf->Output("../public/".config('app.DOSSIER_EMPLOYES_storage').$mission[0]->code_emp."/".$pdfFile
            ,"F");    
        return $pdfFile;
    }
}


if(!function_exists('pdf_employe_demande_abscence')){
    function pdf_employe_demande_abscence($abscences)
    {
        //config('app.DOSSIER_DOCUMENTS_storage');
        // Create new Portrait PDF
        $pdf = new Fpdi('p');

        // Reference the PDF you want to use (use relative path)
        $pagecount = $pdf->setSourceFile("../public/".config('app.DOSSIER_DOCUMENTS_storage')."FORMULAIRE_D'AUTORISATION_ABSENCE.pdf");

        // Import the first page from the PDF and add to dynamic PDF
        $tpl = $pdf->importPage(1);
        $pdf->AddPage();

        // Use the imported page as the template
        $pdf->useTemplate($tpl);

        // Set the default font to use
        $pdf->SetFont('Helvetica');

        // adding a Cell using:
        // $pdf->Cell( $width, $height, $text, $border, $fill, $align);

        //  Nom
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(2, 42.5); // set the position of the box
        $pdf->Cell(0, 10, $abscences[0]->nom, 0, 0, 'C'); // add the text, align to Center of cell

        // Prenom
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(2, 55.5); // set the position of the box
        $pdf->Cell(0, 10, $abscences[0]->prenom, 0, 0, 'C'); // add the text, align to Center of cell

        // MATRICULE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(40, 67); // set the position of the box
        $pdf->Cell(0, 10, $abscences[0]->code_emp, 0, 0, 'L'); // add the text, align to Center of cell

        // DEPARTEMENT
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(95, 68); // set the position of the box
        $pdf->Cell(0, 10, $abscences[0]->dept, 0, 0, 'L'); // add the text, align to Center of cell

        // SERVICE
        $pdf->SetFontSize('11'); // set font size
        //$str = iconv('UTF-8', 'windows-1252', "Maintenance des Services à Valeur Ajouté");
        $pdf->SetXY(130, 68.5); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252', $abscences[0]->service), 0, 0, 'L'); // add the text, align to Center of cell

        // MOTIF
        $txt = $abscences[0]->motif;
        $part1 = "";
        $part2 = "";
        $i = 0;
        if( strlen($txt) > 43 ){
            $nbrMots = explode(' ',$txt);
            for($i = 0; $i < count($nbrMots); $i++ ){
                $part1 =$part1.' '.$nbrMots[$i];
                if (strlen($part1) > 43) {
                    break;
                }
            }
            $put = iconv('UTF-8', 'windows-1252', $part1);
            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(95, 80.5); // set the position of the box
            $pdf->Cell(0, 10, $put , 0, 0, 'L'); 

            for($i = $i+1; $i < count($nbrMots); $i++ ){
                $part2 = $part2.' '.$nbrMots[$i];
            }
            $put = iconv('UTF-8', 'windows-1252', $part2);
            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(16, 90); // set the position of the box
            $pdf->Cell(0, 10, $put , 0, 0, 'L'); 
            
        }else{
            $put = iconv('UTF-8', 'windows-1252', $txt);
            $pdf->SetFontSize('14'); // set font size
            $pdf->SetXY(95, 80.5); // set the position of the box
            $pdf->Cell(0,10, $put , 0, 0, 'L'); 
        }

        // DATE DEPART
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(45, 105.5); // set the position of the box
        $pdf->Cell(45, 10, iconv('UTF-8', 'windows-1252',  date("d/m/Y", strtotime($abscences[0]->date_depart))), 0, 0, 'C'); 

        // DATE REPRISE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(130, 106.5); // set the position of the box
        $pdf->Cell(45, 10, iconv('UTF-8', 'windows-1252', date("d/m/Y", strtotime($abscences[0]->date_reprise))), 0, 0, 'C'); 

        // HEURE DEPART
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(45, 116); // set the position of the box
        $pdf->Cell(45, 10, iconv('UTF-8', 'windows-1252', "07:30"), 0, 0, 'C'); 

        // HEURE REPRISE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(130, 117); // set the position of the box
        $pdf->Cell(45, 10, iconv('UTF-8', 'windows-1252', "07:30"), 0, 0, 'C'); 

        // NBR H DEMANDE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(55, 127.5); // set the position of the box
        $pdf->Cell(52, 10, iconv('UTF-8', 'windows-1252', $abscences[0]->nbrJ_demande*8), 0, 0, 'C'); 

        // NBR J DEMANDE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(55, 132.5); // set the position of the box
        $pdf->Cell(52, 10, iconv('UTF-8', 'windows-1252', $abscences[0]->nbrJ_demande), 0, 0, 'C'); 

        // NBR J ACCORDE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(50, 137.5); // set the position of the box
        $pdf->Cell(52, 10, iconv('UTF-8', 'windows-1252', $abscences[0]->nbrJ_accord), 0, 0, 'C'); 

        // NBR J SANS SOLDE
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(70, 138.5); // set the position of the box
        $pdf->Cell(70, 10, iconv('UTF-8', 'windows-1252', $abscences[0]->nbrJ_accord_ssolde), 0, 0, 'C'); 

        // render PDF to browser
        //$pdf->Output();

        $date = str_replace(' ', '', $abscences[0]->created_at);
        $date = str_replace(':', '',$date);
        $date = str_replace('-', '',$date);
        $pdfFile = "abscenceD"."-".$abscences[0]->code_emp."_".$date.".pdf";

        // Store file
        $pdf->Output("../public/".config('app.DOSSIER_EMPLOYES_storage').$abscences[0]->code_emp."/".$pdfFile
            ,"F");

        //$pdfData = $pdf->Output("../public/".config('app.DOSSIER_EMPLOYES_storage').$abscences[0]->code_emp."/demandeAbscence".$abscences[0]->created_at.".pdf",'S');

        return $pdfFile;
    }
}

if(!function_exists('pdf_employe_attestation_conge')){
    function pdf_employe_attestation_conge($conges)
    {
			/*				13 				*/
        // Create new Portrait PDF
        $pdf = new FPDI('p');

        // Reference the PDF you want to use (use relative path)
        $pagecount = $pdf->setSourceFile("../public/".config('app.DOSSIER_DOCUMENTS_storage')."ATTESTATION CONGES model.pdf");

        // Import the first page from the PDF and add to dynamic PDF
        $tpl = $pdf->importPage(1);
        $pdf->AddPage();

        // Use the imported page as the template
        $pdf->useTemplate($tpl);

        // Set the default font to use
        $pdf->SetFont('Helvetica');
        $pdf->SetFont('Helvetica', 'B', 16);

        //  Nom Complet
        $pdf->SetFontSize('12'); // set font size
        $pdf->SetXY(30, 92); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$conges[0]->nom.' '.$conges[0]->prenom), 0, 0, 'L'); // add the text, align to Center of cell
        //  Poste
        $pdf->SetFontSize('12'); // set font size
        $pdf->SetXY(30, 100); // set the position of the box
        $pdf->Cell(0, 10, iconv('UTF-8', 'windows-1252',$conges[0]->poste), 0, 0, 'L'); // add the text, align to Center of cell


        //  Date Depart
        $pdf->SetFontSize('12'); // set font size
        $pdf->SetXY(45, 116); // set the position of the box
        $pdf->Cell(0, 10, date("d/m/Y", strtotime($conges[0]->date_debut)), 0, 0, 'L'); // add the text, align to Center of cell
        //  Date de Reprise -1
        $pdf->SetFontSize('12'); // set font size
        $pdf->SetXY(75, 116); // set the position of the box
        $pdf->Cell(0, 10,date("d/m/Y", strtotime($conges[0]->date_fin_avant)), 0, 0, 'L'); // add the text, align to Center of cell

        //  Date de Reprise
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(115, 131.5); // set the position of the box
        $pdf->Cell(0, 10, date("d/m/Y", strtotime($conges[0]->date_fin)), 0, 0, 'L'); // add the text, align to Center of cell

        $date_of_day = $conges[0]->date_of_day;
        //  Fait le
        $pdf->SetFontSize('14'); // set font size
        $pdf->SetXY(160, 187); // set the position of the box
        $pdf->Cell(0, 10,date("d/m/Y", strtotime($date_of_day)), 0, 0, 'L'); // add the text, align to Center of cell
        
        // render PDF to browser
        //$pdf->Output();

        $date = str_replace(' ', '', $conges[0]->created_at);
        $date = str_replace(':', '',$date);
        $date = str_replace('-', '',$date);
        $pdfFile = "congeA"."-".$conges[0]->code_emp."_".$date.".pdf";

        // Store file
        $pdf->Output("../public/".config('app.DOSSIER_EMPLOYES_storage').$conges[0]->code_emp."/".$pdfFile
            ,"F");

        //$pdfData = $pdf->Output("../public/".config('app.DOSSIER_EMPLOYES_storage').$abscences[0]->code_emp."/demandeAbscence".$abscences[0]->created_at.".pdf",'S');

        return $pdfFile;
    }
}


?>