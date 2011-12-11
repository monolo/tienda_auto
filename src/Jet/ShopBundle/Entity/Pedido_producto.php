<?php

namespace Jet\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jet\ShopBundle\Entity\Pedido_producto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pedido_producto
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
     * @var string $size_list
     *
     * @ORM\Column(name="size_list", type="string", length=10)
     */
    private $size_list;

    /**
     * @var integer $quantity
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedido_productos")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     */
    private $pedido;
    
    /**
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
	private $product;


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
        return $this->size_list;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set pedido
     *
     * @param Jet\ShopBundle\Entity\Pedido $pedido
     */
    public function setPedido(\Jet\ShopBundle\Entity\Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get pedido
     *
     * @return Jet\ShopBundle\Entity\Pedido 
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set product
     *
     * @param Jet\ShopBundle\Entity\Product $product
     */
    public function setProduct(\Jet\ShopBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Jet\ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}