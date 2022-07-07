<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
 
use Symfony\Component\Mime\Email;  

class SecurityController extends AbstractController
{
    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

 /*
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
 
 
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }*/


    /**
     * @Route("/create-account", name="create_account_route")
     */
    public function create_account_route(Request $request, UserRepository $userRepository): Response
    {
         
        $user = new User();
        $user->setGender(0);
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            
            $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $user->setPhotoURL('/users/default.png');
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }



    

    
    /**
     * @Route("/forget-password", name="forget_password_route", methods={"GET","POST"})
     */
    public function forgetPassword(Request $request,UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $errorMessage='';
        $successMessage='';
        

        if ($request->getMethod() == 'POST') {
            $email = trim($request->request->get('email'));
            $user = $userRepository->findOneBy(['email'=>$email]);
            if ($user != null) {

                $domaine = $request->server->get('HTTP_HOST');
                $token = uniqid($email,true);

                $blocEmail = '<h1>Tunisiens Du Monde</h1>
                <h3>Mot de passe oublié?</h3> 
                <p>Vous nous avez dit que vous avez oublié votre mot de passe. Définissez-en un nouveau en suivant le lien ci-dessous.</p>
                <a href="http://'.$domaine.'/new-password?token='.$token.'">réinitialiser le mot de passe</a>
                <hr/>';
                $blocEmail.="<p>Si vous n'avez pas besoin de réinitialiser votre mot de passe, ignorez simplement cet e-mail. Votre mot de passe ne changera pas.</p>";                
 

                $user->setResetPasswordToken($token);

                $this->getDoctrine()->getManager()->flush();


                // send verification mail
                $emailMessage = (new Email())
                ->from('contact@tdm.com.tn')
                ->to($email) 
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Mot de passe oublié')
                ->html($blocEmail);

            

            try {
                $mailer->send($emailMessage);
                $successMessage="un e-mail de vérification a été envoyé avec succès à ".$email.", veuillez vérifier votre boîte de réception.";
             
            } catch (\Throwable $th) {
               // dump($th);
                $errorMessage="Une erreur s'est produite. Veuillez réessayer."; 
            }
 
               
            }else{
                $errorMessage= 'Mauvaise adresse e-mail, veuillez réessayer';
            }
        
        }



        return $this->render('security/forget-password.html.twig', [ 
            'errorMessage'=>$errorMessage,
            'successMessage'=>$successMessage
       ]);
    }




    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
