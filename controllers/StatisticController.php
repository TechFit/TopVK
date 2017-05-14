<?php


namespace app\controllers;

use Yii;
use app\models\Statistics;
use yii\base\Controller;

/**
 * Class StatisticController
 * @package app\controllers
 *
 */
class StatisticController extends Controller
{
    /**
     * @return string
     *
     * VK statistic page
     */
    public function actionGroup()
    {
        $ownerId = Yii::$app->getRequest()->get('ownerId');

        $statistic = new Statistics($ownerId);

        $groupStatistic = $statistic->communityData();

        return $this->render('group', [
            'groupStatistic' => $groupStatistic
        ]);
    }
}