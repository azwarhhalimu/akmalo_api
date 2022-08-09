<?php

class TestingTbl extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    function tableName()
    {
        return "nama_tabel";
    }
    function getDbConnection()
    {
        return Yii::app()->db;
    }
}