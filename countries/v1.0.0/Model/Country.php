<?php

namespace Mod\countries\Model;
use Zend_Db_Table_Abstract;

/**
 * Class Country
 */
class Country extends Zend_Db_Table_Abstract
{

    protected $_name = 'core_countries';

    /** 
     * получение записи таблицы core_countries по id
     * @param string $id
     */
    public function getCountryById($id)
    {
        $res = $this->_db->fetchRow("
            SELECT 
                    id, name, code
                FROM
                    core_countries
                where id  = ? 
            LIMIT 1
        ", $id);
        return $res;
    }
}