<?php

class Kategori_kontakTbl extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    function tableName()
    {
        return "kategori_kontak";
    }
    function getDbConnection()
    {
        return Yii::app()->db;
    }
}