<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
             
        ]);
    }

    /**
     * @Route("/profile/update-info", name="update_profile_route")
     */
    public function update_info(Request $request,UserRepository $userRepository): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user,['edit_password'=>false,'edit_photo'=>true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $image = $form->get('photoURL')->getData();
            
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $image->move('multi/users/',
                        $newFilename
                    );
                } catch (FileException $e) {
                     
                }
 
                $user->setPhotoURL('/multi/users/'.$newFilename);
            } 





            $userRepository->add($user);
            return $this->redirectToRoute('app_profile');
        }
        
        return $this->render('profile/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);

 
    }



    
}
