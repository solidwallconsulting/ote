<?php

namespace App\Controller;

use App\Repository\DirectMessageRepository;
use App\Repository\PartnersRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin-dashboard", name="admin_route")
     */
    public function index(
        UserRepository $userRepository,
        PartnersRepository $partnersRepository ,
        DirectMessageRepository $directMessageRepository
    ): Response
    {




        $messagesFlux = [];


        $partners = $partnersRepository->findAll();


        foreach ($partners as $key => $partner) {
            $user = $partner->getUser();

            // total
            $tmpMessages = $directMessageRepository->findBy(['receiver'=>$user->getId()]);
            
            // new
            $newMessages = $directMessageRepository->findBy(['receiver'=>$user->getId(),"vue"=>0]);


            array_push(
                $messagesFlux, array("partner"=>$partner,"messages"=>sizeof($tmpMessages),"new_messages"=>sizeof($newMessages))
            );
            
        }


        //dump($messagesFlux);


        
        return $this->render('admin/index.html.twig', [ 
            'users'=>$userRepository->findAll(),
            'partners'=>$partnersRepository->findAll(),
            'messagesFlux'=>$messagesFlux
           
            
        ]);
    }
}
