<?php

namespace App\Controller\Cart;

use App\Manager\ProductManager;
use App\Service\StripePaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    use CartTotalTrait;

    /**
     * @var ProductManager
     */
    private $productManager;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var StripePaymentService
     */
    private $stripePaymentService;

    /**
     * @var string
     */
    private $stripeApiKey;

    public function __construct(ProductManager $productManager, SessionInterface $session, StripePaymentService $stripePaymentService)
    {
        $this->productManager = $productManager;
        $this->session = $session;
        $this->stripePaymentService = $stripePaymentService;
        $this->stripeApiKey = $_ENV['STRIPE_API_KEY'];
    }

    /**
     * @Route("/cart/checkout", methods={"GET"})
     */
    public function checkoutAction()
    {
        $products = $this->session->get('cart_products');
        $quantities = $this->session->get('cart_quantities');
        $total = $this->getCartTotal($products, $quantities);
        $paymentIntent = $this->stripePaymentService->createPaymentIntent($total);

        return $this->render('cart/checkout.html.twig', [
            'products' => $products,
            'quantities' => $quantities,
            'total' => $total,
            'payment_intent' => $paymentIntent,
            'stripe_api_key' => $this->stripeApiKey,
        ]);
    }

    /**
     * @Route("/cart/checkout/success", methods={"GET"})
     */
    public function successAction()
    {
        $this->session->remove('cart_products');
        $this->session->remove('cart_quantities');

        return $this->render('cart/checkout_success.html.twig');
    }
}
