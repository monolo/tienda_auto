<?php

namespace Jet\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jet\ShopBundle\Entity\Product;
use Jet\ShopBundle\Entity\Subcategory;

class BotController extends Controller {

    /**
     * @Route("/auto/robot/{valor}", name="auto_robot", defaults={"valor" = 0})
     */
    public function indexAction($valor) {

        function GET($url) {
            $curl = curl_init();
            $header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
            $header[] = "Cache-Control: max-age=0";
            $header[] = "Connection: keep-alive";
            $header[] = "Keep-Alive: 300";
            $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
            $header[] = "Accept-Language: en-us,en;q=0.5";
            $header[] = "Pragma: "; // browsers keep this blank.
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/2008111317  Firefox/3.0.4');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
            curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
            curl_setopt($curl, CURLOPT_AUTOREFERER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            //Si no se Logra Ejecutar file_get_contents
            if (!$html = curl_exec($curl)) {
                $html = file_get_contents($url);
            }

            curl_close($curl);
            return $html;
        }

        $resultado;

        function save_image($img, $fullpath) {
            $ch = curl_init($img);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            $rawdata = curl_exec($ch);
            curl_close($ch);
            if (file_exists($fullpath)) {
                unlink($fullpath);
            }
            $fp = fopen($fullpath, 'x');
            fwrite($fp, $rawdata);
            fclose($fp);
        }

        if ($valor == 1) {
            $em = $this->getDoctrine()->getEntityManager();
            $botproduct = $em->getRepository('JetShopBundle:BotProduct')->findOneByChecked(1);

            $productos;
            $result;
            if (!$botproduct) {
                $valor = 0;
            } else {
                if ($botproduct->getSaveurl() == "null") {
                    $productos = $em->getRepository('JetShopBundle:Product')->findBySubcategory($botproduct->getSubcategory()->getId());
                    foreach ($productos as $producto) {
                        if ($producto->getChecked() == 1) {
                            $producto->setDisplay(0);
                            $em->flush();
                        }
                    }
                    $result = GET($botproduct->getUrlproduct());
                } else {
                    $result = GET($botproduct->getSaveurl());
                }


                $url = "http://www.51bab.es";

                $bollink = true;
                //for ($j = 0; ($bollink == true && $j < 1); $j++) {
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
                    save_image($url . "/uploadImage/" . $dateimage[0] . "/" . $nameimage2[0], $directorio);
                    $product = new Product();
                    $product->setItemNumber($item_number);
                    $product->setName($name);
                    $product->setPath($nameimage2[0]);
                    $product->setPrice($price);
                    $product->setSizeList($size_list);
                    $product->setComment("prueba");
                    $product->setCategory($botproduct->getCategory());
                    $product->setSubcategory($botproduct->getSubcategory());
                    $product->setDisplay(1);
                    $product->setChecked(1);
                    $em->persist($product);
                    $em->flush();
                } else {
                    if (file_exists($directorio) == false || filesize($directorio) < 20000) {
                        save_image($url . "/uploadImage/" . $dateimage[0] . "/" . $nameimage2[0], $directorio);
                    }
                    $products->setItemNumber($item_number);
                    $products->setPrice($price);
                    $products->setSizeList($size_list);
                    $products->setCategory($botproduct->getCategory());
                    $products->setSubcategory($botproduct->getSubcategory());
                    $products->setChecked(1);
                    $products->setDisplay(1);
                    $em->flush();
                }

                if (sizeof($linktd) == 2) {
                    $result = GET($url . $linktd[1]);
                    $bollink = true;
                    $botproduct->setSaveurl($url . $linktd[1]);
                    $em->flush();
                } else {
                    $bollink = false;
                    $botproduct->setChecked(0);
                    $em->flush();
                }
                //}
            }
            $resultado = $this->render('JetShopBundle:Bot:ajax.html.twig', array('valor'=>$valor));
        } else {
            $resultado = $this->render('JetShopBundle:Bot:index.html.twig', array('valor'=>$valor));
        }
        return $resultado;
    }

}