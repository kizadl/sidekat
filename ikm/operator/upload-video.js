        // disable autodiscover
        Dropzone.autoDiscover = false;

        var idinstansi = $("#lblidinstansi").val();
        /////////////////////////////////////////////
        /////////////// VIDEO ///////////////////////
        var myVideo = new Dropzone("#dropzonevideo", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=mp4&ketfolder=video",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "video/*",
            maxFiles: 1,
            //maxFilesize: 0.3, // MB
            maxFilesize: 100, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
            createImageThumbnails: true,
            thumbnailWidth: 120,
            thumbnailHeight: 120,
            addRemoveLinks: true,
            timeout: 280000,
            dictRemoveFileConfirmation: "Hapus file ini?", // ask before removing file
            // Language Strings
            dictFileTooBig: "File terlalu besar ({{filesize}}mb). Max ukuran file {{maxFilesize}}mb",
            dictInvalidFileType: "Type file tidak valid",
            dictCancelUpload: "Cancel",
            dictRemoveFile: "Remove",
            dictMaxFilesExceeded: "Hanya {{maxFiles}} files yang diperkenankan",
            dictDefaultMessage: "Drop files here to upload",
        });
 
        myVideo.on("complete", function(file) {
            setTimeout(function() {myVideo.removeFile(file);}, 10000);
        });

        myVideo.on("addedfile", function(file) {});      
        myVideo.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myVideo.on("sending", function(file, xhr, formData) {
            formData.append("dropzonevideo", "1"); // $_POST["dropzone"]
        });
        myVideo.on("error", function(file, response) {console.log(response);});
        // on success
        myVideo.on("successmultiple", function(file, response) {console.log(response);});

               /**
         *  Add existing images to the dropzone
         *  @var videos
         *
         */
         
                var videos = [];
            
                for(let i = 0; i < videos.length; i++) {
                
                    let img = videos[i];
                    //console.log(img.url);
                
                    // Create the mock file:
                    var mockFile = {name: img.name, size: img.size, url: img.url};
                    // Call the default addedfile event handler
                    myVideo.emit("addedfile", mockFile);
                    // And optionally show the thumbnail of the file:
                    myVideo.emit("thumbnail", mockFile, img.url);
                    // Make sure that there is no progress bar, etc...
                    myVideo.emit("complete", mockFile);
                    // If you use the maxFiles option, make sure you adjust it to the
                    // correct amount:
                    var existingFileCount = 1; // The number of files already uploaded
                    myVideo.options.maxFiles = myVideo.options.maxFiles - existingFileCount;
                }

                       // button trigger for processingQueue
        var submitDropzoneVideo = document.getElementById("cmdVideo");
        submitDropzoneVideo.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myVideo.files != "") {
                // console.log(myVideo.files);
                myVideo.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG KELAS //////////////////////////////////////////
        var myFoto = new Dropzone("#dropzonefotokelas", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=kelas",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 40,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFoto.on("complete", function(file) {
            setTimeout(function() {myFoto.removeFile(file);}, 10000);
        });
        myFoto.on("addedfile", function(file) {});      
        myFoto.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFoto.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotokelas", "1"); // $_POST["dropzone"]
        });
        myFoto.on("error", function(file, response) {console.log(response);});
        // on success
        myFoto.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        /**
         *  Add existing images to the dropzone
         *  @var images
         *
         */
         
        var images = [];
            
        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFoto.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFoto.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFoto.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFoto.options.maxFiles = myFoto.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFoto = document.getElementById("cmdFotoKelas");
        submitDropzoneFoto.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFoto.files != "") {
                // console.log(myVideo.files);
                myFoto.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });


        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG PERPUSTAKAAN //////////////////////////////////////////
        var myFotoPerpus = new Dropzone("#dropzonefotoperpustakaan", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=perpustakaan",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoPerpus.on("complete", function(file) {
            setTimeout(function() {myFotoPerpus.removeFile(file);}, 10000);
        });
        myFotoPerpus.on("addedfile", function(file) {});      
        myFotoPerpus.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoPerpus.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotoperpustakaan", "1"); // $_POST["dropzone"]
        });
        myFotoPerpus.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoPerpus.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoPerpus.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoPerpus.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoPerpus.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoPerpus.options.maxFiles = myFotoPerpus.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoPerpus = document.getElementById("cmdFotoPerpustakaan");
        submitDropzoneFotoPerpus.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoPerpus.files != "") {
                // console.log(myVideo.files);
                myFotoPerpus.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });


        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG KEPSEK //////////////////////////////////////////
        var myFotoKepsek = new Dropzone("#dropzonefotokepsek", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=kepsek",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 3,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoKepsek.on("complete", function(file) {
            setTimeout(function() {myFotoKepsek.removeFile(file);}, 10000);
        });
        myFotoKepsek.on("addedfile", function(file) {});      
        myFotoKepsek.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoKepsek.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotokepsek", "1"); // $_POST["dropzone"]
        });
        myFotoKepsek.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoKepsek.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoKepsek.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoKepsek.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoKepsek.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoKepsek.options.maxFiles = myFotoKepsek.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoKep = document.getElementById("cmdFotoKepsek");
        submitDropzoneFotoKep.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoKepsek.files != "") {
                // console.log(myVideo.files);
                myFotoKepsek.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });


        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG GURU //////////////////////////////////////////
        var myFotoGuru = new Dropzone("#dropzonefotoguru", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=guru",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoGuru.on("complete", function(file) {
            setTimeout(function() {myFotoGuru.removeFile(file);}, 10000);
        });
        myFotoGuru.on("addedfile", function(file) {});      
        myFotoGuru.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoGuru.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotoguru", "1"); // $_POST["dropzone"]
        });
        myFotoGuru.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoGuru.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoGuru.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoGuru.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoGuru.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoGuru.options.maxFiles = myFotoGuru.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoGuru = document.getElementById("cmdFotoGuru");
        submitDropzoneFotoGuru.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoGuru.files != "") {
                // console.log(myVideo.files);
                myFotoGuru.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG PEMBINAAN //////////////////////////////////////////
        var myFotoPembinaan = new Dropzone("#dropzonefotopembinaan", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=pembinaan",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoPembinaan.on("complete", function(file) {
            setTimeout(function() {myFotoPembinaan.removeFile(file);}, 10000);
        });
        myFotoPembinaan.on("addedfile", function(file) {});      
        myFotoPembinaan.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoPembinaan.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotopembinaan", "1"); // $_POST["dropzone"]
        });
        myFotoPembinaan.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoPembinaan.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoPembinaan.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoPembinaan.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoPembinaan.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoPembinaan.options.maxFiles = myFotoPembinaan.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoPemb = document.getElementById("cmdFotoPembinaan");
        submitDropzoneFotoPemb.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoPembinaan.files != "") {
                // console.log(myVideo.files);
                myFotoPembinaan.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });


        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG MULTIMEDIA //////////////////////////////////////////
        var myFotoMultimedia = new Dropzone("#dropzonefotomultimedia", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=multimedia",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 10,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoMultimedia.on("complete", function(file) {
            setTimeout(function() {myFotoMultimedia.removeFile(file);}, 10000);
        });
        myFotoMultimedia.on("addedfile", function(file) {});      
        myFotoMultimedia.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoMultimedia.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotomultimedia", "1"); // $_POST["dropzone"]
        });
        myFotoMultimedia.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoMultimedia.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoMultimedia.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoMultimedia.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoMultimedia.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoMultimedia.options.maxFiles = myFotoMultimedia.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoMM = document.getElementById("cmdFotoMultimedia");
        submitDropzoneFotoMM.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoMultimedia.files != "") {
                // console.log(myVideo.files);
                myFotoMultimedia.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG KOMPUTER //////////////////////////////////////////
        var myFotoKomp = new Dropzone("#dropzonefotokomputer", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=komputer",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 10,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoKomp.on("complete", function(file) {
            setTimeout(function() {myFotoKomp.removeFile(file);}, 10000);
        });
        myFotoKomp.on("addedfile", function(file) {});      
        myFotoKomp.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoKomp.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotokomputer", "1"); // $_POST["dropzone"]
        });
        myFotoKomp.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoKomp.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoKomp.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoKomp.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoKomp.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoKomp.options.maxFiles = myFotoKomp.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoKomp = document.getElementById("cmdFotoKomputer");
        submitDropzoneFotoKomp.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoKomp.files != "") {
                // console.log(myVideo.files);
                myFotoKomp.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG IPS //////////////////////////////////////////
        var myFotoIPS = new Dropzone("#dropzonefotoips", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=ips",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoIPS.on("complete", function(file) {
            setTimeout(function() {myFotoIPS.removeFile(file);}, 10000);
        });
        myFotoIPS.on("addedfile", function(file) {});      
        myFotoIPS.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoIPS.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotoips", "1"); // $_POST["dropzone"]
        });
        myFotoIPS.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoIPS.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoIPS.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoIPS.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoIPS.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoIPS.options.maxFiles = myFotoIPS.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoIPS = document.getElementById("cmdFotoIPS");
        submitDropzoneFotoIPS.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoIPS.files != "") {
                // console.log(myVideo.files);
                myFotoIPS.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG IPA //////////////////////////////////////////
        var myFotoIPA = new Dropzone("#dropzonefotoipa", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=ipa",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoIPA.on("complete", function(file) {
            setTimeout(function() {myFotoIPA.removeFile(file);}, 10000);
        });
        myFotoIPA.on("addedfile", function(file) {});      
        myFotoIPA.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoIPA.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotoipa", "1"); // $_POST["dropzone"]
        });
        myFotoIPA.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoIPA.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoIPA.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoIPA.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoIPA.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoIPA.options.maxFiles = myFotoIPA.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoIPA = document.getElementById("cmdFotoIPA");
        submitDropzoneFotoIPA.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoIPA.files != "") {
                // console.log(myVideo.files);
                myFotoIPA.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG BAHASA //////////////////////////////////////////
        var myFotoBahasa = new Dropzone("#dropzonefotobahasa", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=bahasa",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoBahasa.on("complete", function(file) {
            setTimeout(function() {myFotoBahasa.removeFile(file);}, 10000);
        });
        myFotoBahasa.on("addedfile", function(file) {});      
        myFotoBahasa.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoBahasa.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotobahasa", "1"); // $_POST["dropzone"]
        });
        myFotoBahasa.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoBahasa.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoBahasa.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoBahasa.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoBahasa.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoBahasa.options.maxFiles = myFotoBahasa.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoBahasa = document.getElementById("cmdFotoBahasa");
        submitDropzoneFotoBahasa.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoBahasa.files != "") {
                // console.log(myVideo.files);
                myFotoBahasa.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG WC UMUM //////////////////////////////////////////
        var myFotoWCUmum = new Dropzone("#dropzonefotowcumum", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=wcumum",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoWCUmum.on("complete", function(file) {
            setTimeout(function() {myFotoWCUmum.removeFile(file);}, 10000);
        });
        myFotoWCUmum.on("addedfile", function(file) {});      
        myFotoWCUmum.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoWCUmum.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotowcumum", "1"); // $_POST["dropzone"]
        });
        myFotoWCUmum.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoWCUmum.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoWCUmum.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoWCUmum.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoWCUmum.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoWCUmum.options.maxFiles = myFotoWCUmum.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoWCU = document.getElementById("cmdFotoWcumum");
        submitDropzoneFotoWCU.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoWCUmum.files != "") {
                // console.log(myVideo.files);
                myFotoWCUmum.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG WC SISWA //////////////////////////////////////////
        var myFotoWCSiswa = new Dropzone("#dropzonefotowcsiswa", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=wcsiswa",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 10,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoWCSiswa.on("complete", function(file) {
            setTimeout(function() {myFotoWCSiswa.removeFile(file);}, 10000);
        });
        myFotoWCSiswa.on("addedfile", function(file) {});      
        myFotoWCSiswa.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoWCSiswa.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotowcsiswa", "1"); // $_POST["dropzone"]
        });
        myFotoWCSiswa.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoWCSiswa.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoWCSiswa.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoWCSiswa.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoWCSiswa.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoWCSiswa.options.maxFiles = myFotoWCSiswa.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoWCS = document.getElementById("cmdFotoWCSiswa");
        submitDropzoneFotoWCS.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoWCSiswa.files != "") {
                // console.log(myVideo.files);
                myFotoWCSiswa.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG WC SURU //////////////////////////////////////////
        var myFotoWCGuru = new Dropzone("#dropzonefotowcguru", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=wcguru",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoWCGuru.on("complete", function(file) {
            setTimeout(function() {myFotoWCGuru.removeFile(file);}, 10000);
        });
        myFotoWCGuru.on("addedfile", function(file) {});      
        myFotoWCGuru.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoWCGuru.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotowcguru", "1"); // $_POST["dropzone"]
        });
        myFotoWCGuru.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoWCGuru.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoWCGuru.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoWCGuru.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoWCGuru.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoWCGuru.options.maxFiles = myFotoWCGuru.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoWCg = document.getElementById("cmdFotoWCGuru");
        submitDropzoneFotoWCg.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoWCGuru.files != "") {
                // console.log(myVideo.files);
                myFotoWCGuru.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });

        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG IBADAH //////////////////////////////////////////
        var myFotoIbadah = new Dropzone("#dropzonefotoibadah", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=ibadah",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 4,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoIbadah.on("complete", function(file) {
            setTimeout(function() {myFotoIbadah.removeFile(file);}, 10000);
        });
        myFotoIbadah.on("addedfile", function(file) {});      
        myFotoIbadah.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoIbadah.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotoibadah", "1"); // $_POST["dropzone"]
        });
        myFotoIbadah.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoIbadah.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoIbadah.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoIbadah.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoIbadah.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoIbadah.options.maxFiles = myFotoIbadah.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoIbd = document.getElementById("cmdFotoIbadah");
        submitDropzoneFotoIbd.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoIbadah.files != "") {
                // console.log(myVideo.files);
                myFotoIbadah.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });


        ////////////////////////////////////////////////////////////////////////////////
        ///////////////////////// RUANG ASRAMA //////////////////////////////////////////
        var myFotoAsrama = new Dropzone("#dropzonefotoasrama", {
            url: "upload-video.php?idinstansi="+idinstansi+"&ketfile=jpeg&ketfolder=asrama",
            method: "POST",
            paramName: "file",
            autoProcessQueue : false,
            acceptedFiles: "image/*",
            maxFiles: 12,
            //maxFilesize: 0.3, // MB
            maxFilesize: 0.3, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
            dictDefaultMessage: "Drop files here to upload",
        });

        myFotoAsrama.on("complete", function(file) {
            setTimeout(function() {myFotoAsrama.removeFile(file);}, 10000);
        });
        myFotoAsrama.on("addedfile", function(file) {});      
        myFotoAsrama.on("removedfile", function(file) {});
        // Add mmore data to send along with the file as POST data. (optional)
        myFotoAsrama.on("sending", function(file, xhr, formData) {
            formData.append("dropzonefotoasrama", "1"); // $_POST["dropzone"]
        });
        myFotoAsrama.on("error", function(file, response) {console.log(response);});
        // on success
        myFotoAsrama.on("successmultiple", function(file, response) {console.log(response);});
        ////////////////////////////////////////////////////////////////////////////////

        for(let i = 0; i < images.length; i++) {
        
            let img = images[i];
            //console.log(img.url);
        
            // Create the mock file:
            var mockFile = {name: img.name, size: img.size, url: img.url};
            // Call the default addedfile event handler
            myFotoAsrama.emit("addedfile", mockFile);
            // And optionally show the thumbnail of the file:
            myFotoAsrama.emit("thumbnail", mockFile, img.url);
            // Make sure that there is no progress bar, etc...
            myFotoAsrama.emit("complete", mockFile);
            // If you use the maxFiles option, make sure you adjust it to the
            // correct amount:
            var existingFileCount = 1; // The number of files already uploaded
            myFotoAsrama.options.maxFiles = myFotoAsrama.options.maxFiles - existingFileCount;
        }
        
        // button trigger for processingQueue
        var submitDropzoneFotoAsr = document.getElementById("cmdFotoAsrama");
        submitDropzoneFotoAsr.addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
        
            if (myFotoAsrama.files != "") {
                // console.log(myVideo.files);
                myFotoAsrama.processQueue();
            } else {
            // if no file submit the form    
                document.getElementById("dropzone-form").submit();
            }
        
        });


        $('#cmdAksiVideo').on('click',function(){
            var idsekolah = $("#lblidinstansi").val();
            var sttsupload = $("#lblstatusupload").val();
            var ruang = "video";
            $.ajax({
              type:"POST",		
              url :"aksi/list-file/tampilkan-daftar-file.php",	
              data:{idsekolah:idsekolah,ruang:ruang,sttsupload:sttsupload},
              beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
              },
              success:function(resp){
                document.body.style.cursor = "default";
                $("#loading").fadeOut("slow");
                $("#isianModBebasData").html(resp);
                $("#isianModBebasData").fadeIn(1000);
                $("#modBebasData").modal('show');
              },
              error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";	},
            });
        });

        $('.btnAksiFoto').on('click',function(){
            var idsekolah = $("#lblidinstansi").val();
            var sttsupload = $("#lblstatusupload").val();
            var ruang = $(this).data("ruang");
            $.ajax({
              type:"POST",		
              url :"aksi/list-file/tampilkan-daftar-file.php",	
              data:{idsekolah:idsekolah,ruang:ruang,sttsupload:sttsupload},
              beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
              },
              success:function(resp){
                document.body.style.cursor = "default";
                $("#loading").fadeOut("slow");
                $("#isianModBebasData").html(resp);
                $("#isianModBebasData").fadeIn(1000);
                $("#modBebasData").modal('show');
              },
              error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";	},
            });
        });
