<?php

namespace app\models;


use yii\db\ActiveRecord;

/**
 * Class Auth
 * @package app\models
 * @author M.Barvinok
 */
class Auth extends ActiveRecord
{
    private $user;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'auth';
    }

    /**
     * @param $user_id
     * @return array|null|ActiveRecord
     */
    public function getUser($user_id)
    {
        return Users::find()->where(['id' => $user_id])->one();
    }


}