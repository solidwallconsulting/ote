<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppController extends AbstractController
{


    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/app", name="app_app")
     */
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }



    /**
     * @Route("/new-password", name="new_password_route", methods={"GET","POST"})
     */
    public function newPassword(Request $request,UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $errorMessage='';
        $successMessage=''; 

        if ($request->getMethod() == 'POST') {

            $token = $request->query->get('token'); 
            $newPasswordTXT = trim($request->request->get('new-password'));
            $user = $userRepository->findOneBy(['resetPasswordToken'=>$token]);

             
           if ($user != null) {
              
            $user->setPassword($this->encoder->encodePassword($user,$newPasswordTXT));
            $user->setResetPasswordToken(null);

            $this->getDoctrine()->getManager()->flush();

            $successMessage ='Votre mot de passe est mis à jour avec succès.';
            
           }else{
               $errorMessage ='On dirait que vous utilisez un ancien lien.';
           }
        
        }



        return $this->render('app/new-password.html.twig', [ 
            'errorMessage'=>$errorMessage,
            'successMessage'=>$successMessage
       ]);
    }


}
