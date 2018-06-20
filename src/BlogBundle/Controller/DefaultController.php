<?php

namespace BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use AppBundle\Controller\ArticleController;
//use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * Lists all article entities.
     * @Route("/blog/index.html", name="blog_index_route")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em
            ->getRepository('AppBundle:Article')
            ->findAll();

        return $this->render('@Blog/blog_view/index.html.twig', ['articles' => $articles]);
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
            throw $this->createNotFoundException("No category found for $categorybytitle");
        }
//        dump($categorybytitle['0']);
        return $this->render('@Blog/blog_view/categoryShow.html.twig', ['categorybytitle' => $categorybytitle['0']]);
    }
}
