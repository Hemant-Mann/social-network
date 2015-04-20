<?php
namespace Shared {
    class Model extends \Framework\Model {
        /**
        * @column
        * @readwrite
        * @primary
        * @type autonumber
        */
        protected $_id;

        /**
        * @column
        * @readwrite
        * @type boolean
        * @index
        */
        protected $_live;
        
        /**
        * @column
        * @readwrite
        * @type boolean
        * @index
        */
        protected $_deleted;
        
        /**
        * @column
        * @readwrite
        * @type datetime
        */
        protected $_created;
        
        /**
        * @column
        * @readwrite
        * @type datetime
        */
        protected $_modified;

        public function save() {
            $primary = $this->getPrimaryColumn();
            $raw = $primary["raw"];
            
            // ID is not set so it is INSERT statement
            if (empty($this->$raw)) {
                $this->setCreated(date("Y-m-d H:i:s"));
                $this->setDeleted(false);
                $this->setLive(true);
            } else {
                // ID is set so UPDATE statement
                // live and deleted will be opposite of each other always

                // if undoing delete, live must be true
                if($this->getDeleted() === false) {
                    $this->setLive(true);
                } else if($this->getDeleted() === true) {
                    $this->setLive(false);
                } else {
                    $this->setLive(true);
                    $this->setDeleted(false);
                }
            }

            $this->setModified(date("Y-m-d H:i:s"));
            
            parent::save();
        }
    }
}
