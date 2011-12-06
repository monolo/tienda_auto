<?php

namespace Jet\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Jet\ShopBundle\Model\Cart;

class EntradaController extends Controller {

	/**
   	 * @Route("/comprar", name="entrada_checkout")
   	 * @Template()
   	 */
   	 public function checkoutAction() {
   	 	$cart = new Cart($this->container->get('request')->getSession());
        $carts=$cart->getCart();
        if(sizeof($carts)!=0){
        	$response=array();	
        }
        else{
        	$response=$this->redirect($this->generateUrl("entrada_index"));
        }
        return $response;
   	 }

    /**
     * @Route("/{category}",name="entrada_index", defaults={"category" = "home"})
     * @Template()
     * @Method("GET")
     */
    public function indexAction($category) {
        $em = $this->getDoctrine()->getEntityManager();
        $slider = array();
        $categories = $em->getRepository('JetShopBundle:Category')->findAll();
        $subcategories = array();
        $product = array();
        $response = array();
        $category = mb_strtolower($category);
        
        $ema = $em->getRepository('JetShopBundle:Product');
		$cart = new Cart($this->container->get('request')->getSession());
        $carts=$cart->getCart();
        $products=array();
        $price=0;
        foreach($carts as $key=>$value){
        	$products[$key]=$ema->find($key);
        	foreach($value as $auxcart){
        		$price=$price+($products[$key]->getPrice()*$auxcart);
        	}
        }

        foreach ($categories as $aux) {
            if (mb_strtolower($aux->getName(), "UTF-8") == $category || $category == 'home') {
                $category = $aux;
                $subcategories = $em->getRepository('JetShopBundle:Subcategory')->findByCategory($aux->getId());
                $product = $em->getRepository('JetShopBundle:Product')->findByCategory($aux->getId());
                $slider = $em->getRepository('JetShopBundle:Slider')->findByCategory($aux->getId());
                $response = array('category' => $category, 'categories' => $categories, 'product' => $product, 'subcategories' => $subcategories, 'slider' => $slider, 'cart' => $carts, 'products' => $products, 'price' => $price);
                break;
            } else {
                $response = $this->forward('JetShopBundle:Entrada:error', array('category' => $category));
            }
        }
        return $response;
    }

    /**
     * @Route("/{category}/add/{id}/{size_list}", name="add_cart", defaults={"category" = "home"})
     * @Method("GET")
     */
    public function addAction($category, $id, $size_list) {
        $em = $this->getDoctrine()->getEntityManager()->getRepository('JetShopBundle:Product');
        $cart = new Cart($this->container->get('request')->getSession());
        $ides=$em->find($id);
        settype($size_list, "integer");
        if(isset($ides) &&  $size_list!=0){
            $cart->addItem($id,$size_list);
        }
        $carts=$cart->getCart();
        $products=array();
        $price=0;
        foreach($carts as $key=>$value){
        	if($key==$id){
        		$products[$key]=$ides;
        		foreach($value as $auxcart){
        			$price=$price+($products[$key]->getPrice()*$auxcart);
        		}
        	}
        	else{
        		$products[$key]=$em->find($key);
        		foreach($value as $auxcart){
        			$price=$price+($products[$key]->getPrice()*$auxcart);
        		}
        	}
        }
        if ($this->container->get('request')->isXmlHttpRequest()) {
            return $this->render('JetShopBundle:Cart:cart.html.twig', array(
                        'products' => $products,
                        'cart' => $carts,
                        'category' => $category,
                        'price' => $price
                    ));
        } else {
            return $this->redirect($this->generateUrl("entrada_index", array('category' => $category), true));
        }
    }

    /**
     * @Route("/{category}/remove/{id}/{size_list}", name="remove_cart", defaults={"category" = "home"})
     * @Method("GET")
     */
    public function removeAction($category, $id, $size_list) {
        $em = $this->getDoctrine()->getEntityManager()->getRepository('JetShopBundle:Product');
		$cart = new Cart($this->container->get('request')->getSession());
		$ides=$em->find($id);
        if(isset($ides)){
        	$cart->removeItem($id, $size_list);
        }
        $carts=$cart->getCart();
        $products=array();
        $price=0;
        foreach($carts as $key=>$value){
        	$products[$key]=$em->find($key);
        	foreach($value as $auxcart){
        		$price=$price+($products[$key]->getPrice()*$auxcart);
        	}
        }

        if ($this->container->get('request')->isXmlHttpRequest()) {
            return $this->render('JetShopBundle:Cart:cart.html.twig', array(
                        'products' => $products,
                        'cart' => $carts,
                        'category' => $category,
                        'price' => $price
                    ));
        } else {
            return $this->redirect($this->generateUrl("entrada_index", array('category' => $category), true));
        }
    }

    /**
     * @Route("/error", name="entrada_error")
     * @Template()
     * @Method("GET")
     */
    public function errorAction($category) {
        return array('category' => $category);
    }

}