<?php
/**
 * bootstrap
 *
 * @author uussoft <uussoft@yiisns.cn>
 * @link http://www.yiisns.cn/
 * @copyright 2016-2017 YiiSNS
 * @date 19.02.2016
 * @since 1.0.0
 */
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('application', dirname(dirname(__DIR__)) . '/application');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');