<!DOCTYPE html>
<?php
session_start();
require "functions/functions.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Esigelec online Sales</title>
    <link rel="stylesheet" type="text/css" href="css/newstyle.css">
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
                <input type="text" name="user_query" placeholder="Search products">
                <input type="submit" name="search" value="Search">
            </form>
        </div>
    </div>
    <div class="content_wrapper">
        <div id="sidebar">
            <div class="sidebar_title">My Account </div>
            <ul class="cats">
                <?php
                    $user = $_SESSION['customer_email'];
                    $get_img = "select * from customers where cust_email='$user'";
                    $run_img = mysqli_query($con, $get_img);
                    $row_img = mysqli_fetch_array($run_img);
                    $c_image = $row_img['cust_image'];
                    $c_name = $row_img['cust_name'];
                    echo "<img src='customer/customer_images/$c_image' width='150' height='150'
                            style='border: 2px solid white;border-radius: 50%;'>"
                ?>
                <li><a href="my_account.php?my_wishlist">My Wish List</a></li>
                <li><a href="my_account.php?my_orders">My Orders</a></li>


                <li><a href="my_account.php?del_account">Delete Account</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div id="content_area">
            <div class="shopping_cart">
                <?php cart(); ?>
                <span style="float: right;
                    font-size: 18px; padding: 5px;line-height: 40px;">
                    <?php
                        if(isset($_SESSION['customer_email'])){
                            echo "Welcome ".$_SESSION['customer_email'];
                            echo "<a style='color: orange;' href='./logout.php'> Logout</a>";
                        } else {
                            header('location: index.php');
                        }
                    ?>
                    </span>
            </div>
            <div class="products_box">
                <?php
                    if(isset($_GET['my_orders'])) {
                        echo "<h2 style='padding: 20px;'> Welcome:  $c_name </h2>";
                        $email_id = $_SESSION['customer_email'];
                        $hist_query="SELECT * from history where cust_email='$email_id'";
                        $get_hist = mysqli_query($con,$hist_query);
                        while ($hist_row = mysqli_fetch_array($get_hist)){
                                        $pro_title = $hist_row['pro_title'];
                                        $pro_image = $hist_row['pro_image'];
                                        $pro_price = $hist_row['pro_price'];
                                        $pro_qty = $hist_row['pro_quantity'];
                        ?>
                                    <table>
                                        <tr align="center">
                                            <td><?php echo $pro_title; ?>
                                                <br>
                                                <img src="admin/product_images/<?php echo $pro_image; ?>"
                                                     width="60" height="60">
                                            </td>
                                            <td><?php echo "$".$pro_price?></td>
                                            <td><?php echo $pro_qty; ?></td>
                                        </tr>
                <?php

                        }
                    }
                ?></table>

                <?php
                    if(isset($_GET['my_wishlist'])){
                        $email_id = $_SESSION['customer_email'];
                        $wish_query="SELECT * from favlist where cust_email='$email_id'";
                        $get_wish = mysqli_query($con,$wish_query);
                        while ($wish_row = mysqli_fetch_array($get_wish)){
                            $pro_id = $wish_row['prod_id'];
                        $get_pro = "select * from products where pro_id='$pro_id'";
                        $run_pro = mysqli_query($con, $get_pro);
                        while ($row_pro = mysqli_fetch_array($run_pro)) {
                            $pro_title = $row_pro['pro_title'];
                            $pro_price = $row_pro['pro_price'];
                            $pro_image = $row_pro['pro_image'];
                            $pro_desc = $row_pro['pro_desc'];



                ?>
                                    <table>
                                        <tr align="center">
                                            <td><?php echo $pro_title; ?>
                                                <br>
                                                <img src="admin/product_images/<?php echo $pro_image; ?>"
                                                     width="60" height="60">
                                            </td>
                                            <td><?php echo "$".$pro_price?></td>
                                        </tr>
                </table>
                <?php

                            }
                        }
                    }
                    if(isset($_GET['del_account'])){
                        include ('del_account.php');
                    }

                ?>


            </div>

        </div>
    </div>
</div>
</body>
</html>
