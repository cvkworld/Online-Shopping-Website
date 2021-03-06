<!DOCTYPE html>
<?php
session_start();
require "functions/functions.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Esigelec Online Sales</title>
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
                <?php
                global $con;
                $ip = getIp();
                if(isset($_POST['update_cart'])){
                    
                    for($i =0; $i< sizeof($_POST['product_id']); $i++){
                        $pro_id = $_POST['product_id'][$i];
                        $qty = $_POST['qty'][$i];
                        if($qty > 0) {
                            $update_qty = "update cart set qty='$qty' where p_id='$pro_id' AND ip_add='$ip'";
                            $run_qty = mysqli_query($con, $update_qty);
                        }
                    }
                    if(isset($_POST['remove'])) {
                        foreach ($_POST['remove'] as $remove_id) {
                            $del_pro = "delete from cart where p_id='$remove_id' AND ip_add='$ip'";
                            $run_del = mysqli_query($con, $del_pro);
                        }
                    }
                    header('location: '.$_SERVER['PHP_SELF']);
                }
                if(isset($_POST['continue'])){
                    header('location: index.php');
                }
                ?>
                <div class="shopping_cart">
                    <?php cart(); ?>
                    <span style="
                    font-size: 18px; padding: 5px;line-height: 40px;">
                        <?php
                        if(!isset($_SESSION['customer_email']))
                            echo "Welcome guest!";
                        else
                            echo "Welcome ".$_SESSION['customer_email'];
                        ?>
                        <b>
                            Shopping Cart - </b>
                        Total Items: <?php total_items(); ?>
                        Total Price: <?php total_price(); ?>
                        <?php
                        if(!isset($_SESSION['customer_email'])){
                            echo "   <a href='checkout.php'>Login</a>";
                        }
                        else{
                            echo "<a href='logout.php'>Logout</a>";
                        }
                        ?>
                    </span>

                </div>
                <div class="products_box">
                    <br>
                    <form action="" method="post" enctype="multipart/form-data">
                        <table align="center" width="700px" bgcolor="#87ceeb">
                            <tr align="center">
                                <th> Remove </th>
                                <th> Product(s) </th>
                                <th> Quantity </th>
                                <th> Unit Price </th>
                                <th> Items Total </th>
                            </tr>
                            <?php
                                $ip = getIp();
                                $total = 0;
                                $sel_price = "select * from cart where ip_add = '$ip'";
                                $run_price = mysqli_query($con,$sel_price);
                                while($cart_row = mysqli_fetch_array($run_price)){
									//print_r($cart_row);
                                    $pro_id = $cart_row['p_id'];
                                    $pro_qty = $cart_row['qty'];
                                    $pro_price = "select * from products where pro_id = '$pro_id'";
									//print_r($pro_price);
                                    $run_pro_price = mysqli_query($con, $pro_price);
                                    while ($pro_row = mysqli_fetch_array($run_pro_price)){
                                        $pro_title = $pro_row['pro_title'];
                                        $pro_image = $pro_row['pro_image'];
                                        $pro_price = $pro_row['pro_price'];
                                        $pro_price_all_items = $pro_price * $pro_qty;
                                        $total += $pro_price_all_items;
                                        ?>
                                        <tr align="center">
                                            <td><input type="checkbox" name="remove[]"
                                                       value="<?php echo $pro_id; ?>"></td>
                                            <td><?php echo $pro_title; ?> <br>
                                                <img src="admin/product_images/<?php echo $pro_image; ?>"
                                                     width="60" height="60">
                                            </td>
                                            <td><input size="2" name="qty[]" value="<?php echo $pro_qty;?>">
                                                <input name="product_id[]" type="hidden" value="<?php echo $pro_id;?>">
                                            </td>
                                            <td><?php echo "$".$pro_price ; ?></td>
                                            <td><?php echo "$".$pro_price_all_items; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>

                            <tr align="right">
                                <td colspan="4"><b>Sub Total:</b></td>
                                <td><?php echo "$".$total; ?></td>
                            </tr>
                            <tr align="center">
                                <td colspan="2"><input type="submit" name="update_cart" value="Update Cart"></td>
                                <td><input type="submit" name="continue" value="Continue Shopping"></td>
                                <td><button>
                                        <a style="text-decoration: none;
                                            color: black;" href="checkout.php">
                                            Checkout</a>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
