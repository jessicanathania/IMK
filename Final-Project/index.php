<!DOCTYPE html>
<html lang="en">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartfarm";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM moisture ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agricultural Monitoring System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">18212028 | 18213019-021-045</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#status">Status Tanah</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#log">Log Tanah</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#kelembapan">Data Kelembapan</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome To Our Project!</div>
                <div class="intro-heading">Agricultural Monitoring System</div>
                <a href="#status" class="page-scroll btn btn-xl">Check</a>
            </div>
        </div>
    </header>

    <!-- Status Tanah Section -->
    <section id="status" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Status Tanah</h2>
                    <h3 class="section-subheading text-muted"><?php while($row = mysqli_fetch_assoc($result)) {
									echo $row["DateTime"];
									$moist = $row["moist"];
								}?></h3>
                </div>
				
            <div class="row text-center">
                <div class="col-md-12 text-center">
					<div class="timeline-image image-center">
                                <img src=<?php 
	
									if ( $moist >=50 ){
										echo "img/Lembab.png"; 
									} else{
										echo "img/Kering.png";
									}

							?> class="center-block" alt="" height="302" width="302" >
                    </div>

                    <h4 class="service-heading"><?php 

									if ( $moist >= 50){
										echo "Ladang Cukup Air";
									} else{
										echo "Ladang Kering";
									}

					?></h4>
                    <p class="text-muted"><?php 

									if ( $moist < 800){
										echo "";
									} else{
										echo "Irigasi sedang dilakukan";
									}

					?></p>
				</div>
            </div>
        </div>
    </section>

    <!-- Log Tanah Section -->
    <section id="log">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Log Tanah</h2>
                </div>
            </div>
        </div>
		
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<?php 
				function get_data() {
					$info = array();
					$con = mysqli_connect('localhost','root','', 'smartfarm');
					$result = mysqli_query($con, 'SELECT ID, DateTime, moist FROM moisture ORDER BY ID DESC LIMIT 20');
					$info = mysqli_fetch_all ($result, MYSQL_ASSOC);
					return $info;
				}
				echo "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
				<script type='text/javascript'>
				 google.charts.load('current', {packages: ['corechart', 'line']});
				 google.charts.setOnLoadCallback(drawLineColors);

				function drawLineColors() {

				  var data = new google.visualization.DataTable();
				  data.addColumn('string');
				  data.addColumn('number');
				  data.addColumn({type:'string',role:'tooltip'});
				  data.addRows([";
				$data = get_data();
				  for ($x = (count($data)-1); $x >= 0; $x--) {
					$datarow = $data[$x];
					echo "['".$datarow['ID']."',".$datarow['moist'].",'Time | ".$datarow['DateTime']."']";
					if ($x != 0) {
						echo",";
					}
					echo"\n";
				}
				 echo "]);

				  var options = {

					hAxis: {
					  title: 'Waktu'
					},
					vAxis: {
					  title: 'Persentase Kelembapan'
					},
				  };

				  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

				  chart.draw(data, options);
				  }
				</script>";
				?>		  
	<body>
			<div style="text-align:center" id="chart_div" style="width: 900px; height: 600px"></div>
		  </body>
    </section>

    <!-- Data Kelembapan Section -->
    <section id="kelembapan" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Data Kelembapan</h2>
                    <h3 class="section-subheading text-muted">Berikut data mendetail mengenai kelembapan sawah anda</h3>
					<?php
					$link = mysqli_connect("localhost", "root", "", "smartfarm");
						 
						// Check connection
						if($link === false){
							die("ERROR: Could not connect. " . mysqli_connect_error());
						}
						 
						// Attempt select query execution
						$sql = "SELECT * FROM moisture ORDER BY id DESC LIMIT 10";
						if($result = mysqli_query($link, $sql)){
							if(mysqli_num_rows($result) > 0){
								echo "<table class = table>";
									echo "<thead class=thead-inverse align=center>";
									echo "<tr>";
										echo "<th align=right>ID</th>";
										echo "<th>Waktu</th>";
										echo "<th>Kelembapan</th>";
									echo "</tr>";
								while($row = mysqli_fetch_array($result)){
									echo "<tr>";
										echo "<td>" . $row['ID'] . "</td>";
										echo "<td>" . $row['DateTime'] . "</td>";
										echo "<td>" . $row['moist'] . "</td>";
									echo "</tr>";
								}
								echo "</table>";
								// Close result set
								mysqli_free_result($result);
							} else{
								echo "No records matching your query were found.";
							}
						} else{
							echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
						}
						 
						// Close connection
						mysqli_close($link);
					?>
                </div>
            </div>
        </div>
    </section>
	


    <footer>
        <div class="container" >
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; IMKA 2016</span>
                </div>
            </div>
        </div>
    </footer>

   

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>

</html>
