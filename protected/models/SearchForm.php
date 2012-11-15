<?php

/**
 * 描述 SearchForm
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
class SearchForm extends CFormModel{
    public $keywords;

    public function  rules() {
        return array(
            array('keywords','safe')
        );
    }

    public function  attributeLabels() {
        return array(
            'keywords'=>'关键字'
        );
    }

}
?>
