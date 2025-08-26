/*================ PENDIDIKAN =================*/
function isiMasterPendidikan(){
		
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "ikm/aksi/isi_tabel_pendidikan.php",
		data: {idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			$('#tblPendidikan').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			toastr.info('Refresh master data pendidikan sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].pendidikan+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnEditPendidikan" data-id="'+data[i].idpendidikan+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelPendidikan').html(html);
				$("#tblPendidikan").dataTable({"paging": false,"lengthChange": false,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
				initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshPendidikan").click(function(){
	toastr.remove();
	isiMasterPendidikan();
});

$("#cmdTambahPendidikan").click(function(){
	toastr.remove();
	$.ajax({
		type:"POST",
		url :"ikm/aksi/pendidikan/tambah_pendidikan.php",
		success:function(resp){
			$("#isianModPendidikan").html(resp);
			$("#isianModPendidikan").fadeIn(1000);
			$("#ModTambahPendidikan").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTambahPendidikan").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelPendidikan').on('click','.btnEditPendidikan',function(){
	toastr.remove();
	var idpendidikan = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"ikm/aksi/pendidikan/edit_pendidikan.php",	
		data:{idpendidikan:idpendidikan},
		success:function(resp){
			$("#isianModPendidikanedit").html(resp);
			$("#isianModPendidikanedit").fadeIn(1000);
			$("#ModEditPendidikan").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditPendidikan").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ PEKERJAAN =================*/
function isiMasterPekerjaan(){
	
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "ikm/aksi/isi_tabel_pekerjaan.php",
		data: {idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			$('#tblPekerjaan').dataTable().fnDestroy();	
			document.body.style.cursor = "default";
			toastr.info('Refresh master data pekerjaan sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].pekerjaan+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnEditPekerjaan" data-id="'+data[i].idpekerjaan+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelPekerjaan').html(html);
				$("#tblPekerjaan").dataTable({"paging": false,"lengthChange": false,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
				initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshPekerjaan").click(function(){
	toastr.remove();
	isiMasterPekerjaan();
});

$("#cmdTambahPekerjaan").click(function(){
	toastr.remove();
	$.ajax({
		type:"POST",
		url :"ikm/aksi/pekerjaan/tambah_pekerjaan.php",
		success:function(resp){
			$("#isianModPekerjaan").html(resp);
			$("#isianModPekerjaan").fadeIn(1000);
			$("#ModTambahPekerjaan").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTambahPekerjaan").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelPekerjaan').on('click','.btnEditPekerjaan',function(){
	toastr.remove();
	var idpekerjaan = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"ikm/aksi/pekerjaan/edit_pekerjaan.php",	
		data:{idpekerjaan:idpekerjaan},
		success:function(resp){
			$("#isianModPekerjaanedit").html(resp);
			$("#isianModPekerjaanedit").fadeIn(1000);
			$("#ModEditPekerjaan").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditPekerjaan").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ UNSUR =================*/
function isiMasterUnsur(){
	
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "ikm/aksi/isi_tabel_unsur.php",
		data: {idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			$('#tblUnsur').dataTable().fnDestroy();	
			document.body.style.cursor = "default";
			toastr.info('Refresh data unsur penilaian sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].unsur+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnEditUnsur" data-id="'+data[i].idunsur+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelUnsur').html(html);
				$("#tblUnsur").dataTable({"paging": false,"lengthChange": false,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
				initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshUnsur").click(function(){
	toastr.remove();
	isiMasterUnsur();
});

$('#isitabelUnsur').on('click','.btnEditUnsur',function(){
	toastr.remove();
	var idunsur = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"ikm/aksi/unsur/edit_unsur.php",	
		data:{idunsur:idunsur},
		success:function(resp){
			$("#isianModUnsuredit").html(resp);
			$("#isianModUnsuredit").fadeIn(1000);
			$("#ModEditUnsur").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditUnsur").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ SOAL =================*/
function isiMasterSoal(){
		
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "ikm/aksi/isi_tabel_soal.php",
		data:{idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			$('#tblSoal').dataTable().fnDestroy();	
			document.body.style.cursor = "default";
			toastr.info('Refresh data pengaturan soal sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 		
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].soal+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].TP+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].KP+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].P+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].SP+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnEditSoal" data-id="'+data[i].idsoal+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelSoal').html(html);
				$("#tblSoal").dataTable({"paging": false,"lengthChange": false,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
				initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshSoal").click(function(){
	toastr.remove();
	isiMasterSoal();
});

$('#isitabelSoal').on('click','.btnEditSoal',function(){
	toastr.remove();
	var idsoal = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"ikm/aksi/soal/edit_soal.php",	
		data:{idsoal:idsoal},
		success:function(resp){
			$("#isianModSoaledit").html(resp);
			$("#isianModSoaledit").fadeIn(1000);
			$("#ModEditSoal").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditSoal").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ SOAL STANDART =================*/
function isiMasterSoalStandart(){
			
	$.ajax({
		type:"POST",
		url : "ikm/aksi/isi_tabel_soal_standart.php",
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			$('#tblSoalStd').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			toastr.info('Refresh data standarisasi soal sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 		
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].soal+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].TP+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].KP+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].P+'</td>'+
						'<td align="center" class="text-info" style="vertical-align:middle;">'+data[i].SP+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnEditSoalStd" data-id="'+data[i].idsoal+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelSoalStd').html(html);
				$("#tblSoalStd").dataTable({"paging": false,"lengthChange": false,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
				initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshSoalStd").click(function(){
	toastr.remove();
	isiMasterSoalStandart();
});

$("#cmdTambahSoalStd").click(function(){
	toastr.remove();
	$.ajax({
		type:"POST",
		url :"ikm/aksi/soal-standart/tambah_soal_std.php",	
		success:function(resp){
			$("#isianModSoalStd").html(resp);
			$("#isianModSoalStd").fadeIn(1000);
			$("#ModTambahSoalStd").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTambahSoalStd").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelSoalStd').on('click','.btnEditSoalStd',function(){
	toastr.remove();
	var idsoal = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"ikm/aksi/soal-standart/edit_soal_std.php",	
		data:{idsoal:idsoal},
		success:function(resp){
			$("#isianModSoaleditStd").html(resp);
			$("#isianModSoaleditStd").fadeIn(1000);
			$("#ModEditSoalStd").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditSoalStd").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});