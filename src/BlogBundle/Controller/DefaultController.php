<?php

namespace BlogBundle\Controller;

use AppBundle\Controller\ArticleController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/blog", name="blog_index_route")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em
            ->getRepository('AppBundle:Article')
            ->findAll();

        dump($articles);
        return $this->render('@Blog/Default/index.html.twig', ['articles' => $articles]);
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/blog/{slug}", name="blog_show_route")
     * @Method("GET")
     */
    public function singleAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em
            ->getRepository('AppBundle:Article')
            ->findOneBy(['slug' => $slug]);
dump($article);
        return $this->render('@Blog/Default/singleArticle.html.twig', ['article' => $article]);
    }
}
