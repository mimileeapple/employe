<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");?>

    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <title>首頁</title>
    <style>
        html, body {
            height: 100%; margin: 0; font-size: 10pt;
            font-family: 微軟正黑體, Arial, Helvetica, sans-serif;
        }
        .content {
            display: flex; height: 100%; padding: 0;
        }
        .content>div {
            border: px solid gray; padding: 6px;
            /* 設定 border-box，width 要內含 padding 與 border */
            box-sizing: border-box;
        }
        .col1 {
            /* flex-basis 優先於 width 或 height */
            flex-basis: 250px; flex-grow: 0; flex-shrink: 0;
        }
        .col2 {
            /* 以下寫法相當於 flex-grow: 1; flex-shrink: 2; flex-basis: 400px; */
            flex: 1 2 400px;
        }
        div { padding: 6px; }
        /* .disp { background-color:teal; color: yellow; height: 1em; }*/


    </style>
</head>
<body style="text-align: center">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><hr class="dropdown-divider"></li>
                    </ul>
        要步要在你自己電腦寫完再來這        </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
<img src="img/logo.png">
<h2 class="title-m">人資系統</h2>

<div class="content">
    <div class="col1" >
        <div class="disp"></div>

        <li><a href="personalinfor/{{Session::get('empid')}}/edit">修改個人資料</a></li>
        <li><a href="#">我要請假</a></li>
        <li><a href="#">個人請假單查詢</a></li>
        <li><a href="employees">員工資料管理</a></li>
        <li><a href="#">請假單簽核</a></li>
    </div>
    <div class="col2" >


    </div>

</div>


</body>
</html><?php
