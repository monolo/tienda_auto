<?php

namespace Jet\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EntradaController extends Controller
{
	/**
	 * @Route("/{category}",name="entrada_index", defaults={"category" = "home"})
	 * @Template()
	 */
	public function indexAction($category)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$slider = array();
		$categories = $em->getRepository('JetShopBundle:Category')->findAll();
		$subcategories = array();
		$product = array();
                $response = array();
                
		foreach($categories as $aux)
		{
			if(mb_strtolower($aux->getName(), "UTF-8") == $category || $category =='home')
			{
                            $category=$aux;
                            $subcategories = $em->getRepository('JetShopBundle:Subcategory')->findByCategory($aux->getId());
                            $product = $em->getRepository('JetShopBundle:Product')->findByCategory($aux->getId());
                            $slider = $em->getRepository('JetShopBundle:Slider')->findByCategory($aux->getId());
                            $response = array('category' => $category, 'categories' => $categories, 'product' => $product, 'subcategories' => $subcategories, 'slider' => $slider);
                            break;
                        }
			else{
                            $response = $this->forward('JetShopBundle:Entrada:error', array('category' => $category));
			}
		}
		return $response;
	}
        
        /**
         * @Route("/error", name="entrada_error")
         * @Template()
         */
        public function errorAction($category)
        {
            return array('category' => $category);
        }
}