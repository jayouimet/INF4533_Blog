<?php
    include_once dirname(__FILE__) . "/DatabaseEnums.php";

    class DatabaseRelation {
        public string $attrName;
        public string $fkAttr;
        public string $tableName;
        public string $relationship;

        public function __construct($attrName, $tableName, $fkAttr, $relationship) {
            $this->attrName = $attrName;
            $this->fkAttr = $fkAttr;
            $this->tableName = $tableName;
            $this->relationship = $relationship;
        }
    }
?>