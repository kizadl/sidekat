function bersihkan(){
	stopVideo()
	$("#lblhalaman").val("");
	$("#txttransid").val("");$("#txttransketerangan").val("");$("#txttransnmwilayah").val("");
	
	$("#txttransiddetailsekolah").val("");//// detail sekolah ////

	$("#lblkoppeta").text("");
	$("#lblkopgrafik1").text("");$("#lblkopgrafik2").text("");
	$("#lblkopgrafik3").text("");$("#lblkopgrafik4").text("");
	
	$("#area-halaman-utama").fadeOut("slow");
	$("#area-halaman-sekolah").fadeOut("slow");
	$("#area-halaman-operator").fadeOut("slow");
	$("#area-halaman-media").fadeOut("slow");
	$("#area-halaman-pupr").fadeOut("slow");
	$("#area-peta").fadeOut("slow");
  }

  $('#cmdGantiPassword').on('click', function() {
	var idoperator = $('#lbleditor').val();
	$.ajax({
		type:"POST",		
		url :"../services/reset_password.php",	
		data:{idoperator:idoperator},
		success:function(resp){
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
			$("#modTambahData").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	}); 
  });

  $('#btnModeUploadON').on('click', function() {
	var sttsmode = $(this).data('mode');
	let text = "Yakin Anda merubah status upload file "+sttsmode+" ?";
	if (confirm(text) == true) {
	$.ajax({
		type:"POST",		
		url :"aksi/status-server/aksi_ubah_status_upload.php",	
		data:{sttsmode:sttsmode},
		dataType : 'json',
		success:function(data){
			if (data.msg2 == "ok"){
				$('#nav-mode-upload').toggleClass('notification-indicator-warning').addClass('notification-indicator-primary');
				$('#btnModeUploadON').fadeOut("slow");
				$('#btnModeUploadOFF').fadeIn();
			} else if (data.msg2 == "err"){
				alert('Proses perubahan status gagal\nUlangi sekali lagi');	
			}
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
	}  
  });

  $('#btnModeUploadOFF').on('click', function() {
	var sttsmode = $(this).data('mode');
	let text = "Yakin Anda merubah status upload file "+sttsmode+" ?";
	if (confirm(text) == true) {
	$.ajax({
		type:"POST",		
		url :"aksi/status-server/aksi_ubah_status_upload.php",	
		data:{sttsmode:sttsmode},
		dataType : 'json',
		success:function(data){
			if (data.msg2 == "ok"){
				$('#nav-mode-upload').toggleClass('notification-indicator-primary').addClass('notification-indicator-warning');
				$('#btnModeUploadOFF').fadeOut("slow");
				$('#btnModeUploadON').fadeIn();
			} else if (data.msg2 == "err"){
				alert('Proses perubahan status gagal\nUlangi sekali lagi');	
			}
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
	}  
  });

  function ambilJumlahOperator() {
  	$.ajax({
  		type: "POST",
  		url: "aksi/operator/ambil_jumlah_operator.php",
  		success: function (data) {
  			$("#lblnavjmloperator").html(data);
  		},
  		error: function () {
  			console.log('error');
  		},
  	});
  }

  function ambilJumlahPengaduan() {
  	$.ajax({
  		type: "POST",
  		url: "aksi/ambil_jumlah_pengaduan.php",
  		success: function (data) {
  			$("#lblnavjmlpengaduan").html(data);
  		},
  		error: function () {
  			console.log('error');
  		},
  	});
  }

  $("#lv_operator").on("click",function(){
	bersihkan();           
	$("#lblnavjmloperator").html("0"); // nav jumlah operator
	ambilJumlahOperator()
	isiMasterOperator();
	$("#area-halaman-operator").fadeIn();

	$("#lblhalaman").val("operator");
	$("#loading").fadeOut("slow");
  });
  
  $("#lv_klinik_dapodik").on("click",function(){
	window.open("../klinik-dapo/dashboard.html","_self")
  });

  $("#lv_survei_ats").on("click",function(){
	window.open("../ats/dashboard.html","_self")
  });

  $("#lv_lap_pupr").on("click",function(){
	bersihkan();           
	isiMasterLaporanPUPR();
	$("#area-halaman-pupr").fadeIn();

	$("#lblhalaman").val("pupr");
	$("#loading").fadeOut("slow");
  });

  $("#lv_menu_spm").on("click",function(){
	window.open("../spm/home.html","_self")
  });
  
  $("#lv_menu_lppd").on("click",function(){
	window.open("../lppd/home.html","_self")
  });

  $("#lv_web_profil").on("click",function(){
	window.open("../pengaturan-web/home.html","_self")
  });

  $("#lv_pengaduan").on("click",function(){
	ambilJumlahPengaduan();
	window.open("../pengaduan/home.html","_self")
  });

  $("#lv_ikm").on("click",function(){
	window.open("../ikm/home.html","_self")
  });

  $("#lv_data_media").on("click",function(){
	bersihkan();           
	isiMasterMedia();
	$("#area-halaman-media").fadeIn();

	$("#lblhalaman").val("mastermedia");
	$("#loading").fadeOut("slow");
  });

  $('#lv_sinkron_dapodik').on('click', function() {
	$.ajax({
		type:"POST",		
		url :"aksi/sinkron/sinkronisasi.php",	
		success:function(resp){
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
			$("#modTambahData").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	}); 
  });

  $('#lv_sinkron_media').on('click', function() {
	$.ajax({
		type:"POST",		
		url :"aksi/sinkron/sinkron-media.php",	
		success:function(resp){
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
			$("#modTambahData").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	}); 
  });

   /*================ PENGUNJUNG =================*/
   var hasilApiSekolah;

  arridproduk = [];
  function carikecamatanreg(){
		$.ajax({
			url         : "aksi/hasilapi.json",
			type        : "GET",
			dataType    : "json",
			//data        : {get_param : 'value'},	
			error  : function() {
				alert("Koneksi ke server terputus")	
			},
			success     : function(resp){
				//
				
				myArray = resp['data'];
				//console.log(myArray)
				//var groupedPeople=groupArrayOfObjects(resp,"kecamatan");
				//$.each(groupedPeople, function(index, hd) {	
				//	arridproduk.push(hd);
				//});
				//console.log(arridproduk);
				//myArray = resp;
				//var grupkecamatan = groupArrayOfObjects(myArray,"kecamatan");
				//	console.log(grupkecamatan);	
					//$("#nyobak").text(JSON.stringify(grupkecamatan))
					//$("#nyobak").html(grupkecamatan.nama)

				$.each(resp, function(index, hd) {	
					console.log(hd.nama)
					$("#nyobak").html(hd.kecamatan)
					//arridproduk.push(groupedPeople);		
				});	
				//console.log(JSON.stringify(arridproduk))
				//caridetail();
			}
		});		
	}	

	function caridetail(){
		//$.each(arridproduk, function(index, hd) {	
		//	console.log(hd)
		//	$("#nyobak").text(hd.kecamatan)
			//arridproduk.push(hd);
		//});
		//var data = JSON.parse(arridproduk);
		
		console.log(arridproduk['nama'])
		var i;
		for(i=0; i<arridproduk.length; i++){
			//console.log(arridproduk[i].nama)
			//$("#nyobak").text(arridproduk[i].nama)	
			//if (data[i].sttsrenbut == "belum"){var warnabad = "bg-blue";}else if (data[i].sttsrenbut == "tolak"){var warnabad = "bg-pink";}

		}
	}
	

	function groupArrayOfObjects(list, key) {
		return list.reduce(function(rv, x) {
		  (rv[x[key]] = rv[x[key]] || []).push(x);
		  return rv;
		}, {});
	  };

  /*================ OPERATOR =================*/
  function isiMasterOperator(){
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
	  type:"POST",
	  url : "aksi/isi_tabel_operator.php",
	  data:{idinstansi:idinstansi},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
		  $('#tabelOperatorAdm').dataTable().fnDestroy();
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
  
				  if(data[i].akses == "ADMINISTRATOR"){
					var warna = "badge-soft-light";
				  }else if(data[i].akses == "OPERATOR"){
					var warna = "badge-soft-info";
				  } 
  
				  if(data[i].blokir == "Y"){
					  var warnablokir = "badge-soft-warning";
				  } else if(data[i].blokir == "N"){
					  var warnablokir = "badge-soft-primary";
				  }
  
				  html += 
				  '<tr class="btn-reveal-trigger">'+
					'<td class="align-middle text-center" width="4%"><span class="badge '+warna+'">'+data[i].no+'</span></td>'+
					'<td class="align-middle" width="18%">'+data[i].username+'</td>'+
					'<td class="align-middle text-truncate" width="32%" style="max-width:150px;">'+data[i].nminstansi+'</td>'+
					'<td class="align-middle" width="12%"><span class="badge '+warna+' rounded-pill">'+data[i].akses+'</span></td>'+
					'<td class="align-middle text-center" width="10%"><span class="badge '+warnablokir+'">'+data[i].nmblokir+'</span></td>'+
					'<td class="align-middle" width="12%"><span class="badge '+warnablokir+' rounded-pill">'+data[i].nmurl+'</span></td>'+
					'<td class="align-middle" width="4%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnBlokirOptAdm" data-idoperator="'+data[i].idoperator+'" data-username="'+data[i].username+'" data-nminstansi="'+data[i].nminstansi+'" data-blokir="'+data[i].blokir+'" data-bs-toggle="tooltip" title="Blokir"><span class="fas fa-ban"></span></button>'+
					'</td>'+
					'<td class="align-middle" width="4%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnEditOptAdm" data-idoperator="'+data[i].idoperator+'" data-username="'+data[i].username+'" data-bs-toggle="modal" data-bs-target="#modEditOperatorAdm" data-bs-toggle="tooltip" title="Edit"><span class="fas fa-edit"></span></button>'+
					'</td>'+
					'<td class="align-middle" width="4%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnHapusOptAdm" data-idoperator="'+data[i].idoperator+'" data-username="'+data[i].username+'" data-nminstansi="'+data[i].nminstansi+'" data-bs-toggle="tooltip" title="Hapus"><span class="fas fa-trash-alt"></span></button>'+
					'</td>'+
				  '</tr>';
				  }			
				  $('#isitabelOperatorAdm').html(html);
				  $("#tabelOperatorAdm").dataTable({"paging": true, "lengthChange": false,"ordering": true,"info": false,"autoWidth": true,"responsive": true,"select": false,"scrollX": true,
						initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
						$("#loading").fadeOut("slow");		

	  },
	  error: function() {
		$("#loading").fadeOut("slow");
		alert("Koneksi bermasalah periksa internet");
		document.body.style.cursor = "default";					
	  },
	});	
  }

  $("#cmdRefreshOperator").click(function(){
	isiMasterOperator();
  });

  $("#cmdTambahOperator").click(function(){
	$.ajax({
	  type:"POST",
	  url :"aksi/operator/tambah_operator.php",			
	  success:function(resp){
		$("#isianModTambahData").html(resp);
		$("#isianModTambahData").fadeIn(1000);
		$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
		$("#modTambahData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#isitabelOperatorAdm').on('click','.btnEditOptAdm',function(){
	var idoperator = $(this).data('idoperator');
	$.ajax({
	  type:"POST",		
	  url :"aksi/operator/edit_operator.php",	
	  data:{idoperator:idoperator},
	  success:function(resp){
		$("#isianModEditData").html(resp);
		$("#isianModEditData").fadeIn(1000);
		$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#isitabelOperatorAdm').on('click','.btnHapusOptAdm',function(){
	var idoperator = $(this).data('idoperator');var nmoperator = $(this).data('username');
	var nminstansi = $(this).data('nminstansi');
	let text = "Yakin Anda menghapus data operator\n\n"+nmoperator+"\n"+nminstansi;
	if (confirm(text) == true) {
	  $.ajax({
		type:"POST",		
		url :"aksi/operator/aksi_hapus.php",	
		data:{idoperator:idoperator},
		success:function(resp){
		  $("#ToastSukses").toast("show");
		  isiMasterOperator();	
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
	}  
  });

  $('#isitabelOperatorAdm').on('click','.btnBlokirOptAdm',function(){
	var idoperator = $(this).data('idoperator');var nmoperator = $(this).data('username');
	var blokir = $(this).data('blokir');var nminstansi = $(this).data('nminstansi');
	if (blokir=="Y"){var ubahstatus ="Membuka Blokir";var status ="N";} else {var ubahstatus ="Memblokir";var status ="Y";}
	let text = "Yakin Anda "+ubahstatus+" data operator\n\n"+nmoperator+"\n"+nminstansi;
	if (confirm(text) == true) {
	  $.ajax({
		type:"POST",		
		url :"aksi/operator/aksi_blokir.php",	
		data:{idoperator:idoperator,status:status},
		success:function(resp){
		  $("#ToastSukses").toast("show");
		  isiMasterOperator();	
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
	}  
  });


  /* ============== IDENTITAS SKPD =============== */
  $("#cmdIdentitasSKPD").click(function(){
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
	  type:"POST",
	  url :"aksi/identitas-instansi/edit_identitas_instansi.php",			
	  data:{idinstansi:idinstansi},
	  success:function(resp){
		$("#isianModEditData").html(resp);
		$("#isianModEditData").fadeIn(1000);
		$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  /*================ MEDIA =================*/
  function isiMasterMedia(){
	var filtermedia = $("#cbofiltermedia").val();
	$.ajax({
	  type:"POST",
	  url : "aksi/isi_tabel_media.php",
	  data: {filtermedia: filtermedia},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
		  $('#tabelMediaAdm').dataTable().fnDestroy();
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
  
				  if(data[i].jmltotal <= 0){var warna = "text-danger";} else {var warna = "text-primary";}

				  html += 
				  '<tr class="btn-reveal-trigger">'+
					'<td class="align-middle" width="12%">'+data[i].npsn+'</td>'+
					'<td class="align-middle text-truncate" width="34%" style="max-width:250px;">'+data[i].nminstansi+'</td>'+
					'<td class="align-middle text-center" width="3%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnViewMediaAdm" data-id="'+data[i].id+'" data-koordinat="'+data[i].koordinat+'" data-bs-toggle="tooltip" title="Tampilkan data media"><span class="fa fa-camera"></span></button>'+
					'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].video+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].kelas+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].perpustakaan+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].kepsek+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].guru+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].pembinaan+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].multimedia+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].komputer+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].ips+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].ipa+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].bahasa+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].wcumum+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].wcsiswa+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].wcguru+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].ibadah+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%">'+data[i].asrama+'</td>'+
					'<td class="align-middle text-center '+warna+'" width="3%"><strong>'+data[i].jmlmedia+'</strong></td>'+
				  '</tr>';
				  }			
				  $('#isitabelMediaAdm').html(html);
				  $("#tabelMediaAdm").dataTable({"paging": true, "lengthChange": false,"pageLength": 25,"ordering": true,"info": false,"autoWidth": false,"responsive": false,"select": false,"scrollX": true,
						initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
						$("#loading").fadeOut("slow");		

	  },
	  error: function() {
		$("#loading").fadeOut("slow");
		alert("Koneksi bermasalah periksa internet");
		document.body.style.cursor = "default";					
	  },
	});	
  }

  $("#cmdRefreshMedia").on("click",function(){
	isiMasterMedia();
  });

  $("#cmdExcelMedia").on("click",function(){
	var filtermedia = $("#cbofiltermedia").val();
	window.open("excel-rekap-"+filtermedia+".html", '_self')
  });

  $('#isitabelMediaAdm').on('click', '.btnViewMediaAdm', function() {
	$("#txttransiddetailsekolah").val("");
	var idsekolah = $(this).data('id');
	$("#txttransiddetailsekolah").val(idsekolah);

	window.scrollTo(0, 0);
	const koordinat = $(this).data('koordinat');
	const words1 = koordinat.split(',');
	map.setView([words1[0], words1[1]], 18);
	
	stopVideo()

	$.ajax({
		type: 'POST',
		url: "aksi/tampilkan/tampilkan-detail-dashboard.php",
		data: {
			idsekolah: idsekolah
		},
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function(resp) {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			$("#area-halaman-utama").fadeOut("slow");
			$("#area-halaman-operator").fadeOut("slow");
			$("#area-halaman-media").fadeOut("slow");
			$("#area-halaman-pupr").fadeOut("slow");
			$("#area-halaman-sekolah").fadeIn();
			$("#area-peta").fadeIn();

			$('#hal-detail-sekolah').html(resp);

			//let player = Plyr.setup('.popin__video-container');
			//player.restart();
			isiVideo()

			isiFotoKelas()
			isiFotoPerpustakaan()
			isiFotoKepsek()
			isiFotoGuru()
			isiFotoPembinaan()
			isiFotoMultimedia()
			isiFotoKomputer()
			isiFotoIPS()
			isiFotoIPA()
			isiFotoBahasa()
			isiFotoWCUmum()
			isiFotoWCSiswa()
			isiFotoWCGuru()
			isiFotoIbadah()
			isiFotoAsrama()

			$("#modTambahDataLarge").modal('hide');
		},
		error: function() {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			alert("Koneksi ke server terputus");
		},
	});
});

 /*================ MEDIA =================*/
 function isiMasterLaporanPUPR(){
	var filtermedia = $("#cbofilterpupr").val();
	$.ajax({
	  type:"POST",
	  url : "aksi/isi_tabel_kondisi_prasarana.php",
	  data: {filtermedia: filtermedia},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
		  $('#tabelPUPRAdm').dataTable().fnDestroy();
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
 
				  html += 
				  '<tr class="btn-reveal-trigger">'+
					'<td class="align-middle" width="12%">'+data[i].npsn+'</td>'+
					'<td class="align-middle text-truncate" width="34%" style="max-width:250px;">'+data[i].nminstansi+'</td>'+
					'<td class="align-middle text-center" width="3%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnViewMediaPUPRAdm" data-id="'+data[i].id+'" data-koordinat="'+data[i].koordinat+'" data-bs-toggle="tooltip" title="Tampilkan data media"><span class="fa fa-camera"></span></button>'+
					'</td>'+
					'<td class="align-middle text-center" width="12%">'+
						'<a href="tampilkan-'+data[i].npsn+'.html" target="_blank" class="badge badge-soft-primary">'+data[i].statussetuju+'</a>'+
					'</td>'+
					'<td class="align-middle text-center text-primary" width="3%"><strong>'+data[i].jmltotal+'</strong></td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].kelas+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].perpustakaan+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].kepsek+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].guru+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].pembinaan+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].multimedia+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].komputer+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].ips+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].ipa+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].bahasa+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].wcumum+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].wcsiswa+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].wcguru+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].ibadah+'</td>'+
					'<td class="align-middle text-center" width="3%">'+data[i].asrama+'</td>'+
				  '</tr>';
				  }			
				  $('#isitabelPUPRAdm').html(html);
				  $("#tabelPUPRAdm").dataTable({"paging": true, "lengthChange": false,"pageLength": 25,"ordering": true,"info": false,"autoWidth": false,"responsive": false,"select": false,"scrollX": true,
						initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
						$("#loading").fadeOut("slow");		

	  },
	  error: function() {
		$("#loading").fadeOut("slow");
		alert("Koneksi bermasalah periksa internet");
		document.body.style.cursor = "default";					
	  },
	});	
  }

  $("#cmdRefreshPUPR").on("click",function(){
	isiMasterLaporanPUPR();
  });

  $('#isitabelPUPRAdm').on('click', '.btnViewMediaPUPRAdm', function() {
	bersihkan();
	$("#txttransiddetailsekolah").val("");
	var idsekolah = $(this).data('id');
	$("#txttransiddetailsekolah").val(idsekolah);

	window.scrollTo(0, 0);
	const koordinat = $(this).data('koordinat');
	const words1 = koordinat.split(',');
	map.setView([words1[0], words1[1]], 18);
	
	stopVideo()

	$.ajax({
		type: 'POST',
		url: "aksi/tampilkan/tampilkan-detail-dashboard.php",
		data: {
			idsekolah: idsekolah
		},
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function(resp) {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			$("#area-halaman-utama").fadeOut("slow");
			$("#area-halaman-media").fadeOut("slow");
			$("#area-halaman-sekolah").fadeIn();
			$("#area-peta").fadeIn();

			$('#hal-detail-sekolah').html(resp);

			//let player = Plyr.setup('.popin__video-container');
			//player.restart();
			isiVideo()

			isiFotoKelas()
			isiFotoPerpustakaan()
			isiFotoKepsek()
			isiFotoGuru()
			isiFotoPembinaan()
			isiFotoMultimedia()
			isiFotoKomputer()
			isiFotoIPS()
			isiFotoIPA()
			isiFotoBahasa()
			isiFotoWCUmum()
			isiFotoWCSiswa()
			isiFotoWCGuru()
			isiFotoIbadah()
			isiFotoAsrama()

			$("#modTambahDataLarge").modal('hide');
		},
		error: function() {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
			alert("Koneksi ke server terputus");
		},
	});
  });
