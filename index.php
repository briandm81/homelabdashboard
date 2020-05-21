<?php
require_once('environment.php');

$sitesettings = spawnSettings();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Homelab Rat Dashboard</title>

  <!-- Custom fonts for this template-->
  <?php
	if (!$sitesettings[0]->siteIcon=="")
	{
  ?>
  <link rel="icon" type="image/png" href="<?php echo $sitesettings[0]->siteIcon; ?>" sizes="any" />
  <?php
	}
  ?>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom Homelab Rat styles-->
  <link href="css/hlr.css" rel="stylesheet">
  <link href="vendor/tabulator/css/semantic-ui/tabulator_semantic-ui.min.css" rel="stylesheet">

</head>

<body id="page-top" onload="startTime()">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="<?php echo $sitesettings[0]->siteImage; ?>" style="width:30px;height:16px;">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $sitesettings[0]->siteTitle; ?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="javascript:void(0);" id="btnDashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">


<?php

	$bookmarks = spawnBookmarks();

	$collapsed = false;

	//$bms = spawnBookmarks();
	foreach($bookmarks as $bm)
    {
		if($collapsed) {
			if(!$bm->isCollapseHeader and !$bm->isCollapseItem)
			{
				$collapsed = false;
			?>
									  </div>
					</div>
				</li>
			<?php
		}
			}
		
		if ($bm->isDivider)
        { 
			$collapsed = false;
			?>
				<hr class="sidebar-divider">
			<?php
		}
		elseif ($bm->isHeading)
        { 
			$collapsed = false;
			?>
				<div class="sidebar-heading">
					<?php echo $bm->name ?>
				</div>
			<?php
		}
		elseif ($bm->isCollapseHeader)
		{
			$collapsed = true;
			?>
			<h6 class="collapse-header"><?php echo $bm->name ?>:</h6>
			<?php
		}
		elseif ($bm->isCollapsed)
		{
			$collapsed = true;
			?>
				<li class="nav-item">
					<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?php echo $bm->name ?>" aria-expanded="true" aria-controls="<?php echo $bm->name ?>">
					<?php
					if (!$bm->image=="")
					{
					?>
					  <img src="<?php echo $bm->image ?>" style="width:25px;height:25px;">
					<?php
					}
					else
					{
						if (!$bm->icon=="")
						{
						?>
						  <i class="fas fa-fw <?php echo $bm->icon ?>"></i>
						<?php
						}
					?>
					<?php
					}
					?>
					  <span><?php echo $bm->name ?></span>
					</a>
					<div id="<?php echo $bm->name ?>" class="collapse" aria-labelledby="<?php echo $bm->name ?>" data-parent="#accordionSidebar">
					  <div class="bg-white py-2 collapse-inner rounded">
						
						
			<?php
		}
		elseif ($bm->isCollapseItem)
		{
			$collapsed = true;
			?>
				<a class="collapse-item" target="_blank" href="<?php echo $bm->url ?>" id="btn<?php echo $bm->name ?>"><?php echo $bm->name ?></a>
			<?php
		}
		else
		{
			$collapsed = false;
			if (!$bm->isIframe)
			{ 
			?>
				<li class="nav-item active">
					<a class="nav-link" target="_blank" href="<?php echo $bm->url ?>" id="btn<?php echo $bm->name ?>">
					  <?php
					if (!$bm->image=="")
					{
					?>
					  <img src="<?php echo $bm->image ?>" style="width:25px;height:25px;">
					<?php
					}
					else
					{
						if (!$bm->icon=="")
						{
						?>
						  <i class="fas fa-fw <?php echo $bm->icon ?>"></i>
						<?php
						}
					?>
					<?php
					}
					?>
					  <span><?php echo $bm->name ?></span></a>
				</li>
			<?php
			}
			else
			{
			?>
			
				<li class="nav-item active">
					<a class="nav-link" href="javascript:void(0);" id="btn<?php echo $bm->name ?>">
					  <?php
					if (!$bm->image=="")
					{
					?>
					  <img src="<?php echo $bm->image ?>" style="width:25px;height:25px;">
					<?php
					}
					else
					{
						if (!$bm->icon=="")
						{
						?>
						  <i class="fas fa-fw <?php echo $bm->icon ?>"></i>
						<?php
						}
					?>
					<?php
					}
					?>
					  <span><?php echo $bm->name ?></span></a>
				</li>
			<?php
			}
		}
	}
	if($collapsed) {
			$collapsed = false;
			?>
						</div>
					</div>
				</li>
			<?php
		}
?>


      
      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="javascript:void(0);" id="btnSettings">
          <i class="fas fa-fw fa-cog"></i>
          <span>Settings</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
		<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
		<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
			<?php
				if ($sitesettings[0]->weatherEnabled == "Enabled")
				{
			?>
			<button type="button" class="btn btn-primary my-2 my-sm-0" id="headertitle">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</button>
			<?php
				}
			?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
    <button type="button" class="btn btn-primary my-2 my-sm-0" id="headerclock">00:00:00</button>
  </div>
</nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
			<div id="dashboarddiv">
			<?php
				if ($sitesettings[0]->weatherEnabled == "Enabled")
				{
			?>
				<div class="row" id="weatherdiv">
					<div class="col-lg-6">
						<!-- Collapsable Card Example -->
						<div class="card shadow mb-4">
							<!-- Card Header - Accordion -->
							<a href="#collapseWeatherCurrent" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseWeatherCurrent">
								<h6 class="m-0 font-weight-bold text-primary">Current Weather</h6>
							</a>
							<!-- Card Content - Collapse -->
							<div class="collapse show" id="collapseWeatherCurrent">
								<div class="card-body" id="currentweathercontent">
									<div class="spinner-border" role="status">
									  <span class="sr-only">Loading...</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<!-- Collapsable Card Example -->
						<div class="card shadow mb-4">
							<!-- Card Header - Accordion -->
							<a href="#collapseWeatherForecast" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseWeatherForecast">
								<h6 class="m-0 font-weight-bold text-primary"><?php echo $sitesettings[0]->daysForecast; ?> Forecast</h6>
							</a>
							<!-- Card Content - Collapse -->
							<div class="collapse show" id="collapseWeatherForecast">
								<div class="card-body" id="weatherforecastcontent">
									<div class="spinner-border" role="status">
									  <span class="sr-only">Loading...</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>
				<div class="row">
					<div class="col-lg">
						<!-- Collapsable Card Example -->
						<div class="card shadow mb-4">
							<!-- Card Header - Accordion -->
							<a href="#collapseDashboard" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseDashboard">
								<h6 class="m-0 font-weight-bold text-primary">Service Status</h6>
							</a>
							<!-- Card Content - Collapse -->
							<div class="collapse show" id="collapseDashboard">
								<div class="card-body">
									<iframe allowfullscreen="true" frameborder="0" id="frame-Dashboard" style="height:270px" sandbox="allow-presentation allow-forms allow-same-origin allow-pointer-lock allow-scripts allow-popups allow-modals allow-top-navigation" scrolling="auto" src="<?php echo $sitesettings[0]->iframeURL; ?>" class="iframe"></iframe>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="framediv">
				<div class="col-lg">
					<div class="card shadow mb-4">
						<div class="card-header py-3">
						  <h6 class="m-0 font-weight-bold text-primary" id="frame-Header">iFrame</h6>
						</div>
						<div class="card-body" id="mainpagebody">
							<iframe allowfullscreen="true" frameborder="0" id="frame-Content" sandbox="allow-presentation allow-forms allow-same-origin allow-pointer-lock allow-scripts allow-popups allow-modals allow-top-navigation" scrolling="auto" class="iframe"></iframe>
						</div>
					</div>
				</div>
			</div>
			<div id="settingsdiv">
				<div class="row">
					<div class="col-lg">
						<div class="card shadow mb-4">
							<div class="card-header py-3">
							  <h6 class="m-0 font-weight-bold text-primary" id="frame-Header">General Settings</h6>
							</div>
							<div class="card-body" id="settingsgeneralbody">
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg">
						<div class="card shadow mb-4">
							<div class="card-header py-3">
							  <h6 class="m-0 font-weight-bold text-primary" id="frame-Header">Sidebar Settings</h6>
							</div>
							<div class="card-body" id="settingsbody">
								
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Homelab Rat Dashboard</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script type="text/javascript" src="vendor/tabulator/js/tabulator.min.js"></script>
  
  <script>
	function startTime() {
	  var today = new Date();
	  var h = today.getHours();
	  var m = today.getMinutes();
	  var s = today.getSeconds();
	  m = checkTime(m);
	  s = checkTime(s);
	  <?php
		if ($sitesettings[0]->timeFormat=="12 Hour")
		{
		?>
			if (h > 12) {
				document.getElementById('headerclock').innerHTML = h-12 + ":" + m + ":" + s + " PM";
			}
			else {
				document.getElementById('headerclock').innerHTML = h + ":" + m + ":" + s + " AM";
			}
		<?php
		}
		else
		{
		?>
			document.getElementById('headerclock').innerHTML = h + ":" + m + ":" + s;
		<?php
		}
	  ?>
	  var t = setTimeout(startTime, 500);
	}
	
	function checkTime(i) {
	  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	  return i;
	}
	var pageToLoad;
	var pageTitle;

	function navigation() {
		$.ajax({
			url : pageToLoad,
			data:{},
			success: function(data){
				$('#mainpagebody').html(data);
				$('#mainpagetitle').text(pageTitle);
			}
		});
	}

		
	$(document).ready(function(){
	
	
		<?php
				if ($sitesettings[0]->weatherEnabled == "Enabled")
				{
		?>
	
		$.ajax({
			url : 'weathercurrent.php',
			type: "get",
			data:{location:<?php echo $sitesettings[0]->zipCode; ?>},
			success: function(data){
				$('#currentweathercontent').html(data);
			}
		});
		
		$.ajax({
			url : 'weatherforecast.php',
			type: "get",
			data:{location:<?php echo $sitesettings[0]->zipCode; ?>, daysForecast:'<?php echo $sitesettings[0]->daysForecast; ?>'},
			success: function(data){
				$('#weatherforecastcontent').html(data);
			}
		});
		
		$.ajax({
			url : 'weatherheader.php',
			type: "get",
			data:{location:<?php echo $sitesettings[0]->zipCode; ?>},
			success: function(data){
				$('#headertitle').html(data);
			}
		});
		
		<?php
				}
		?>
	
		$("#framediv").hide();
		$("#settingsdiv").hide();
		
	<?php
		foreach($bookmarks as $bm)
		{
			if ($bm->isIframe)
			{ 
			?>
		$("#btn<?php echo $bm->name ?>").click(function() {
			$("#frame-Header").text("<?php echo $bm->name ?>");
			$("#settingsdiv").hide();
			$("#framediv").show();
			$("#dashboarddiv").hide();
			$("#frame-Content").attr("src", "<?php echo $bm->url ?>");
		})
			<?php
			}
		}
	?>
						
		$("#btnDashboard").click(function() {
			$("#settingsdiv").hide();
			$("#framediv").hide();
			$("#settingsdiv").hide();
			$("#dashboarddiv").show();
		})
		$("#btnSettings").click(function() {
			//$("#headertitle").text("Dashboard");
			$("#framediv").hide();
			$("#settingsdiv").show();
			$("#dashboarddiv").hide();
			
			$.ajax({
				url : 'settingsgeneral.php',
				data:{},
				success: function(data){
					$('#settingsgeneralbody').html(data);
				}
			});
			
			$.ajax({
				url : 'settingsbookmarks.php',
				data:{},
				success: function(data){
					$('#settingsbody').html(data);
				}
			});
			
		})
	});

	</script>
  

</body>

</html>
