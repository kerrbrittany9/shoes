<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();

        }

        function testGetStoreName()
        {
            $store_name = "DSW";
            $test_store = new Store($store_name);

            $result = $test_store->getStoreName();

            $this->assertEquals($store_name, $result);
        }

        function testsetStoreName()
        {
            $store_name = "Niketown";
            $test_store = new Store($store_name);
            $new_store_name = "NickTown";

            $test_store->setStoreName($new_store_name);
            $result = $test_store->getStoreName();

            $this->assertEquals($new_store_name, $result);
        }

        function testSave()
        {
            $store_name = "The Shoe depot";
            $test_store = new Store($store_name);
            $executed = $test_store->save();
            $this->assertTrue($executed, "Store not successfully saved to database");
        }


        function testGetId()
        {
            $store_name = "Shoes and Stuff";
            $test_store = new Store($store_name);
            $test_store->save();

            $result = $test_store->getId();

            $this->assertEquals(true, is_numeric($result));
        }


        function testGetAll()
        {
            $store_name_1 = "Nordstrom";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "Kid Shoes";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store_1, $test_store_2], $result);
        }

        function testDeleteAll()
        {
            $store_name_1 = "Shoes Beyonce Wore";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "David Bowie Shoes";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $store_name_1 = "Shoe Depot";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "Shoes and Stuff";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $result = Store::find($test_store_2->getId());

            $this->assertEquals($test_store_2, $result);
        }

        function testUpdateStoreName()
        {
            $store_name = "Shooeos";
            $test_store = new Store($store_name);
            $test_store->save();

            $new_store_name = "Shoes";
            $test_store->updateStoreName($new_store_name);

            $this->assertEquals("Shoes", $test_store->getStoreName());
        }

        function testDelete()
        {
            $store_name_1 = "Walking Store";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "Running Shoes";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $test_store_1->delete();
            $this->assertEquals([$test_store_2], Store::getAll());
        }
    }
?>
