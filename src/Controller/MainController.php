<?php

namespace App\Controller;

use App\Entity\Coupon;
use App\Entity\DirectMessage;
use App\Entity\Partners;
use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewType;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\CouponRepository;
use App\Repository\DirectMessageRepository;
use App\Repository\PartnersRepository;
use App\Repository\RegionRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{

    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    /**
     * @Route("/redirect", name="redirect_route")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user->getRoles()[0] == 'ROLE_ADMIN') {
            return $this->redirectToRoute('admin_route');
        }   


        if ($user->getRoles()[0] == 'ROLE_USER') {
            return $this->redirectToRoute('main_app_route');
        }   



        if ($user->getRoles()[0] == 'ROLE_OPERATOR') {
            return $this->redirectToRoute('operator_app_route');
        }   



        


        
    }


    /**
     * @Route("/", name="app_login", methods={"GET", "POST"})
     */
    public function welcome(Request $request, AuthenticationUtils $authenticationUtils): Response
    {


        

        if ($this->getUser()) {
             return $this->redirectToRoute('redirect_route');
        }

         
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();




        
        $user = new User();
        $user->setGender(0);
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
 
            $entityManager = $this->getDoctrine()->getManager();
            $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $user->setPhotoURL('/users/default.png');
            

            $entityManager->persist($user);
            $entityManager->flush();
            
            
        }
        
    


        return $this->render('main/index.html.twig', [ 
            'last_username' => $lastUsername, 'error' => $error,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }



    
    /**
     * @Route("/operateur-dashboard", name="operator_app_route")
     */
    public function operator_app_route(DirectMessageRepository $directMessageRepository, PartnersRepository $partnersRepository)
    {

        $messagesFlux = [];


            $partner = $partnersRepository->findOneBy(['user'=>$this->getUser()]);


        
            $user = $this->getUser();

            // total
            $tmpMessages = $directMessageRepository->findBy(['receiver'=>$user->getId()]);
            
            // new
            $newMessages = $directMessageRepository->findBy(['receiver'=>$user->getId(),"vue"=>0]);

  
  
        $messages = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId()]);
        return $this->render('main/operateur.html.twig', [ 
            'messages'=>$messages,
            'newMessages'=>$newMessages,
            'allMessages'=>$tmpMessages,
            
            "partner"=>$partner,
            'messagesFlux'=>$messagesFlux
        ]);
    }



    /**
     * @Route("/operateur-dashboard/messages", name="operator_messages_app_route")
     */
    public function operator_messages_app_route(DirectMessageRepository $directMessageRepository)
    {

        // notifications
        $messages = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId(),'vue'=>0]);



        $received = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId() ]);
        $sent = $directMessageRepository->findBy(['sender'=>$this->getUser()->getId() ]);
        

        $talkingWith = [];



        foreach ($received as $key => $value) {
            
            $alreadyAdded = false;

            foreach ($talkingWith as $key => $tmp) {
                if ($value->getSender()->getId() == $tmp->getId() ) {
                    $alreadyAdded =true;
                }
            }

            if ($alreadyAdded == false) {
                array_push($talkingWith,$value->getSender());
            }

        }


        foreach ($sent as $key => $value) {
            $alreadyAdded = false;

            foreach ($talkingWith as $key => $tmp) {
                if ($value->getReceiver()->getId() == $tmp->getId() ) {
                    $alreadyAdded =true;
                }
            }

            if ($alreadyAdded == false) {
                array_push($talkingWith,$value->getReceiver());
            }

        }
        




        return $this->render('main/messages.html.twig', [ 
            'messages'=>$messages,
            'talkingWith'=>$talkingWith
        ]);
    }


    /**
     * @Route("/operateur-dashboard/direct/{id}", name="operator_messages_direct_app_route")
     */
    public function operator_messages_direct_user_app_route( Request $request, DirectMessageRepository $directMessageRepository, User $user)
    {
        $messages = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId(),'vue'=>0]);



        $chats=[];

        $received = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId(),'sender'=>$user->getId()]);
        $sent = $directMessageRepository->findBy(['sender'=>$this->getUser()->getId(),'receiver'=>$user->getId()]);
        
        

        foreach ($received as $key => $value) {
            array_push($chats,$value);
        }
        foreach ($sent as $key => $value) {
            array_push($chats,$value);
        }

        // vues

        foreach ($chats as $key => $chat) {
            if ( $chat->getSender()->getId() != $this->getUser()->getId()  ) {
                $chat->setVue(1);
                $this->getDoctrine()->getManager()->flush();
            }
        }



        /***************************** */


        
        $received2 = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId() ]);
        $sent2 = $directMessageRepository->findBy(['sender'=>$this->getUser()->getId() ]);
        

        $talkingWith = [];



        foreach ($received2 as $key => $value) {
            
            $alreadyAdded = false;

            foreach ($talkingWith as $key => $tmp) {
                if ($value->getSender()->getId() == $tmp->getId() ) {
                    $alreadyAdded =true;
                }
            }

            if ($alreadyAdded == false) {
                array_push($talkingWith,$value->getSender());
            }

        }


        foreach ($sent2 as $key => $value) {
            $alreadyAdded = false;

            foreach ($talkingWith as $key => $tmp) {
                if ($value->getReceiver()->getId() == $tmp->getId() ) {
                    $alreadyAdded =true;
                }
            }

            if ($alreadyAdded == false) {
                array_push($talkingWith,$value->getReceiver());
            }

        }
        

        
        $method = $request->getMethod();

        if ($method == "POST") {


            $msg = $request->request->get('message'); 
            $msg = trim($msg); 
            $direct = new DirectMessage();
            $direct->setSender($this->getUser());
            $direct->setReceiver($user);
            $direct->setMessageDate(new DateTime());
            $direct->setMessage($msg); 
            $direct->setVue(0);
 

            if ($msg != '') {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($direct);
                $entityManager->flush();
            }
 

            
             
            return $this->redirectToRoute('operator_messages_direct_app_route', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
        

        }

        return $this->render('main/direct.html.twig', [ 
            'messages'=>$messages,
            'chats'=>$chats,
            'talkingWith'=>$talkingWith,
            'target'=>$user
        ]);
    }






    /**
     * @Route("/tunisiens-du-monde", name="main_app_route")
     */
    public function main_app_route(DirectMessageRepository $directMessageRepository, PartnersRepository $partnersRepository): Response
    {
        $messages = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId(),'vue'=>0]); 
        $partners = $partnersRepository->findAll();
        
        return $this->render('main/app.html.twig', [
            'partners'=>$partners,
            "messages"=>$messages
        ]);
    }


    /**
     * @Route("/stand/view/{id}", name="stand_route")
     */
    public function stand_route( Partners $partners ): Response
    {
         
        return $this->render('main/stand.html.twig', [
             'partner'=>$partners
        ]);
    }





    /**
     * @Route("/main/app/send-message/{id}/{message}", name="send_message_route", methods={"POST"})
     */
    public function FunctionName(Partners $partner,$message, DirectMessageRepository $directMessageRepository): JsonResponse
    {
        

        $directMessage = new DirectMessage();
        $directMessage->setVue(0);
        $directMessage->setMessageDate(new DateTime());
        $directMessage->setMessage($message);
        $directMessage->setSender($this->getUser());
        $directMessage->setReceiver($partner->getUser());

        $directMessageRepository->add($directMessage, true);


        return $this->json([ 'message'=>$message, 'id_message'=>$directMessage->getId(),'success'=>true ]); 

    }





    /**
     * @Route("/espace-client", name="espace_client_route")
     */
    public function espace_client(DirectMessageRepository $directMessageRepository, Request $request, UserRepository $userRepository): Response
    {
        $messages = $directMessageRepository->findBy(['receiver'=>$this->getUser()->getId(),'vue'=>0]);

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
                    $user->setPhotoURL('/multi/users/'.$newFilename);
                } catch (FileException $e) { 
                } 
            } 
 

            $userRepository->add($user);
            return $this->redirectToRoute('espace_client_route');
        }
         
        
        return $this->render('main/espace-client.html.twig', [
            "messages"=>$messages,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

   
    



 
    
}
