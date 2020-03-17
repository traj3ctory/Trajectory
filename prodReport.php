<?php require_once 'includes/header.php'; ?>

<?php
// session_start();

// authenticate user role
if ($_SESSION['role'] == "ADMIN") {
    ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-check"></i> Product Report
            </div>
            <!-- /panel-heading -->
            <div class="panel-body">

                <form class="form-horizontal" action="php_action/getOrderProdReport.php" method="post"
                    id="getOrderReportForm">
                    <div class="form-group">
                        <label for="prodName" class="col-sm-2 control-label">Product</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="prodName" name="prodName" placeholder="Product">
                                <?php $sql = "SELECT DISTINCT product_name FROM product";
                                $query = $connect->query($sql);
                                echo "<option>~Select~</option>";
                                while ($result = $query->fetch_assoc()) {
                                    echo "<option>".$result['product_name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startDate" class="col-sm-2 control-label">Start Date</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="startDate" name="startDate"
                                placeholder="Start Date" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="endDate" class="col-sm-2 control-label">End Date</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date"
                                value="<?php echo date("m/d/Y"); ?>" readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="generateReportBtn"> <i
                                    class="glyphicon glyphicon-ok-sign"></i> Generate Report</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /panel-body -->
        </div>
    </div>
    <!-- /col-dm-12 -->
</div>
<!-- /row -->

<script src="custom/js/prodReport.js"></script>

<?php } else {
    header("Location: dashboard.php");
}?>

<?php require_once 'includes/footer.php'; ?>