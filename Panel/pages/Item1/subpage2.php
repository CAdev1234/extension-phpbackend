<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: index.php");
	exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/datatables.css">
	<link rel="stylesheet" href="../../assets/css/style.css">

	<!-- script -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>
	<!-- menu -->
	
	<div class="nav-side-menu">
		<div class="brand"><a href='' >Dashboard</a></div>
		<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
			<div class="menu-list">
				<ul id="menu-content" class="menu-content collapse out">
					<li class="mb-1">
					  <a id="dashboard"  href="/pages/dashboard.php"><i class="fab fa-chrome sidebar-icon"></i> Dashboard</a>
					</li>
					
					<li data-toggle="collapse" data-target="#ajuda" class="collapsed mb-1">
						<a href="#" >
							<i class="fa fa-life-ring sidebar-icon"></i> Items 
							<span class="arrow ml-auto"><i class="fa fa-angle-down"></i></span>
						</a>
					</li>
					<ul class="sub-menu collapse" id="ajuda">
						<li><a id="subpage1" href="statistic.php" >Statistic</a></li>
						<li><a id="subpage2" href="" >Item2</a></li>
					</ul>
				</ul>
		 </div>
	</div>
	<div class="main">
		
	</div>
	
</body>
</html>