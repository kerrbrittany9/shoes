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

        function setStoreName($new_store_name)
        {
            $this->store_name = (string) $new_store_name;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}')");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        function getId()
        {
            return $this->id;
        }


        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $store_id = $store['id'];
                $new_store = new Store($store_name, $store_id);
                array_push($stores, $new_store);
            }
            return $stores;
        }
        
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }




    }
?>
