<?php

namespace Jet\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jet\ShopBundle\Entity\Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;
    
    /**
     * @ORM\OneToMany(targetEntity="Subcategory", mappedBy="subcategory")
     */
    private $subcategories;
    
    /**
     * @ORM\OneToMany(targetEntity="Slider", mappedBy="slider")
     */
    private $slider;


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
    $this->subcategories = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add subcategories
     *
     * @param Jet\ShopBundle\Entity\Subcategory $subcategories
     */
    public function addSubcategory(\Jet\ShopBundle\Entity\Subcategory $subcategories)
    {
        $this->subcategories[] = $subcategories;
    }

    /**
     * Get subcategories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }
    public function __toString()
    {
    	return $this->name; 
    }

    /**
     * Add slider
     *
     * @param Jet\ShopBundle\Entity\Slider $slider
     */
    public function addSlider(\Jet\ShopBundle\Entity\Slider $slider)
    {
        $this->slider[] = $slider;
    }

    /**
     * Get slider
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSlider()
    {
        return $this->slider;
    }
}