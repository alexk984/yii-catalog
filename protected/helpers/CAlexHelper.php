<?php
class CAlexHelper
{
    const PRODUCTION = 1;
    const DEVELOPMENT = 2;

    /**
     * Get money in specific format 1234 = 1 234
     * @static
     * @param $price money number
     * @return string money in specific format
     */
    public static function GetMoneyFormat($price)
    {
        $price = (string)$price;
        $res = '';
        for ($i = strlen($price) - 1; $i >= 0; $i--) {
            $res .= $price{$i};
            if (((strlen($price) - $i) % 3) == 0) $res .= ' ';
        }
        return strrev($res);
    }

    public static function GetFormatWord($word, $number)
    {
        $num = $number % 10;
        if ($word == 'оценка') {
            if ($num == 1)
                return 'оценка';
            elseif ($num > 1 && $num < 5)
                return 'оценки';
            else
                return 'оценок';
        }
    }

    /**
     * Save good images from urls
     * @static
     * @param $images array with image urls
     * @param $good_id
     */
    public static function SaveImages($images, $good_id)
    {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/goods/';

        foreach ($images as $url) {
            $path_parts = pathinfo($url);
            $name = $good_id . '_' . substr(md5(microtime()), 0, 5) . '.' . $path_parts['extension'];
            while (file_exists($imagePath . $name))
                $name = $good_id . '_' . substr(md5(microtime()), 0, 5) . '.' . $path_parts['extension'];

            if (!empty($url)) {
                file_put_contents($imagePath . $name, file_get_contents($url));
                $image = new GoodImage();
                $image->good_id = $good_id;
                $image->image = $name;
                if ($image->save()) {
                    //create small pictures
                    $image = Yii::app()->image->load($imagePath . $name);
                    $image->resize(200, 200, Image::AUTO);
                    $image->save($imagePath . 's_' . $name);
                    $image = Yii::app()->image->load($imagePath . $name);
                    $image->resize(100, 100, Image::AUTO);
                    $image->save($imagePath . 'xs_' . $name);
                    $image = Yii::app()->image->load($imagePath . $name);
                    $image->resize(400, 400, Image::AUTO);
                    $image->save($imagePath . 'l_' . $name);
                }
            }
        }
    }
}
