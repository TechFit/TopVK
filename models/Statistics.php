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
    private $ownerId = false;

    public function __construct($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return mixed
     *
     * Function for getting count of group posts on the wall
     */
    public function getCommunityBaseInfo()
    {
        /** @var  $vk \yii\authclient\OAuth2*/
        $vk = Yii::$app->authClientCollection->getClient('vkontakte');

        $communityData['groupWallCount'] = $vk->api('wall.get', 'GET', [
            'owner_id' => '-' . $this->ownerId,
            'count' => 100,
            'fields' => 'count',
        ]);

        $communityData['totalPosts'] = ArrayHelper::getValue($communityData, 'groupWallCount.response.0');
        $communityData['totalPages'] = ceil(ArrayHelper::getValue($communityData, 'groupWallCount.response.0') / 100);

        return $communityData;
    }

    /**
     * @param int    $offset
     * @return bool|mixed
     *
     *  Function for getting post with maximum count of likes
     */
    public function getTopPost($offset = 100)
    {
        $cache = Yii::$app->cache;
        $key   = 'topPost' . $this->ownerId;

        /** @var  $vk \yii\authclient\OAuth2*/
        $vk = Yii::$app->authClientCollection->getClient('vkontakte');

        $listOfLikes = [];
        $responseAboutGroupWall = [];
        $listOfMaxLikes  = $cache->get($key);

        if ($listOfMaxLikes === false) {

            for ($i = 1; $i <= 3; $i++) {
                $responseAboutGroupWall['groupWallCount'] = $vk->api('wall.get', 'GET', [
                    'owner_id' => '-' . $this->ownerId,
                    'count' => 100,
                    'offset' => $offset,
                ]);

                foreach (ArrayHelper::getValue($responseAboutGroupWall, 'groupWallCount.response') as $item) {

                    $listOfLikes[ArrayHelper::getValue($item, 'id')] = ArrayHelper::getValue($item, 'likes.count');

                }

                $listOfMaxLikes['likes'] = max($listOfLikes);
                $listOfMaxLikes['id'] = array_search($listOfMaxLikes['likes'], $listOfLikes);

                $offset += 100;
            }

//            $cache->set($key, $listOfMaxLikes);
        }

        return $listOfMaxLikes;
    }

    /**
     * @param $postId
     * @return array
     *
     * Getting data(for example, text, img, likes etc.) from wall post
     */
    public function getWallPostData($postId)
    {
        /** @var  $vk \yii\authclient\OAuth2*/
        $vk = Yii::$app->authClientCollection->getClient('vkontakte');

        $responseAboutWallPost = $vk->api('wall.getById', 'GET', [
            'posts' => "-" . $this->ownerId . '_' . $postId,
            'fields' => '',
        ]);

        return $responseAboutWallPost;
    }

    public function communityData()
    {
        $data['baseInfo'] = $this->getCommunityBaseInfo();
        $data['topPost'] = $this->getTopPost();
        $data['postInfo'] = $this->getWallPostData($data['topPost']['id']);

        return $data;
    }
}