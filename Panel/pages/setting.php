<?php
require "../config.php";
require "../module/dbconnection.php";
require "../module/fetch_client_data.php";
require "../module/fetch_user_data.php";
require "../module/fetch_setting.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
// echo($_SESSION["loggedin"]);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: ../index.php");
	exit;
}
$loggedin_user = fetch_user_data($db_connec, $_SESSION['id']);
$setting = fetch_setting($db_connec);
$setting = $setting[0];
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="../assets/css/fontawesome_all.css">
	<script src="../assets/js/jquery-3.5.1.js"></script>
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	

	<style>
	#chartdiv {
		width: 100%;
		height: 500px;
		overflow: hidden;
	}
	</style>

</head>
<body>
	<!-- menu -->
	<div id="server_root_path" style="display: none;"><?= $ROOT_DIR_PATH ?></div>
	
	<div class="nav-side-menu">
		<div class="brand"><a href='' >Dashboard</a></div>
		<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
			<div class="menu-list">
				<ul id="menu-content" class="menu-content collapse out">
					<li class="mb-1">
						<a id="dashboard" href="<?=$ROOT_DIR_PATH?>/pages/dashboard.php">
							<i class="fab fa-chrome sidebar-icon"></i> 
							<span class="">Dashboard</span>
						</a>
					</li>
					
					<li data-toggle="collapse" data-target="#ajuda" class="collapsed mb-1">
						<a href="<?=$ROOT_DIR_PATH?>/pages/statistic.php">
							<i class="fa fa-life-ring sidebar-icon"></i>  
							<span class="">Statistic</span>
						</a>
					</li>

					<li data-toggle="collapse" data-target="#ajuda" class="collapsed mb-1">
						<a href="<?=$ROOT_DIR_PATH?>/pages/setting.php">
                            <i class="fas fa-cog sidebar-icon"></i>  
							<span class="">Setting</span>
						</a>
					</li>
				</ul>
		 </div>
	</div>
	<div class="main">
		<div class="header">
			<i class="fas fa-user-circle" style="font-size: 30px;color:white;margin-left:auto"></i>
			<a class="logout-btn" href="/api/auth/signout.php"><?=$loggedin_user['username']?></a>
		</div>
		<div class="page-body">
			<div class="success_alert alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
				<strong>Submit Success!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="closeSuccessAlert()">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="form-group">
				<label for="time_interval">Time Interval</label>
				<input type="number" name="time_interval" class="form-control" id="time_interval" placeholder="Enter time(ms)" value="<?php if(isset($setting['time_interval'])) echo($setting['time_interval'])?>">
			</div>
			<button type="button" class="btn btn-primary" onclick="submitSetting()">Submit</button>
		</div>
	</div>
	
	
	<script type="text/javascript">
		$(document).ready(() => {
		})
		function closeSuccessAlert() {
			$('.success_alert').css('cssText', 'display: none');
		}
		function submitSetting() {
			var time_interval = Number(document.querySelector('#time_interval').value)
			if (time_interval === 0) {
				window.alert('Please fill inputs correctly.')
				return
			}
			var formData = new FormData()
			formData.append('time_interval', time_interval)
			var server_root_path = document.querySelector('#server_root_path').innerText
			$.ajax({
				type: "post",
				url: `${server_root_path}/api/setting.php`,
				data: formData,
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				success: function (res) {
					if(res.message = "success") {
						$('.success_alert').css('cssText', 'display: block')
					}
				}
			});
		}
	</script>

</body>
</html>