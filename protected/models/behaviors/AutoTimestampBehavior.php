<?php

/**
 * 描述 AutoTimestampBehavior
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
class AutoTimestampBehavior extends CActiveRecordBehavior {

    /**
     * The field that stores the creation time
     */
    public $created = 'create_date';
    /**
     * The field that stores the modification time
     */
    public $modified = 'modify_date';

    public function beforeValidate($on) {
        if ($this->Owner->getIsNewRecord()) {
            $this->Owner->{$this->created} = time();
            $this->Owner->{$this->modified} = time();
        } else {
            $this->Owner->{$this->modified} = time();
        }

        return true;
    }

}