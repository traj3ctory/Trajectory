<?php require_once 'includes/header.php';?>

<?php

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
    $totalRevenue += $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT users.username , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwiseOrder = $userwiseQuery->num_rows;

$connect->close();

?>


<style type="text/css">
.ui-datepicker-calendar {
    display: none;
}

</style>

<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">


<div class="row mt-5">
    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) {?>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">

                <a href="product.php" style="text-decoration:none;color:white;">
                    <i class="glyphicon glyphicon-briefcase"></i>
                    Total Product
                    <span class="badge pull pull-right"><?php echo $countProduct; ?></span>
                </a>

            </div>
            <!--/panel-heading-->
        </div>
        <!--/panel-->
    </div>
    <!--/col-md-4-->

    <div class="col-md-4">
        <div class="panel panel-danger">
            <div class="panel-heading ">
                <a href="product.php" style="text-decoration:none;color:black;">
                    <i class="glyphicon glyphicon-stats"></i>
                    Low Stock
                    <span class="badge pull pull-right"><?php echo $countLowStock; ?></span>
                </a>
            </div>
            <!--/panel-heading-->
        </div>
        <!--/panel-->
    </div>
    <!--/col-md-4-->


    <?php }?>
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <a href="orders.php?o=manord" style="text-decoration:none;color:black;">
                    <i class="glyphicon glyphicon-folder-close"></i>
                    Total Orders
                    <span class="badge pull pull-right"><?php echo $countOrder; ?></span>
                </a>

            </div>
            <!--/panel-heading-->
        </div>
        <!--/panel-->
    </div>
    <!--/col-md-4-->



    <div class="col-md-4">
        <div class="card">
            <div class="bg-primary py-2">
                <h1><i class="glyphicon glyphicon-calendar "></i>
                <?php
date_default_timezone_set("Africa/Lagos");
echo date(" Y - m - d  l");?></h1>
            </div>

            <div class="cardContainer">
                <p>
            <div id="clock"></div>
            </p>
            </div>
        </div>
        <br />

        <div class="card mb-4">
            <div class="cardHeader py-2">
                <h1>&#8358; <?php if ($totalRevenue) {
    echo $totalRevenue;
} else {
    echo '0';
}?></h1>
            </div>

            <div class="cardContainer">
                <p>&#8358; Total Revenue Generated</p>
            </div>
        </div>

    </div>

    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) {?>
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Sales Person id</div>
            <div class="panel-body">
                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th style="width:40%;">User id</th>
                            <th style="width:20%;">Amount (&#8358)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($orderResult = $userwiseQuery->fetch_assoc()) {?>
                        <tr>
                            <td><?php echo $orderResult['username'] ?></td>
                            <td>&#8358; <?php echo $orderResult['totalorder'] ?></td>

                        </tr>

                        <?php }?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <?php }?>

</div>


<!--/row-->

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="custom/js/time.js"></script>


<?php require_once 'includes/footer.php';?>