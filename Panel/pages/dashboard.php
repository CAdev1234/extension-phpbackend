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
$clients = $db_connec->getAllQuery('client_tb');
$clients_data = fetch_clients_data($db_connec);

$new_clients = fetch_new_clients($db_connec);

$clients_top_country = fetch_clients_top_country($db_connec);
$clients_top_country_perc = 0;
for ($index = 0; $index < count($clients_top_country); $index++) { 
	$clients_top_country_perc = $clients_top_country_perc + $clients_top_country[$index]['count'];
	if ($index > 2) break;
}
if (count($clients_data) != 0) {
	$clients_top_country_perc = round(($clients_top_country_perc / count($clients_data) * 100), 0);
}else {
	$clients_top_country_perc = 0;
}

$setting = fetch_setting($db_connec);
if(count($setting) === 0) {
	header("location: ./setting.php");
	exit;
}else {
	$setting = json_encode($setting[0]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../assets/css/fontawesome_all.css">
	<link rel="stylesheet" href="../assets/css/style.css">

	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">
	

	<!-- script -->
	<!-- <script src="../assets/js/popper.min.js"></script> -->

	<!-- Amchart Resources -->
	<script src="../assets/js/amchart/core.js"></script>
	<script src="../assets/js/amchart/maps.js"></script>
	<script src="../assets/js/amchart/worldLow.js"></script>
	<script src="../assets/js/amchart/animated.js"></script>

	<script src="../assets/js/country.js"></script>

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
	<div id="setting" style="display: none;"><?= $setting ?></div>
	<div class="nav-side-menu">
		<div class="brand"><a href='' >Dashboard</a></div>
		<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
			<div class="menu-list">
				<ul id="menu-content" class="menu-content collapse out">
					<li class="mb-1">
						<a id="dashboard" href="dashboard.php">
							<i class="fab fa-chrome sidebar-icon"></i> Dashboard
						</a>
					</li>
					
					<li data-toggle="collapse" data-target="#ajuda" class="collapsed mb-1">
						<a href="<?=$ROOT_DIR_PATH?>/pages/statistic.php">
							<i class="fa fa-life-ring sidebar-icon"></i> Statistic 
						</a>
					</li>

					<li data-toggle="collapse" data-target="#ajuda" class="collapsed mb-1">
						<a href="<?=$ROOT_DIR_PATH?>/pages/setting.php">
							<i class="fa fa-life-ring sidebar-icon"></i> Setting 
						</a>
					</li>
				</ul>
		 </div>
	</div>
	<div class="main">
		<div class="header">
			<i class="fas fa-user-circle" style="font-size: 30px;color:white;margin-left:auto"></i>
			<a class="logout-btn" href="<?=$ROOT_DIR_PATH?>/api/auth/signout.php"><?=$loggedin_user['username']?></a>
		</div>
		<div class="page-body">
			<div class="state-overview">
				<div class="row">
					<div class="col-xl-3 col-md-3 col-lg-3 col-12">
						<div class="info-box bg-b-green">
							<span class="info-box-icon"><i class="fas fa-users"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Total Users</span>
								<span class="info-box-number"><?php echo(count($clients))?></span>
								<div class="progress">
									<div class="progress-bar" style="width: <?php if (count($clients) === 0) {
											echo("0%");
										}else {
											echo("100%");
										} ?>"></div>
								</div>
								<span class="progress-description">
									<?php
										if (count($clients) === 0) {
											echo("0%");
										}else {
											echo("100%");
										}
									?>
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
					</div>
					<!-- /.col -->
					<div class="col-xl-3 col-md-3 col-12">
						<div class="info-box bg-b-yellow">
							<span class="info-box-icon"><i class="fas fa-user-plus"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">New Users (In 24h)</span>
								<span class="info-box-number"><?= count($new_clients)?></span>
								<div class="progress">
									<div class="progress-bar" style="width: <?=count($new_clients) / count($clients) * 100?>%"></div>
								</div>
								<span class="progress-description">
								<?php if(count($clients) !== 0) {
									echo(round(count($new_clients) / count($clients) * 100, 2));
									}else {
										echo(0);
									}
								?>%
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-xl-3 col-md-3 col-12">
						<div class="info-box bg-b-blue">
							<span class="info-box-icon"><i class="fas fa-globe"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Online Users</span>
								<span class="info-box-number"></span>
								<div class="progress">
									<div class="progress-bar"></div>
								</div>
								<span class="progress-description"></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-xl-3 col-md-3 col-12">
						<div class="info-box bg-b-pink">
							<span class="info-box-icon"><i class="fas fa-user-friends"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">By Top 3 Countries</span>
								<div style="display: grid;grid-template-columns: auto auto;">
								<?php 
									if (count($clients_top_country) === 0) {
										echo('<span class="info-box-number" style="margin-right: 10px;">' . 0 . '</span>');
									}else {
										for ($index = 0; $index < count($clients_top_country); $index++) {
											if($index > 2) break; 
											echo('<span class="info-box-number" style="margin-right: 10px;">' . $clients_top_country[$index]['country'] . ": " . round(intval($clients_top_country[$index]['count']) / count($clients) * 100, 0) . '%</span>');		
										}
									}
								?>
								</div>
								
								<!-- <div class="progress">
								<div class="progress-bar" style="width: <?= $clients_top_country_perc ?>%"></div>
								</div>
								<span class="progress-description"><?= $clients_top_country_perc ?>%</span> -->
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
				</div>
			</div>
			<div id="wrap">
				<div style="display: flex;align-items:center;margin-bottom: 10px;margin-top:20px">
					<h2 style="margin:0px;">User Status</h2>
					<div style="margin-left: auto;">
						<button class="delete_all" onclick="deleteAll()">Delete All</button>
					</div>
				</div>
				<div class="client_data_table"></div>
			</div>
			<div style="background: white;padding-inline: 30px;padding-block: 10px;border-radius: 10px;margin-top:30px;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
				<h2>User Position</h2>
				<div id="chartdiv"></div>
			</div>

			<div id="img_modal"
				style="display:none; z-index: 50; position:fixed;top:0px;left:0px;width:100vw;height:100vh;background-color:black;justify-items:center;align-items:center"
				onclick="closeImgModal()">
				<img style="height: 80vh;margin-left:auto;margin-right:auto;">
			</div>
		</div>
	</div>
	
	<script src="../assets/js/jquery-3.5.1.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(() => {
			
			showClientDataTable()
			showMap()
			updateOnlineStatus()
			var setting = document.querySelector('#setting').innerText
			setting = JSON.parse(setting)
			setInterval(() => {
				updateOnlineStatus()
			}, Number(setting.time_interval));
		})

		function showImgModal(ev) {
			document.querySelector('#img_modal img').src = ev.target.currentSrc
			document.querySelector('#img_modal').style.display = "flex"
		}
		function closeImgModal() {
			document.querySelector('#img_modal').style.display = "none"
		}
		function showClientDataTable() {
			var server_root_path = document.querySelector('#server_root_path').innerText
			$.ajax({
				type: "post",
				url: `${server_root_path}/api/client_data.php`,
				success: function (response) {
					var current_timestamp = response.data.current_timestamp
					current_timestamp = new Date(current_timestamp).getTime() - 5000
					var table_data = response.data.client_data
					var clients = response.data.clients
					var table_html = `
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th>Id</th>
									<th>Ip Address</th>
									<th>Country</th>
									<th>Last Connect</th>
									<th>Current Website</th>
									<th>Time Spending</th>
									<th>Screenshot</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>`
						for (let index = 0; index < table_data.length; index++) {
							table_html = table_html + `
							<tr class="gradeX">
								<td>${table_data[index].id}</td>
								<td>${table_data[index].ip_address}</td>
								<td>${getCountryName(table_data[index].country)}</td>
								<td>${table_data[index].last_connect}</td>
								<td>${table_data[index].current_website}</td>
								<td>${table_data[index].time_spending}</td>
								<td>
									<div style="display: flex;">
										<img src="${table_data[index].screenshot}" 
											alt="" 
											style="max-width: 100px;cursor:pointer;margin-left:auto;margin-right:auto;">
									</div>
								</td>
								<td>
							`
							
							var client = clients.filter(item => item.identity === table_data[index].user_identity)
							if (client.length !== 0) {
								if (new Date(client[0].last_activity).getTime() > current_timestamp) {
									table_html = table_html + `
											<div identity=${table_data[index].user_identity} style="padding: 5px 7px;background: #26A69A;border-radius: 20px;color: white;text-align: center;">Online</div>
									`
								}else {
									table_html = table_html + `
											<div identity=${table_data[index].user_identity} style="padding: 5px 7px;background: #D81B60;border-radius: 20px;color: white;text-align: center;">Offline</div>
									`
								}
								table_html = table_html + `</td></tr>`
							}
						}
					table_html = table_html + `</tbody></table>`
					table_html = $.parseHTML(table_html)
					$('.client_data_table').append(table_html);

					var client_data_table = $('#example').DataTable({
						"searching": true,
						"paging": true,
						"order": [[3, "asc"]],
						"ordering": true,
						"columnDefs": [{
							"targets": [6, 7],
							"orderable": false
						}]
					});
					
					var screenshots = document.querySelectorAll('#example img')
					for (let index = 0; index < screenshots.length; index++) {
						screenshots[index].addEventListener('click', event => {
							showImgModal(event)
						})
					}
					
				}
			});
		}

		function deleteAll() {
			var server_root_path = document.querySelector('#server_root_path').innerText
			$.ajax({
				type: "post",
				url: `${server_root_path}/api/del_all_client_data.php`,
				success: function (res) {
					if (res.message === "delete success") {
						window.location.reload()
					}
				}
			})
		}

		// Chart code
		function showMap() {
			am4core.ready(() => {

				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create map instance
				var chart = am4core.create("chartdiv", am4maps.MapChart);

				// Set map definition
				chart.geodata = am4geodata_worldLow;

				// Set projection
				chart.projection = new am4maps.projections.Miller();

				// Create map polygon series
				var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

				// Exclude Antartica
				polygonSeries.exclude = ["AQ"];

				// Make map load polygon (like country names) data from GeoJSON
				polygonSeries.useGeodata = true;

				// Configure series
				var polygonTemplate = polygonSeries.mapPolygons.template;
				// polygonTemplate.tooltipText = "{name}";
				polygonTemplate.polygon.fillOpacity = 1;

				// Create hover state and set alternative fill color
				var hs = polygonTemplate.states.create("hover");
				// hs.properties.fill = chart.colors.getIndex(50);
				hs.properties.fill = am4core.color('#6037f5');


				// Add image series
				var imageSeries = chart.series.push(new am4maps.MapImageSeries());
				imageSeries.mapImages.template.propertyFields.longitude = "longitude";
				imageSeries.mapImages.template.propertyFields.latitude = "latitude";
				
				imageSeries.mapImages.template.tooltipText = "{title}";
				imageSeries.mapImages.template.propertyFields.url = "url";

				var circle = imageSeries.mapImages.template.createChild(am4core.Circle);
				circle.radius = 4;
				circle.propertyFields.fill = "color";
				circle.nonScaling = true;

				var circle2 = imageSeries.mapImages.template.createChild(am4core.Circle);
				circle2.radius = 5;
				circle2.propertyFields.fill = "color";


				circle2.events.on("inited", function(event){
					animateBullet(event.target);
				})


				function animateBullet(circle) {
					var animation = circle.animate([{ property: "scale", from: 1 / chart.zoomLevel, to: 5 / chart.zoomLevel }, { property: "opacity", from: 1, to: 0 }], 1000, am4core.ease.circleOut);
					animation.events.on("animationended", function(event){
						animateBullet(event.target.object);
					})
				}

				var colorSet = new am4core.ColorSet();

				var server_root_path = document.querySelector('#server_root_path').innerText
				$.ajax({
					type: "post",
					url: `${server_root_path}/api/client_data.php`,
					success: (response) => {
						var clients = response.data.clients
						var clients_per_country = response.data.clients_per_country
						var current_timestamp = new Date(response.data.current_timestamp).getTime() - 5000
						var array_var = []
						for (let index = 0; index < clients.length; index++) {
							var num_clients = clients_per_country.filter(item => item.country === clients[index].country)
							
							var obj_var = {
								title: `${num_clients[0].country}: ${num_clients[0]['count(id)']}`,
								latitude: Number(clients[index].latitude),
								longitude: Number(clients[index].longitude),
								// "color":colorSet.next()
							}
							if (new Date(clients[index].last_activity).getTime() > current_timestamp) {
								obj_var.color = colorSet.next()
							}
							array_var.push(obj_var)
						}
						imageSeries.data = array_var
					}
				});
				var setting = document.querySelector('#setting').innerText
				setting = JSON.parse(setting)
				setInterval(() => {
					var server_root_path = document.querySelector('#server_root_path').innerText
					$.ajax({
						type: "post",
						url: `${server_root_path}/api/client_data.php`,
						success: (response) => {
							var clients = response.data.clients
							var clients_per_country = response.data.clients_per_country
							var current_timestamp = new Date(response.data.current_timestamp).getTime() - 5000
							var array_var = []
							for (let index = 0; index < clients.length; index++) {
								var num_clients = clients_per_country.filter(item => item.country === clients[index].country)
								
								var obj_var = {
									title: `${num_clients[0].country}: ${num_clients[0]['count(id)']}`,
									latitude: Number(clients[index].latitude),
									longitude: Number(clients[index].longitude),
									// "color":colorSet.next()
								}
								if (new Date(clients[index].last_activity).getTime() > current_timestamp) {
									obj_var.color = colorSet.next()
								}
								array_var.push(obj_var)
							}
							imageSeries.data = array_var
						}
					});
				}, Number(setting.time_interval));
			}); // end am4core.ready()
		}

		function updateOnlineStatus() {
			var server_root_path = document.querySelector('#server_root_path').innerText
			$.ajax({
				type: "post",
				url: `${server_root_path}/api/client_data.php`,
				success: function (res) {
					var current_timestamp = new Date(res.data.current_timestamp).getTime() - 10000
					var clients = res.data.clients
					var client_data = res.data.client_data
					var table_data = res.data.client_data
					var count_online_client = 0
					if (clients.length !== 0) {
						console.log(new Date(clients[0].last_activity).getTime(), current_timestamp, new Date(clients[0].last_activity).getTime() - current_timestamp)
						for (let index = 0; index < clients.length; index++) {
							var status_ele = document.querySelector(`#example > tbody > tr:nth-child(${index + 1}) > td:nth-child(8) > div`)
							if (new Date(clients[index].last_activity).getTime() > current_timestamp) {
								// online client
								if (status_ele !== null) status_ele.style.backgroundColor = '#26A69A'
								if (status_ele !== null) status_ele.innerText = 'online'
								count_online_client = count_online_client + 1
							}else {
								// offline client
								if (status_ele !== null) status_ele.style.backgroundColor = '#D81B60'
								if (status_ele !== null) status_ele.innerText = 'offline'
							}
						}
					}
					
					document.querySelector('body > div.main > div.page-body > div.state-overview > div > div:nth-child(3) > div > div > span.info-box-number').innerText = count_online_client
					document.querySelector('body > div.main > div.page-body > div.state-overview > div > div:nth-child(3) > div > div > div > div.progress-bar').style.width = String(Math.round(count_online_client / clients.length * 100)) + "%"
					document.querySelector('body > div.main > div > div.state-overview > div > div:nth-child(3) > div > div > span.progress-description').innerText = clients.length === 0 ? "0%" : String(Math.round(count_online_client / clients.length * 100)) + "%"
				}
			});
		}
	</script>

</body>
</html>