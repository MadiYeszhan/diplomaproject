<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use DOMDocument;
use DOMXPath;
use Zebra_cURL;

class ParseController extends Controller
{
    public function parseAptekaPlus($link)
    {
        $link = trim($link);
        //$link = "https://aptekaplus.kz/catalog/med/lekarstvennye-sredstva/antibakterialnye-i-protivovirusnye-sredstva/ingavirin-90-mg-7-kapsul/element";
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
                            return ['pharmacy' => 'Аптека Плюс','available' => 'В наличии','count' => 'Больше 10','price' => $price,'color' => 'green'];
                        }
                        elseif ($isAvailable == "Осталось всего: Менее 10 шт"){
                            return ['pharmacy' => 'Аптека Плюс','available' => 'В наличии','count' => 'Меньше 10','price' => $price,'color' => 'orange'];
                        }
                    }
                    //if product is not available
                    elseif ($isNotAvailable == "Нет в наличии") {
                        //return that product is not available
                        return ['pharmacy' => 'Аптека Плюс','available' => "Нет в наличии",'count' => 0,'price' => $price,'color' => "red"];
                    }
                }
            }
        }
        return null;
    }

    public function parseBiosfera($link)
    {
        $link = trim($link);
        //$link = "https://biosfera.kz/product/product?product_id=27395";
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
                        return ['pharmacy' => 'Биосфера','available' => 'В наличии','count' => 'Не известно','price' => $price,'color' => 'green'];
                    }
                    //if product is not available
                    elseif ($isAvailable == "Нет в наличии в интернет-аптеке") {
                        //return that product is not available
                        return ['pharmacy' => 'Биосфера','available' => 'Нет в наличии','count' => 0,'price' => $price,'color' => 'red'];
                    }
                }
            }
        }
        return null;
    }

    public function parseEuropharma($link)
    {
//        $link = "https://europharma.kz/ingavirin-90-mg-no-7-kaps";
        //check if link is appropriate
        $link = trim($link);
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


                //if elements is existed
                if (($isAvailable != null or $isNotAvailable != null) and ($price != null and is_numeric($price))) {
                    //if product is available
                    if ($isAvailable == "Есть в наличии") {
                        return ['pharmacy' => 'europharma','available' => 'В наличии','count' => 'Не известно','price' => $price,'color' => 'green'];
                    }
                    //if product is not available
                    elseif ($isNotAvailable == "Нет в наличии") {
                        //return that product is not available
                        return ['pharmacy' => 'europharma','available' => 'Нет в наличии','count' => 0,'price' => $price,'color' => 'red'];
                    }
                }
            }
        }
        return null;
    }

    public function parseTalap($link)
    {
        $link = trim($link);
//        $link = "https://apteka-talap.kz/catalog/lekarstvennye_sredstva/zabolevaniya_serdechno_sosudistoy_sistemy/arterialnaya_gipertoniya/2557/";
//        $link = "https://apteka-talap.kz/catalog/lekarstvennye_sredstva/zabolevaniya_oporno_dvigatelnogo_apparata/khondroprotektory/3427/";
        //check if link is appropriate
        if (isset(parse_url($link)['host'])) {
            //if domain is right
            if (parse_url($link)['host'] == 'apteka-talap.kz') {
                $finder = new DomXPath($this->parseLink($link));

                $isAvailable = null;
                $price = null;

                //find elements in html
                if (sizeof($finder->query('//span[@class="store_view"]')) > 0) {
                    $isAvailable = trim($finder->query('//span[@class="store_view"]')[0]->nodeValue);
                    if ($isAvailable != 'Нет в наличии')
                    $isAvailable = intval(filter_var($isAvailable, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
                }

                if (sizeof($finder->query('//span[@class="price_value"]')) > 0) {
                    $price = trim($finder->query('//span[@class="price_value"]')[0]->nodeValue);
                    $price = intval(preg_replace('/[^0-9]/i', '',$price));
                }

                //if elements is existed
                if ($isAvailable != null and ($price != null and is_numeric($price))) {
                    //if product is not available
                    if ($isAvailable == 'Нет в наличии'){
                        return ['pharmacy' => 'Талап','available' => 'Нет в наличии','count' => 0,'price' => $price,'color' => 'red'];
                    }
                    elseif ($isAvailable > 0) {
                        //return that product is available
                        return ['pharmacy' => 'Талап','available' => 'В наличии','count' => $isAvailable,'price' => $price,'color' => 'green'];
                    }
                }
            }
        }
        return null;
    }

    public function parseEvcalyptus($link)
    {
        $link = trim($link);
//      $link = "https://evcalyptus.kz/index.php?route=product/product&path=59&product_id=18955";
//      $link = "https://evcalyptus.kz/index.php?route=product/product&path=18&product_id=24750";
//      $link = "https://evcalyptus.kz/index.php?route=product/product&path=18&product_id=28017";

        //check if link is appropriate
        if (isset(parse_url($link)['host'])) {
            //if domain is right
            if (parse_url($link)['host'] == 'evcalyptus.kz') {
                $finder = new DomXPath($this->parseLink($link));

                $isAvailable = null;
                $price = null;

                //find elements in html
                if (sizeof($finder->query('//ul/li/font')) > 0) {
                    $isAvailable = trim($finder->query('//ul/li/font')[0]->nodeValue);
                }

                if (sizeof($finder->query('//ul/li/h2')) > 0) {
                    $price = trim($finder->query('//ul/li/h2')[0]->nodeValue);
                    $price = intval(preg_replace('/[^0-9]/i', '',$price));
                }

                //if elements is existed
                if ($isAvailable != null and ($price != null and is_numeric($price))) {
                    //if product is available
                    if ($isAvailable == 'В наличии'){
                        return ['pharmacy' => 'Evcalyptus','available' => 'В наличии','count' => 'Не известно','price' => $price,'color' => 'green'];
                    }
                    elseif ($isAvailable == "Заканчивается (перед оплатой, необходимо уточнить в аптеки наличие товара)") {
                        //return that product is not available
                        return ['pharmacy' => 'Evcalyptus','available' => 'В наличии','count' => 'Ограничено','price' => $price,'color' => 'orange'];
                    }
                    elseif ($isAvailable == "Нет в наличии") {
                        //return that product is not available
                        return ['pharmacy' => 'Evcalyptus','available' => 'Нет в наличии','count' => 0,'price' => $price,'color' => 'red'];
                    }
                }
            }
        }
        return null;
    }

    private function parseLink($link){
        //parse url content
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $link);
//        $host = [implode(':', [parse_url($link)['host'], 443, gethostbyname(parse_url($link)['host']),])];
//        curl_setopt($ch, CURLOPT_RESOLVE, $host);
//        curl_setopt($ch, CURLOPT_ENCODING, '');
//        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $output = curl_exec($ch);
//        curl_close($ch);

        $curl = new Zebra_cURL();
        $curl->cache('cURL/cache', 3600);
        $host = [implode(':', [parse_url($link)['host'], 443, gethostbyname(parse_url($link)['host']),])];
        $curl->option(CURLOPT_ENCODING,'');
        $curl->option(CURLOPT_RESOLVE, $host);
        $output = $curl->scrap($link, true);

        //create and load DOM
        $dom = new DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($output);
        libxml_use_internal_errors($internalErrors);
        return $dom;
    }
}
