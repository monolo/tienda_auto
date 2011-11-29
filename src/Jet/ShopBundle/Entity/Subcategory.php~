<?php

namespace Jet\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jet\ShopBundle\Entity\Subcategory
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Subcategory
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subcategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="subcategory")
     */
    private $products;
    
    /**
     * @ORM\OneToMany(targetEntity="BotProduct", mappedBy="subcategory")
     */
    private $botproducts;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set category
     *
     * @param Jet\ShopBundle\Entity\Category $category
     */
    public function setCategory(\Jet\ShopBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Jet\ShopBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add products
     *
     * @param Jet\ShopBundle\Entity\Product $products
     */
    public function addProduct(\Jet\ShopBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
    public function __toString()
    {
    	return $this->name; 
    }

    /**
     * Add botproducts
     *
     * @param Jet\ShopBundle\Entity\BotProduct $botproducts
     */
    public function addBotProduct(\Jet\ShopBundle\Entity\BotProduct $botproducts)
    {
        $this->botproducts[] = $botproducts;
    }

    /**
     * Get botproducts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBotproducts()
    {
        return $this->botproducts;
    }
}