function bersihkan() {
	$("#lblhalaman").val("");
	$("#txttransid").val(""); $("#txttransketerangan").val(""); $("#txttransnmwilayah").val("");

	$("#txttransiddetailsekolah").val("");//// detail sekolah ////
	$("#txttransketkurikulum").val("");

	$(".lblkopgrafik1").text(""); $("#lblkopgrafik2").text("");
	$("#lblkopgrafik3").text(""); $("#lblkopgrafik4").text("");

	$("#area-halaman-utama").fadeOut("slow");
	$("#area-halaman-sekolah").fadeOut("slow");

	$("#area-halaman-jam-mengajar").fadeOut("slow");
	$("#area-halaman-rombel-SD").fadeOut("slow");
	$("#area-halaman-rombel-SMP").fadeOut("slow");

	$("#area-halaman-kebutuhan-SD").fadeOut("slow");
	$("#area-halaman-kebutuhan-SMP").fadeOut("slow");

	$("#area-halaman-PTK").fadeOut("slow");

	$("#area-peta").fadeOut("slow");
}

$('#cmdGantiPassword').on('click', function () {
	var idoperator = $('#lbleditor').val();
	$.ajax({
		type: "POST",
		url: "../services/reset_password.php",
		data: { idoperator: idoperator },
		success: function (resp) {
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#lv_sinkron_dapodik').on('click', function () {
	$.ajax({
		type: "POST",
		url: "aksi/sinkron/sinkronisasi.php",
		success: function (resp) {
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#lv_sinkron_ptk').on('click', function () {
	$.ajax({
		type: "POST",
		url: "aksi/sinkron/sinkronisasi-ptk.php",
		success: function (resp) {
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahData").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$("#lv_statistik_spm").on("click", function () {
	bersihkan();

	$("#area-halaman-rombel-SMP").fadeOut("slow");

	$("#area-halaman-kebutuhan-SD").fadeOut("slow");

	$("#area-halaman-sekolah").fadeOut("slow");
	$("#area-halaman-utama").fadeIn();
	$("#area-peta").fadeIn();

	$("#txttransketerangan").val("kota");
	var nmwilayah = "Kabupaten Jember";
	$(".lblkopgrafik1").text(nmwilayah);
	$("#lblkopgrafik2").text(nmwilayah);
	$("#lblkopgrafik3").text(nmwilayah);
	$("#lblkopgrafik4").text(nmwilayah);

	hitungGrafikTotalSekolah();
    isiGrafikStatus();

    hitungGrafikRombelSD();
    hitungGrafikRombelSMP();
    hitungGrafikKebutuhanGuruSD();
    hitungGrafikKebutuhanGuruSMP();

    isiGrafikAkreditasi();
    isiGrafikPutusSekolah();isiGrafikLulusSekolah();
	isiGafikUsia();isiGrafikSertifikasi();

	$("#lblhalaman").val("kurikulum-SD");
	$("#loading").fadeOut("slow");
});

$("#lv_master_jam_mengajar").on("click", function () {
	bersihkan();

	isiMasterJamMapel();
	$("#area-halaman-jam-mengajar").fadeIn();

	$("#lblhalaman").val("master-jam-mengajar");
	$("#loading").fadeOut("slow");
});

$("#lv_master_rumus_bk").on("click", function () {
	$.ajax({
		type:"POST",
		url :"aksi/jam-mengajar/edit_rumus_bk.php",			
		success:function(resp){
		  $("#isianModTambahData").html(resp);
		  $("#isianModTambahData").fadeIn(1000);
		  $("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
		  $("#modTambahData").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$("#lv_kurikulum_sd").on("click", function () {
	bersihkan();
	var ketsekolah = $(this).data('keterangan');
	$("#txttransketkurikulum").val(ketsekolah);

	ambiljumlahrombel()
	isiMasterRombelSD();
	$("#area-halaman-rombel-SD").fadeIn();

	$("#lblhalaman").val("kurikulum-SD");
	$("#loading").fadeOut("slow");
});

$("#lv_kurikulum_smp").on("click", function () {
	bersihkan();
	var ketsekolah = $(this).data('keterangan');
	$("#txttransketkurikulum").val(ketsekolah);

	ambiljumlahrombel()
	isiMasterRombelSMP();
	$("#area-halaman-rombel-SMP").fadeIn();

	$("#lblhalaman").val("kurikulum-SMP");
	$("#loading").fadeOut("slow");
});

$("#lv_lap_kebutuhan_sd").on("click", function () {
	bersihkan();
	var ketsekolah = $(this).data('keterangan');
	$("#txttransketkurikulum").val(ketsekolah);

	isiMasterKebutuhanSD();
	$("#area-halaman-kebutuhan-SD").fadeIn();

	$("#lblhalaman").val("kebutuhan-SD");
	$("#loading").fadeOut("slow");
});

$("#lv_lap_kebutuhan_smp").on("click", function () {
	bersihkan();
	var ketsekolah = $(this).data('keterangan');
	$("#txttransketkurikulum").val(ketsekolah);

	isiMasterKebutuhanSMP();
	$("#area-halaman-kebutuhan-SMP").fadeIn();

	$("#lblhalaman").val("kebutuhan-SMP");
	$("#loading").fadeOut("slow");
});

$("#lv_ptk").on("click", function () {
	bersihkan();
	ambiljumlahPTK();
	isiMasterPTK();
	$("#area-halaman-PTK").fadeIn();

	$("#lblhalaman").val("PTK");
	$("#loading").fadeOut("slow");
});

/*=====================================================*/
 /*================ Jam Mata Pelajaran =================*/
 /*=====================================================*/
 function isiMasterJamMapel(){
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
	  type:"POST",
	  url : "aksi/isi_tabel_jam_mapel.php",
	  data:{idinstansi:idinstansi},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
		  $('#tabelJamMapel').dataTable().fnDestroy();
				var html = '';
				var i;
				for(i=0; i<data.length; i++){

				  if(data[i].bentukpendidikan == "SD"){
					  var warnapendidikan = "badge-soft-warning";
				  } else if(data[i].bentukpendidikan == "SMP"){
					  var warnapendidikan = "badge-soft-primary";
				  }
  
				  html += 
				  '<tr class="btn-reveal-trigger">'+
					'<td class="align-middle text-center" width="4%">'+data[i].no+'</td>'+
					'<td class="align-middle" width="12%">'+data[i].idmapel+'</td>'+
					'<td class="align-middle text-truncate" width="56%" style="max-width:150px;">'+data[i].matapelajaran+'</td>'+
					'<td class="align-middle text-center" width="6%">'+data[i].jumlahjam+'</td>'+
					'<td class="align-middle text-center" width="10%"><span class="badge '+warnapendidikan+'">'+data[i].bentukpendidikan+'</span></td>'+
					'<td class="align-middle" width="4%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnEditJam" data-idjam="'+data[i].idjam+'" data-idmapel="'+data[i].idmapel+'" data-bs-toggle="modal" data-bs-target="#modEditOperatorAdm" data-bs-toggle="tooltip" title="Edit"><span class="fas fa-edit"></span></button>'+
					'</td>'+
					'<td class="align-middle" width="4%">'+
					  '<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnHapusJam" data-idjam="'+data[i].idjam+'" data-idmapel="'+data[i].idmapel+'" data-matapelajaran="'+data[i].matapelajaran+'" data-jumlahjam="'+data[i].jumlahjam+'" data-bentukpendidikan="'+data[i].bentukpendidikan+'" data-bs-toggle="tooltip" title="Hapus"><span class="fas fa-trash-alt"></span></button>'+
					'</td>'+
				  '</tr>';
				  }			
				  $('#isitabelJamMapel').html(html);
				  $("#tabelJamMapel").dataTable({"paging": true, "lengthChange": false,"ordering": true,"info": false,"autoWidth": true,"responsive": true,"select": false,"scrollX": true,
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

  $("#cmdRefreshJam").click(function(){
	isiMasterJamMapel();
  });

  $("#cmdTambahJam").click(function(){
	$.ajax({
	  type:"POST",
	  url :"aksi/jam-mengajar/tambah_jam.php",			
	  success:function(resp){
		$("#isianModTambahData").html(resp);
		$("#isianModTambahData").fadeIn(1000);
		$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
		$("#modTambahData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#isitabelJamMapel').on('click','.btnEditJam',function(){
	var idjam = $(this).data('idjam');
	$.ajax({
	  type:"POST",		
	  url :"aksi/jam-mengajar/edit_jam.php",	
	  data:{idjam:idjam},
	  success:function(resp){
		$("#isianModEditData").html(resp);
		$("#isianModEditData").fadeIn(1000);
		$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#isitabelJamMapel').on('click','.btnHapusJam',function(){
	var idjam = $(this).data('idjam');var idmapel = $(this).data('idmapel');
	var matapelajaran = $(this).data('matapelajaran');
	var jumlahjam = $(this).data('jumlahjam');var bentukpendidikan = $(this).data('bentukpendidikan');
	let text = "Yakin Anda menghapus data jam mata pelajaran\n\n"+matapelajaran+"\nJumlah jam : "+jumlahjam+"\nPendidikan : "+bentukpendidikan;
	if (confirm(text) == true) {
	  $.ajax({
		type:"POST",		
		url :"aksi/jam-mengajar/aksi_hapus.php",	
		data:{idjam:idjam},
		success:function(resp){
		  $("#ToastSukses").toast("show");
		  isiMasterJamMapel();	
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
	}  
  });

function ambiljumlahrombel() {
	$.ajax({
		type: "POST",
		url: "aksi/rombel/ambil_jumlah_rombel.php",
		dataType: 'json',
		success: function (data) {
			$("#lblnavjmlkurikulumSD").html("0");
			$("#lblnavjmlkurikulumSMP").html("0");
			var i;
			for (i = 0; i < data.length; i++) {
				$("#lblnavjmlkurikulumSD").html(data[i].jumSD);
				$("#lblnavjmlkurikulumSMP").html(data[i].jmlSMP);
			}
		},
		error: function () {
			console.log('error');
		},
	});
}

function ambiljumlahPTK() {
	$.ajax({
		type: "POST",
		url: "aksi/ptk/ambil_jumlah_ptk.php",
		dataType: 'json',
		success: function (data) {
			$("#lblnavjmlPTK").html("0");
			var i;
			for (i = 0; i < data.length; i++) {
				$("#lblnavjmlPTK").html(data[i].jumPTK);
			}
		},
		error: function () {
			console.log('error');
		},
	});
}

/*================ ROMBEL SD =================*/
function isiMasterRombelSD() {
	var ketsekolah = $("#txttransketkurikulum").val();
	var kabupaten = $("#lblkodekabupaten-datamart").val();
	var filterrombel = $("#cbofilterrombelSD").val();

	$.ajax({
		type: "POST",
		url: "aksi/rombel/isi_tabel_rombel.php",
		data: { ketsekolah: ketsekolah, kabupaten: kabupaten, filterrombel: filterrombel },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelRombelSD').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttssekolah == "NEGERI") {
					var warna = "badge-soft-info";//var warna = "badge-soft-light";
				} else if (data[i].sttssekolah == "SWASTA") {
					var warna = "badge-soft-warning";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="6%">' + data[i].no + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].npsn + '</td>' +
					'<td class="align-middle text-truncate" width="38%" style="max-width:150px;">' + data[i].nmsekolah + '</td>' +
					'<td class="align-middle text-center" width="10%"><span class="badge ' + warna + ' rounded-pill">' + data[i].sttssekolah + '</span></td>' +
					'<td class="align-middle text-center" width="4%"><strong>' + data[i].jmlrombel + '</strong></td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel1 + '</td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel2 + '</td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel3 + '</td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel4 + '</td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel5 + '</td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel6 + '</td>' +
					'<td class="align-middle text-center text-primary" width="4%"><strong>' + data[i].jumK13 + '</strong></td>' +
					'<td class="align-middle text-center text-danger" width="4%"><strong>' + data[i].jumKMB + '</strong></td>' +
					'</tr>';
			}
			$('#isitabelRombelSD').html(html);
			$("#tabelRombelSD").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": true, "select": false, "scrollX": true,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
			$("#loading").fadeOut("slow");

		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshRombelSD").click(function () {
	isiMasterRombelSD();
});

$("#cmdExcelRombelSD").on("click", function () {
	var filtermedia = $("#cbofilterrombelSD").val();
	window.open("rombel-sd-" + filtermedia + ".html", '_self')
});


/*================ ROMBEL SMP =================*/
function isiMasterRombelSMP() {
	var ketsekolah = $("#txttransketkurikulum").val();
	var kabupaten = $("#lblkodekabupaten-datamart").val();
	var filterrombel = $("#cbofilterrombelSMP").val();

	$.ajax({
		type: "POST",
		url: "aksi/rombel/isi_tabel_rombel.php",
		data: { ketsekolah: ketsekolah, kabupaten: kabupaten, filterrombel: filterrombel },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelRombelSMP').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttssekolah == "NEGERI") {
					var warna = "badge-soft-info";//var warna = "badge-soft-light";
				} else if (data[i].sttssekolah == "SWASTA") {
					var warna = "badge-soft-warning";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="6%">' + data[i].no + '</td>' +
					'<td class="align-middle text-center" width="10%">' + data[i].npsn + '</td>' +
					'<td class="align-middle text-truncate" width="50%" style="max-width:150px;">' + data[i].nmsekolah + '</td>' +
					'<td class="align-middle text-center" width="10%"><span class="badge ' + warna + ' rounded-pill">' + data[i].sttssekolah + '</span></td>' +
					'<td class="align-middle text-center" width="4%"><strong>' + data[i].jmlrombel + '</strong></td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel7 + '</td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel8 + '</td>' +
					'<td class="align-middle text-center" width="4%">' + data[i].rombel9 + '</td>' +
					'<td class="align-middle text-center text-primary" width="4%"><strong>' + data[i].jumK13 + '</strong></td>' +
					'<td class="align-middle text-center text-danger" width="4%"><strong>' + data[i].jumKMB + '</strong></td>' +
					'</tr>';
			}
			$('#isitabelRombelSMP').html(html);
			$("#tabelRombelSMP").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": true, "select": false, "scrollX": true,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
			$("#loading").fadeOut("slow");

		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshRombelSMP").click(function () {
	isiMasterRombelSMP();
});

$("#cmdExcelRombelSMP").on("click", function () {
	var filtermedia = $("#cbofilterrombelSMP").val();
	window.open("rombel-smp-" + filtermedia + ".html", '_self')
});

/*================ KEBUTUHAN GURU SD =================*/
function isiMasterKebutuhanSD() {
	var ketsekolah = $("#txttransketkurikulum").val();
	var kabupaten = $("#lblkodekabupaten-datamart").val();
	var filterkebutuhan = $("#cbofilterkebutuhanSD").val();
	$.ajax({
		type: "POST",
		url: "aksi/rombel/isi_tabel_kebutuhan_sd.php",
		data: { ketsekolah: ketsekolah, kabupaten: kabupaten, filterkebutuhan: filterkebutuhan },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelKebutuhanSD').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttssekolah == "NEGERI") {
					var warna = "badge-soft-info";//var warna = "badge-soft-light";
				} else if (data[i].sttssekolah == "SWASTA") {
					var warna = "badge-soft-warning";
				}

				if (data[i].kurangguru < 0) {
					var wrnkurang = "danger";
				} else if (data[i].kurangguru >= 0) {
					var wrnkurang = "primary";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="2%">' + data[i].no + '</td>' +
					'<td class="align-middle text-center" width="6%">' + data[i].npsn + '</td>' +
					//'<td class="align-middle text-truncate" width="38%" style="max-width:100px;">' + data[i].nmsekolah + '</td>' +
					'<td class="align-middle text-truncate" width="200px">' + data[i].nmsekolah + '</td>' +
					'<td class="align-middle text-center" width="6%"><span class="badge ' + warna + ' rounded-pill">' + data[i].sttssekolah + '</span></td>' +
					
					'<td class="align-middle text-center text-primary" width="2%" style="background:#F5F5DC;"><strong>' + data[i].jumK13 + '</strong></td>' +
					'<td class="align-middle text-center text-danger" width="2%" style="background:#F5F5DC;"><strong>' + data[i].jumKMB + '</strong></td>' +
					'<td class="align-middle text-center" width="2%" style="background:#F5F5DC;"><strong>' + data[i].jmlrombel + '</strong></td>' +

					'<td class="align-middle text-center text-secondary" width="2%"><strong>' + data[i].JumPTT + '</strong></td>' +
					'<td class="align-middle text-center text-secondary" width="2%"><strong>' + data[i].JumGuru + '</strong></td>' +

					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumPNS + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumPPPK + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumGTY + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumHonorer + '</td>' +
					
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealGURUKELAS + '</span> / ' + data[i].jumgurukelasideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealPJOK + '</span> / ' + data[i].jumguruPJOKideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealPAI + '</span> / ' + data[i].jumguruPAIideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealBING + '</span> / ' + data[i].jumguruBINGideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealTIK + '</span> / ' + data[i].jumguruTIKideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><strong><span class="text-danger">' + data[i].jumTotalReal + '</span> / ' + data[i].jumguruTOTALideal + '</strong></td>' +
					/*
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumgurukelasMapel + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumguruPJOKMapel + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumguruPAIMapel + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumguruBINGMapel + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumguruTIKMapel + '</td>' +
					*/
					'<td class="align-middle text-center text-' + wrnkurang + '" width="2%" style="background:#F5F5DC;"><strong>' + data[i].kurangguru + '</strong></td>' +

					'<td class="align-middle" width="2%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnViewKebutuhanSD" data-idsekolah="' + data[i].idsekolah + '" data-npsn="' + data[i].npsn + '" data-bs-toggle="tooltip" title="Pembelajaran"><span class="fas fa-cog"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelKebutuhanSD').html(html);
			$("#tabelKebutuhanSD").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": false, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
			$("#loading").fadeOut("slow");

		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshKebutuhanSD").click(function () {
	isiMasterKebutuhanSD();
});

$("#cmdExcelKebutuhanSD").on("click", function () {
	var filtermedia = $("#cbofilterkebutuhanSD").val();
	window.open("kebutuhan-guru-sd-" + filtermedia + ".html", '_self')
});

$('#isitabelKebutuhanSD').on('click', '.btnViewKebutuhanSD', function () {
	var idsekolah = $(this).data('idsekolah');var npsn = $(this).data('npsn');
	var keterangan = "SD";
	$.ajax({
		type: "POST",
		url: "aksi/tampilkan/tampilkan-detail.php",
		data: { idsekolah: idsekolah,npsn: npsn,keterangan: keterangan },
		success: function (resp) {
			$("#isianModdetailLarge").html(resp);
			$("#isianModdetailLarge").fadeIn(1000);
			$("#modDetailLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modDetailLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

/*================ KEBUTUHAN GURU SMP =================*/
function isiMasterKebutuhanSMP() {
	var ketsekolah = $("#txttransketkurikulum").val();
	var kabupaten = $("#lblkodekabupaten-datamart").val();
	var filterkebutuhan = $("#cbofilterkebutuhanSMP").val();
	$.ajax({
		type: "POST",
		url: "aksi/rombel/isi_tabel_kebutuhan_smp.php",
		data: { ketsekolah: ketsekolah, kabupaten: kabupaten, filterkebutuhan: filterkebutuhan },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelKebutuhanSMP').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttssekolah == "NEGERI") {
					var warna = "badge-soft-info";//var warna = "badge-soft-light";
				} else if (data[i].sttssekolah == "SWASTA") {
					var warna = "badge-soft-warning";
				}

				if (data[i].kurangguru < 0) {
					var wrnkurang = "danger";
				} else if (data[i].kurangguru >= 0) {
					var wrnkurang = "primary";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].npsn + '</td>' +
					'<td class="align-middle text-truncate" width="200px">' + data[i].nmsekolah + '</td>' +
					'<td class="align-middle text-center" width="8%"><span class="badge ' + warna + ' rounded-pill">' + data[i].sttssekolah + '</span></td>' +
					
					'<td class="align-middle text-center text-primary" width="4%" style="background:#F5F5DC;"><strong>' + data[i].jumK13 + '</strong></td>' +
					'<td class="align-middle text-center text-danger" width="4%" style="background:#F5F5DC;"><strong>' + data[i].jumKMB + '</strong></td>' +
					'<td class="align-middle text-center" width="3%" style="background:#F5F5DC;"><strong>' + data[i].jmlrombel + '</strong></td>' +

					'<td class="align-middle text-center text-secondary" width="2%"><strong>' + data[i].JumPTT + '</strong></td>' +
					'<td class="align-middle text-center text-secondary" width="2%"><strong>' + data[i].JumGuru + '</strong></td>' +

					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumPNS + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumPPPK + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumGTY + '</td>' +
					'<td class="align-middle text-center text-600" width="2%" style="background:#F5F5DC;">' + data[i].jumHonorer + '</td>' +

					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealPPKN + '</span> / ' + data[i].jumguruPPKNideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealBIN + '</span> / ' + data[i].jumguruBINideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealBING + '</span> / ' + data[i].jumguruBINGideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealMAT + '</span> / ' + data[i].jumguruMATideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealIPS + '</span> / ' + data[i].jumguruIPSideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealIPA + '</span> / ' + data[i].jumguruIPAideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealPRAKARYA + '</span> / ' + data[i].jumguruPrakaryaideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealSENI + '</span> / ' + data[i].jumguruSeniideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealPJOK + '</span> / ' + data[i].jumguruPJOKideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealPAI + '</span> / ' + data[i].jumguruPAIideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealTIK + '</span> / ' + data[i].jumguruTIKideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><span class="text-danger">' + data[i].jumRealBK + '</span> / ' + data[i].jumguruBKideal + '</td>' +
					'<td class="align-middle text-center text-primary" width="2%"><strong><span class="text-danger">' + data[i].jumTotalReal + '</span> / ' + data[i].jumguruTOTALideal + '</strong></td>' +
					'<td class="align-middle text-center text-' + wrnkurang + '" width="2%" style="background:#F5F5DC;"><strong>' + data[i].kurangguru + '</strong></td>' +

					'<td class="align-middle" width="4%">' +
					'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnViewKebutuhanSMP" data-idsekolah="' + data[i].idsekolah + '" data-npsn="' + data[i].npsn + '" data-bs-toggle="tooltip" title="Pembelajaran"><span class="fas fa-cog"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelKebutuhanSMP').html(html);
			$("#tabelKebutuhanSMP").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": false, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
			$("#loading").fadeOut("slow");
		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshKebutuhanSMP").click(function () {
	isiMasterKebutuhanSMP();
});

$("#cmdExcelKebutuhanSMP").on("click", function () {
	var filtermedia = $("#cbofilterkebutuhanSMP").val();
	window.open("kebutuhan-guru-smp-" + filtermedia + ".html", '_self')
});

$('#isitabelKebutuhanSMP').on('click', '.btnViewKebutuhanSMP', function () {
	var idsekolah = $(this).data('idsekolah');var npsn = $(this).data('npsn');
	var keterangan = "SMP";
	$.ajax({
		type: "POST",
		url: "aksi/tampilkan/tampilkan-detail.php",
		data: { idsekolah: idsekolah,npsn: npsn,keterangan: keterangan },
		success: function (resp) {
			$("#isianModdetailLarge").html(resp);
			$("#isianModdetailLarge").fadeIn(1000);
			$("#modDetailLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modDetailLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

/*================ PTK =================*/
function isiMasterPTK() {
	var filtersekolah = $("#cbofilterPTK").val();
	$.ajax({
		type: "POST",
		url: "aksi/ptk/isi_tabel_ptk.php",
		data: { filtersekolah: filtersekolah },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelPTK').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if (data[i].sttssekolah == "NEGERI") {
					var warna = "badge-soft-info";
				} else if (data[i].sttssekolah == "SWASTA") {
					var warna = "badge-soft-warning";
				}

				html +=
					'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle text-center" width="4%">' + data[i].no + '</td>' +
					'<td class="align-middle text-center" width="8%">' + data[i].npsn + '</td>' +
					'<td class="align-middle text-truncate" width="200px">' + data[i].nmsekolah + '</td>' +
					'<td class="align-middle text-center" width="8%"><span class="badge ' + warna + ' rounded-pill">' + data[i].sttssekolah + '</span></td>' +

					'<td class="align-middle text-center text-secondary" width="3%"><strong>' + data[i].JumPTT + '</strong></td>' +
					'<td class="align-middle text-center text-secondary" width="3%"><strong>' + data[i].JumGuru + '</strong></td>' +

					'<td class="align-middle text-center text-600" width="3%" style="background:#F5F5DC;">' + data[i].jumPNS + '</td>' +
					'<td class="align-middle text-center text-600" width="3%" style="background:#F5F5DC;">' + data[i].jumPPPK + '</td>' +
					'<td class="align-middle text-center text-600" width="3%" style="background:#F5F5DC;">' + data[i].jumGTY + '</td>' +
					'<td class="align-middle text-center text-600" width="3%" style="background:#F5F5DC;">' + data[i].jumHonorer + '</td>' +

					'<td class="align-middle text-center" width="4%">' +
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1 btnViewPTK" data-idsekolah="' + data[i].idsekolah + '" data-npsn="' + data[i].npsn + '" data-nmsekolah="' + data[i].nmsekolah + '" data-bs-toggle="tooltip" title="Detail PTK"><span class="fas fa-user-friends"></span></button>' +
					'</td>' +
					'</tr>';
			}
			$('#isitabelPTK').html(html);
			$("#tabelPTK").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": false, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
			$("#loading").fadeOut("slow");
		},
		error: function () {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshPTK").click(function () {
	isiMasterPTK();
});

$("#cmdExcelPTK").on("click", function () {
	var filtersekolah = $("#cbofilterPTK").val();
	window.open("data-ptk-" + filtersekolah + ".html", '_self')
});

$('#isitabelPTK').on('click', '.btnViewPTK', function () {
	var idsekolah = $(this).data('idsekolah');var npsn = $(this).data('npsn');var nmsekolah = $(this).data('nmsekolah');
	$.ajax({
		type: "POST",
		url: "aksi/ptk/tampilkan-list-ptk.php",
		data: { idsekolah: idsekolah,npsn: npsn,nmsekolah: nmsekolah },
		success: function (resp) {
			$("#isianModdetailLarge").html(resp);
			$("#isianModdetailLarge").fadeIn(1000);
			$("#modDetailLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modDetailLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});
