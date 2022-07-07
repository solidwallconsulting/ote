<?php

namespace App\Controller;

use App\Entity\DirectMessage;
use App\Entity\User;
use App\Repository\DirectMessageRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    

    

    /**
     * @Route("/espace-client/messages", name="client_messages_app_route")
     */
    public function client_messages_app_route(DirectMessageRepository $directMessageRepository)
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
        




        return $this->render('client/messages.html.twig', [ 
            'messages'=>$messages,
            'talkingWith'=>$talkingWith
        ]);
    }


    /**
     * @Route("/espace-client/direct/{id}", name="client_messages_direct_app_route")
     */
    public function client_messages_direct_app_route( Request $request, DirectMessageRepository $directMessageRepository, User $user)
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
 
             
            return $this->redirectToRoute('client_messages_direct_app_route', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
        

        }

        return $this->render('client/direct.html.twig', [ 
            'messages'=>$messages,
            'chats'=>$chats,
            'talkingWith'=>$talkingWith,
            'target'=>$user
        ]);
    }




}
