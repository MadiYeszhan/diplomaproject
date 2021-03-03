<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Monolog\Handler\IFTTTHandler;

class ParseController extends Controller
{
    public function parseAptekaPlus()
    {
        $link = "https://aptekaplus.kz/catalog/med/lekarstvennye-sredstva/antibakterialnye-i-protivovirusnye-sredstva/ingavirin-90-mg-7-kapsul/element";
        //check if link is appropriate
        if (isset(parse_url($link)['host'])) {
            //if domain is right
            if (parse_url($link)['host'] == 'aptekaplus.kz') {
                $finder = new DomXPath($this->parseLink($link));

                $isAvailable = null;
                $isNotAvailable = null;
                $price = null;

                //find elements in html
                if (sizeof($finder->query('//div[@class="quantity-limit"]')) > 0) {
                    $isAvailable = trim($finder->query('//div[@class="quantity-limit"]')[0]->nodeValue);
                }

                if (sizeof($finder->query('//a[@class="text-noavailable"]')) > 0) {
                    $isNotAvailable = trim($finder->query('//a[@class="text-noavailable"]')[0]->nodeValue);
                }

                if (sizeof($finder->query('//span[@class="current-price__value"]')) > 0) {
                    $price = trim($finder->query('//span[@class="current-price__value"]')[0]->nodeValue);
                    $price = intval(preg_replace('/[^0-9]/i', '',$price));
                }

                //if elements is existed
                if (($isAvailable != null or $isNotAvailable != null) and ($price != null and is_numeric($price))) {
                    //if product is available
                    if ($isAvailable != "") {
                        $isAvailable = preg_replace('/\s+/', ' ', $isAvailable);
                        if ($isAvailable == "В наличии: Более 10 шт"){
                            dd('More 10');
                        }
                        elseif ($isAvailable == "Осталось всего: Менее 10 шт"){
                            dd('Less 10');
                        }
                    }
                    //if product is not available
                    elseif ($isNotAvailable == "Нет в наличии") {
                        //return that product is not available
                        dd('Товара нет в наличии');
                    }
                }
            }
        }
        dd("Wrong link");
    }

    public function parseBiosfera()
    {
        $link = "https://biosfera.kz/product/product?product_id=27395";
        //check if link is appropriate
        if (isset(parse_url($link)['host'])) {
            //if domain is right
            if (parse_url($link)['host'] == 'biosfera.kz') {
                $finder = new DomXPath($this->parseLink($link));

                $isAvailable = null;
                $price = null;

                //find elements in html
                if (sizeof($finder->query('//td[@id="txt-stock"]')) > 0) {
                    $isAvailable = trim($finder->query('//td[@id="txt-stock"]')[0]->nodeValue);
                }

                if (sizeof($finder->query('//div[@id="fix_price"]')) > 0) {
                    $price = trim($finder->query('//div[@id="fix_price"]')[0]->nodeValue);
                    $price = intval(preg_replace('/[^0-9]/i', '',$price));
                }

                //if elements is existed
                if ($isAvailable != null and ($price != null and is_numeric($price))) {
                    //if product is available
                    if ($isAvailable == "Есть в наличии"){
                        dd('Есть в наличии');
                    }
                    //if product is not available
                    elseif ($isAvailable == "Нет в наличии в интернет-аптеке") {
                        //return that product is not available
                        dd('Нет в наличии в интернет-аптеке');
                    }
                }
            }
        }
        dd("Wrong link");
    }

    public function parseEuropharma()
    {
        $link = "https://europharma.kz/ingavirin-90-mg-no-7-kaps";
        //check if link is appropriate
        if (isset(parse_url($link)['host'])) {
            //if domain is right
            if (parse_url($link)['host'] == 'europharma.kz') {
                $finder = new DomXPath($this->parseLink($link));

                $isAvailable = null;
                $isNotAvailable = null;
                $price = null;

                //find elements in html
                if (sizeof($finder->query('//dd[@class="characteristic__value product__available--yes"]')) > 0) {
                    $isAvailable = utf8_decode(trim($finder->query('//dd[@class="characteristic__value product__available--yes"]')[0]->nodeValue));
                }

                if (sizeof($finder->query('//dd[@class="characteristic__value product__available--no"]')) > 0) {
                    $isNotAvailable = utf8_decode(trim($finder->query('//dd[@class="characteristic__value product__available--no"]')[0]->nodeValue));
                }

                if (sizeof($finder->query('//span[@class="product__price-value"]')) > 0) {
                    $price = trim($finder->query('//span[@class="product__price-value"]')[0]->nodeValue);
                    $price = intval(preg_replace('/[^0-9]/i', '',$price));
                }

                var_dump($price);
                var_dump($isNotAvailable);
                var_dump($isAvailable);

                //if elements is existed
                if (($isAvailable != null or $isNotAvailable != null)) {
                    //if product is available
                    if ($isAvailable == "Есть в наличии") {
                        dd("Есть в наличии");
                    }
                    //if product is not available
                    elseif ($isNotAvailable == "Нет в наличии") {
                        //return that product is not available
                        dd('Товара нет в наличии');
                    }
                }
            }
        }
        dd("Wrong link");
    }

    private function parseLink($link){
        //parse url content
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        libxml_use_internal_errors(true);

        //create and load DOM
        $dom = new DOMDocument();
        $dom->loadHTML($output);
        return $dom;
    }
}
