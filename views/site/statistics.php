<?php

use yii\helpers\ArrayHelper,
    yii\helpers\Html;

use yii\widgets\Pjax,
    yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Статистика';
?>
<div class="statistic-index">
    <div class="container">
        <div class="loader on">
            <div class="wrap">
                <div class="bg">
                    <div class="loading">
                        <span class="title">loading</span>
                    </div>
                </div>
            </div>
        </div>

        <?php Pjax::begin(); ?>
            <?= Html::beginForm('statistics', 'get', ['data-pjax' => '']) ?>
            <?= Html::input('text', 'ownerId') ?>
            <?= Html::submitButton('Отправить', ['class' => 'flat_button secondary']) ?>
            <?= Html::endForm() ?>
        <?php Pjax::end(); ?>
        <div class="data-stats">
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
        </div>
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
