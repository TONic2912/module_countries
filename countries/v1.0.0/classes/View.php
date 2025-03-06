<?php
namespace Mod\countries\classes;

require_once DOC_ROOT . 'core2/inc/classes/class.list.php';
require_once DOC_ROOT . 'core2/inc/classes/class.edit.php';
require_once DOC_ROOT . 'core2/inc/classes/class.tab.php';
require_once DOC_ROOT . 'core2/inc/classes/Common.php';

class View extends \Common {

    private $app = "index.php?module=countries&action=index";

    /**
     * получение списка из таблицы core_countries
     * @return string
     * @throws \Exception
     */
    public function getList($app) {

        $list = new \listTable('core_countries');

        $list->SQL = "
            SELECT id, name, code
            FROM core_countries                
            WHERE id > 0
            ORDER BY name ASC
        ";

        $list->addColumn($this->_("Название страны"),  "255", "TEXT");
        $list->addColumn($this->_("Двухбуквенный код"), "2", "TEXT");
        $list->noCheckboxes = "yes";
        
        $list->addURL    = $app . "&edit=0";
        $list->editURL   = $app . "&edit=TCOL_00";
  
        $list->getData();
        ob_start();

        $list->showTable();
        return ob_get_clean();
    }


    /**
     * добавление данных ($id = null)/редактирование данных ($id>0)
     * @param string    $app
     * @param  int/null $id
     */
    public function getEdit(string $app, int $id = null) {

        $edit = new \editTable('core_countries');

        $fields = [
            'id',
            'name',
            'code'
        ];
       
        $implode_fields = implode(",\n", $fields);

            $edit->SQL = $this->db->quoteInto("
            SELECT {$implode_fields}
            FROM core_countries
            WHERE id = ?
        ", $id ? $id : 0);

        $edit->addControl($this->translate->tr("Название страны:"), "TEXT", "maxlength=\"255\" size=\"60\"", "", "", true);
        $edit->addControl($this->translate->tr("Двухбуквенный код:"), "TEXT", "maxlength=\"2\" size=\"60\"", "", "", true);

        $edit->back = $app;
        $edit->firstColWidth = '200px';
        $edit->addButton($this->_("Вернуться к списку стран"), "load('$app')");
        $edit->save("xajax_saveCountry(xajax.getFormValues(this.id))");


        return $edit->render();
    }

}