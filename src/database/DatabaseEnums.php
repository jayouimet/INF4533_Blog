<?php
    /**
     * To define all types of field in the database
     */
    abstract class DatabaseTypes
    {
        const DB_INT = 'i';
        const DB_FLOAT = 'd';
        const DB_TEXT = 's';
        const DB_BLOB = 'b';
    }

    /**
     * To define all relationship between fields in the database.
     */
    abstract class DatabaseRelationship
    {
        const MANY_TO_ONE = 'MANY_TO_ONE';
        const ONE_TO_MANY = 'ONE_TO_MANY';
        const MANY_TO_MANY = 'MANY_TO_MANY';
    }
?>