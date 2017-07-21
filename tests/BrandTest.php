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

    class BrandTest extends PHPUnit_Framework_TestCase
    {
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
    }
?>
