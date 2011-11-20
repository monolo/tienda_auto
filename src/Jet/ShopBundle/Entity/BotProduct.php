<?php

namespace Jet\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jet\ShopBundle\Entity\BotProduct
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BotProduct
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
     * @var string $subcategory51bab
     *
     * @ORM\Column(name="subcategory51bab", type="string", length=50)
     */
    private $subcategory51bab;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="botproducts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="botproducts")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    private $subcategory;


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
     * Set subcategory51bab
     *
     * @param string $subcategory51bab
     */
    public function setSubcategory51bab($subcategory51bab)
    {
        $this->subcategory51bab = $subcategory51bab;
    }

    /**
     * Get subcategory51bab
     *
     * @return string 
     */
    public function getSubcategory51bab()
    {
        return $this->subcategory51bab;
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
     * Set subcategory
     *
     * @param Jet\ShopBundle\Entity\Subcategory $subcategory
     */
    public function setSubcategory(\Jet\ShopBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get subcategory
     *
     * @return Jet\ShopBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }
}