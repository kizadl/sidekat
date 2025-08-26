<?php
error_reporting(0);
require_once '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');

$idkegiatan = trim($_POST['idkegiatan']);

$qri = ("SELECT judul,isi_kegiatan FROM kegiatan_sekolah WHERE id_kegiatan='" . $idkegiatan . "'");
$dblayanan = mysqli_query($dbconn, $qri);
$d = mysqli_fetch_assoc($dblayanan);

$judul = ucwords(strtolower($d['judul']));
$isikegiatan = $d['isi_kegiatan'];

mysqli_free_result($dblayanan);
mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Upload Foto Kegiatan Sekolah</h5>
        <p class="fs--1 mb-0 text-white">Silahkan upload foto-foto kegiatan sekolah</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="row mb-3 g-3">
        <div class="col-xxl-12">
            <div class="card bg-primary text-white h-lg-100">
                <div class="card-body d-flex align-items-center">
                    <p class="fs--1 mt-0 mb-0">
                        <strong><?php echo $judul ?></strong><br><?php echo $isikegiatan ?><br><br>
                        Upload foto <strong>Headline</strong> (Foto akan ditampilkan di halaman utama).<br>
                        Upload foto-foto <strong>Kegiatan Sekolah</strong> untuk ditampilkan detail kegiatan sekolah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input class="form-control form-control-sm datetimepicker fs--1" id="txtidkegiatanUpload" value="<?php echo $idkegiatan ?>" type="text" hidden />

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0 fs--1">Upload Foto Headline</h5>
        </div>
        <div class="card-body bg-light">
            <div id="dropzoneuploadheadline" class="dropzone"></div>
            <center>
                <button class="btn btn-falcon-default btn-sm" id="cmdUploadHeadline">Upload Headline</button>
            </center>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header">
            <h5 class="mb-0 fs--1">Upload Foto-Foto Kegiatan Sekolah</h5>
        </div>
        <div class="card-body bg-light">
            <div id="dropzoneuploadkegiatan" class="dropzone"></div>
            <center>
                <button class="btn btn-falcon-default btn-sm" id="cmdUploadKegiatan">Upload Kegiatan</button>
            </center>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-falcon-danger" type="button" data-bs-dismiss="modal">Close</button>
</div>

<script type="text/javascript" charset="utf-8">
    var idinstansi = $('#lblidinstansi').val();
    var idsekolah = $('#lblidsekolah').val();
    var idkegiatan = $('#txtidkegiatanUpload').val();

    //////////////////////////////////////////
    ///////////////// HEADLINE ///////////////
    var myFotoHeadline = new Dropzone("#dropzoneuploadheadline", {
        url: "aksi/kegiatan/aksi-upload-kegiatan.php?idkegiatan=" + idkegiatan + "&ketfile=jpeg&ketfolder=headline",
        method: "POST",
        paramName: "file",
        autoProcessQueue: false,
        acceptedFiles: "image/*",
        maxFiles: 1,
        //maxFilesize: 0.3, // MB
        maxFilesize: 0.3, // MB
        uploadMultiple: true,
        parallelUploads: 10, // use it with uploadMultiple
        createImageThumbnails: true,
        thumbnailWidth: 120,
        thumbnailHeight: 120,
        addRemoveLinks: true,
        timeout: 180000,
        dictRemoveFileConfirmation: "Hapus file ini?", // ask before removing file
        // Language Strings
        dictFileTooBig: "File terlalu besar ({{filesize}}mb). Max ukuran file {{maxFilesize}}mb",
        dictInvalidFileType: "Type file tidak valid",
        dictCancelUpload: "Cancel",
        dictRemoveFile: "Remove",
        dictMaxFilesExceeded: "Hanya {{maxFiles}} files yang diperkenankan",
        dictDefaultMessage: "Drop file disini untuk upload foto headline",
    });

    myFotoHeadline.on("complete", function(file) {
        setTimeout(function() {
            myFotoHeadline.removeFile(file);
        }, 10000);
    });
    myFotoHeadline.on("addedfile", function(file) {});
    myFotoHeadline.on("removedfile", function(file) {});
    // Add mmore data to send along with the file as POST data. (optional)
    myFotoHeadline.on("sending", function(file, xhr, formData) {
        formData.append("dropzoneuploadheadline", "1"); // $_POST["dropzone"]
    });
    myFotoHeadline.on("error", function(file, response) {
        console.log(response);
    });
    // on success
    myFotoHeadline.on("successmultiple", function(file, response) {
        console.log(response);
        isiListKegiatan();
    });

    /**
     *  Add existing images to the dropzone
     *  @var images
     */

    var images = [];

    for (let i = 0; i < images.length; i++) {

        let img = images[i];
        //console.log(img.url);

        // Create the mock file:
        var mockFile = {
            name: img.name,
            size: img.size,
            url: img.url
        };
        // Call the default addedfile event handler
        myFotoHeadline.emit("addedfile", mockFile);
        // And optionally show the thumbnail of the file:
        myFotoHeadline.emit("thumbnail", mockFile, img.url);
        // Make sure that there is no progress bar, etc...
        myFotoHeadline.emit("complete", mockFile);
        // If you use the maxFiles option, make sure you adjust it to the
        // correct amount:
        var existingFileCount = 1; // The number of files already uploaded
        myFotoHeadline.options.maxFiles = myFotoHeadline.options.maxFiles - existingFileCount;
    }

    // button trigger for processingQueue
    var submitDropzoneFotoHeadline = document.getElementById("cmdUploadHeadline");
    submitDropzoneFotoHeadline.addEventListener("click", function(e) {
        // Make sure that the form isn't actually being sent.
        e.preventDefault();
        e.stopPropagation();

        if (myFotoHeadline.files != "") {
            // console.log(myVideo.files);
            myFotoHeadline.processQueue();
        } else {
            // if no file submit the form    
            document.getElementById("dropzone-form").submit();
        }

    });


    //////////////////////////////////////////
    ///////////////// KEGIATAN ///////////////
    var myFotoKegiatan = new Dropzone("#dropzoneuploadkegiatan", {
        url: "aksi/kegiatan/aksi-upload-kegiatan.php?idkegiatan=" + idkegiatan + "&ketfile=jpeg&ketfolder=kegiatan",
        method: "POST",
        paramName: "file",
        autoProcessQueue: false,
        acceptedFiles: "image/*",
        maxFiles: 10,
        //maxFilesize: 0.3, // MB
        maxFilesize: 0.3, // MB
        uploadMultiple: true,
        parallelUploads: 10, // use it with uploadMultiple
        createImageThumbnails: true,
        thumbnailWidth: 120,
        thumbnailHeight: 120,
        addRemoveLinks: true,
        timeout: 180000,
        dictRemoveFileConfirmation: "Hapus file ini?", // ask before removing file
        // Language Strings
        dictFileTooBig: "File terlalu besar ({{filesize}}mb). Max ukuran file {{maxFilesize}}mb",
        dictInvalidFileType: "Type file tidak valid",
        dictCancelUpload: "Cancel",
        dictRemoveFile: "Remove",
        dictMaxFilesExceeded: "Hanya {{maxFiles}} files yang diperkenankan",
        dictDefaultMessage: "Drop file disini untuk upload foto-foto kegiatan",
    });

    myFotoKegiatan.on("complete", function(file) {
        setTimeout(function() {
            myFotoKegiatan.removeFile(file);
        }, 10000);
    });
    myFotoKegiatan.on("addedfile", function(file) {});
    myFotoKegiatan.on("removedfile", function(file) {});
    // Add mmore data to send along with the file as POST data. (optional)
    myFotoKegiatan.on("sending", function(file, xhr, formData) {
        formData.append("dropzoneuploadkegiatan", "1"); // $_POST["dropzone"]
    });
    myFotoKegiatan.on("error", function(file, response) {
        console.log(response);
    });
    // on success
    myFotoKegiatan.on("successmultiple", function(file, response) {
        console.log(response);
        isiListKegiatan();
    });

    for (let i = 0; i < images.length; i++) {

        let img = images[i];
        //console.log(img.url);

        // Create the mock file:
        var mockFile = {
            name: img.name,
            size: img.size,
            url: img.url
        };
        // Call the default addedfile event handler
        myFotoKegiatan.emit("addedfile", mockFile);
        // And optionally show the thumbnail of the file:
        myFotoKegiatan.emit("thumbnail", mockFile, img.url);
        // Make sure that there is no progress bar, etc...
        myFotoKegiatan.emit("complete", mockFile);
        // If you use the maxFiles option, make sure you adjust it to the
        // correct amount:
        var existingFileCount = 1; // The number of files already uploaded
        myFotoKegiatan.options.maxFiles = myFotoKegiatan.options.maxFiles - existingFileCount;
    }

    // button trigger for processingQueue
    var submitDropzoneFotoKegiatan = document.getElementById("cmdUploadKegiatan");
    submitDropzoneFotoKegiatan.addEventListener("click", function(e) {
        // Make sure that the form isn't actually being sent.
        e.preventDefault();
        e.stopPropagation();

        if (myFotoKegiatan.files != "") {
            // console.log(myVideo.files);
            myFotoKegiatan.processQueue();
        } else {
            // if no file submit the form    
            document.getElementById("dropzone-form").submit();
        }

    });
</script>