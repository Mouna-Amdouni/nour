<?php

namespace App\Controller;

use App\Entity\Enqueteur;
use App\Entity\Sondage;
use App\Entity\Question;
use App\Entity\Utilisateur;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use App\Repository\SujetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sondage")
 */
class SondageController extends AbstractController
{
    /**
     * @Route("/", name="sondage_index", methods={"GET"})
     */
    public function index(SondageRepository $sondageRepository): Response
    {
        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondageRepository->findAll(),
        ]);
    }
    /**
     * @Route("/sondages",name="listesondage",methods="GET")
     */
    public function getSondages(){
        $repo=$this->getDoctrine()->getRepository(Sondage::class);
        $sondages=$repo->findAll();
        
        
        foreach($sondages as $son)
        {    
            $em1=$this->getDoctrine()->getManager();
            $NbrSondage =count($em1->getRepository(Question::class)->findByNbrSondage($son->getId()));
            $son->setNbQuestion($NbrSondage );
            $em1->flush();
        }
        


        return $this->render('sondage/liste_sondage.html.twig',[
            'sondages'=>$sondages
            
        ]);
    }

    /**
     * @Route("/new/{id}", name="sondage_new", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param SujetRepository $sujetRepository
     * @param Utilisateur $utilisateur
     * @return Response
     */
    public function new($id,Request $request,SujetRepository $sujetRepository,Enqueteur $utilisateur): Response
    {
//        dd($request);
        $sondage = new Sondage();
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);
        $enqueteur = new Enqueteur();
      //  $enqueteur=$enqueteur->

//        $utilisateur= new Utilisateur();
//        $utilisateur=$utilisateur->getId();
        //dd($utilisateur);
        $sujet=$sujetRepository->find($id);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $sondage->setSujet($sujet);
            $sondage->setEnqueteur($utilisateur);
            //dd($sondage);
            $entityManager->persist($sondage);
            $entityManager->flush();

            return $this->redirectToRoute('neww', [
                    'id' => $sondage->getId()
                ]
            );
        }

        return $this->render('sondage/new.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/{id}", name="sondage_show", methods={"GET"})
     * @param Sondage $sondage
     * @return Response
     */
    public function show(Sondage $sondage): Response
    {
        return $this->render('sondage/show.html.twig', [
            'sondage' => $sondage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sondage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sondage $sondage): Response
    {
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sondage_index');
        }

        return $this->render('sondage/edit.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sondage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sondage $sondage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sondage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sondage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sondage_index');
    }
    /**
     * @Route("/sondagee/{id}",name="sondagee")
     * @param $id
     */
    public function getQuestion($id,SondageRepository $sondageRepository){

            $sondage=$sondageRepository->find($id);
            dd($sondage);

    }
}
