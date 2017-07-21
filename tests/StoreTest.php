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
    }
?>
