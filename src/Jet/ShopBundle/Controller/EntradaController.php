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

class EntradaController extends Controller {

	/**
   	 * @Route("/comprar", name="entrada_checkout")
   	 * @Template()
   	 * @Method("GET")
   	 */
   	 public function checkoutAction() {
   	 	$cart = new Cart($this->container->get('request')->getSession());
        $carts=$cart->getCart();
        
        if(sizeof($carts)!=0){
        	$pedido_producto = array();
        	$form_producto = array();
        	$em = $this->getDoctrine()->getEntityManager();
        	$productos = array();
        	foreach($carts as $valor => $cart){
        		$pedido_producto[$valor] = new Pedido_producto();
        		$form_producto[$valor] = $this->createForm(new Pedido_productoType(), $pedido_producto[$valor]);
        		$producto[$valor] = $em->getRepository('JetShopBundle:Product')->find($valor);
        	}
        	$user = new User();
        	$form_user = $this->createForm(new UserPedidoType(), $user);
        	
        	$response=array('producto' => $producto, 'form_producto' => $form_producto, 'form_user' => $form_user );	
        }
        else{
        	$response=$this->redirect($this->generateUrl("entrada_index"));
        }
        return $response;
   	 }
   	 
    
    /**
     * @Route("/ajax/{category}/{subcategory}", name="entrada_category", defaults={"category" = "home","subcategory" = "home"})
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
        	$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneBy(array('category' => $auxcategory->getId(), 'name' => $subcategory));
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
    		return $this->redirect($this->generateUrl("entrada_index", array('category' => $auxcategory->getName(), 'subcategory' => 'home'), true));
    	}
    }
    
    /**
     * @Route("/ajax/{category}/{subcategory}/{product}", name="entrada_product", defaults={"category" = "home","subcategory" = "home","product" = "1"})
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
        	$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneBy(array('category' => $auxcategory->getId(), 'name' => $subcategory));
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
            return $this->redirect($this->generateUrl("entrada_index", array('category' => $category, 'subcategory' => 'home'), true));
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
            return $this->redirect($this->generateUrl("entrada_index", array('category' => $category, 'subcategory' => 'home'), true));
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
    
    /**
     * @Route("/{category}/{subcategory}/{product}", defaults={"category" = "home", "subcategory" = "home","product" = "num"} ,name="entrada_index", requirements={"category" = "[^(auto)][^(\/)]*|otros"})
     * @Template()
     * @Method("GET")
     */
    public function indexAction($category,$subcategory, $product) {
    	if($product=="num"){
    		$product=1;
    	}
    	$num_producto=$product;
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
        $auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneBy(array('category' => $auxcategory->getId(), 'name' => $subcategory));
        if(!isset($auxsubcategory)){
        	$auxsubcategory=$em->getRepository('JetShopBundle:Subcategory')->findOneByCategory($auxcategory->getId());
        }
        $subcategories = $em->getRepository('JetShopBundle:Subcategory')->findByCategory($auxcategory->getId());
        
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
    	$slider = $em->getRepository('JetShopBundle:Slider')->findAll();
        
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
        return array('category' => $auxcategory, 'categories' => $categories, 'product' => $auxproductos, 'subcategories' => $subcategories, 'slider' => $slider, 'cart' => $carts, 'products' => $products, 'price' => $price, 'subcategory' => $auxsubcategory, 'cantidad' => $cantidad, 'num_producto'=> $num_producto);
    }
    
    
    /**
     * @Route("/")
     * @Method("GET")
     */
    public function holaAction(){
    	return $this->redirect($this->generateUrl("entrada_index", array('category' => "calzado", 'subcategory' => 'nike', 'product' => "1"), true));
    }

}