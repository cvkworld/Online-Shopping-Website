<!DOCTYPE html>
<?php
session_start();
require "functions/functions.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Esigelec Online Sales</title>
    <link rel="stylesheet" href="css/newstyle.css">
</head>
<body>
    <div class="main_wrapper">
        <div class="header_wrapper">
            <img id="banner" src="images/banner2.jpg">
        </div>
        <div class="menubar">
            <ul id="menu">
                <li><a href="index.php">Home</a></li>
                
                <li><a href="my_account.php">My Account</a></li>
                <li><a href="cart.php">Cart</a></li>
                <?php
                if(isset($_SESSION['isAdmin'])){
                    echo "<li><a href='admin/index.php?insert_product'>Insert Product</a></li>";
                }
                ?>

            </ul>
            <div id="form">
                <form method="get" action="results.php">
                    <input type="text" name="user_query" placeholder="Search products" id="searchBox">
                    <input type="submit" name="search" value="Search">
                </form>
            </div>
        </div>
        <div class="content_wrapper">
            <div id="sidebar">
                <div class="sidebar_title">Categories </div>
                <ul class="cats">
                    <?php getCats(); ?>
                </ul>
                <div class="sidebar_title">Brands </div>
                <ul class="cats">
                    <?php getBrands(); ?>
                </ul>
            </div>
            <div id="content_area">
                <div class="shopping_cart">
                    <?php cart(); ?>
                    <span style="float: left;
                    font-size: 18px; padding: 5px;line-height: 40px;">
                        <?php
                        if(!isset($_SESSION['customer_email']))
                            echo "Welcome guest!";
                        else
                            echo "Welcome ".$_SESSION['customer_email'];
                         ?>
                        <b >
                            Shopping Cart - </b>
                        Total Items: <?php total_items(); ?>
                        Total Price: <?php total_price(); ?>
                        <?php
                            if(!isset($_SESSION['customer_email'])){
                                
                                echo "<a href='checkout.php'>Login</a>";
                            }
                            else{
                                echo "<a href='logout.php'>Logout</a>";
                            }
                        ?>
                    </span>
                </div>
                <div class="products_box">
                    <?php getPro(); ?>
                </div>   
                
                
                           
            </div>
            <div class="pagination" style='float: center;'>
                    <a href="index.php?page=1">&laquo;</a>
                    <a href="index.php?page=1">1</a>
                    <a href="index.php?page=2">2</a>
                    <a href="index.php?page=3">3</a>
                    <a href="index.php?page=3">&raquo;</a>
                    
                </div>            
        </div>
    </div>   
</body>
</html>