/*================ TRANSAKSI TITIPAN =================*/
function isiTransaksiTitipan(){
	$('#tblTransTTP').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_titipan.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh transaksi terima titipan sukses')
            var html = '';$('#lbltotalTransTTP').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].alamat+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+
						'<td align="right" style="vertical-align:middle;">'+data[i].jmltitipan+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].jumnota+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnTerimaTTP" data-idcustomer="'+data[i].idcustomer+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';
$('#lbltotalTransTTP').text(data[i].jmltotal);					
                }				
				$('#isitabelTransTTP').html(html);
				$("#tblTransTTP").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransTTP").click(function(){
	toastr.remove();
	isiTransaksiTitipan();
});

$('#isitabelTransTTP').on('click','.btnTerimaTTP',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idcustomer = $(this).data('idcustomer');var idpenerima = $('#lbleditor').val();
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-titipan/terima_titipan.php",	
		data:{idcabang:idcabang,idcustomer:idcustomer,idpenerima:idpenerima},
		success:function(resp){
			$("#isianModTerimaTitipan").html(resp);
			$("#isianModTerimaTitipan").fadeIn(1000);
			$("#ModTerimaTitipan").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTerimaTitipan").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

///////////////////////////////////////////////////////////////
/*====================== TRANSAKSI BIAYA ===================*/
///////////////////////////////////////////////////////////////
function isiTransaksiBiaya(){
	$('#tblTransCO').dataTable().fnDestroy();	
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawal").val();
	var tglakhir = $("#txttglakhir").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_biaya.php",
		data: {idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh transaksi cash out sukses')
            var html = '';$('#lbltotalTransBiaya').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].tgledit+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmbiaya+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmkategori+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].rincian+'</td>'+
						'<td align="right" class="text-danger" style="vertical-align:middle;">'+data[i].jumlah+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnEditTransCO" data-idtrans="'+data[i].idtransbiaya+'" '+data[i].disfee+'><i class="fas fa-pencil-alt"></i></button> '+
							'<button class="btn btn-tool text-danger btnHapusTransCO" data-idtrans="'+data[i].idtransbiaya+'" data-nmbiaya="'+data[i].nmbiaya+'" data-nmkategori="'+data[i].nmkategori+'" data-rincian="'+data[i].rincian+'" data-jumlah="'+data[i].jumlah+'" '+data[i].disfee+'><i class="far fa-trash-alt"></i></button>'+						
						'</td>'+
					'</tr>';
$('#lbltotalTransBiaya').text(data[i].jmltotal);// jumlah total footer card					
                }				
				$('#isitabelTransCO').html(html);
				$("#tblTransCO").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});	
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransCO").click(function(){
	toastr.remove();
	isiTransaksiBiaya();
});

$("#cmdTambahTransCO").click(function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url :"aksi/transaksi-biaya/tambah_trans_biaya.php",
		data:{idcabang:idcabang},
		success:function(resp){
			$("#isianModTransBiaya").html(resp);
			$("#isianModTransBiaya").fadeIn(1000);
			$("#ModTransBiaya").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTransBiaya").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelTransCO').on('click','.btnEditTransCO',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();
	var idtransbiaya = $(this).data('idtrans');
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-biaya/edit_trans_biaya.php",	
		data:{idcabang:idcabang,idtransbiaya:idtransbiaya},
		success:function(resp){
			$("#isianModTransBiayaedit").html(resp);
			$("#isianModTransBiayaedit").fadeIn(1000);
			$("#ModEditTransBiaya").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditTransBiaya").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelTransCO').on('click','.btnHapusTransCO',function(){
	toastr.remove();
	$("#cmdHapusTransBiaya").removeAttr("disabled");
	$("#cmdBatalHapusTransBiaya").removeAttr("disabled");
	$(".modal-body").css("opacity", "");
	$('#pesanHapusTransBiaya').html('');
	$('#txtidTransBiayaHapus').val('');

	var idtrans = $(this).data('idtrans');
	var nmbiaya = $(this).data('nmbiaya');var nmkategori = $(this).data('nmkategori');
	var rincian = $(this).data('rincian');var jumlah = $(this).data('jumlah');
	$('#txtidTransBiayaHapus').val(idtrans);

	$('#pesanHapusTransBiaya').html('Yakin, Anda menghapus data transaksi<br>POS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  <b>'+ nmbiaya +'</b><br>Kategori &nbsp;:  '+ nmkategori + '<br>'+ rincian + '<br>Rp. '+ jumlah +',-');
	$("#ModHapusTransBiaya").modal({backdrop:'static', keyboard:false});
	$("#ModHapusTransBiaya").modal('show');
});

$("#cmdHapusTransBiaya").click(function(){
	var idtransaksi = $('#txtidTransBiayaHapus').val();
	$.ajax({
		type:"POST",
		url :"aksi/transaksi-biaya/aksi_hapus.php",
		data:{idtransaksi:idtransaksi},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdHapusTransBiaya").attr("disabled","disabled");
			$("#cmdBatalHapusTransBiaya").attr("disabled","disabled");
		},				
		success:function(resp){
			$("#pesanHapusTransBiaya").html(resp.msg1);				
			setTimeout(function(){ $('#ModHapusTransBiaya').modal('hide');},1000);
			isiTransaksiBiaya();
		},
		error: function() {alert('Koneksi bermasalah periksa internet');
			$("#cmdHapusTransBiaya").removeAttr("disabled","disabled");
			$("#cmdBatalHapusTransBiaya").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});			
});	

/*================ TRANSAKSI ITJ =================*/
function isiTransaksiITJ(){
	$('#tblTransITJ').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_itj.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh data transaksi ITJ sukses')
            var html = '';$('#lbltotalTransITJ').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmsales+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].harga+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].itj+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnTerimaITJ" data-idpiutang="'+data[i].idpiutang+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';
$('#lbltotalTransITJ').text(data[i].jmltotal);					
                }				
				$('#isitabelTransITJ').html(html);
				$("#tblTransITJ").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransITJ").click(function(){
	toastr.remove();
	isiTransaksiITJ();
});

$('#isitabelTransITJ').on('click','.btnTerimaITJ',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idpiutang = $(this).data('idpiutang');
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-itj/terima_itj.php",	
		data:{idcabang:idcabang,idpiutang:idpiutang},
		success:function(resp){
			$("#isianModTerimaITJ").html(resp);
			$("#isianModTerimaITJ").fadeIn(1000);
			$("#ModTerimaITJ").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTerimaITJ").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ TRANSAKSI DP =================*/
function isiTransaksiDP(){
	$('#tblTransDP').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_dp.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh transaksi terima DP sukses')
            var html = '';$('#lbltotalTransDP').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].harga+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].sisadp+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tenordp+'</td>'+
						'<td align="right" style="vertical-align:middle;">'+data[i].jmlangsurdp+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnTerimaDP" data-idpiutang="'+data[i].idpiutang+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';
$('#lbltotalTransDP').text(data[i].jmltotal);					
                }				
				$('#isitabelTransDP').html(html);
				$("#tblTransDP").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransDP").click(function(){
	toastr.remove();
	isiTransaksiDP();
});

$('#isitabelTransDP').on('click','.btnTerimaDP',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idpiutang = $(this).data('idpiutang');
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-dp/terima_dp.php",	
		data:{idcabang:idcabang,idpiutang:idpiutang},
		success:function(resp){
			$("#isianModTerimaDP").html(resp);
			$("#isianModTerimaDP").fadeIn(1000);
			$("#ModTerimaDP").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTerimaDP").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ TRANSAKSI PIUTANG =================*/
function isiTransaksiPiutang(){
	$('#tblTransPiutang').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_piutang.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh transaksi terima piutang sukses')
            var html = '';$('#lbltotalTransPiutang').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].harga+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].angsuransisa+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tenorangsuran+'</td>'+
						'<td align="right" style="vertical-align:middle;">'+data[i].jmlangsurpiutang+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnTerimaPiutang" data-idpiutang="'+data[i].idpiutang+'"><i class="fas fa-pencil-alt"></i></button> '+
						'</td>'+
					'</tr>';
$('#lbltotalTransPiutang').text(data[i].jmltotal);					
                }				
				$('#isitabelTransPiutang').html(html);
				$("#tblTransPiutang").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransPiutang").click(function(){
	toastr.remove();
	isiTransaksiPiutang();
});

$('#isitabelTransPiutang').on('click','.btnTerimaPiutang',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idpiutang = $(this).data('idpiutang');
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-piutang/terima_piutang.php",	
		data:{idcabang:idcabang,idpiutang:idpiutang},
		success:function(resp){
			$("#isianModTerimaPiutang").html(resp);
			$("#isianModTerimaPiutang").fadeIn(1000);
			$("#ModTerimaPiutang").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTerimaPiutang").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});


/*================ TRANSAKSI BAYAR FEE=================*/
function isiTransaksiBayarFee(){
	$('#tblTransFee').dataTable().fnDestroy();	
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_fee.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh transaksi fee marketing sukses')
            var html = '';$('#lbltotalTransFee').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmkaryawan+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].bagian+'</td>'+
						'<td class="text-muted" align="center" style="vertical-align:middle;">'+data[i].fee+'</td>'+
						'<td class="text-muted" align="center" style="vertical-align:middle;">'+data[i].notasales+'</td>'+	
						'<td class="text-primary" align="right" style="vertical-align:middle;">'+data[i].feesales+'</td>'+
						'<td class="text-danger" align="right" style="vertical-align:middle;">'+data[i].byrsales+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].sisasales+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-muted btnViewFee" data-idkaryawan="'+data[i].idkaryawan+'" data-nmkaryawan="'+data[i].nmkaryawan+'" data-jabatan="'+data[i].bagian+'" data-nota="'+data[i].notasales+'" data-jumlah="'+data[i].feesales+'" data-bayar="'+data[i].byrsales+'" data-sisa="'+data[i].sisasales+'" '+data[i].dishide+'><i class="fas fa-search"></i></button> '+						
						'</td>'+
					'</tr>';
$('#lbltotalTransFee').text(data[i].jmltotal);						
                }				
				$('#isitabelTransFee').html(html);
				$("#tblTransFee").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransFee").click(function(){
	toastr.remove();
	isiTransaksiBayarFee();
});

$('#isitabelTransFee').on('click','.btnViewFee',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idkaryawan = $(this).data('idkaryawan');var nmkaryawan = $(this).data('nmkaryawan');var jabatan = $(this).data('jabatan');
	var nota= $(this).data('nota');var jumlah = $(this).data('jumlah');
	var bayar= $(this).data('bayar');var sisa = $(this).data('sisa');
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-bayar-fee/view_fee.php",	
		data:{idcabang:idcabang,idkaryawan:idkaryawan,nmkaryawan:nmkaryawan,jabatan:jabatan,nota:nota,jumlah:jumlah,bayar:bayar,sisa:sisa},
		success:function(resp){
			$("#isianModVieewFee").html(resp);
			$("#isianModVieewFee").fadeIn(1000);
			$("#ModViewFee").modal({backdrop: 'static', keyboard: false}) 
			$("#ModViewFee").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ TRANSAKSI CANCEL CUSTOMER =================*/
function isiTransaksiCancel(){
	$('#tblcancelCustomer').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_cancel.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh tabel data customer sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+'-'+data[i].type+'</td>'+
						'<td class="text-primary" align="right" style="vertical-align:middle;">'+data[i].harga+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].bayar+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].jmltitipan+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].bayarmarketing+'</td>'+
						'<td class="text-red" align="right" style="vertical-align:middle;">'+data[i].hutmarketing+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-danger btnCancelCus" data-id="'+data[i].idcustomer+'"><i class="fas fa-ban"></i></button>'+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelcancelCustomer').html(html);
				$("#tblcancelCustomer").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransCancel").click(function(){
	toastr.remove();
	isiTransaksiCancel();
});

$('#isitabelcancelCustomer').on('click','.btnCancelCus',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idcustomer = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-cancel/tambah_cancel.php",	
		data:{idcabang:idcabang,idcustomer:idcustomer},
		success:function(resp){
			$("#isianModCancelCus").html(resp);
			$("#isianModCancelCus").fadeIn(1000);
			$("#ModCancelCus").modal({backdrop: 'static', keyboard: false}) 
			$("#ModCancelCus").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

/*================ TRANSAKSI UPGRADE CUSTOMER =================*/
function isiTransaksiUpgrade(){
	$('#tblUpgradeCustomer').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_trans_upgrade.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh tabel data customer sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+'-'+data[i].type+'</td>'+
						'<td class="text-primary" align="right" style="vertical-align:middle;">'+data[i].harga+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].bayar+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].jmltitipan+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-primary btnUpgradeCus" data-id="'+data[i].idcustomer+'"><i class="fas fa-arrow-circle-up"></i></button>'+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelUpgradeCustomer').html(html);
				$("#tblUpgradeCustomer").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshTransUpgrade").click(function(){
	toastr.remove();
	isiTransaksiUpgrade();
});

$('#isitabelUpgradeCustomer').on('click','.btnUpgradeCus',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idcustomer = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"aksi/transaksi-upgrade/tambah_upgrade.php",	
		data:{idcabang:idcabang,idcustomer:idcustomer},
		success:function(resp){
			$("#isianModUpgradeCus").html(resp);
			$("#isianModUpgradeCus").fadeIn(1000);
			$("#ModUpgradeCus").modal({backdrop: 'static', keyboard: false}) 
			$("#ModUpgradeCus").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});
