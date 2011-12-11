<?php

namespace Jet\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Jet\ShopBundle\Entity\Product
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var decimal $price
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @var string $size_list
     *
     * @ORM\Column(name="size_list", type="string", length=50)
     */
    private $size_list;

    /**
     * @var string $comment
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var string $item_number
     *
     * @ORM\Column(name="item_number", type="string", length=255)
     */
    private $item_number;

    /**
     * @var boolean $checked
     *
     * @ORM\Column(name="checked", type="boolean")
     */
    private $checked=false;

    /**
     * @var boolean $display
     *
     * @ORM\Column(name="display", type="boolean")
     */
    private $display=true;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="products")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    private $subcategory;
    
    
    /**
     * @ORM\OneToOne(targetEntity="Pedido_producto")
     * @ORM\JoinColumn(name="pedido_producto_id", referencedColumnName="id")
     */
	private $pedido_producto;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->setPath(uniqid().'.'.$this->file->guessExtension());
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does automatically
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }


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

    /**
     * Set price
     *
     * @param decimal $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return decimal 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set size_list
     *
     * @param string $sizeList
     */
    public function setSizeList($sizeList)
    {
        $this->size_list = $sizeList;
    }

    /**
     * Get size_list
     *
     * @return string 
     */
    public function getSizeList()
    {
        return explode("/",$this->size_list);
    }

    /**
     * Set comment
     *
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set item_number
     *
     * @param string $itemNumber
     */
    public function setItemNumber($itemNumber)
    {
        $this->item_number = $itemNumber;
    }

    /**
     * Get item_number
     *
     * @return string 
     */
    public function getItemNumber()
    {
        return $this->item_number;
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
     * Set display
     *
     * @param boolean $display
     */
    public function setDisplay($display)
    {
        $this->display = $display;
    }

    /**
     * Get display
     *
     * @return boolean 
     */
    public function getDisplay()
    {
        return $this->display;
    }
    
    public function __toString()
    {
    	return $this->name; 
    }
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
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

    /**
     * Set pedido_producto
     *
     * @param Jet\ShopBundle\Entity\Pedido_producto $pedidoProducto
     */
    public function setPedidoProducto(\Jet\ShopBundle\Entity\Pedido_producto $pedidoProducto)
    {
        $this->pedido_producto = $pedidoProducto;
    }

    /**
     * Get pedido_producto
     *
     * @return Jet\ShopBundle\Entity\Pedido_producto 
     */
    public function getPedidoProducto()
    {
        return $this->pedido_producto;
    }
}