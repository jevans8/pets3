<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');

//Instantiate the F3 Base class
$f3 = Base::instance();

//Default route
$f3->route('GET /', function(){
    //echo '<h1>My Pets</h1>';
    //echo '<a href="order">Order a Pet</a>';

    //instantiate new template object
    $view = new Template();

    //display home page via render method
    echo $view->render('views/pet-home.html');

});

//Order route
$f3->route('GET|POST /order', function($f3){

    //check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //echo "post method";

        //validate the data
        if(empty($_POST['pet'])){
            echo "please supply a pet type";
        }
        else{
            //data is valid
            $_SESSION['pet'] = $_POST['pet'];
            $_SESSION['color'] = $_POST['color'];

            //redirect to the summary route
            $f3->reroute("summary");
        }
    }

    //instantiate new template object
    $view = new Template();

    //display home page via render method
    echo $view->render('views/pet-order.html');

});

//Order summary route
$f3->route('GET /summary', function(){

    //instantiate new template object
    $view = new Template();

    //display home page via render method
    echo $view->render('views/order-summary.html');

});

//Run F3
$f3->run();