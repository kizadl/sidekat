<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
include "../../../services/tgl_indo.php";
function anti_injection($data){
    global $dbconn;
    $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
    return $filter;
  }

$idpodcast = anti_injection(trim($_POST['idpodcast']));

$sqlx = ("SELECT judul,isi_podcast,link_youtube,hari,tanggal,jam FROM podcast WHERE id_podcast='" . $idpodcast . "'");
$result = mysqli_query($dbconn, $sqlx);
$sm = mysqli_fetch_assoc($result);

$judul = $sm['judul'];
$isipodcast = $sm['isi_podcast'];
$linkyoutube = $sm['link_youtube'];
$hari = $sm['hari'];
$tanggal = tgl_indo($sm['tanggal']);

mysqli_free_result($result);
mysqli_close($dbconn);
?>
<!------------------MODAL PENCARIAN ------------------>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Media Podcast</h5>
        <p class="fs--1 mb-0 text-white">Media Podcast Dinas Pendidikan Kabupaten Jember</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="col-xxl-12 col-lg-12">
        <div class="card h-100 mb-3">
            <div class="card-body py-0 fs--1">
                <div class="plyr__video-embed" id="player">
                    <iframe src="https://www.youtube.com/embed/<?php echo $linkyoutube ?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                </div>
            </div>
        </div>
        
        <div class="card h-100 mb-0">
            <div class="card-body py-0 fs--1">
                <p class="mb-0 mt-3 fs--1 fw-semi-bold text-800"><?php echo $judul ?></p>
                <p class="mb-0 fs--1 text-600"><?php echo $hari . ", " . $tanggal ?></p>
                <hr />
                <p><?php echo $isipodcast ?></p>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" charset="utf-8">
    //const players = Plyr.setup('.js-player');
    $('#modTambahDataLarge').on('hide.bs.modal', function () {
        //players.forEach(function(player) {
            //player.pause();
       // });
    })
</script>