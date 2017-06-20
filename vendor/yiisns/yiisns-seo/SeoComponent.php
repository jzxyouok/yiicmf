<?php
/**
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 30.03.2016
 */
namespace yiisns\seo;

use yiisns\kernel\base\Component;
use yiisns\apps\helpers\StringHelper;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * Class SeoComponent
 * 
 * @package yiisns\kernel\seo
 */
class SeoComponent extends Component implements BootstrapInterface
{
    /**
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => \Yii::t('yiisns/seo', 'Seo')
        ]);
    }

    /**
     * @var int
     */
    public $maxKeywordsLength = 300;

    /**
     *
     * @var int
     */
    public $minKeywordLenth = 6;

    /**
     *
     * @var array
     */
    public $keywordsStopWords = [];

    /**
     *
     * @var bool
     */
    public $enableKeywordsGenerator = true;

    /**
     *
     * @var string
     */
    public $robotsContent = "User-agent: *";

    /**
     *
     * @var string
     */
    public $countersContent = "";
    
    /**
     *
     * @var array
     */
    public $keywordsPriority = [
        'title' => 8,
        'h1' => 6,
        'h2' => 4,
        'h3' => 3,
        'h5' => 2,
        'h6' => 2
        //'b' => 2,
        //'strong' => 2,
    ];

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'enableKeywordsGenerator',
                    'minKeywordLenth',
                    'maxKeywordsLength'
                ],
                'integer'
            ],
            [
                'robotsContent',
                'string'
            ],
            [
                'countersContent',
                'string'
            ]
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'enableKeywordsGenerator' => \Yii::t('yiisns/seo', 'Automatic generation of keywords'),
            'minKeywordLenth' => \Yii::t('yiisns/seo', 'The minimum length of the keyword'),
            'maxKeywordsLength' => \Yii::t('yiisns/seo', 'Length keywords'),
            'robotsContent' => 'Robots.txt',
            'countersContent' => \Yii::t('yiisns/seo', 'Codes counters')
        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'enableKeywordsGenerator' => \Yii::t('yiisns/seo', 'If the page is not specified keywords, they will generate is for her, according to certain rules automatically'),
            'minKeywordLenth' => \Yii::t('yiisns/seo', 'The minimum length of the keyword, which is listed by the key (automatic generation)'),
            'maxKeywordsLength' => \Yii::t('yiisns/seo', 'The maximum length of the string of keywords (automatic generation)'),
            'robotsContent' => \Yii::t('yiisns/seo', 'This value is added to the automatically generated file robots.txt, in the case where it is not physically created on the server')
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->fieldSet(\Yii::t('yiisns/seo', 'Keywords'));
        
        echo $form->field($this, 'enableKeywordsGenerator')->checkbox(\Yii::$app->formatter->booleanFormat);
        
        echo $form->field($this, 'minKeywordLenth');
        echo $form->field($this, 'maxKeywordsLength');
        
        echo $form->fieldSetEnd();
        
        echo $form->fieldSet(\Yii::t('yiisns/seo', 'Indexing'));
        echo $form->field($this, 'robotsContent')->textarea(['rows' => 7]);
        echo $form->fieldSetEnd();
        
        echo $form->fieldSet(\Yii::t('yiisns/seo', 'Codes counters'));
        echo $form->field($this, 'countersContent')->textarea(['rows' => 10]);
        echo $form->fieldSetEnd();
    }

    public function bootstrap($application)
    {
        if (! $this->enableKeywordsGenerator) {
            return $this;
        }
        
        /**
         * Generate SEO
         */
        \Yii::$app->view->on(View::EVENT_END_PAGE, function (Event $e) {
            if (! \Yii::$app->request->isAjax && ! \Yii::$app->request->isPjax) {
                $this->generateBeforeOutputPage($e->sender);
            }
        });
    }

    public function generateBeforeOutputPage(\yii\web\View $view)
    {
        $content = ob_get_contents();
        
        if (! isset($view->metaTags['keywords'])) {
            $view->registerMetaTag([
                'name' => 'keywords',
                'content' => $this->keywords($content)
            ], 'keywords');
        }
        
        \Yii::$app->response->content = $content;
    }

    /**
     *
     * Generating keywords
     *
     * @param string $content            
     * @return string
     */
    public function keywords($content = '')
    {
        $result = '';
        
        $content = $this->processPriority($content);
        if ($content) {
            // We remove from tags and break into an array
            $content = preg_replace("!<script(.*?)</script>!si", '', $content);
            $content = preg_replace('/(&\w+;)|\'/', ' ', strtolower(strip_tags($content)));
            $words = preg_split('/(\s+)|([\.\,\:\(\)\"\'\!\;])/m', $content);
            
            foreach ($words as $n => $word) {
                if (strlen($word) < $this->minKeywordLenth || (int) $word || strpos($word, '/') !== false || strpos($word, '@') !== false || strpos($word, '_') !== false || strpos($word, '=') !== false || in_array(StringHelper::strtolower($word), $this->keywordsStopWords)) {
                    unset($words[$n]);
                }
            }
            // Get an array with the number of each word
            $words = array_count_values($words);
            arsort($words);
            $words = array_keys($words);
            
            $count = 0;
            foreach ($words as $word) {
                if (strlen($result) > $this->maxKeywordsLength)
                    break;
                
                $count ++;
                if ($count > 1) {
                    $result .= ', ' . StringHelper::strtolower($word);
                } else
                    $result .= StringHelper::strtolower($word);
            }
        }
        return $result;
    }

    /**
     *
     * Text processing according to priorities and tags H1 and other
     *
     * @param string $content            
     * @return string
     */
    public function processPriority($content = "")
    {
        $contentNewResult = '';
        
        foreach ($this->keywordsPriority as $tag => $prioryty) {
            if (preg_match_all("!<{$tag}(.*?)\>(.*?)</{$tag}>!si", $content, $words)) {
                $contentNew = '';
                if (isset($words[2])) {
                    foreach ($words[2] as $num => $string) {
                        $contentNew .= $string;
                    }
                }
                
                if ($contentNew) {
                    for ($i = 1; $i <= $prioryty; $i ++) {
                        $contentNewResult .= " " . $contentNew;
                    }
                }
            }
        }
        
        return $contentNewResult . $content;
    }
}