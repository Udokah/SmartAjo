<?php
/**
 * smartAjo
 * Class: visitor.php
 * Author: @thisisudo
 * Date: 11/22/14
 * Time: 7:47 PM
 */


$app->get('/' , function () use ($app){
    $view = new CustomView();
    $view->setTitle('Welcome To SmartAjo');
    $view->setHeader(VISITOR_HEADER);
    $view->setFooter(VISITOR_FOOTER);
    $view->setBody(VISITOR_VIEWS . '/index.php');
    $view->render();
});


$app->get('/login' , function () use ($app){
    $view = new CustomView();
    $view->setTitle('Login To SmartAjo');
    $view->setHeader(VISITOR_HEADER);
    $view->setFooter(VISITOR_FOOTER);
    $view->setBody(VISITOR_VIEWS . '/login.php');
    $view->render();
});


$app->get('/signup' , function () use ($app){
    $view = new CustomView();
    $view->setTitle('Signup for SmartAjo');
    $view->setHeader(VISITOR_HEADER);
    $view->setFooter(VISITOR_FOOTER);
    $view->setBody(VISITOR_VIEWS . '/signup.php');
    $view->render();
});


$app->get('/faq' , function () use ($app){
    $view = new CustomView();
    $view->setTitle('FAQ');
    $view->setHeader(VISITOR_HEADER);
    $view->setFooter(VISITOR_FOOTER);
    $view->setBody(VISITOR_VIEWS . '/faq.php');
    $view->render();
});

$app->get('/about' , function () use ($app){
    $view = new CustomView();
    $view->setTitle('About SmartAjo');
    $view->setHeader(VISITOR_HEADER);
    $view->setFooter(VISITOR_FOOTER);
    $view->setBody(VISITOR_VIEWS . '/about.php');
    $view->render();
});

$app->get('/ourteam' , function () use ($app){
    $view = new CustomView();
    $view->setTitle('Our Team');
    $view->setHeader(VISITOR_HEADER);
    $view->setFooter(VISITOR_FOOTER);
    $view->setBody(VISITOR_VIEWS . '/ourteam.php');
    $view->render();
});


$app->get('/contact' , function () use ($app){
    $view = new CustomView();
    $view->setTitle('Our Team');
    $view->setHeader(VISITOR_HEADER);
    $view->setFooter(VISITOR_FOOTER);
    $view->setBody(VISITOR_VIEWS . '/contact.php');
    $view->render();
});