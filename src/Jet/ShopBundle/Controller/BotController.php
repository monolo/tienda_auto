<?php

namespace Jet\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jet\ShopBundle\Entity\Product;
use Jet\ShopBundle\Entity\Subcategory;

class BotController extends Controller {

    /**
     * @Route("/auto/bot", name="auto_bot")
     * @Template()
     */
    public function indexAction() {

        function curl($url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        }

        function saveImage($url, $path) {
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_HEADER, 0);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $s = curl_exec($c);
            curl_close($c);
            $f = fopen($path, 'wb');
            $z = fwrite($f, $s);
            if ($z != false)
                return true;
            return false;
        }

        $url = "http://www.51bab.es";
        /*$subcategories = array();
        $result = curl('http://www.51bab.es/sitemap.php');
        //links
        if (preg_match_all("#<\s*a[^>]*>[^<]+</a>#is", $result, $links)) {
            foreach ($links[0] as $link) {
                preg_match("#>[^<]*<#is", $link, $linka);
                @preg_match("#[^>][^<]*#is", $linka[0], $nomo);

                preg_match("#href=\"[^(\")]*\"#is", $link, $linke);
                @preg_match("#[^(href=\")][^(\")]*#is", $linke[0], $linkes);
                @$subcategories[$nomo[0]] = $linkes[0];
            }
        }*/

        //select botproduct
        $em = $this->getDoctrine()->getEntityManager();
        $botproducts = $em->getRepository('JetShopBundle:BotProduct')->findByChecked(1);
        $checkeds = $em->getRepository('JetShopBundle:Product')->findByChecked(1);
        foreach ($checkeds as $checked) {
            if ($checked->getChecked() == 1) {
                $checked->setDisplay(0);
                $em->flush();
            }
        }
        foreach ($botproducts as $botproduct) {
            $checkeds = $em->getRepository('JetShopBundle:Product')->findByChecked(1);
            foreach ($checkeds as $checked) {
                if ($checked->getChecked() == 1) {
                    $checked->setDisplay(0);
                    $em->flush();
                }
            }
        }
        //save database
        foreach ($botproducts as $botproduct) {
            $result = curl($botproduct->getUrlproduct());

            $bollink = true;
            for ($j = 0; $bollink == true; $j++) {
                $linktd = array();
                preg_match_all("#<a\s*class=\"60pxborder[^>]*>#is", $result, $tds);
                for ($i = 0; $i < sizeof($tds[0]); $i++) {
                    preg_match("#href=\"(\?|\/|\w|\d|-|=|.\S)*\"#is", $tds[0][$i], $linke);
                    preg_match("#[^(href=\")](\?|\/|\w|\d|-|=|.\S)*[^(\")]#is", $linke[0], $linkes);
                    $linktd[$i] = $linkes[0];
                }
                //name
                preg_match("#<h1>[^<]*</h1>#is", $result, $auxname);
                preg_match("#[^(<h1>)][^<]*[^(</h1>)]*#is", $auxname[0], $name);
                $name = $name[0];

                //size_list
                $size_list = "";
                preg_match_all("#<option[^>]*>\S*</option>#is", $result, $auxsize_list);
                for ($i = 0; $i < sizeof($auxsize_list[0]); $i++) {
                    preg_match("#>(\d|\w)*<#is", $auxsize_list[0][$i], $aux2);
                    preg_match("#[^>](\d|\w)*[^<]#is", $aux2[0], $aux);
                    if ($i == 0) {
                        $size_list = $aux[0];
                    } else {
                        $size_list = $size_list . "/" . $aux[0];
                    }
                }

                //price
                preg_match("#<span\s*id=\"oneprice[^>]*>[^>]*>#is", $result, $auxprice);
                preg_match("#>[^<]*<#is", $auxprice[0], $aux2price);
                preg_match("#[^>][^<]*#is", $aux2price[0], $price);
                $price = number_format(($price[0] * 0.740028121) * 1.2, 2, '.', '');

                //image
                preg_match("#<img\s*alt=\"" . $name[0] . "[^>]*#is", $result, $auximage);
                preg_match("#src=\"[^\"]*\"#is", $auximage[0], $aux2image);
                preg_match("#[^(src=\")][^\"]*#is", $aux2image[0], $image);
                preg_match("#%[^&]*&#is", $image[0], $auxnameimage);
                preg_match("#[^%][^&]*#is", $auxnameimage[0], $nameimage);
                preg_match("#\d*\.\w*#is", $nameimage[0], $nameimage2);
                preg_match("#=[^%]*%#is", $image[0], $auxdateimage);
                preg_match("#[^=][^%]*#is", $auxdateimage[0], $dateimage);
                $directorio = "/var/www/comertial.com/web/uploads/documents/" . $nameimage2[0];

                //item number
                preg_match("#Item\s*Code\s*\:[^<]*#is", $result, $auxitem_number);
                preg_match("#[^(Item Code\:)][^<]*#is", $auxitem_number[0], $item_number);
                $item_number = $item_number[0];
                
                
                $products = $em->getRepository('JetShopBundle:Product')->findOneByName($name);
                if (!$products) {
                    saveImage($url . "/smallImage/big/" . $dateimage[0] . "/" . $nameimage2[0], $directorio);
                    $product = new Product();
                    $product->setItemNumber($item_number);
                    $product->setName($name);
                    $product->setPath($nameimage2[0]);
                    $product->setPrice($price);
                    $product->setSizeList($size_list);
                    $product->setComment("prueba");
                    $product->setCategory($botproduct->getCategory());
                    $product->setSubcategory($botproduct->getSubcategory());
                    if ((filesize($directorio) / 1024) < 25) {
                        $product->setDisplay(0);
                    } else {
                        $product->setDisplay(1);
                    }
                    $product->setChecked(1);
                    $em->persist($product);
                    $em->flush();
                } else {
                    if (file_exists($directorio) == false || (filesize($directorio) / 1024) < 25) {
                        saveImage($url . "/smallImage/big/" . $dateimage[0] . "/" . $nameimage2[0], $directorio);
                    }
                    $products->setItemNumber($item_number);
                    $products->setPrice($price);
                    $products->setSizeList($size_list);
                    $products->setCategory($botproduct->getCategory());
                    $products->setSubcategory($botproduct->getSubcategory());
                    $products->setChecked(1);
                    if ((filesize($directorio) / 1024) < 25) {
                        $products->setDisplay(0);
                    } else {
                        $products->setDisplay(1);
                    }
                    $em->flush();
                }

                if ($j == 0) {
                    $result = curl($url . $linktd[1]);
                    $bollink = true;
                } else if (sizeof($linktd) == 2) {
                    $result = curl($url . $linktd[1]);
                    $bollink = true;
                } else {
                    $bollink = false;
                }
            }
        }
        $checkedas = $em->getRepository('JetShopBundle:Product')->findByChecked(1);
        foreach ($checkedas as $checked) {
            if ($checked->getDisplay() == 0 && $checked->getChecked() == 1) {
                $em->remove($checked);
                $em->flush();
            }
        }

        return array("hola" => "hola");
    }

}