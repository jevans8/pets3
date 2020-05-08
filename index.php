<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');
require_once ('model/validation-functions.php');

//Instantiate the F3 Base class
$f3 = Base::instance();
$f3->set('colors', array('pink', 'green', 'blue'));

////////////////////////////////////////////////////////////////////////////////////////
//Default route
$f3->route('GET /', function(){
    //echo '<h1>My Pets</h1>';
    //echo '<a href="order">Order a Pet</a>';

    //instantiate new template object
    $view = new Template();

    //display home page via render method
    echo $view->render('views/pet-home.html');

});

////////////////////////////////////////////////////////////////////////////////////////
//Order route
$f3->route('GET|POST /order', function($f3){
    $_SESSION = array();
    //check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //echo "post method";
        $animal = $_POST['pet'];
        $color = $_POST['color'];
        //checks if the string input is valid
        //if it is then it saves it on the session
        //else it sets a variable to the hide and displays an error.
        if(validString($animal)){
            $_SESSION['animal'] = $animal;
        }
        else{
           $f3->set("errors","Please enter an animal");
        }
        //checks if the color is valid
        if(validColor($color)){
            $_SESSION['color'] = $color;
        }
        else{
            $f3->set("colorError","Please select a color.");
        }
        //if both is valid then reroute to the summary page.
        if(validColor($color)&&validString($animal)){
            $f3->reroute('summary');
        }
    }

    //instantiate new template object
    $view = new Template();

    //display home page via render method
    echo $view->render('views/pet-order.html');

});

$f3->route('GET|POST /summary', function(){

    //instantiate new template object

    $view = new Template();

    //display home page via render method
    echo $view->render('views/order-summary.html');

});

//Run F3
$f3->run();