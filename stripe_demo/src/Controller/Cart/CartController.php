<?php

namespace App\Controller\Cart;

use App\Manager\ProductManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
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

    public function __construct(ProductManager $productManager, SessionInterface $session)
    {
        $this->productManager = $productManager;
        $this->session = $session;
    }

    /**
     * @Route("/cart", methods={"GET"})
     */
    public function indexAction()
    {
        $products = $this->session->get('cart_products');
        $quantities = $this->session->get('cart_quantities');
        $total = $this->getCartTotal($products, $quantities);

        return $this->render('cart/index.html.twig', [
            'products' => $products,
            'quantities' => $quantities,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/cart/products/add/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function addProductAction(int $id)
    {
        $product = $this->productManager->find($id);
        if (empty($product)) {
            throw new BadRequestHttpException('The provided product does not exists.');
        }
        $products = $this->session->get('cart_products');
        if (empty($products)) {
            $products = new ArrayCollection();
        }
        $quantities = $this->session->get('cart_quantities');
        if (empty($quantities)) {
            $quantities = [];
        }

        $productExistsInCart = $products->exists(function ($key, $element) use ($product) {
            return $element->getId() == $product->getId();
        });
        if ($productExistsInCart) {
            ++$quantities[$product->getId()];
        } else {
            $products->set($product->getId(), $product);
            $quantities[$product->getId()] = 1;
        }

        $this->session->set('cart_products', $products);
        $this->session->set('cart_quantities', $quantities);

        return $this->redirect('/cart');
    }

    /**
     * @Route("/cart/products/remove/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function removeProductAction(int $id)
    {
        $product = $this->productManager->find($id);
        if (empty($product)) {
            throw new BadRequestHttpException('The provided product does not exists.');
        }
        $products = $this->session->get('cart_products');
        $quantities = $this->session->get('cart_quantities');

        if (isset($quantities[$product->getId()])) {
            if ($quantities[$product->getId()] > 1) {
                --$quantities[$product->getId()];
            } else {
                $products->remove($product->getId());
                unset($quantities[$product->getId()]);
            }
        }

        $this->session->set('cart_products', $products);
        $this->session->set('cart_quantities', $quantities);

        return $this->redirect('/cart');
    }
}
