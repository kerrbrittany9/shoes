<?php
    class Brand
    {
        private $brand_name;
        private $price_point;
        private $id;

        function __construct($brand_name, $price_point, $id = null)
        {
            $this->brand_name = $brand_name;
            $this->price_point = $price_point;
            $this->id = $id;
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        function setBrandName($new_brand_name)
        {
            $this->brand_name = (string) $new_brand_name;
        }


        function getPricePoint()
        {
            return $this->price_point;
        }

        function setPricePoint($new_price_point)
        {
            $this->price_point = (string) $new_price_point;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO brands (brand_name, price_point) VALUES ('{$this->getBrandName()}', '{$this->getPricePoint()}')");
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
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $price_point = $brand['price_point'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $price_point, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function find($search_id)
        {
            $returned_brands = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE id = :id");
            $returned_brands->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_brands->execute();
            foreach ($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $price_point = $brand['price_point'];
                $brand_id = $brand['id'];
                if ($brand_id == $search_id) {
                    $returned_brand = new Brand($brand_name, $price_point, $brand_id);
                }
            }
            return $returned_brand;
        }

        function addStore($store)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO inventory (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN inventory ON (inventory.brand_id = brands.id) JOIN stores ON (stores.id = inventory.store_id) WHERE brands.id = {$this->getId()};");
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $store_id = $store['id'];
                $new_store = new Store($store_name, $store_id);
                array_push($stores, $new_store);

                var_dump($stores);
            }
            return $stores;
        }

        function makeTitleCase($brand_name)
        {
            $brand_name_array = explode(" ", $brand_name);
            $output_titlecased = array();
            foreach ($brand_name_array as $word) {
                array_push($output_titlecased, ucfirst($word));
            }
            return implode(" ", $output_titlecased);
        }

        static function findDuplicateBrand($search_brand_name)
        {
            $returned_brands = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE brand_name = :brand_name");
            $returned_brands->bindParam(':brand_name', $search_brand_name, PDO::PARAM_STR);
            $returned_brands->execute();
            foreach ($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $price_point = $brand['price_point'];
                $brand_id = $brand['id'];
                if ($brand_name == $search_brand_name) {
                    $returned_brand = new Brand($brand_name, $price_point, $brand_id);
                }
            }
            return $returned_brand;
        }
    }
?>
