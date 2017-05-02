<?php

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$this->title = 'Статистика';
?>
<div class="site-index">
    <div class="container">
        <p class="btn btn-default">
            Total posts: <b><?= $community['totalPosts']; ?></b>
        </p>
        <p class="btn btn-default">
            Total pages: <b><?= $community['totalPages']; ?></b>
        </p>
        <p class="btn btn-default">
            Total post Id: <b><?= $listOfMaxLikes['id'] ?> </b>
        </p>
        <p class="btn btn-default">
            Total Likes of post: <b><?= $listOfMaxLikes['likes'] ?> </b>
        </p>
        <p>
            <?= date('Y-m-d H:i:s', ArrayHelper::getValue($dataAboutPost, 'response.0.date')); ?>
        </p>

        <p>
            <?= ArrayHelper::getValue($dataAboutPost, 'response.0.text'); ?>
        </p>
        <p>
            <img src="<?= ArrayHelper::getValue($dataAboutPost, 'response.0.attachment.photo.src_big'); ?> " alt="" >
        </p>
        <a href="https://vk.com/wall<?= ArrayHelper::getValue($dataAboutPost, 'response.0.from_id') . '_' . ArrayHelper::getValue($dataAboutPost, 'response.0.id'); ?> ">
            Ссылка на пост
        </a>
    </div>
</div>
