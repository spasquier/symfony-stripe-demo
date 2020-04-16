<?php

namespace App\Controller;

use App\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var ProductManager $productManager
     */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $products = $this->productManager->findAll();

        return $this->render('index.html.twig', ['products' => $products]);
    }
}
