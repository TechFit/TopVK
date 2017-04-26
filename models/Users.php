<?php
/**
 * Users class
 *
 */
namespace app\models;


use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->token = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}