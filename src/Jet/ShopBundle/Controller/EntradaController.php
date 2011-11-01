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
		$slider = $em->getRepository('JetShopBundle:Slider')->findAll();
		$categories = $em->getRepository('JetShopBundle:Category')->findAll();
		$subcategories = array();
		$product = array();
		foreach($categories as $aux)
		{
			if($aux->getName()==$category || $category=='home')
			{
				$category=$aux;
				$subcategories = $em->getRepository('JetShopBundle:Subcategory')->findByCategory($aux->getId());
				$product = $em->getRepository('JetShopBundle:Product')->findByCategory($aux->getId());
			}
			else{
					
			}
		}
		return array('category' => $category, 'categories' => $categories, 'product' => $product, 'subcategories' => $subcategories, 'slider' => $slider);
	}	
}