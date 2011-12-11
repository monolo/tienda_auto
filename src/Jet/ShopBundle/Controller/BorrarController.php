<?php

namespace Jet\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Jet\ShopBundle\Form\ProductType;

use Jet\ShopBundle\Entity\Pedido_producto;
use Jet\ShopBundle\Entity\User;

use Jet\ShopBundle\Model\Cart;

/**
 * Borrar controller.
 *
 * @Route("/borrar")
 */
class BorrarController extends Controller {
	/**
     * @Route("/ajax/{category}/{subcategory}", name="borrar_entrada_category", defaults={"category" = "home","subcategory" = "home"})
     * @Method("GET")
     * @Template()
     */
    public function subcategoryAction($category,$subcategory){
    	if($this->container->get('request')->isXmlHttpRequest()){
    		$product = 1;
    		$em = $this->getDoctrine()->getEntityManager();
    		$category = mb_strtolower($category);
        	$auxcategory=$em->getRepository('JetShopBundle:Category')->findOneByName($category);;
        	if(!isset($auxcategory)){
        		for($i=0;$i<20;$i++){
        			$auxcategory = $em->getRepository('JetShopBundle:Category')->find($i);
        			if(isset($auxcategory)){
        				break;
        			}
        		}
        	}
        	$subcategory = mb_strtolower($subcategory);
        	$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneByName($subcategory);
        	if(!isset($auxsubcategory)){
        		$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneByCategory($auxcategory->getId());
        	}
    		$productos = $em->getRepository('JetShopBundle:Product')->findBySubcategory($auxsubcategory->getId());
    		$auxproductos = array();
    		$num_product=sizeof($productos);
    		$cantidad=0;
    		for($i=0;$i<$num_product;$i++){
				if($i/20>=($product-1) && $i/20<$product ){
					$auxproductos[$i]=$productos[$i];
				}
				$cantidad=$i;
    		}
    		return array('product' => $auxproductos, 'subcategory' => $auxsubcategory, 'cantidad' => $cantidad, 'category' => $auxcategory);
    	}
    	else{
    		return $this->redirect($this->generateUrl("entrada_index", array('category' => $category->getName(), 'subcategory' => 'home'), true));
    	}
    }
    
    /**
     * @Route("/ajax/{category}/{subcategory}/{product}", name="borrar_entrada_product", defaults={"category" = "home","subcategory" = "home","product" = "1"})
	 * @Method("GET")
	 * @Template()
	 */
	public function productAction($category,$subcategory,$product){
		//if($this->container->get('request')->isXmlHttpRequest()){
    		$em = $this->getDoctrine()->getEntityManager();
			$category = mb_strtolower($category);
        	$auxcategory=$em->getRepository('JetShopBundle:Category')->findOneByName($category);;
        	if(!isset($auxcategory)){
        		for($i=0;$i<20;$i++){
        			$auxcategory = $em->getRepository('JetShopBundle:Category')->find($i);
        			if(isset($auxcategory)){
        				break;
        			}
        		}
        	}
        	$subcategory = mb_strtolower($subcategory);
        	$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneByName($subcategory);
        	if(!isset($auxsubcategory)){
        		$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneByCategory($auxcategory->getId());
        	}
    		$productos = $em->getRepository('JetShopBundle:Product')->findBySubcategory($auxsubcategory->getId());
    		$auxproductos = array();
    		$num_product=sizeof($productos);
    		for($i=0;$i<$num_product;$i++){
				if($i/20>=($product-1) && $i/20<$product ){
					$auxproductos[$i]=$productos[$i];
				}
    		}
    		return array("product" => $auxproductos, 'category' => $auxcategory, 'subcategory' => $auxsubcategory);
		/*}
    	else{
    		return $this->redirect($this->generateUrl("entrada_index", array('category' => $category->getName(), 'subcategory' => 'home'), true));
    	}*/
	}
	
	/**
     * @Route("/error", name="borrar_entrada_error")
     * @Template()
     * @Method("GET")
     */
    public function errorAction($category) {
        return array('category' => $category);
    }
    
    /**
     * @Route("/{category}/{subcategory}/{product}", defaults={"category" = "home", "subcategory" = "home","product" = "1"}, requirements={"category" = "[^auto]|[^\/]*"} ,name="borrar_entrada_index")
     * @Template()
     * @Method("GET")
     */
    public function indexAction($category,$subcategory, $product) {
        $em = $this->getDoctrine()->getEntityManager();
        $slider = array();
        $categories = $em->getRepository('JetShopBundle:Category')->findAll();
        $response = array();
        $category = mb_strtolower($category);
        $auxcategory=$em->getRepository('JetShopBundle:Category')->findOneByName($category);;
        if(!isset($auxcategory)){
        	for($i=0;$i<20;$i++){
        		$auxcategory = $em->getRepository('JetShopBundle:Category')->find($i);
        		if(isset($auxcategory)){
        			break;
        		}
        	}
        }
        $subcategory = mb_strtolower($subcategory);
        $auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneByName($subcategory);
        if(!isset($auxsubcategory)){
        	$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneByCategory($auxcategory->getId());
        }
        $subcategories = $em->getRepository('JetShopBundle:Subcategory')->findByCategory($auxcategory->getId());
        $product = 1;
        
        $category = mb_strtolower($category);
        $productos = $em->getRepository('JetShopBundle:Product')->findBySubcategory($auxsubcategory->getId());
    	$auxproductos = array();
    	$num_product=sizeof($productos);
    	$cantidad=0;
    	for($i=0;$i<$num_product;$i++){
			if($i/20>=($product-1) && $i/20<$product ){
				$auxproductos[$i]=$productos[$i];
			}
			$cantidad=$i;
    	}
    	$slider = $em->getRepository('JetShopBundle:Slider')->findByCategory($auxcategory->getId());
        
        //cart
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
        return array('category' => $auxcategory, 'categories' => $categories, 'product' => $auxproductos, 'subcategories' => $subcategories, 'slider' => $slider, 'cart' => $carts, 'products' => $products, 'price' => $price, 'subcategory' => $auxsubcategory, 'cantidad' => $cantidad);
    }

}