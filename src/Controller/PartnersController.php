<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Entity\PartnerSocialMedias;
use App\Entity\PartnersUtilLinkes;
use App\Entity\PartnersUtilsDocs;
use App\Entity\User;
use App\Form\PartnerSocialMediasType;
use App\Form\PartnersType;
use App\Form\PartnersUtilLinkesType;
use App\Form\PartnersUtilsDocsType;
use App\Form\UserType;
use App\Repository\ConventionsRepository;
use App\Repository\PartnerSocialMediasRepository;
use App\Repository\PartnersRepository;
use App\Repository\PartnersUtilLinkesRepository;
use App\Repository\PartnersUtilsDocsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin-dashboard/partners")
 */
class PartnersController extends AbstractController
{

    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/", name="app_partners_index", methods={"GET"})
     */
    public function index(PartnersRepository $partnersRepository): Response
    {
        return $this->render('partners/index.html.twig', [
            'partners' => $partnersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_partners_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PartnersRepository $partnersRepository): Response
    {
        $partner = new Partners();
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            //hundle partner logo url
            $image = $form->get('logoURL')->getData(); 
            
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $image->move('multi/partners/',
                        $newFilename
                    );
                    $partner->setLogoURL('/multi/partners/'.$newFilename);
                } catch (FileException $e) {
                     
                }
 
                
            } 

            $coverImageURL = $form->get('coverImageURL')->getData(); 
            
            if ($coverImageURL) {
                $newFilename = uniqid().'.'.$coverImageURL->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $coverImageURL->move('multi/partners/',
                        $newFilename
                    );
                    $partner->setCoverImageURL('/multi/partners/'.$newFilename);
                } catch (FileException $e) {
                     
                }
 
                
            }  

            $partner->setViews(0);
            $partnersRepository->add($partner);
            return $this->redirectToRoute('create_operateur_account_route', ['id'=>$partner->getId(), 'ok'=>'Partenaire ajouté avec succès'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partners/new.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_partners_show", methods={"GET"})
     */
    public function show(Partners $partner): Response
    {
        return $this->render('partners/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_partners_edit", methods={"GET", "POST"})
     */
    public function edit(PartnersUtilLinkesRepository $partnersUtilLinkesRepository , Request $request, PartnerSocialMediasRepository $partnerSocialMediasRepository, Partners $partner, PartnersRepository $partnersRepository, PartnersUtilsDocsRepository $partnersUtilsDocsRepository): Response
    {
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        //hundle partner logo url
        $image = $form->get('logoURL')->getData(); 
                    
        if ($image) {
            $newFilename = uniqid().'.'.$image->guessExtension();

            // Move the file to the directory where brochures are stored
            try { 
                $image->move('multi/partners/',
                    $newFilename
                );
                $partner->setLogoURL('/multi/partners/'.$newFilename);
            } catch (FileException $e) {
                
            }

            
        } 

        $coverImageURL = $form->get('coverImageURL')->getData(); 
        
        if ($coverImageURL) {
            $newFilename = uniqid().'.'.$coverImageURL->guessExtension();

            // Move the file to the directory where brochures are stored
            try { 
                $coverImageURL->move('multi/partners/',
                    $newFilename
                );
                $partner->setCoverImageURL('/multi/partners/'.$newFilename);
            } catch (FileException $e) {
                
            }

            
        }   

             
            $partnersRepository->add($partner);
            return $this->redirectToRoute('app_partners_index', ['ok'=>'Partenaire mis à jour avec succès'], Response::HTTP_SEE_OTHER);
        }



        // docs

        $partnersUtilsDoc = new PartnersUtilsDocs();
        $partnersUtilsDoc->setPartner($partner);
        $formDoc = $this->createForm(PartnersUtilsDocsType::class, $partnersUtilsDoc);
        $formDoc->handleRequest($request);

        if ($formDoc->isSubmitted() && $formDoc->isValid()) { 

            $doc = $formDoc->get('docURL')->getData(); 
        
            if ($doc) {
                $newFilename = uniqid().'.'.$doc->guessExtension();
    
                // Move the file to the directory where brochures are stored
                try { 
                    $doc->move('partners-docs/docs/',
                        $newFilename
                    );
                    $partnersUtilsDoc->setDocURL('/partners-docs/docs/'.$newFilename);
                    $partnersUtilsDocsRepository->add($partnersUtilsDoc, true);
                    return $this->redirectToRoute('app_partners_edit', ['id'=>$partner->getId(),'ok'=>'Document ajouté avec succès'], Response::HTTP_SEE_OTHER);
                } catch (FileException $e) {
                    
                }
    
                
            }   

            

           
        }

         



        // social media
        $partnerSocialMedia = new PartnerSocialMedias();
        $partnerSocialMedia->setPartner($partner);
        $formSocial = $this->createForm(PartnerSocialMediasType::class, $partnerSocialMedia);
        $formSocial->handleRequest($request);

        if ($formSocial->isSubmitted() && $formSocial->isValid()) {
            $partnerSocialMediasRepository->add($partnerSocialMedia, true); 
            return $this->redirectToRoute('app_partners_edit', ['id'=>$partner->getId(),'ok'=>'Réseau ajouté avec succès'], Response::HTTP_SEE_OTHER);
        }



        // links

        $partnersUtilLinke = new PartnersUtilLinkes();
        $partnersUtilLinke->setPartner($partner);
        $formLinks = $this->createForm(PartnersUtilLinkesType::class, $partnersUtilLinke);
        $formLinks->handleRequest($request);


        

        if ($formLinks->isSubmitted() && $formLinks->isValid()) {
            $partnersUtilLinkesRepository->add($partnersUtilLinke, true);

            return $this->redirectToRoute('app_partners_edit', ['id'=>$partner->getId(),'ok'=>'Lien ajouté avec succès'], Response::HTTP_SEE_OTHER);
        }
 

        return $this->renderForm('partners/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,

            'partners_utils_doc' => $partnersUtilsDoc,
            'formDoc' => $formDoc,

            'partner_social_media' => $partnerSocialMedia,
            'formSocial' => $formSocial,

            'partners_util_linke' => $partnersUtilLinke,
            'formLinks' => $formLinks

        ]);
    }

    /**
     * @Route("/{id}", name="app_partners_delete", methods={"POST"})
     */
    public function delete(Request $request, Partners $partner, PartnersRepository $partnersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {

            $partnersRepository->remove($partner);

        }

        return $this->redirectToRoute('app_partners_index', [], Response::HTTP_SEE_OTHER);
    }





    /**
     * @Route("/create-account/{id}", name="create_operateur_account_route")
     */
    public function create_account_route(Partners $partner, Request $request, UserRepository $userRepository): Response
    {
         
        $user = new User();

        

        $form = $this->createForm(UserType::class, $user,['operateur'=>true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));
            $user->setRoles(['ROLE_OPERATOR']);
            $user->setPhotoURL('/users/default.png');
            

            $entityManager->persist($user); 
            $partner->setUser($user); 
            $entityManager->flush();


            return $this->redirectToRoute('app_partners_index', ['ok'=>'Partenaire ajouté avec succès'], Response::HTTP_SEE_OTHER);




        }
        
        return $this->render('partners/new-step-two.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }



}
