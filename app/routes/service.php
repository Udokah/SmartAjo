<?php
/**
 * smartAjo
 * Class: service.php
 * Author: @thisisudo
 * Date: 11/23/14
 * Time: 11:31 AM
 */


$app->group('/service' , function () use ($app){

    $app->post('/login' , function () use ($app){
        verifyRequiredParams('login,password');
        $login = $app->request->post('login') ;
        $password = $app->request->post('password') ;
        $userModel = new userModel();
        push(200,$userModel->authenticate($login,$password));
    });


    $app->post('/signup' , function () use ($app){
        verifyRequiredParams('name,email,phone,password');
        $name = $app->request->post('name') ;
        $email = $app->request->post('email') ;
        $phone = $app->request->post('phone') ;
        $password = $app->request->post('password') ;
        $userModel = new userModel();
        push( 200,$userModel->create($name,$email,$phone,$password));
    });


    $app->post('/new/ajo' , function () use ($app){
        verifyRequiredParams('uid,name,amount,debit_date,debit_account,credit_account');
        $uid = $app->request->post('uid') ;
        $name = $app->request->post('name') ;
        $amount = $app->request->post('amount') ;
        $debit_date = $app->request->post('debit_date') ;
        $debit_account = $app->request->post('debit_account') ;
        $credit_account = $app->request->post('credit_account') ;
        $userModel = new ajoModel();
        push( 200,$userModel->create($uid,$name,$amount,$debit_date,$debit_account,$credit_account));
    });


    $app->post('/add/account' , function () use ($app){
        verifyRequiredParams('uid,name,account,bank');
        $uid = $app->request->post('uid') ;
        $title = $app->request->post('title') ;
        $name = $app->request->post('name') ;
        $account = $app->request->post('account') ;
        $bank = $app->request->post('bank') ;
        $model = new ajoModel();
        push( 200,$model->newBankAccount($uid,$title,$name,$account,$bank));
    });


    $app->post('/join/ajo' , function () use ($app){
        push(200,array("ok"));
    });


    $app->get('/ajo/:uid' , function ($uid) use ($app){
        $ajo = new ajoModel();
        $info = $ajo->getAjoInfo($uid);
        push(200,$info);
    });


});