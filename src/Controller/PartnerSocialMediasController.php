<?php

namespace App\Controller;

use App\Entity\PartnerSocialMedias;
use App\Form\PartnerSocialMediasType;
use App\Repository\PartnerSocialMediasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partner/social/medias")
 */
class PartnerSocialMediasController extends AbstractController
{
    /**
     * @Route("/", name="app_partner_social_medias_index", methods={"GET"})
     */
    public function index(PartnerSocialMediasRepository $partnerSocialMediasRepository): Response
    {
        return $this->render('partner_social_medias/index.html.twig', [
            'partner_social_medias' => $partnerSocialMediasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_partner_social_medias_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PartnerSocialMediasRepository $partnerSocialMediasRepository): Response
    {
        $partnerSocialMedia = new PartnerSocialMedias();
        $form = $this->createForm(PartnerSocialMediasType::class, $partnerSocialMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerSocialMediasRepository->add($partnerSocialMedia, true);

            return $this->redirectToRoute('app_partner_social_medias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partner_social_medias/new.html.twig', [
            'partner_social_media' => $partnerSocialMedia,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_partner_social_medias_show", methods={"GET"})
     */
    public function show(PartnerSocialMedias $partnerSocialMedia): Response
    {
        return $this->render('partner_social_medias/show.html.twig', [
            'partner_social_media' => $partnerSocialMedia,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_partner_social_medias_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PartnerSocialMedias $partnerSocialMedia, PartnerSocialMediasRepository $partnerSocialMediasRepository): Response
    {
        $form = $this->createForm(PartnerSocialMediasType::class, $partnerSocialMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerSocialMediasRepository->add($partnerSocialMedia, true);

            return $this->redirectToRoute('app_partner_social_medias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partner_social_medias/edit.html.twig', [
            'partner_social_media' => $partnerSocialMedia,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_partner_social_medias_delete", methods={"POST"})
     */
    public function delete(Request $request, PartnerSocialMedias $partnerSocialMedia, PartnerSocialMediasRepository $partnerSocialMediasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partnerSocialMedia->getId(), $request->request->get('_token'))) {
            $partnerSocialMediasRepository->remove($partnerSocialMedia, true);
        }

      
        return $this->redirectToRoute('app_partners_edit', ['id'=>$partnerSocialMedia->getPartner()->getId()], Response::HTTP_SEE_OTHER);
    }
}
