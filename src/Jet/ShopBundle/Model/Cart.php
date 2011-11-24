<?php

namespace Jet\ShopBundle\Model;

/**
 *  This file is a part of the symfony demo application
 *
 * (c) Noël GUILBERT <noelguilbert@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class Cart
{
  protected $session;

  /**
   * Constructs the Cart instance
   *
   * @param Session $session 
   */
  public function __construct($session)
  {
    $this->session = $session;
  }

  public function addItem($id,$size_list)
  {
    $cart = $this->getCart();
    if(!isset($cart[$id][$size_list])){
    	$cart[$id][$size_list]=1;
    }
    else{
    	++$cart[$id][$size_list];
    }
    $this->session->set('cart', $cart);
  }

  public function removeItem($id,$size_list)
  {
    $cart = $this->getCart();
    unset($cart[$id][$size_list]);
    $this->session->set('cart', $cart);
  }

  public function getCart()
  {
    return $this->session->get('cart', array());
  }
}
