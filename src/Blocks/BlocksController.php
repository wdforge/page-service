<?php

/**
 * 
 * @package    Pagess - Blocks
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */

namespace PagesService\Blocks;

use System\Action\ActionController;
use System\Http\HttpRequest;
use System\Std\View\ViewPage;

class BlocksController extends ActionController {

    /**
     * Параметры фильтрации передаваемых данных 
     */
    protected $_requestFilter = [

        'GetByIdAction' => [
            '__isRequest' => true,
            'id' => [
                'from' => 'GET',
                'type' => 'int',
                'regexp' => '/\d+/',
                'error' => 'Request param "id" is not valid set.',
            ],
        ],


        'GetBySectionAction' => [
            '__isRequest' => true,
            'section' => [
                'from' => 'GET',
                'type' => 'int',
                'regexp' => '/\d+/',
                'error' => 'Request param "page" is not valid set.',
            ],
        ],

        'GetByTypeAction' => [
            '__isRequest' => true,
            'type' => [
                'from' => 'GET',
                'type' => 'string',
                'regexp' => '/\d+/',
                'error' => 'Request param "type" is not valid set.',
            ],
        ],

        'GetByParentAction' => [
            '__isRequest' => true,
            'parent' => [
                'from' => 'GET',
                'type' => 'string',
                'regexp' => '/\d+/',
                'error' => 'Request param "parent" is not valid set.',
            ],
        ],

    ];

    /**
     * получение списка всех объектов + пример аутентификации.
     * @param none
     * @return JsonModel
     */
    public function IndexAction(HttpRequest $request) {

        $result = [];
        $authError = false;

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();

        // выполнение с авторизацией по Api - ключу.
        $apiKey = $request->getGetSection('apikey');

        if (!$this->getAccessManager()->isLogged()) {
            $authError = true;
            if ($this->getAccessManager()->enter($apiKey)) {
                $authError = false;
            }
        }

        if ($authError) {
            $result['error'] = 'Can\'t not autorizated by this api key';
        }

        if (!$authError) {
            // запрос к базе и возврат в виде списка объектов
            $result = $this->getServiceManager()
                ->getRepository('EntityBlockItem')
                ->findAll();
        }

        $result['method'] = 'Index';
        $result['time'] = self::getWorkTime();
        $result['eventdata'] = $event->result;

        return new Json_Model($result);
    }

    /**
     * Получение одного объекта по идентификатору.
     *
     * @param integer $id   идентификатор объекта
     * @return JsonModel
     */
    public function GetByIdAction(HttpRequest $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();

        $id = $request->getGetSection('id');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
					->getRepository('EntityBlockItem')
					->getById($id);


        $result['method'] = 'GetById';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new JsonModel($result);
    }


    /**          
     * Получение одного объекта по типу
     *
     * @param string $type   класс объекта
     * @return JsonModel
     */
    public function GetByTypeAction(HttpRequest $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();
        $type = $request->getGetSection('type');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('EntityBlockItem')
            ->getByUrl($type);

        $result['method'] = 'GetByType';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new JsonModel($result);
    }


    /**          
     * Получение одного объекта по родителю.
     *
     * @param integer $parent   идентификатор объекта
     * @return JsonModel
     */
    public function GetByParentAction(HttpRequest $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();
        $parent = $request->getGetSection('parent');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('EntityBlockItem')
            ->getByParent($parent);

        $result['method'] = 'GetByParent';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new JsonModel($result);
    }

    /**          
     * Получение одного объекта по разделу страницы.
     *
     * @param integer $id   идентификатор объекта
     * @return JsonModel
     */
    public function GetBySectionAction(Http_Request $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();
        $section = $request->getGetSection('section');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('EntityBlockItem')
            ->getBySection($section);

        $result['method'] = 'GetBySection';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new JsonModel($result);
    }


    public function GetPageAction(HttpRequest $request) {

        $page = new ViewPage([
			    'test1'=>'test007',
			    'test2'=>'test008',
		    ],

            'pages', 
            'blocks'
		);

        $page->addScripts([
            '/js/test1.js',
            '/js/test2.js',
            '/js/test3.js',
        ]);

        $page->addStyles([
            '/css/test1.css',
            '/css/test2.css',
            '/css/test3.css',
        ]);

        return $page;
    }
}
