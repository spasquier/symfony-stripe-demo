<?php

namespace App\Controller\Cart;

use App\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    use CartTotalTrait;

    /**
     * @var ProductManager $productManager
     */
    private $productManager;

    /**
     * @var SessionInterface $session
     */
    private $session;

    public function __construct(ProductManager $productManager, SessionInterface $session)
    {
        $this->productManager = $productManager;
        $this->session = $session;
    }

    /**
     * @Route("/cart/checkout", methods={"GET"})
     */
    public function checkoutAction()
    {
        $products = $this->session->get('cart_products');
        $quantities = $this->session->get('cart_quantities');
        $total = $this->getCartTotal($products, $quantities);

        return $this->render('cart/checkout.html.twig', [
            'products' => $products,
            'quantities' => $quantities,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/cart/checkout/stripe/connect", methods={"POST"})
     */
    public function stripeConnectAction()
    {
        return $this->redirect('/cart/checkout/success');
    }

    /**
     * @Route("/cart/checkout/success", methods={"GET"})
     */
    public function successAction()
    {
        $products = $this->session->get('cart_products');
        $quantities = $this->session->get('cart_quantities');
        $total = $this->getCartTotal($products, $quantities);

        return $this->render('cart/checkout.success.html.twig', [
            'products' => $products,
            'quantities' => $quantities,
            'total' => $total,
        ]);
    }
}
