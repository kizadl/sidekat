
<?php
error_reporting(0);
session_start();

if ($_SESSION['AKSES'] == "administrator") {
	$iduser = $_SESSION['IDOPERATOR'];
	$username = $_SESSION['USERNAME'];
	$nmoperator = $_SESSION['NMOPERATOR'];
	$akses = $_SESSION['AKSES'];
	$idinstansi = "1";
	$idinduk = "0";
} else {
	header('location:home.html');
}

require_once '../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "../services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tanggal = tgl_indo(date('Y-m-d'));
$tglserver = date('Y-m-d');

$editor = $iduser;

$qriserver = ("SELECT server_url FROM set_server WHERE id_server='1'");
$dbserver = mysqli_query($dbconn, $qriserver);
$s = mysqli_fetch_assoc($dbserver);
$urlserver = $s['server_url'];
mysqli_free_result($dbserver);

$qricbg = ("SELECT nm_instansi,kota FROM m_instansi WHERE id_instansi='" . $idinstansi . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$nmcabang = ucwords(strtolower($c['nm_instansi']));
$kotacabang = ucwords(strtolower($c['kota']));
$ketinduk = "Y";
mysqli_free_result($dbcabang);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="google" content="notranslate" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="google-site-verification" content="PRBTvS9zydGttLgDyEs4uLpqduLM02G7MC8BQWhO45A" />
	<link rel="icon" href="favicon.png">
	<title>IKM | <?php echo $nmcabang; ?></title>
	<link rel="stylesheet" href="ikm/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="ikm/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="ikm/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="ikm/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="ikm/plugins/toastr/toastr.min.css">
	<link rel="stylesheet" href="ikm/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="ikm/dist/css/style_layanan.css">
	<link rel="stylesheet" href="ikm/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm" style="-webkit-user-select:none;-moz-user-select:none;">
	<div class="wrapper">

		<div id="loading"></div>

		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">

				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="fas fa-ellipsis-v"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right p-0">
						
						<a href="../ikm/logout.html" class="dropdown-item">
							<i class="fas fa-sign-out-alt mr-2"></i>
							Log Out
						</a>
					</div>
				</li>
			</ul>
		</nav>

		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<a href="#" class="brand-link">
				<img src="ikm/dist/img/logo.png" class="brand-image img-circle elevation-3">
				<span class="brand-text">Indeks Kepuasan Masyarakat</span>
			</a>

			<div class="sidebar">
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">

						<li class="nav-item">
							<a href="#" class="nav-link active" id="lv_dashboard">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="#" class="nav-link" onclick="hidupkanGrafik();">
								<i class="fas fa-circle nav-icon text-primary" id="icografik"></i>
								<p>Mode Grafik Rekapitulasi</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link" onclick="hidupkanTabel();">
								<i class="far fa-circle nav-icon text-muted" id="icotabel"></i>
								<p>Mode Tabel Detail</p>
							</a>
						</li>

						<li class="nav-item has-treeview menu-open">
							<a href="#" class="nav-link">
								<p>
									Master Data
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="#" class="nav-link" id="lv_soal">
										<i class="fas fa-copy nav-icon text-maroon"></i>
										<p>Pengaturan Soal</p>
									</a>
								</li>
								<li class="nav-item" style="display:none">
									<a href="#" class="nav-link" id="lv_soal_standart">
										<i class="fas fa-copy nav-icon text-maroon"></i>
										<p>Soal Standart</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link" id="lv_pendidikan">
										<i class="fas fa-graduation-cap nav-icon text-info"></i>
										<p>Pendidikan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link" id="lv_pekerjaan">
										<i class="fas fa-address-card nav-icon text-info"></i>
										<p>Pekerjaan</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link" id="lv_unsur">
										<i class="fas fa-paste nav-icon text-teal"></i>
										<p>Unsur Penilaian</p>
									</a>
								</li>
							</ul>
						</li>

					</ul>
				</nav>
			</div>
		</aside>

		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">

				</div>
			</div>

			<div style="display:none">
				<input type="text" id="lblurlserver" value="<?php echo $urlserver; ?>" readonly="readonly" />
				<input type="text" id="lbltglserver" value="<?php echo $tglserver; ?>" readonly="readonly" />
				<input type="text" id="lblhalaman" value="" readonly="readonly" />
				<input type="text" id="lblidinstansi" value="<?php echo $idinstansi; ?>" readonly="readonly" />
				<input type="text" id="lblidinduk" value="<?php echo $idinduk; ?>" readonly="readonly" />
				<input type="text" id="lblketinduk" value="<?php echo $ketinduk; ?>" readonly="readonly" />
				<input type="text" id="lblnminstansi" value="<?php echo $nmcabang; ?>" readonly="readonly" />

				<input type="text" id="lbleditor" value="<?php echo $editor; ?>" readonly="readonly" />
				<input type="text" id="lblakses" value="<?php echo $akses; ?>" readonly="readonly" />

				<input type="text" id="lbltransidinstansi" value="" readonly="readonly" />
				<input type="text" id="lbltransidinduk" value="" readonly="readonly" />
				<input type="text" id="lbltransketerangan" value="" readonly="readonly" />
				<input type="text" id="lbltransnminstansi" value="" readonly="readonly" />
				<input type="text" id="lbltransmode" value="" readonly="readonly" />

				<input type="text" id="lbltransjmldata" value="0" readonly="readonly" />
			</div>

			<!-- Main content -->
			<div class="content">

				<?php
				include "dashboard.php";
				include "master.php";
				include "modal.php";
				?>

			</div>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

	</div>
	<!-- ./wrapper -->

	<script src="ikm/plugins/jquery/jquery.min.js"></script>
	<script src="ikm/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="ikm/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<script src="ikm/plugins/select2/js/select2.full.min.js"></script>
	<script src="ikm/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="ikm/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="ikm/dist/js/adminlte.min.js"></script>
	<script src="ikm/plugins/chart.js/Chart.min.js"></script>
	<script src="ikm/plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="ikm/plugins/toastr/toastr.min.js"></script>
	<script src="ikm/dist/js/dashboard.js"></script>
	<script src="ikm/dist/js/master8.js"></script>
	<script src="ikm/dist/js/laporan3.js"></script>

	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("body").tooltip({
				selector: '[data-toggle=tooltip]'
			});

			var tglserver = $("#lbltglserver").val();
			arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
			arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
			mydate = new Date(tglserver);

			tanggal = mydate.getDate();
			bulan = mydate.getMonth();
			tahun = mydate.getFullYear();

			$("#txttglawal").val(tahun + '-' + arrbulan[bulan] + '-' + arrtanggal[tanggal]);
			$("#txttglakhir").val(tahun + '-' + arrbulan[bulan] + '-' + arrtanggal[tanggal]);

			bersihkan();
			$("#lblhalaman").val("dashboard");
			$("#lbltransmode").val("grafik");
			var nminstansi = $("#lblnminstansi").val();

			$("#kopdashboardADMIN").html("Indeks Kepuasan Masyarakat - " + nminstansi);
			$("#area-dashboard-ikm-admin").fadeIn();
			hariiniIndo();
			isiDasboardAdm();
			isiGrafikDasboardAdm();
			isiTabelDashboardAdm();
		});

		function hariiniIndo() {

			$("#koptgldashboardADMIN").html("");
			$("#koptgldashboard1ADMIN").html("");
			$("#koptgldashboard2ADMIN").html("");
			$("#koptgldashboard3ADMIN").html("");
			$("#koptgldashboard4ADMIN").html("");

			var tglserver = $("#lbltglserver").val();
			arrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Januari"];
			mydate = new Date(tglserver);

			tanggal = mydate.getDate();
			bulan = mydate.getMonth();
			tahun = mydate.getFullYear();

			tglsekarangindo = tanggal + ' ' + arrbulan[bulan] + ' ' + tahun;

			$("#koptgldashboardADMIN").html(tglsekarangindo);
			$("#koptgldashboard1ADMIN").html(tglsekarangindo);
			$("#koptgldashboard2ADMIN").html(tglsekarangindo);
			$("#koptgldashboard3ADMIN").html(tglsekarangindo);
			$("#koptgldashboard4ADMIN").html(tglsekarangindo);
		}

		function periodeIndo() {
			$("#koplaporan").html("");
			arrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Januari"];
			arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];

			var tglawal = $("#txttglawal").val();
			dtawal = new Date(tglawal);
			tanggalawal = dtawal.getDate();
			bulanawal = dtawal.getMonth();
			tahunawal = dtawal.getFullYear();

			var tglakhir = $("#txttglakhir").val();
			dtakhir = new Date(tglakhir);
			tanggalakhir = dtakhir.getDate();
			bulanakhir = dtakhir.getMonth();
			tahunakhir = dtakhir.getFullYear();

			tglawalindo = arrtanggal[tanggalawal] + ' ' + arrbulan[bulanawal] + ' ' + tahunawal;
			tglakhirindo = arrtanggal[tanggalakhir] + ' ' + arrbulan[bulanakhir] + ' ' + tahunakhir;

			var akses = $("#lblakses").val();
			var halaman = $("#lblhalaman").val();
				var nminstansi = $("#lblnminstansi").val();
				$("#koplaporan").html("Indeks Kepuasan Masyarakat - " + nminstansi + "<br>" +
					"<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " + tglawalindo + " s/d " + tglakhirindo + "</small>");
		}

		function bersihkan() {
			$("#lblhalaman").val('');
			$("#lbltransidinstansi").val('');
			$("#lbltransidinduk").val('');
			$("#lbltransketerangan").val('');
			$("#lbltransnminstansi").val('');
			$("#lbltransjmldata").val(0);
			$("#area-dashboard-ikm-admin").css("display", "none");
			$("#area-laporan-ikm").css("display", "none");
			$("#area-soal").css("display", "none");
			$("#area-soal-standart").css("display", "none");
			$("#area-pendidikan").css("display", "none");
			$("#area-pekerjaan").css("display", "none");
			$("#area-unsur").css("display", "none");
			$("#area-laporan-tabel-ikm").css("display", "none");
			$("#area-laporan-grafik-ikm").css("display", "none");
		}

		$("#lv_dashboard").click(function() {
			bersihkan();
			$("#lblhalaman").val('dashboard');
			var nminstansi = $("#lblnminstansi").val();
			var modelaporan = $("#lbltransmode").val();
			if (modelaporan == "grafik") {
				$("#kopdashboard").html("Indeks Kepuasan Masyarakat - " + nminstansi);
				$("#area-dashboard-ikm-admin").fadeIn();
				hariiniIndo();
				isiDasboardAdm();
				isiGrafikDasboardAdm();
				isiTabelDashboardAdm();
			} else {
				$("#area-laporan-ikm").fadeIn();
				periodeIndo();
				isiLaporan();
				isiTabelLaporan();
			}
		});

		function hidupkanGrafik() {
			//bersihkan();
			document.getElementById("icografik").className = "fas fa-circle nav-icon text-primary";
			document.getElementById("icotabel").className = "far fa-circle nav-icon text-muted";
			$("#lbltransmode").val("grafik");

			$("#area-laporan-ikm").css("display", "none");
			var halaman = $("#lblhalaman").val();
			var akses = $("#lblakses").val();
			var nminstansi = $("#lblnminstansi").val();
			$("#kopdashboardADMIN").html("Indeks Kepuasan Masyarakat - " + nminstansi);
			$("#area-dashboard-ikm-admin").fadeIn();
			isiDasboardAdm();
			isiGrafikDasboardAdm();
			isiTabelDashboardAdm();
		}

		function hidupkanTabel() {
			//bersihkan();
			document.getElementById("icografik").className = "far fa-circle nav-icon text-muted";
			document.getElementById("icotabel").className = "fas fa-circle nav-icon text-primary";
			$("#lbltransmode").val("tabel");

			var halaman = $("#lblhalaman").val();
			var akses = $("#lblakses").val();
			$("#area-dashboard-ikm-admin").css("display", "none");
			$("#area-laporan-ikm").fadeIn();
			periodeIndo();
			isiLaporan();
			isiTabelLaporan();
		}

		///////////////////// MASTER DATA //////////////////////// 
		$("#lv_pendidikan").click(function() {
			bersihkan();
			$("#area-pendidikan").fadeIn();
			isiMasterPendidikan();
			$("#lblhalaman").val('pendidikan');
		});

		$("#lv_pekerjaan").click(function() {
			bersihkan();
			$("#area-pekerjaan").fadeIn();
			isiMasterPekerjaan();
			$("#lblhalaman").val('pekerjaan');
		});

		$("#lv_unsur").click(function() {
			bersihkan();
			$("#area-unsur").fadeIn();
			isiMasterUnsur();
			$("#lblhalaman").val('unsur');
		});

		$("#lv_soal").click(function() {
			bersihkan();
			$("#area-soal").fadeIn();
			isiMasterSoal();
			$("#lblhalaman").val('soal');
		});

		$("#lv_soal_standart").click(function() {
			bersihkan();
			$("#area-soal-standart").fadeIn();
			isiMasterSoalStandart();
			$("#lblhalaman").val('soalstandart');
		});
	</script>
</body>

</html>