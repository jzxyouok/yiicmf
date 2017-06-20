<?php
/* @var $this yii\web\View */
$this->registerCss(<<<CSS
.sx-about-cms
{
    padding: 15px;
    font-size: 15px;
}

.sx-about-cms ul li
{
    margin-left: 15px;
}
.sx-about-cms img
{
    max-width: 200px;
    float: left;
    margin: 10px;
}
CSS
)
?>
<div class="row sx-about-cms">
    <div class="col-md-12 col-lg-12">
        <!--<a href="http://www.yiisns.cn" target="_blank">
            <img src="http://www.yiisns.cn/img/logo.png" />
        </a>-->
        <p>
            <b>«YiiSNS»</b> - The system of managing web projects, the universal software for the creation, support and development success.
        </p>
        <p>
            <ul>
                <li><a href="http://www.yiisns.cn" target="_blank">www.yiisns.cn</a> — WebSite</li>
                <li><a href="http://doc.yiisns.cn/" target="_blank">doc.yiisns.cn</a> — Documentation</li>
                <li><a href="http://marketplace.yiisns.cn/" target="_blank">marketplace.yiisns.cn</a> — Solutions</li>
                <li><a href="http://www.yiisns.cn/contacts" target="_blank">http://www.yiisns.cn/contacts</a> — Contacts us</li>
            </ul>
        </p>
    </div>
</div>