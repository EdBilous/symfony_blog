<?php

namespace BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

//use AppBundle\Controller\ArticleController;

class DefaultController extends Controller
{

    /**
     * Lists all article entities.
     * @Method({"GET", "POST"})
     * @Route("/blog/index.html", name="blog_index_route")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em
            ->getRepository('AppBundle:Article')
            ->findAll();

        $form = $this->createForm('AppBundle\Form\SearchType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
            $inquiry = $form->getData()['inquiry'];
            $result = $articlesRepository->searchBy($inquiry);

            return $this->render('@Blog/blog_view/articleSearch.html.twig', [
                'articles' => $result,
                'inquiry' => $inquiry,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('@Blog/blog_view/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/show/{slug}", name="blog_show_route")
     * @Method("GET")
     */
    public function singleAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em
            ->getRepository('AppBundle:Article')
            ->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException("No article found for $slug");
        }

        return $this->render('@Blog/blog_view/articleShow.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/blog/category/{category}", name="blog_category_route")
     * @Method("GET")
     */
    public function categoryAction($category)
    {
        $em = $this->getDoctrine()->getManager();

        $categorybytitle = $em
            ->getRepository('AppBundle:Category')
            ->findBy(['title' => $category]);

        if (!$categorybytitle) {
            throw $this->createNotFoundException("No category found for $category");
        }

        return $this->render('@Blog/blog_view/categoryShow.html.twig', ['categorybytitle' => $categorybytitle['0']]);
    }
}
