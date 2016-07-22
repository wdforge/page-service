<?php

/**
 * 
 * @package    Pages
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */

/**
 * Формирование и передача запросов в виде массивов 
 * на метод выбоки findAll
 */
namespace PagesService\Pages;
use System\Db\Repository\DbZendRepository;
use System\Repository\AbstractRepository;

class PagesRepository extends DbZendRepository {

    function __construct() {
        // тип данных элемента по умолчанию
        $this->setEntityClass('EntityPageItem');
    }

    public function findAll($params = [
        'table' => 'pages',
        'field' => [
            'id',
            'title',
            'header',
            'type',
            'url',
            'parent_id',
            'ts'
        ]]) {

        return parent::findAll($params);
    }

    public function getByID($id) {

        $params = [
            'table' => 'pages',
    	     'field' => [
                'id',
                'title',
                'header',
                'type',
                'url',
                'parent_id',
                'ts'
            ],
            'where' => [
                'id = ' . $id,
            ],
        ];

        return parent::findAll($params);
    }

    public function getByUrl($url) {

        $params = [
            'table' => 'pages',
    	     'field' => [
                'id',
                'title',
                'header',
                'type',
                'url',
                'parent_id',
                'ts'
            ],
            'where' => [
                'url = ' . $url,
            ],
        ];

        return parent::findAll($params);
    }


    public function getListByParent($parent_id) {

        $params = [
            'table' => 'pages',
            'field' => [
                'id',
                'title',
                'header',
                'type',
                'url',
                'parent_id',
                'ts'
            ],
            'where' => [
                'parent_id = ' . $parent_id,
            ],
        ];

        return parent::findAll($params);
    }

}
