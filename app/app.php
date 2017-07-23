<?php

    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";


    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\Debug\Debug;
    Debug::enable();
    $app = new Silex\Application();
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });

    $app->post("/", function() use ($app) {
        $store_name = $_POST['store_name'];
        $new_store = new Store($store_name);
        $title_case_store = $new_store->makeTitleCase($store_name);
        $new_store->setStoreName($title_case_store);
        $new_store->save();

        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });

    $app->get("/edit_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'inventory' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->patch("/edit_store/{id}", function($id) use ($app) {
        $store_name  = $_POST['store_name'];
        $store = Store::find($id);
        $title_case_store = $store->makeTitleCase($store_name);
        $store->updateStoreName($title_case_store);

        return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'all_brands' => Brand::getAll(), 'inventory' => $store->getBrands()));
    });

    $app->post("/assign_brand/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['all_brands']);
        $store->addBrand($brand);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'all_brands' => Brand::getAll(), 'inventory' => $store->getBrands()));
    });

    $app->delete("/delete_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll()));
    });


    $app->post("/add_brand", function() use ($app) {
        $brand_name = $_POST['brand_name'];
        $price_point = $_POST['price_point'];
        $new_brand = new Brand($brand_name, $price_point);
        $title_case_brand = $new_brand->makeTitleCase($brand_name);
        $new_brand->setBrandName($title_case_brand);
        $new_brand->save();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });

    $app->get("/edit_brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('edit_brand.html.twig', array('brand' => $brand, 'brand_stores' => $brand->getStores(), 'all_stores' => Store::getAll(), 'all_brands' => Store::getAll()));
    });

    $app->post("/assign_store/{id}", function($id) use ($app) {
        $brand= Brand::find($id);
        $store = Store::find($_POST['all_stores']);
        $brand->addStore($store);
        return $app['twig']->render('edit_brand.html.twig', array('brand' => $brand, 'all_stores' => Store::getAll(), 'brand_stores' => $brand->getStores()));
    });

    return $app;

?>
