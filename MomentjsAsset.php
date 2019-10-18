<?php
/**
 * @link https://github.com/borodulin/yii2-momentjs
 * @copyright Copyright (c) 2019 Szelepcsenyi Zsolt
 * @license 
 */
namespace szelepke\momentjs;
use yii\web\View;

class MomentjsAsset extends \yii\web\AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @bower alias used.
    public $sourcePath = '@bower/moment/min';
    
    /**
     * Locale support and globally assingment
     * @link http://momentjs.com/docs/#/i18n/
     * @var string | boolean
     */
    public static $language;
    
    public function registerAssetFiles($view)
    {
        if (self::$language !== false) {
            $language = self::$language ? self::$language : \Yii::$app->language; 
            $this->js = ['moment-with-locales.min.js'];
            //assing locale globally
            $key = md5($js = "moment.locale('$language');");
            $view->js[$view::POS_READY] = [$key => $js] + (array)$view->js[$view::POS_READY];
        } else {
            $this->js = ['moment.min.js'];
        }
        parent::registerAssetFiles($view);
    }
    
    /**
     * Converts PHP Date format to MomentJS Date format
     * 
     * @param string $format PHP date format
     * @return string
     * 
     * @link http://php.net/manual/en/function.date.php
     * @link http://momentjs.com/docs/#/parsing/string-format/
     */
    public static function fromPhpFormat($format)
    {
        return strtr($format, [
            's'=>'ss','i'=>'mm','g'=>'h','h'=>'hh','G'=>'H','H'=>'HH',
            'w'=>'e','W'=>'E','j'=>'D','d'=>'DD','D'=>'DDD','l'=>'DDDD',
            'n'=>'M','m'=>'MM','M'=>'MMM','F'=>'MMMM','y'=>'YY','Y'=>'YYYY','U'=>'X',
        ]);
    }

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
    
}