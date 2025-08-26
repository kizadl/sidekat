$("#lv_kegiatan").click(function () {
    bersihkan();
    $("#area-halaman-utama").fadeOut("slow");
    $("#area-upload-video").fadeOut("slow");
    $("#area-halaman-sekolah").fadeOut("slow");
    $("#area-upload-foto").fadeOut("slow");
    $("#area-halaman-kegiatan").fadeIn();

    $("#div-video").html("")

    $("#txttransid").val("");
    $("#txttransketerangan").val("");
    $("#txttransnmwilayah").val("");
    //map.closePopup();
    isiListKegiatan();
});

function isiListKegiatan() {
	var filterinfo = $('#cbofilterkegiatan').val();
    var idsekolah = $('#lblidsekolah').val();
	$.ajax({
		type: "POST",
		url: "aksi/isi_tabel_kegiatan.php",
		data: { filterinfo: filterinfo,idsekolah: idsekolah },
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			document.body.style.cursor = "default";
			$('#tabelKegiatan').dataTable().fnDestroy();
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {

				if(data[i].headline == "Y"){
					var wrnhead = "bg-primary";
				} else if(data[i].headline == "N"){
					var wrnhead = "bg-warning";
				}

				html +=
				'<tr class="btn-reveal-trigger">' +
					'<td class="align-middle" width="16%">' +
						'<a href="#" class="d-flex gap-3 align-items-center position-relative"><img class="rounded-1 border border-200 btnTampilFoto" data-idkegiatan="'+data[i].idkegiatan+'" src="../data-media/foto/headline/' + data[i].idkegiatan + '.jpeg" width="100" alt="" onerror=this.onerror=null;this.src="../data-media/headline.jpeg" /></a>' +
					'</td>' +
					'<td class="align-middle" width="25%">'+data[i].hari+', '+data[i].tanggal+'<br/><span class="text-primary">' + data[i].judul + '</span></td>' +
					'<td class="align-middle" width="49%">' + data[i].isikegiatan + '</td>' +
					'<td class="align-middle text-center" width="3%"><span class="badge '+wrnhead+'">'+data[i].headline+'</span></td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnUploadKegiatan" data-idkegiatan="'+data[i].idkegiatan+'"><span class="fas fa-upload"></span></button> '+
					'</td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditKegiatan" data-idkegiatan="'+data[i].idkegiatan+'"><span class="fas fa-edit"></span></button> '+
					'</td>' +
					'<td class="align-middle" width="2%">'+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnHapusKegiatan" data-idkegiatan="'+data[i].idkegiatan+'" data-tanggal="'+data[i].tanggal+'" data-judul="'+data[i].judul+'"><span class="fas fa-trash-alt"></span></button> '+
					'</td>' +
				'</tr>';
			}
			$('#isitabelKegiatan').html(html);
			$("#tabelKegiatan").dataTable({
				"paging": true, "lengthChange": false, "ordering": true, "info": false, "autoWidth": true, "responsive": true, "select": false, "scrollX": false,
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

$("#cmdRefreshKegiatan").click(function () {
	isiListKegiatan();
});

$("#cmdTambahKegiatan").click(function () {
	$.ajax({
		type: "POST",
		url: "aksi/kegiatan/tambah_kegiatan.php",
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelKegiatan').on('click', '.btnTampilFoto', function () {
	var idkegiatan = $(this).data('idkegiatan');
	$.ajax({
		type: "POST",
		url: "aksi/kegiatan/tampilkan-foto-kegiatan.php",
		data: { idkegiatan: idkegiatan },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelKegiatan').on('click', '.btnUploadKegiatan', function () {
	var idkegiatan = $(this).data('idkegiatan');
	$.ajax({
		type: "POST",
		url: "aksi/kegiatan/form-upload-kegiatan.php",
		data: { idkegiatan: idkegiatan },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelKegiatan').on('click', '.btnEditKegiatan', function () {
	var idkegiatan = $(this).data('idkegiatan');
	$.ajax({
		type: "POST",
		url: "aksi/kegiatan/edit_kegiatan.php",
		data: { idkegiatan: idkegiatan },
		success: function (resp) {
			$("#isianModTambahDataLarge").html(resp);
			$("#isianModTambahDataLarge").fadeIn(1000);
			$("#modTambahDataLarge").modal({ backdrop: 'static', keyboard: false })
			$("#modTambahDataLarge").modal('show');
		},
		error: function () { alert('Koneksi bermasalah periksa internet'); },
	});
});

$('#isitabelKegiatan').on('click', '.btnHapusKegiatan', function () {
	var idkegiatan = $(this).data('idkegiatan'); 
	var tanggal = $(this).data('tanggal');
	var judul = $(this).data('judul');
	
	let text = "Yakin Anda menghapus data kegiatan sekolah\nTanggal " + tanggal + "\n" + judul;
	if (confirm(text) == true) {
		$.ajax({
			type: "POST",
			url: "aksi/kegiatan/aksi_hapus.php",
			data: { idkegiatan: idkegiatan },
			success: function (resp) {
				$("#ToastSukses").toast("show");
				isiListKegiatan();
			},
			error: function () { alert('Koneksi bermasalah periksa internet'); },
		});
	}
});
