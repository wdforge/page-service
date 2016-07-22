<?php

/**
 * 
 * @package    Pagess - Sections
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */
class Sections_Controller extends Action_Controller {

    /**
     * Параметры фильтрации передаваемых данных 
     */
    protected $_requestFilter = [

        'GetByIdAction' => [
            '__isRequest' => true,
            'id' => [
                'from' => 'URL',
                'type' => 'int',
                'regexp' => '/\d+/',
                'error' => 'Request param "id" is not valid set.',
            ],
        ],


        'GetByPageAction' => [
            '__isRequest' => true,
            'page' => [
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


        'GetByPageAction' => [
            '__isRequest' => true,
            'page' => [
                'from' => 'GET',
                'type' => 'string',
                'regexp' => '/\d+/',
                'error' => 'Request param "page" is not valid set.',
            ],
        ],

    ];

    /**
     * получение списка всех объектов + пример аутентификации.
     * @param none
     * @return JsonModel
     */
    public function IndexAction(Http_Request $request) {

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
                ->getRepository('Entity_Section_Item')
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
    public function GetByIdAction(Http_Request $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();

        $id = $request->getUrlSection('id');
        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('Entity_Section_Item')
            ->getById($id);

        $result['method'] = 'GetById';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new Json_Model($result);
    }


    /**          
     * Получение одного объекта по идентификатору.
     *
     * @param integer $id   идентификатор объекта
     * @return JsonModel
     */
    public function GetByTypeAction(Http_Request $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();
        $url = $request->getGetSection('type');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('Entity_Section_Item')
            ->getByUrl($url);

        $result['method'] = 'GetByType';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new Json_Model($result);
    }

    /**          
     * Получение одного объекта по идентификатору.
     *
     * @param integer $id   идентификатор объекта
     * @return JsonModel
     */
    public function GetByPageAction(Http_Request $request) {

        // получение данных от обработки события
        $event = $this->getServiceEventManager()->getLastEvent();
        $page = $request->getGetSection('page');

        // запрос к базе и возврат в виде списка объектов
        $result = $this->getServiceManager()
            ->getRepository('Entity_Section_Item')
            ->getByPage($page);

        $result['method'] = 'GetByPage';
        $result['time'] = self::getWorkTime();

        if (!empty($event->result)) {
            $result['eventdata'] = $event->result;
        }

        return new Json_Model($result);
    }

}
