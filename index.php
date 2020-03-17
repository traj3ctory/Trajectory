<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
    header('location: http://localhost/traj3ctory/dashboard.php');

    // check fir timeout
    echo $_SESSION['timeout'];

}


$errors = array();

if($_POST) {		

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Username is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} else {
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			$password = md5($password);
			// exists
			$mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
			$mainResult = $connect->query($mainSql);

			if($mainResult->num_rows == 1) {
				$value = $mainResult->fetch_assoc();
				$user_id = $value['user_id'];

				// set session
                $_SESSION['userId'] = $user_id;
                if ($user_id == 1) {
                    $_SESSION['role'] = "ADMIN";
                } else {
                    $_SESSION['role'] = "USER";
                }

                // set the timeout
                $_SESSION['timeout'] = time();

				header('location: http://localhost/traj3ctory/dashboard.php');	
			} else{
				
				$errors[] = "Incorrect username/password combination";
			} // /else
		} else {		
			$errors[] = "Oh! snaps, Invalid username";		
		} // /else
	} // /else not empty username || password
	
} // /if $_POST
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Traj3ctory IMS</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
    <!-- bootstrap theme-->
    <link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">
    <!-- jquery -->
    <script src="assests/jquery/jquery.min.js"></script>
    <!-- jquery ui -->
    <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
    <script src="assests/jquery-ui/jquery-ui.min.js"></script>

    <!-- bootstrap js -->
    <script src="assests/bootstrap/js/bootstrap.min.js"></script>

    <!-- DEVELOPERS DEFINED CSS -->
    <link rel="stylesheet" href="custom/css/custom.css">
</head>



<body style="background-color: rgba(241, 235, 235, 0.712)">

    <div class="container">
        <div class="row text-center">
            <div class="col-sm-5 col-sm-offset-4">
                <div class="panel panel-primary illusion" style="margin:40% auto">
                    <div class="panel-heading">
                        <h2 class="panel-header">Sign in</h2>
                    </div>
                    <div class="panel-body">

                        <div class="messages">
                            <?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-danger" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
                        </div>

                        <!-- LOGIN DETAIL -->

                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"
                            id="loginForm">
                            <fieldset>
                                <!-- USERNAME -->
                                <div class="input-group input-group-lg mt-4">
                                    <span class="input-group-addon" id="UN"><i
                                            class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Username" aria-describedby="UN" autocomplete="on" autofocus />
                                </div>

                                <!-- PASSWORD -->
                                <div class="input-group input-group-lg my-5">
                                    <span class="input-group-addon" id="pwd"><i
                                            class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" aria-describedby="UN" autocomplete="off" />
                                </div>

                                <!-- BUTTON -->
                                <div class="form-group">
                                    <div class="col-sm-offset-1 col-sm-10">
                                        <button type="submit" class="btn btn-primary"> <i
                                                class="glyphicon glyphicon-log-in"></i> Sign in</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                        <!-- /LOGIN DETAIL -->
                    </div>
                    <!-- panel-body -->
                </div>
                <!-- /panel -->
            </div>
            <!-- /col-md-4 -->
        </div>
        <!-- /row -->
    </div>
    <!-- container -->

</body>

</html>