<?php

use Mod\countries\Model\Country;
use Mod\countries\classes\View;

require_once __DIR__ . "/classes/View.php";
require_once __DIR__ . "/Model/Country.php";
require_once DOC_ROOT . 'core2/inc/classes/Panel.php';
require_once DOC_ROOT . 'core2/inc/classes/Alert.php';

class ModCountriesController extends Common
{
    public function action_index()
    {
        $app = "index.php?module=countries&action=index";
        
        $panel = new Panel();
        $view = new View();

        $content = '';

        try {
            if (isset($_GET['edit'])) {
                if (empty($_GET['edit'])) {                    
                    $panel->setTitle($this->_("Добавление записи"), '', $app);
                    $content = $view->getEdit($app);

                } else {
                    $country = new Country();
                    $panel->setTitle($country->getCountryById($_GET['edit']) ? $country->getCountryById($_GET['edit'])['name'] : '', $this->_('Редактирование записи'), $app);
                    $content = $view->getEdit($app, $_GET['edit']);
                }
            } else {
                $panel->setTitle($this->_("Список стран:"));
                $content = $view->getList($app);
            }

        } catch (Exception $e) {
            echo Alert::danger($e->getMessage(), 'Ошибка');
        }
       
        $panel->setContent($content);
        return $panel->render();

    }

}