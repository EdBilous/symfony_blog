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
     * @Route("/blog", name="blog_index_route")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em
            ->getRepository('AppBundle:Article')
            ->findAll();

        dump($articles);
        return $this->render('@Blog/blog_view/articlesList.html.twig', ['articles' => $articles]);
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
        dump($article);
        return $this->render('@Blog/blog_view/articleShow.html.twig', ['article' => $article]);
    }
}
