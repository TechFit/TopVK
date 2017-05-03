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
    /**
     * @param $ownerId
     * @return mixed
     *
     * Function for getting count of group posts on the wall
     */
    public function getCommunityData($ownerId)
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
     * @param array $communityData
     * @param int   $offset
     * @return array
     *
     * Function for getting post with maximum count of likes
     */
    public function getTopPost($ownerId, array $communityData, $offset = 100)
    {
        /** @var  $vk \yii\authclient\OAuth2*/
        $vk = Yii::$app->authClientCollection->getClient('vkontakte');

        $listOfLikes = [];
        $responseAboutGroupWall = [];
        $listOfMaxLikes = [];

        $cache = Yii::$app->cache;

        $listOfMaxLikes = $cache->get('topPost');

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

            $cache->set('topPost', $listOfMaxLikes, 3600);
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
    public function getWallPostData($ownerId, $postId)
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