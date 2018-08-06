<?php

use \Hcode\Page;
use \Hcode\Model\Category;

$app->get('/categories/:idcategory', function($idcategory){
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $cat = new Category;
    $cat->get((int)$idcategory);
    $pagination = $cat->getProductsPage($page);
    $pages = [];
    for ($i = 1; $i <= $pagination['pages']; $i++)
    {
        array_push($pages, [
            'link'=>"/categories/{$idcategory}?page={$i}",
            'page'=>$i
        ]);
    }
    $page = new Page;
    $page->setTpl("category", array(
        'category' => (count($cat->getValues()) > 0) ? $cat->getValues() : array('descategory'=>"Categoria inválida."),
        'products' => (count($pagination['data']) > 0) ? $pagination['data'] : [],
        'pages' => $pages
    ));
});

