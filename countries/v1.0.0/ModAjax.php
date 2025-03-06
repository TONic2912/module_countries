<?php
require_once("core2/inc/ajax.func.php");

/**
 * Class ModAjax
 */
class ModAjax extends ajaxFunc
{
        /**
     * Сохранение данных
     * @param array $data
     * @return xajaxResponse
     */
	public function axSaveCountry($data): xajaxResponse {
        
        $fields = [
            'name'     => 'req',
            'code' => 'req',
        ];
        // проверка на обязательность заполнения полей (require)
        if ($this->ajaxValidate($data, $fields)) {
            return $this->response;
        }
        // сохранить
        if ( ! $this->saveData($data)) {
            return $this->response;
        }
       
        $this->done($data);
		return $this->response;
    }


}