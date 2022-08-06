<?php

class KontakTbl extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    function tableName()
    {
        return "kontak";
    }
    function getDbConnection()
    {
        return Yii::app()->db;
    }
}