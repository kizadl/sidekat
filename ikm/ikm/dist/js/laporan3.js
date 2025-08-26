
/*================ LAPORAN =================*/
function isiLaporan() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();
	var idinstansi = $('#lblidinstansi').val();
	var idinduk = $('#lblidinduk').val();
	$.ajax({
		type: "POST",
		url: "ikm/aksi/isi_laporan_admin.php",
		data: { idinstansi: idinstansi, idinduk: idinduk, tglawal: tglawal, tglakhir: tglakhir },
		dataType: 'json',
		beforeSend: function (e) {
			$('#lblDBjumTPlaporan').html(''); $('#lblDBjumKPlaporan').html(''); $('#lblDBjumPlaporan').html(''); $('#lblDBjumSPlaporan').html('');
			$('#lblDBpersenTPlaporan').html(''); $('#lblDBpersenKPlaporan').html(''); $('#lblDBpersenPlaporan').html(''); $('#lblDBpersenSPlaporan').html('');
			$("#loading").fadeIn(); toastr.remove();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#lblDBjumTPlaporan').html(''); $('#lblDBjumKPlaporan').html(''); $('#lblDBjumPlaporan').html(''); $('#lblDBjumSPlaporan').html('');
			$('#lblDBpersenTPlaporan').html(''); $('#lblDBpersenKPlaporan').html(''); $('#lblDBpersenPlaporan').html(''); $('#lblDBpersenSPlaporan').html('');
			myArray = data;
			$.each(myArray, function (index, jum) {
				$('#lblDBjumTPlaporan').html(jum.jumTP); $('#lblDBjumKPlaporan').html(jum.jumKP); $('#lblDBjumPlaporan').html(jum.jumP); $('#lblDBjumSPlaporan').html(jum.jumSP);
				$('#lblDBpersenTPlaporan').html(jum.perTP); $('#lblDBpersenKPlaporan').html(jum.perKP); $('#lblDBpersenPlaporan').html(jum.perP); $('#lblDBpersenSPlaporan').html(jum.perSP);
				$("#loading").fadeOut("slow");
				document.body.style.cursor = "default";
				toastr.info('Refresh data detail laporan sukses');
			});
		},
		error: function () {
			$("#loading").fadeOut("slow");
			//toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";
		},
	});
}

function isiTabelLaporan() {
	
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var akses = $("#lblakses").val();
	var halaman = $("#lblhalaman").val();
	var idinstansi = $('#lblidinstansi').val();
	var idinduk = $('#lblidinduk').val();
	$("#lbltransjmldata").val(0);
	$.ajax({
		type: "POST",
		url: "ikm/aksi/isi_tabel_laporan_admin.php",
		data: { idinstansi: idinstansi, idinduk: idinduk, tglawal: tglawal, tglakhir: tglakhir },
		dataType: 'json',
		success: function (data) {
			$('#tblDashboardlaporan').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				$("#lbltransjmldata").val(data[i].no);
				html +=
					'<tr>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].no + '</td>' +
					'<td align="left" style="vertical-align:middle;">' + data[i].nama + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].umur + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].kelamin + '</td>' +
					'<td align="left" style="vertical-align:middle;">' + data[i].nmpendidikan + '</td>' +
					'<td align="left" style="vertical-align:middle;">' + data[i].nmpekerjaan + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n1 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n2 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n3 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n4 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n5 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n6 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n7 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n8 + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].n9 + '</td>' +
					'<td align="center" class="text-blue" style="vertical-align:middle;">' + data[i].jmlskor + '</td>' +
					'</tr>';
			}
			$('#isitabelDashboardlaporan').html(html);
			$("#tblDashboardlaporan").dataTable({
				"paging": true, "lengthChange": true, "ordering": true, "info": true, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
				initComplete: function () { $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off'); }, "searching": true,
			});
			$("#loading").fadeOut("slow");
		},
		error: function () {
			$("#loading").fadeOut("slow");
			document.body.style.cursor = "default";
		},
	});
}

$("#cmdRefreshLaporan").click(function () {
	periodeIndo();
	isiLaporan(); isiTabelLaporan();
});

//////////////////////////
////// export excel //////
//////////////////////////
function LaporanSurvei() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();

	var jmldata = $("#lbltransjmldata").val();
	if (jmldata == 0) { alert("Maaf, tidak ada data yang akan ditampilkan\nJumlah data 0 (nol)"); }
	else {
		var idinstansi = $('#lblidinstansi').val();
		window.open('ikm/laporan-excel/excel_lap_survei_admin.php?idinstansi=' + idinstansi + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir);
	}
}

function rekapUmur() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();

	var jmldata = $("#lbltransjmldata").val();
	if (jmldata == 0) { alert("Maaf, tidak ada data yang akan ditampilkan\nJumlah data 0 (nol)"); }
	else {
		var idinstansi = $('#lblidinstansi').val();
		var idinduk = $('#lblidinduk').val();
		window.open('ikm/laporan-excel/excel_lap_umur_admin.php?idinstansi=' + idinstansi + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir);
	}
}

function rekapPekerjaan() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();

	var jmldata = $("#lbltransjmldata").val();
	if (jmldata == 0) { alert("Maaf, tidak ada data yang akan ditampilkan\nJumlah data 0 (nol)"); }
	else {

		var idinstansi = $('#lblidinstansi').val();
		var idinduk = $('#lblidinduk').val();
		window.open('ikm/laporan-excel/excel_lap_pekerjaan_admin.php?idinstansi=' + idinstansi + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir);
	}
}

function rekapPendidikan() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();

	var jmldata = $("#lbltransjmldata").val();
	if (jmldata == 0) { alert("Maaf, tidak ada data yang akan ditampilkan\nJumlah data 0 (nol)"); }
	else {

		var idinstansi = $('#lblidinstansi').val();
		var idinduk = $('#lblidinduk').val();
		window.open('ikm/laporan-excel/excel_lap_pendidikan_admin.php?idinstansi=' + idinstansi + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir);

	}
}

function rekapKelamin() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();

	var jmldata = $("#lbltransjmldata").val();
	if (jmldata == 0) { alert("Maaf, tidak ada data yang akan ditampilkan\nJumlah data 0 (nol)"); }
	else {
		var idinstansi = $('#lblidinstansi').val();
		var idinduk = $('#lblidinduk').val();
		window.open('ikm/laporan-excel/excel_lap_kelamin_admin.php?idinstansi=' + idinstansi + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir);
	}
}

function LaporanDetail() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();

	var jmldata = $("#lbltransjmldata").val();
	if (jmldata == 0) { alert("Maaf, tidak ada data yang akan ditampilkan\nJumlah data 0 (nol)"); }
	else {
		var idinstansi = $('#lblidinstansi').val();
		var idinduk = $('#lblidinduk').val();
		window.open('ikm/laporan-excel/excel_lap_detail_admin.php?idinstansi=' + idinstansi + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir);
	}
}

function LaporanKritik() {
	var tglawal = $("#txttglawal").val(); var tglakhir = $("#txttglakhir").val();
	var halaman = $("#lblhalaman").val();
	var akses = $("#lblakses").val();

	var jmldata = $("#lbltransjmldata").val();
	if (jmldata == 0) { alert("Maaf, tidak ada data yang akan ditampilkan\nJumlah data 0 (nol)"); }
	else {
		var idinstansi = $('#lblidinstansi').val();
		var idinduk = $('#lblidinduk').val();
		window.open('ikm/laporan-excel/excel_lap_kritik_admin.php?idinstansi=' + idinstansi + '&tglawal=' + tglawal + '&tglakhir=' + tglakhir);
	}
}
