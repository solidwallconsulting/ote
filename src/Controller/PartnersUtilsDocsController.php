<?php

namespace App\Controller;

use App\Entity\PartnersUtilsDocs;
use App\Form\PartnersUtilsDocsType;
use App\Repository\PartnersUtilsDocsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partners/utils/docs")
 */
class PartnersUtilsDocsController extends AbstractController
{
    /**
     * @Route("/", name="app_partners_utils_docs_index", methods={"GET"})
     */
    public function index(PartnersUtilsDocsRepository $partnersUtilsDocsRepository): Response
    {
        return $this->render('partners_utils_docs/index.html.twig', [
            'partners_utils_docs' => $partnersUtilsDocsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_partners_utils_docs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PartnersUtilsDocsRepository $partnersUtilsDocsRepository): Response
    {
        $partnersUtilsDoc = new PartnersUtilsDocs();
        $form = $this->createForm(PartnersUtilsDocsType::class, $partnersUtilsDoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            

            $partnersUtilsDocsRepository->add($partnersUtilsDoc, true);

            return $this->redirectToRoute('app_partners_utils_docs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partners_utils_docs/new.html.twig', [
            'partners_utils_doc' => $partnersUtilsDoc,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_partners_utils_docs_show", methods={"GET"})
     */
    public function show(PartnersUtilsDocs $partnersUtilsDoc): Response
    {
        return $this->render('partners_utils_docs/show.html.twig', [
            'partners_utils_doc' => $partnersUtilsDoc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_partners_utils_docs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PartnersUtilsDocs $partnersUtilsDoc, PartnersUtilsDocsRepository $partnersUtilsDocsRepository): Response
    {
        $form = $this->createForm(PartnersUtilsDocsType::class, $partnersUtilsDoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnersUtilsDocsRepository->add($partnersUtilsDoc, true);

            return $this->redirectToRoute('app_partners_utils_docs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partners_utils_docs/edit.html.twig', [
            'partners_utils_doc' => $partnersUtilsDoc,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_partners_utils_docs_delete", methods={"POST"})
     */
    public function delete(Request $request, PartnersUtilsDocs $partnersUtilsDoc, PartnersUtilsDocsRepository $partnersUtilsDocsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partnersUtilsDoc->getId(), $request->request->get('_token'))) {
            $partnersUtilsDocsRepository->remove($partnersUtilsDoc, true);
        }

        return $this->redirectToRoute('app_partners_edit', ['id'=>$partnersUtilsDoc->getPartner()->getId()], Response::HTTP_SEE_OTHER);
    }
}
