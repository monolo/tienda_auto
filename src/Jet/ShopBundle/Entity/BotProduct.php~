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
     * @var string $urlproduct
     *
     * @ORM\Column(name="urlproduct", type="string", length=100)
     */
    private $urlproduct;
    
    /**
     * @var string $saveurl
     *
     * @ORM\Column(name="saveurl", type="string", length=100)
     */
    private $saveurl;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="botproducts")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    
    private $subcategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="botproducts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @var boolean $checked
     *
     * @ORM\Column(name="checked", type="boolean", nullable=true)
     */
    private $checked;


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

    /**
     * Set urlproduct
     *
     * @param string $urlproduct
     */
    public function setUrlproduct($urlproduct)
    {
        $this->urlproduct = $urlproduct;
    }

    /**
     * Get urlproduct
     *
     * @return string 
     */
    public function getUrlproduct()
    {
        return $this->urlproduct;
    }

    /**
     * Set checked
     *
     * @param boolean $checked
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;
    }

    /**
     * Get checked
     *
     * @return boolean 
     */
    public function getChecked()
    {
        return $this->checked;
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
     * Set saveurl
     *
     * @param string $saveurl
     */
    public function setSaveurl($saveurl)
    {
        $this->saveurl = $saveurl;
    }

    /**
     * Get saveurl
     *
     * @return string 
     */
    public function getSaveurl()
    {
        return $this->saveurl;
    }
}