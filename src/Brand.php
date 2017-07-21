<?php
    class Brand
    {
        private $brand_name;
        private $price_point;
        private $id;
        function __construct($brand_name, $price_point, $id = null)
        {
            $this->brand_name = $brand_name;
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
            $executed = $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}')");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }



    }
?>
