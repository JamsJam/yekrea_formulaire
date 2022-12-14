<?php

namespace App\Controller;

use App\Service\Mail;
use App\Entity\Devis;
use DateTimeImmutable;
use App\Entity\Command;
use App\Repository\DevisRepository;
use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidateController extends AbstractController
{
    /** A la validation de la commande, cette route permet:
     * - La création d'une nouvelle entré dans la table devis dans la table DEVIS
     * - l'insertion de la "date de validation" dans la table COMMANDE
     * 
     * @Route("admin/command/validate/{id}", name="app_validate")
     */
    public function index( Command $command, CommandRepository $commandRepository, DevisRepository $devisRepository ): Response

    {
        $command->setIsValidated(true);

        $serviceDetails = null;
        $service = null;
        // création du numéro de devis à la validation du bouton

        $devis = new Devis();

        //Definition par defaut du Statut En attente (en attente d'une validation client)
        $devis->setStatus("pending");

        //Selection du change ServicesDetail dans command : retourne un tableau d'objet
        $servicesDetail = $command->getServicesDetail();
        //foreach sur le tableau pour atteintre les objets
        foreach ($servicesDetail as $i => $serviceDetail) {
            if ($i<1) {              
                $serviceDetails = $serviceDetail->getNom();
                $service = $serviceDetail->getServices()->getNom();
            } else {            
                //stockage de toute les element sercive et services details dans des variable dediés
                $serviceDetails = $serviceDetails .','. $serviceDetail->getNom();
                $service = $service .','. $serviceDetail->getServices()->getNom();
            }
        }


            
            $materiels = $command->getMateriel();
            $materielDevis = null;
            foreach ($materiels as $index => $materiel) {
                if($index < 1){
                    $materielDevis = $materiel->getNom();
                }else{
                    $materielDevis = $materielDevis .','. $materiel->getNom();

                }
            }
            
            
            
            // creer un numero de devis unique basé sur la fonction Time()
            $numDevis= time()-1663170000;
            
        //assignation dans les champs dédié du ....
        //...Numeros de commande
        $devis->setnumDevis($numDevis);
        //des Service_details
        $devis -> setServiceDetail($serviceDetails);
        //des Service
        $devis -> setService($service);
        // insert dans la table la date de validation de la commande
        $command->setValidationDate(new DateTimeImmutable("now"));
        //de la commande de reference
        $devis->setCommand($command);
        // du materiel necessaire a la commande
        $devis->setMateriel($materielDevis);

        // ajoute en BDD si l'id n'existe pas et le modifie si l'ID existe
        $commandRepository->add($command, true);
        
        $devisRepository->add($devis, true);
        
        return $this->redirectToRoute('app_command_show',["id"=>$command->getId()], Response::HTTP_SEE_OTHER);
    }


    /** 
     * Sur validation de la decision client,
     * -->changement du status du devis : accepté ou annulé
     * -->Definition de la date de decision
     * -->envoie en BDD
     * @Route("admin/devis/validate/{id}", name="app_devis_validate")
     */
    public function clientValidateDevis( Devis $devis, DevisRepository $devisRepository, Request $request ): Response
    {
        $status = $request->query->get('status');
        
        $devis->setStatus($status);
        $devis->setClientDecisionDate(new DateTimeImmutable("now"));
        $devisRepository->add($devis, true);

        
        
        return $this->redirectToRoute('app_devis_show',["id"=>$devis->getId()], Response::HTTP_SEE_OTHER);
    }

    

}
