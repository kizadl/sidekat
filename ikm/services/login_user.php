<?php
error_reporting(0);
include 'config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}	

if(isset($_POST['checkUser']))
{	
	$userName = anti_injection(trim($_POST['uid']));
	$pwd=anti_injection(trim($_POST['pwrd']));
	$pwd2 = md5($pwd);
		$stmt = $mysqli->prepare("SELECT p.id_operator,p.username,p.password,p.nm_operator,p.akses,p.link_url,p.share_link,p.blokir,p.id_instansi,p.id_bidang
								FROM m_operator p WHERE p.username=?");								
		$stmt->bind_param('s',$userName);
		$stmt->execute();
		$stmt->store_result();
		$row = $stmt->num_rows;
		
		if($row<1)
		{
			$stmt2 = $mysqli->prepare("SELECT p.id,p.id_user,p.username,p.password_user,p.nm_user,p.blokir,p.akses,p.id_universitas,p.id_fakultas,p.id_kecamatan
								FROM ats_user p WHERE p.username=?");								
			$stmt2->bind_param('s',$userName);
			$stmt2->execute();
			$stmt2->store_result();
			$row2 = $stmt2->num_rows;
			if($row2<1)
			{
				echo "<script>alert('Maaf, username tidak ditemukan !');</script>";
			}
			else if($row2>=1)
			{
				$stmt2->bind_result($id,$idkoordinator,$usernamekoordinator,$pwkoordinator,$nmkoordinator,$blokirkoordinator,$akseskoordinator,$iduniversitas,$idfakultas,$idkecamatan);
				$rek2 = $stmt2->fetch();

				if($pwkoordinator!==$pwd2){echo "<script>alert('Maaf, password yang Anda input salah !');</script>";
				}elseif($blokirkoordinator=="Y"){echo "<script>alert('Maaf, status akun Anda terblokir !');</script>";
				}else{		
					if ($akseskoordinator == "koordinator"){
					session_start();
					unset($_SESSION['IDKOORDINATOR']);
					unset($_SESSION['USERNAME']);
					unset($_SESSION['NMKOORDINATOR']);
					unset($_SESSION['IDUNIVERSITAS']);
					unset($_SESSION['IDFAKULTAS']);

					$_SESSION['IDKOORDINATOR'] = $idkoordinator;
					$_SESSION['USERNAME'] = $usernamekoordinator;
					$_SESSION['NMKOORDINATOR'] = $nmkoordinator;
					$_SESSION['IDUNIVERSITAS'] = $iduniversitas;
					$_SESSION['IDFAKULTAS'] = $idfakultas;

					echo "	<script>
							document.location.href='ats-koordinator/dashboard.html';
							</script>";
					}

					if ($akseskoordinator == "surveyor"){
						session_start();
						unset($_SESSION['IDSURVEYOR']);
						unset($_SESSION['USERNAME']);
						unset($_SESSION['NMSURVEYOR']);
						unset($_SESSION['IDUNIVERSITAS']);
						unset($_SESSION['IDFAKULTAS']);
						unset($_SESSION['IDKECAMATAN']);
	
						$_SESSION['IDSURVEYOR'] = $idkoordinator;
						$_SESSION['USERNAME'] = $usernamekoordinator;
						$_SESSION['NMSURVEYOR'] = $nmkoordinator;
						$_SESSION['IDUNIVERSITAS'] = $iduniversitas;
						$_SESSION['IDFAKULTAS'] = $idfakultas;
						$_SESSION['IDKECAMATAN'] = $idkecamatan;
	
						echo "	<script>
								document.location.href='ats-surveyor/survei-ats.html';
								</script>";
					}

					if ($akseskoordinator == "desk"){
						session_start();
						unset($_SESSION['IDUSERDESK']);
						unset($_SESSION['USERNAME']);
						unset($_SESSION['NMOPERATORDESK']);
	
						$_SESSION['IDUSERDESK'] = $id;
						$_SESSION['USERNAME'] = $usernamekoordinator;
						$_SESSION['NMOPERATORDESK'] = $nmkoordinator;

						echo "	<script>
								document.location.href='ats-desk/dashboard.html';
								</script>";
					}

				}
			}
		}
		else
		{
			$stmt->bind_result($idoperator,$username,$pw,$nmoperator,$akses,$linkurl,$sharelink,$blokir,$idinstansi,$idbidang);
			$rek = $stmt->fetch();

			if($pw!==$pwd2){echo "<script>alert('Maaf, password yang Anda input salah !');</script>";
			}elseif($blokir=="Y"){echo "<script>alert('Maaf, status akun Anda terblokir !');</script>";
			}else{		
				if ($akses == "administrator" AND $linkurl == "administrator"){
					session_start();
					unset($_SESSION['IDOPERATOR']); 
					unset($_SESSION['USERNAME']); 
					unset($_SESSION['NMOPERATOR']);
					unset($_SESSION['AKSES']);
					unset($_SESSION['IDINSTANSI']); 
					
					$_SESSION['IDOPERATOR'] = $idoperator;
					$_SESSION['USERNAME'] = $username;
					$_SESSION['NMOPERATOR'] = $nmoperator;
					$_SESSION['AKSES'] = $akses;
					$_SESSION['IDINSTANSI'] = $idinstansi;
					
					echo "	<script>
							document.location.href='admin-ikm.html';
							</script>";
				}
				if ($akses == "administrator" AND $linkurl == "pupr"){
					session_start();
					unset($_SESSION['IDOPERATOR']); 
					unset($_SESSION['USERNAME']); 
					unset($_SESSION['NMOPERATOR']);
					unset($_SESSION['AKSES']);
					unset($_SESSION['IDINSTANSI']); 
					
					$_SESSION['IDOPERATOR'] = $idoperator;
					$_SESSION['USERNAME'] = $username;
					$_SESSION['NMOPERATOR'] = $nmoperator;
					$_SESSION['AKSES'] = $akses;
					$_SESSION['IDINSTANSI'] = $idinstansi;
					
					echo "	<script>
							document.location.href='pupr/home.html';
							</script>";
				}
				if ($akses == "administrator" AND $linkurl == "monitoring"){
					session_start();
					unset($_SESSION['IDOPERATOR']); 
					unset($_SESSION['USERNAME']); 
					unset($_SESSION['NMOPERATOR']);
					unset($_SESSION['AKSES']);
					unset($_SESSION['IDINSTANSI']); 
					
					$_SESSION['IDOPERATOR'] = $idoperator;
					$_SESSION['USERNAME'] = $username;
					$_SESSION['NMOPERATOR'] = $nmoperator;
					$_SESSION['AKSES'] = $akses;
					$_SESSION['IDINSTANSI'] = $idinstansi;
					
					echo "	<script>
							document.location.href='monitoring/home.html';
							</script>";
				}
				if ($akses == "operator"){
					session_start();
					unset($_SESSION['IDOPERATOR']); 
					unset($_SESSION['USERNAME']); 
					unset($_SESSION['NMOPERATOR']);
					unset($_SESSION['AKSES']);
					unset($_SESSION['IDINSTANSI']);
					
					$_SESSION['IDOPERATOR'] = $idoperator;
					$_SESSION['USERNAME'] = $username;
					$_SESSION['NMOPERATOR'] = $nmoperator;
					$_SESSION['AKSES'] = $akses;
					$_SESSION['IDINSTANSI'] = $idinstansi;
					
					echo "	<script>
							document.location.href='operator/dashboard.html';
							</script>";
				}
				
				if ($akses == "operator bidang" OR $akses == "kepala seksi" OR $akses == "kepala bidang"){
					session_start();
					unset($_SESSION['IDOPERATOR']); 
					unset($_SESSION['USERNAME']); 
					unset($_SESSION['NMOPERATOR']);
					unset($_SESSION['AKSES']);
					unset($_SESSION['IDINSTANSI']);
					
					$_SESSION['IDOPERATOR'] = $idoperator;
					$_SESSION['USERNAME'] = $username;
					$_SESSION['NMOPERATOR'] = $nmoperator;
					$_SESSION['AKSES'] = $akses;
					$_SESSION['IDINSTANSI'] = $idbidang;
					
					echo "	<script>
							document.location.href='verifikator-bidang/home.html';
							</script>";
				}
			}
		}	
	
}else{
	echo "<script>document.location.href='login.html'</script>";
}	
	
?>