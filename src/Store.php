<?php
    class Store
    {
        private $store_name;
        private $id;
        function __construct($store_name, $id = null)
        {
            $this->store_name = $store_name;
            $this->id = $id;
        }
        function getStoreName()
        {
            return $this->store_name;
        }
    }
?>
