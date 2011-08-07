<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alexk984
 * Date: 01.08.11
 * Time: 15:55
 */

/**
 * Yandex market parser
 */
class ParseController extends Controller
{
    public $server = 'http://market.yandex.ru';

    /**
     * Parse all next pages in yandex market
     * @return void
     */
    public function actionIndex()
    {
        $cat_id = 1;
        Yii::import('ext.phpQuery.phpQuery.phpQuery');
        $this->ParseAllPages('/guru.xml?hid=91052&CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=106905-BPOS=530-EXC=1-PG=10&greed_mode=false', $cat_id);
    }

    public function ParseAllPages($page_url, $cat_id)
    {
        $end = false;
        for ($i = 0; !$end; $i++) {
            $html = file_get_contents($this->server . $page_url);
            $document = phpQuery::newDocument($html);
            $page_url = $document->find('a.b-pager__next')->attr('href');
            if (empty($page_url))
                $end = true;
            $this->ParsePage($page_url, $cat_id);
            echo 'Page #' . $i . ' parsed.<br>';
        }
    }

    public function ParsePage($url, $cat_id)
    {
        $html = file_get_contents($this->server . $url);
        $document = phpQuery::newDocument($html);
        $good_urls = array();
        foreach ($document->find('div.page__b-offers__guru h3.b-offers__title a') as $li)
            $good_urls [] = (pq($li)->attr('href'));

        foreach ($good_urls as $good_url) {
            sleep(1);
            $this->ParseOne($good_url, $cat_id);
        }
    }

    public function ParseOne($url, $cat_id)
    {
        $good = new Good();
        $html = file_get_contents($this->server . $url);
        $document = phpQuery::newDocument($html);

        $name = $document->find('h1.b-page-title_type_model')->text();
        $name = trim(str_replace('новинка', '', $name));
        //is exist
        $exist = Good::model()->count('name="' . trim($name) . '"');
        if ($exist > 0) {
            echo 'Good "' . $name . '" already exist.<br>';
            flush();
            return;
        }
        echo 'Name: ' . $name . '.<br>';
        flush();
        $brand = $document->find('div.b-breadcrumbs a:last')->text();
        //        echo 'Brand: '.$brand.'<br>';
        $features_url = $document->find('p.b-model-friendly__title a')->attr('href');
        //        echo 'Features url: '.$features_url.'<br>';
        $price = $document->find('div.b-model-prices__avg span.b-prices__num')->text();
        $price = preg_replace("(\D+)", "", utf8_encode($price));
        //        echo 'Price: '.$price.'<br>';

        $good->category_id = $cat_id;
        $good->name = $name;
        $good->price = $price;
        $good->date = date("Y-m-d");
        $good->SetBrandFromName($brand);
        $good->save();

        $main_pic = $document->find('#model-pictures span.b-model-pictures__big a')->attr('href');
        //        echo $main_pic;
        $other_pictures = $document->find('#model-pictures span.b-model-pictures__small a')->attr('href');
        //        var_dump($other_pictures);
        $this->SavePictures($good->id, $main_pic);
        $this->SavePictures($good->id, $other_pictures);

        $this->ParseFeatures('http://market.yandex.ru' . $features_url, $good, $cat_id);
    }


    public function ParseFeatures($url, $good, $cat_id)
    {
        $html = file_get_contents($url);
        $document = phpQuery::newDocument($html);
        $elements = $document->find('table.b-properties tr');

        $cat = Category::model()->with(array('attrGroups', 'attrGroups.attrs'))->findByPk($cat_id);

        foreach ($elements as $element) {
            $attr_label = trim(pq($element)->find('th.b-properties__label span')->text());
            //            echo $attr_label;
            //            echo ' : ';
            $val = trim(pq($element)->find('td.b-properties__value')->text());
            //            echo $val;
            //            echo '<br>';
            if (!empty($attr_label) && !empty($val)) {
                //store in database
                foreach ($cat->GetCategoryAttributes() as $attr) {
                    if (strtolower($attr->name) == strtolower($attr_label)) {
                        if (isset($attr->template) && $attr->template != '')
                            $val = trim(str_replace($attr->template, '', $val));

                        if ($attr->type == '1')
                            $good->SetStringFeatureValue($attr, $val);
                        elseif ($attr->type == '3')
                            $good->SetIntFeatureValue($attr->id, $val);
                        elseif ($attr->type == '2')
                            $good->SetBoolFeatureValue($attr->id, $val);
                    }
                }
            }
        }
    }

    public function SavePictures($good_id, $pic)
    {
        if (empty($pic))
            return;
        if (is_array($pic))
            foreach ($pic as $picture)
                CAlexHelper::SaveImages($picture, $good_id);
        else
            CAlexHelper::SaveImages(array($pic), $good_id);
    }


    /**
     * Fill good rating by random data
     * @return void
     */
    public function actionRandomData()
    {
        $users = array(1, 2, 3);
        $all_goods = Good::model()->findAll();
        foreach ($all_goods as $good) {
            $sum = 0;
            $count = 0;
            foreach ($users as $user) {
                if (rand(1, 5) == 5)
                    continue;
                $count++;
                $user_mark = rand(1, 5);
                $sum += $user_mark;

                $user_rating = new Rating();
                $user_rating->good_id = $good->id;
                $user_rating->user_id = $user;
                $user_rating->value = $user_mark;
                $user_rating->save();
            }
            if ($count != 0) {
                $good->rating = round(($sum / $count) * 100);
                $good->update(array('rating'));
            }
            echo $good->id . '<br>';
            flush();
        }
    }

}