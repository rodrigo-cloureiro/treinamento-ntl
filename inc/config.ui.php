<?php

//CONFIGURATION for SmartAdmin UI
//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
    "Home" => APP_URL . "/index.php"
);

include_once "js/repositorio.php";
session_start();

$page_nav = array("home" => array("title" => "Home", "icon" => "fa-home", "url" => APP_URL . "/index.php"));

$page_nav['cadastro'] = array("title" => "Cadastro", "icon" => "fa-pencil-square-o");
$page_nav['cadastro']['sub'] = array();
$page_nav['cadastro']['sub'] += array("funcionario" => array("title" => "Funcionário", "url" => APP_URL . "/funcionarioCadastro.php"));
$page_nav['cadastro']['sub'] += array("tipoDependente" => array("title" => "Tipo de Dependente", "url" => APP_URL . "/tipoDependenteCadastro.php"));

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
