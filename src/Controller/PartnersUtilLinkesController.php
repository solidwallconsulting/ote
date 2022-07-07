<?php

namespace App\Controller;

use App\Entity\PartnersUtilLinkes;
use App\Form\PartnersUtilLinkesType;
use App\Repository\PartnersUtilLinkesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partners/util/linkes")
 */
class PartnersUtilLinkesController extends AbstractController
{
    /**
     * @Route("/", name="app_partners_util_linkes_index", methods={"GET"})
     */
    public function index(PartnersUtilLinkesRepository $partnersUtilLinkesRepository): Response
    {
        return $this->render('partners_util_linkes/index.html.twig', [
            'partners_util_linkes' => $partnersUtilLinkesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_partners_util_linkes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PartnersUtilLinkesRepository $partnersUtilLinkesRepository): Response
    {
        $partnersUtilLinke = new PartnersUtilLinkes();
        $form = $this->createForm(PartnersUtilLinkesType::class, $partnersUtilLinke);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnersUtilLinkesRepository->add($partnersUtilLinke, true);

            return $this->redirectToRoute('app_partners_util_linkes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partners_util_linkes/new.html.twig', [
            'partners_util_linke' => $partnersUtilLinke,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_partners_util_linkes_show", methods={"GET"})
     */
    public function show(PartnersUtilLinkes $partnersUtilLinke): Response
    {
        return $this->render('partners_util_linkes/show.html.twig', [
            'partners_util_linke' => $partnersUtilLinke,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_partners_util_linkes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PartnersUtilLinkes $partnersUtilLinke, PartnersUtilLinkesRepository $partnersUtilLinkesRepository): Response
    {
        $form = $this->createForm(PartnersUtilLinkesType::class, $partnersUtilLinke);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnersUtilLinkesRepository->add($partnersUtilLinke, true);

            return $this->redirectToRoute('app_partners_util_linkes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partners_util_linkes/edit.html.twig', [
            'partners_util_linke' => $partnersUtilLinke,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_partners_util_linkes_delete", methods={"POST"})
     */
    public function delete(Request $request, PartnersUtilLinkes $partnersUtilLinke, PartnersUtilLinkesRepository $partnersUtilLinkesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partnersUtilLinke->getId(), $request->request->get('_token'))) {
            $partnersUtilLinkesRepository->remove($partnersUtilLinke, true);
        }
 
        return $this->redirectToRoute('app_partners_edit', ['id'=>$partnersUtilLinke->getPartner()->getId()], Response::HTTP_SEE_OTHER);
    }
}
