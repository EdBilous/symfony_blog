<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use BlogBundle\Services\ImagesUploaderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Article controller.
 *
 * @Route("admin/articles")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="admin_articles")
     * @Method("GET")
     */
    public function articlesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em
            ->getRepository('AppBundle:Article')
            ->findAll();
//        Doctrine\Common\Util\Debug::dump();
        return $this->render('admin/article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * Creates a new article entity.
     *
     * @Route("/new", name="admin_article_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, ImagesUploaderService $ImagesUploaderService)
    {
        $article = new Article();

        $form = $this->createForm('AppBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $article->getImage();
            if ($file) {

                $fileName = $ImagesUploaderService->upload($file);
                $article->setImage($fileName);

            }

            $articleManager = $this->get("blog.article_manager.service");
            $articleManager->articleCreate($article);

            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/article_new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/{slug}", name="article_show")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('admin/article_show.html.twig', [
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ]);
    }


    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/edit/{slug}/", name="article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('AppBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/article_edit.html.twig', [
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/search/", name="app_search_route")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchArticlesAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\SearchType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
            $inquiry = $form->getData()['inquiry'];
            $result = $articlesRepository->searchBy($inquiry);

            return $this->render('admin/article_search.html.twig', [
                'articles' => $result,
                'inquiry' => $inquiry,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('admin/search_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * Deletes a article entity.
     *
     * @Route("/delete/{slug}/", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('admin_articles');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('article_delete', array('slug' => $article->getSlug())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }
}
