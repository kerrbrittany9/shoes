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
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll()));
    });


    $app->post("/", function() use ($app) {
      $store_name = $_POST['store_name'];
      $new_store = new Store($store_name);
      $new_store->save();
      return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll()));
    });

    $app->get("/edit_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'inventory' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });


    $app->patch("/edit_store/{id}", function($id) use ($app) {
        $store_name  = $_POST['store_name'];
        $store = Store::find($id);
        $store->updateStoreName($store_name);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'all_brands' => Brand::getAll(), 'inventory' => $store->getBrands()));
    });

    $app->post("/assign_brand/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['all_brands']);
        $store->addAuthor($brand);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'all_brands' => Brand::getAll(), 'inventory' => $store->getBrands()));
    });

    $app->delete("/delete_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll()));
    });

    return $app;

?>
