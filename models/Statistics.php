<?php

namespace app\models;

use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Statistics
 * @package app\models
 */
class Statistics
{
    const DEFAULT_API_ID = '-1';
    /**
     * @param $ownerId
     * @return mixed
     *
     * Function for getting count of group posts on the wall
     */
    public function getCommunityData($ownerId = self::DEFAULT_API_ID)
    {
        /** @var  $vk \yii\authclient\OAuth2*/
        $vk = Yii::$app->authClientCollection->getClient('vkontakte');

        $communityData['groupWallCount'] = $vk->api('wall.get', 'GET', [
            'owner_id' => $ownerId,
            'count' => 100,
            'fields' => 'count',
        ]);

        $communityData['totalPosts'] = ArrayHelper::getValue($communityData, 'groupWallCount.response.0');
        $communityData['totalPages'] = ceil(ArrayHelper::getValue($communityData, 'groupWallCount.response.0') / 100);

        return $communityData;
    }

    /**
     * @param string $ownerId
     * @param array  $communityData
     * @param int    $offset
     * @return bool|mixed
     *
     *  Function for getting post with maximum count of likes
     */
    public function getTopPost($ownerId = self::DEFAULT_API_ID, array $communityData, $offset = 100)
    {
        $cache = Yii::$app->cache;
        $key   = 'topPost' . $ownerId;

        /** @var  $vk \yii\authclient\OAuth2*/
        $vk = Yii::$app->authClientCollection->getClient('vkontakte');

        $listOfLikes = [];
        $responseAboutGroupWall = [];
        $listOfMaxLikes  = $cache->get($key);

        if ($listOfMaxLikes === false) {

            for ($i = 1; $i <= $communityData['totalPages']; $i++) {
                $responseAboutGroupWall['groupWallCount'] = $vk->api('wall.get', 'GET', [
                    'owner_id' => $ownerId,
                    'count' => 100,
                    'offset' => $offset,
                    'fields' => 'description',
                ]);

                foreach (ArrayHelper::getValue($responseAboutGroupWall, 'groupWallCount.response') as $item) {
                    $listOfLikes[ArrayHelper::getValue($item, 'id')] = ArrayHelper::getValue($item, 'likes.count');
                }

                $listOfMaxLikes['likes'] = max($listOfLikes);
                $listOfMaxLikes['id'] = array_search($listOfMaxLikes['likes'], $listOfLikes);

                $offset += 100;
            }

            $cache->set($key, $listOfMaxLikes);
        }

        return $listOfMaxLikes;
    }

    /**
     * @param $ownerId
     * @param $postId
     * @return array
     *
     * Getting data(for example, text, img, likes etc.) from wall post
     */
    public function getWallPostData($ownerId = self::DEFAULT_API_ID, $postId)
    {
        /** @var  $vk \yii\authclient\OAuth2*/
        $vk = Yii::$app->authClientCollection->getClient('vkontakte');

        $responseAboutWallPost = $vk->api('wall.getById', 'GET', [
            'posts' => $ownerId . '_' . $postId,
            'fields' => '',
        ]);

        return $responseAboutWallPost;
    }
}