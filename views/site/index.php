<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'calendar.fetus.jp';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>calendar.fetus.jp</h1>
    </div>
    <ul>
        <li>
            <a href="<?= Url::to(['holiday/json']) ?>">休日JSON取得</a>
        </li>
    </ul>
</div>
