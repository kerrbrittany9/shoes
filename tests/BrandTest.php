<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();

        }

        function testGetBrandName()
        {
            $brand_name = "Keds";
            $price_point = "low";
            $test_brand = new Brand($brand_name, $price_point);

            $result = $test_brand->getBrandName();

            $this->assertEquals($brand_name, $result);
        }

        function testSetBrandName()
        {
            $brand_name = "Asics";
            $price_point = "medium";
            $test_brand = new Brand($brand_name, $price_point);
            $new_brand_name = "Asics Plus";

            $test_brand->setBrandName($new_brand_name);

            $result = $test_brand->getBrandName();
            $this->assertEquals($new_brand_name, $result);
        }

        function testSave()
        {
            $brand_name = "Tigers";
            $price_point = "medium";
            $test_brand = new Brand($brand_name, $price_point);
            $executed = $test_brand->save();

            $this->assertTrue($executed, "Brand not successfully saved to database");
        }

        function testGetId()
        {
            $brand_name = "Gucci";
            $price_point = "high";
            $test_brand = new Brand($brand_name, $price_point);
            $test_brand->save();

            $result = $test_brand->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
            $brand_name = "XYZ";
            $price_point = "high";
            $test_brand = new Brand($brand_name, $price_point);
            $test_brand->save();

            $brand_name_2 = "The shoes";
            $price_point_2 = "low";
            $test_brand_2 = new Brand($brand_name_2, $price_point_2);
            $test_brand_2->save();

            $result = Brand::getAll();
            $this->assertEquals([$test_brand, $test_brand_2], $result);
        }
        function testDeleteAll()
        {
            $brand_name_1 = "Minolos";
            $price_point_1 = "high";
            $test_brand_1 = new Brand($brand_name_1, $price_point_1);
            $test_brand_1->save();

            $brand_name_2 = "Converse";
            $price_point_2 = "medium";
            $test_brand_2 = new Brand($brand_name_2, $price_point_2);
            $test_brand_2->save();

            Brand::deleteAll();
            $result = Brand::getAll();
            $this->assertEquals([], $result);
        }


        function testFind()
        {
            $brand_name_1 = "The Feet Covers";
            $price_point_1 = "low";
            $test_brand_1 = new Brand($brand_name_1, $price_point_1);
            $test_brand_1->save();

            $brand_name_2 = "Sole Food";
            $price_point_2 = "high";
            $test_brand_2 = new Brand($brand_name_2, $price_point_2);
            $test_brand_2->save();
            $result = Brand::find($test_brand_2->getId());
            $this->assertEquals($test_brand_2, $result);
        }


        function testAddStore()
        {
            $store_name = "Shoes";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = "Tigers";
            $price_point = "medium";
            $test_brand = new Brand($brand_name, $price_point);
            $test_brand->save();

            $test_brand->addStore($test_store);

            $this->assertEquals($test_brand->getStores(), [$test_store]);
        }

        function testGetStores()
        {
            $store_name_1 = "G.G.";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "Isabel's";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $brand_name = "Air Jordan";
            $price_point = "high";
            $test_brand = new Brand($brand_name, $price_point);
            $test_brand->save();

            $test_brand->addStore($test_store_1);
            $test_brand->addStore($test_store_2);

            
            $this->assertEquals($test_brand->getStores(), [$test_store_1, $test_store_2]);
        }



    }
?>
