<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";


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
    // 'all_brands' => Brand::getAll()

    $app->post("/", function() use ($app) {
      $store_name = $_POST['store_name'];
      $new_store = new Store($store_name);
      $new_store->save();
      return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll()));
    });

    $app->get("/edit_store/{id}", function($id) use ($app) {
       $store = Store::find($id);
       return $app['twig']->render('edit_store.html.twig', array('store' => $store, , 'store_authors' => $store->getBrands()));
   });
   // 'all_brands' => Brand::getAll()

    return $app;
?>