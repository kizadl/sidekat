/*================ DATA CUSTOMER =================*/
function isiLaporanCustomer(){
	$('#tblLapCustomer').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_customer.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan data customer sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 		
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].alamat+' - '+data[i].kota+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+
						'<td class="text-danger" align="center" style="vertical-align:middle;">'+data[i].jt+'</td>'+
						'<td class="text-info" align="center" style="vertical-align:middle;">'+data[i].tglawal+'</td>'+
					'</tr>';					
                }				
				$('#isitabelLapCustomer').html(html);
				$("#tblLapCustomer").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapCustomer").click(function(){
	toastr.remove();
	isiLaporanCustomer();
});

/*================ LAPORAN KARTU TITIPAN =================*/
function isiLaporanKartuTitipan(){
	$('#tblLapKarTitip').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_kartu_titipan.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh kartu titipan angsuran sukses')
            var html = '';$('#lbltotalLapKarTitip').text('');
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
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].jumTitipan+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-kartu-titipan-'+data[i].mdidcustomer+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+						
						'</td>'+
					'</tr>';	
$('#lbltotalLapKarTitip').text(data[i].jmltotal);					
                }				
				$('#isitabelLapKarTitip').html(html);
				$("#tblLapKarTitip").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapKarTitip").click(function(){
	toastr.remove();
	isiLaporanKartuTitipan();
});

/*================ LAPORAN TITIPAN =================*/
function isiLaporanTitipan(){
	$('#tblLapTTP').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapTTP").val();
	var tglakhir = $("#txttglakhirLapTTP").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_titipan.php",
		data:{idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan titipan angsuran sukses')
            var html = '';$('#lbltotalLapTTP').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglterima+'</td>'+
						'<td class="text-primary" align="center" style="vertical-align:middle;">TTP'+data[i].noinvoice+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+						
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+						
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].jumlah+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-titipan-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+
						'</td>'+
					'</tr>';
$('#lbltotalLapTTP').text(data[i].jmltotal);					
                }				
				$('#isitabelLapTTP').html(html);
				$("#tblLapTTP").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapTTP").click(function(){
	toastr.remove();
	isiLaporanTitipan();
});

/*================ LAPORAN CASH IN =================*/
function isiLaporanCashIn(){
	$('#tblLapCashIn').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapCashIn").val();
	var tglakhir = $("#txttglakhirLapCashIn").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_cashin.php",
		data:{idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh penerimaan cash in sukses')
            var html = '';
			$('#lbltotalLapCashIn').text('');$('#lbltotalcashLapCashIn').text('');$('#lbltotalklaimLapCashIn').text('');$('#lbltotalkembaliLapCashIn').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglterima+'</td>'+
						'<td class="text-primary" align="left" style="vertical-align:middle;">'+data[i].nodep+data[i].noinvoice+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+					
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+'-'+data[i].type+'</td>'+	
						'<td align="center" style="vertical-align:middle;">'+data[i].jenis+'</td>'+	
						'<td align="right" style="vertical-align:middle;">'+data[i].titipan+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].cash+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].klaim+'</td>'+
						'<td class="text-primary" align="right" style="vertical-align:middle;">'+data[i].jumlah+'</td>'+
						'<td class="text-red" align="right" style="vertical-align:middle;">'+data[i].kembali+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-penerimaan-itj-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted" '+data[i].disinvitj+'><i class="fas fa-print"></i></a>'+
							'<a href="print-invoice-penerimaan-dp-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted" '+data[i].disinvdp+'><i class="fas fa-print"></i></a>'+
							'<a href="print-invoice-penerimaan-angsuran-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted" '+data[i].disinvpokok+'><i class="fas fa-print"></i></a>'+
						'</td>'+
					'</tr>';
$('#lbltotalLapCashIn').text(data[i].jmltotal);	$('#lbltotalcashLapCashIn').text(data[i].jmlcash);
$('#lbltotalklaimLapCashIn').text(data[i].jmlklaim);$('#lbltotalkembaliLapCashIn').text(data[i].jmlkembali);				
                }				
				$('#isitabelLapCashIn').html(html);
				$("#tblLapCashIn").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapCashIn").click(function(){
	toastr.remove();
	isiLaporanCashIn();
});

/*================ LAPORAN ITJ =================*/
function isiLaporanITJ(){
	$('#tblLapITJ').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapITJ").val();
	var tglakhir = $("#txttglakhirLapITJ").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_itj.php",
		data:{idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan penerimaan ITJ sukses')
            var html = '';$('#lbltotalLapITJ').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglterima+'</td>'+
						'<td class="text-primary" align="center" style="vertical-align:middle;">ITJ'+data[i].noinvoice+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].telepon+'</td>'+						
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+						
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].itj+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-penerimaan-itj-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+
						'</td>'+
					'</tr>';
$('#lbltotalLapITJ').text(data[i].jmltotal);					
                }				
				$('#isitabelLapITJ').html(html);
				$("#tblLapITJ").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapITJ").click(function(){
	toastr.remove();
	isiLaporanITJ();
});

/*================ LAPORAN DP =================*/
function isiLaporanDP(){
	$('#tblLapDP').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapDP").val();
	var tglakhir = $("#txttglakhirLapDP").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_dp.php",
		data:{idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan penerimaan DP sukses')
            var html = '';$('#lbltotalLapDP').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglterima+'</td>'+
						'<td class="text-primary" align="center" style="vertical-align:middle;">DP'+data[i].noinvoice+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+					
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+						
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].dpjumlah+'</td>'+
						'<td class="text-info" align="center" style="vertical-align:middle;">'+data[i].jmltenor+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].dptotal+'</td>'+
						'<td class="text-info" align="center" style="vertical-align:middle;">'+data[i].ketlunas+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-penerimaan-dp-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+
						'</td>'+
					'</tr>';
$('#lbltotalLapDP').text(data[i].jmltotal);					
                }				
				$('#isitabelLapDP').html(html);
				$("#tblLapDP").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapDP").click(function(){
	toastr.remove();
	isiLaporanDP();
});

/*================ LAPORAN PIUTANG =================*/
function isiLaporanPiutang(){
	$('#tblLapPIT').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapPIT").val();
	var tglakhir = $("#txttglakhirLapPIT").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_piutang.php",
		data:{idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan terima angsuran sukses')
            var html = '';$('#lbltotalLapPIT').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglterima+'</td>'+
						'<td class="text-primary" align="center" style="vertical-align:middle;">ANG'+data[i].noinvoice+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+					
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+						
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].dpjumlah+'</td>'+
						'<td class="text-info" align="center" style="vertical-align:middle;">'+data[i].jmltenor+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].dptotal+'</td>'+
						'<td class="text-info" align="center" style="vertical-align:middle;">'+data[i].ketlunas+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-penerimaan-angsuran-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+
						'</td>'+
					'</tr>';
$('#lbltotalLapPIT').text(data[i].jmltotal);					
                }				
				$('#isitabelLapPIT').html(html);
				$("#tblLapPIT").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapPIT").click(function(){
	toastr.remove();
	isiLaporanPiutang();
});

///////////////////////////////////////////////////////////////
/*====================== LAPORAN CASHOUT ===================*/
///////////////////////////////////////////////////////////////
function isiLaporanCashout(){
	$('#tblLapCO').dataTable().fnDestroy();	
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapCO").val();
	var tglakhir = $("#txttglakhirLapCO").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_cashout.php",
		data: {idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan cash out sukses')
            var html = '';$('#lbltotalLapCO').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" class="text-muted" style="vertical-align:middle;">'+data[i].tgledit+'</td>'+
						'<td align="left" class="text-muted" style="vertical-align:middle;">BKK'+data[i].noinvoice+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmbiaya+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmkategori+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].rincian+'</td>'+
						'<td align="right" class="text-danger" style="vertical-align:middle;">'+data[i].jumlah+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-cashout-'+data[i].mdidtransbiaya+'.html" target="_blank" class="btn btn-tool text-muted" '+data[i].discancel+'><i class="fas fa-print"></i></a>'+
							'<a href="print-invoice-cancel-'+data[i].mdidtransbiaya+'.html" target="_blank" class="btn btn-tool text-muted" '+data[i].disfee+'><i class="fas fa-print"></i></a>'+
						'</td>'+
					'</tr>';
$('#lbltotalLapCO').text(data[i].jmltotal);// jumlah total footer card					
                }				
				$('#isitabelLapCO').html(html);
				$("#tblLapCO").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});	
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapCO").click(function(){
	toastr.remove();
	isiLaporanCashout();
});

/*================ LAPORAN FEE MARKETING =================*/
function isiLaporanFee(){
	$('#tblLapFEE').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapFEE").val();
	var tglakhir = $("#txttglakhirLapFEE").val();		
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_fee.php",
		data:{idcabang:idcabang,tglawal:tglawal,tglakhir:tglakhir},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan fee marketing sukses')
            var html = '';$('#lbltotalLapFEE').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 	
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglbayar+'</td>'+
						'<td class="text-primary" align="center" style="vertical-align:middle;">BKK'+data[i].noinvoice+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmkaryawan+'</td>'+					
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].jabatan+'</td>'+					
						'<td class="text-primary" align="right" style="vertical-align:middle;">'+data[i].jmlfee+'</td>'+
						'<td class="text-danger" align="right" style="vertical-align:middle;">'+data[i].jmlbayar+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].jmlsisa+'</td>'+
						'<td class="text-muted" align="center" style="vertical-align:middle;">'+data[i].ketlunas+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-cashout-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+						
						'</td>'+
					'</tr>';
$('#lbltotalLapFEE').text(data[i].jmltotal);					
                }				
				$('#isitabelLapFEE').html(html);
				$("#tblLapFEE").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapFEE").click(function(){
	toastr.remove();
	isiLaporanFee();
});

/*================ LAPORAN KARTU PIUTANG =================*/
function isiLaporanKartuPiutang(){
	$('#tblLapKP').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_kartu_piutang.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh kartu piutang customer sukses')
            var html = '';
			$('#lbltotalITJLapKP').text('');$('#lbltotalDPLapKP').text('');$('#lbltotalPokokLapKP').text('');$('#lbltotalLapKP').text('');
            var i;
                for(i=0; i<data.length; i++){
                    html += 		
					'<tr>'+					
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+
						'<td class="text-muted" align="center" style="vertical-align:middle;">'+data[i].JT+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].itjsisa+'</td>'+
						'<td class="text-info" align="center" style="vertical-align:middle;">'+data[i].ODitj+'</td>'+
						'<td class="text-muted" align="right" style="vertical-align:middle;">'+data[i].dpsisa+'</td>'+
						'<td class="text-muted" align="center" style="vertical-align:middle;">'+data[i].ODdp+'</td>'+
						'<td class="text-blue" align="right" style="vertical-align:middle;">'+data[i].angsuransisa+'</td>'+
						'<td class="text-blue" align="center" style="vertical-align:middle;">'+data[i].ODangsuran+'</td>'+
						'<td class="text-danger" align="right" style="vertical-align:middle;">'+data[i].sisa+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-kartu-piutang-'+data[i].mdidcustomer+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+						
						'</td>'+
					'</tr>';	
$('#lbltotalITJLapKP').text(data[i].jmltotITJ);$('#lbltotalDPLapKP').text(data[i].jmltotDP);$('#lbltotalPokokLapKP').text(data[i].jmltotPokok);$('#lbltotalLapKP').text(data[i].jmltotalpiutang);					
                }				
				$('#isitabelLapKP').html(html);
				$("#tblLapKP").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapKP").click(function(){
	toastr.remove();
	isiLaporanKartuPiutang();
});


/*================ HUTANG FEE=================*/
function isiLaporanHutangFee(){
	$('#tblLapHutangFee').dataTable().fnDestroy();	
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_hutang_fee.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan hutang fee marketing')
            var html = '';$('#lbltotalLapHutangFee').text('');
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
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].sisasales+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-muted btnViewHutFee" data-idkaryawan="'+data[i].idkaryawan+'" data-nmkaryawan="'+data[i].nmkaryawan+'" data-jabatan="'+data[i].bagian+'" data-nota="'+data[i].notasales+'" data-jumlah="'+data[i].feesales+'" data-bayar="'+data[i].byrsales+'" data-sisa="'+data[i].sisasales+'" '+data[i].dishide+'><i class="fas fa-search"></i></button> '+						
						'</td>'+
					'</tr>';
$('#lbltotalLapHutangFee').text(data[i].jmltotal);						
                }				
				$('#isitabelLapHutangFee').html(html);
				$("#tblLapHutangFee").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapHutangFee").click(function(){
	toastr.remove();
	isiLaporanHutangFee();
});

$('#isitabelLapHutangFee').on('click','.btnViewHutFee',function(){
	toastr.remove();
	var idcabang=$('#lblidcabang').val();var idkaryawan = $(this).data('idkaryawan');var nmkaryawan = $(this).data('nmkaryawan');var jabatan = $(this).data('jabatan');
	var nota= $(this).data('nota');var jumlah = $(this).data('jumlah');
	var bayar= $(this).data('bayar');var sisa = $(this).data('sisa');
	$.ajax({
		type:"POST",		
		url :"aksi/laporan-hutang-fee/view_hutang_fee.php",	
		data:{idcabang:idcabang,idkaryawan:idkaryawan,nmkaryawan:nmkaryawan,jabatan:jabatan,nota:nota,jumlah:jumlah,bayar:bayar,sisa:sisa},
		success:function(resp){
			$("#isianModLapHutVieewFee").html(resp);
			$("#isianModLapHutVieewFee").fadeIn(1000);
			$("#ModLapHutViewFee").modal({backdrop: 'static', keyboard: false}) 
			$("#ModLapHutViewFee").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});


/*================ KARTU FEE MARKETING=================*/
function isiLaporanKartuFee(){
	$('#tblLapKartuFee').dataTable().fnDestroy();	
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_kartu_fee.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh kartu fee marketing sukses')
            var html = '';$('#lbltotalLapKartuFee').text('');
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
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].sisasales+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-kartu-hutang-fee-'+data[i].mdidkaryawan+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+						
						'</td>'+
					'</tr>';
$('#lbltotalLapKartuFee').text(data[i].jmltotal);						
                }				
				$('#isitabelLapKartuFee').html(html);
				$("#tblLapKartuFee").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshKartuFee").click(function(){
	toastr.remove();
	isiLaporanKartuFee();
});

/*================ LAPORAN CANCEL =================*/
function isiLaporanCancel(){
	$('#tblLapCancel').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_cancel.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan cancel customer sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 		
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglcancel+'</td>'+
						'<td class="text-primary" align="center" style="vertical-align:middle;">BKK'+data[i].noreg+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+					
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].kavling+' - '+data[i].type+'</td>'+						
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].jmlbayar+'</td>'+
						'<td class="text-info" align="center" style="vertical-align:middle;">'+data[i].pcancel+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].jmlpotongan+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].jmlsisa+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-cancel-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+
						'</td>'+
					'</tr>';			
                }				
				$('#isitabelLapCancel').html(html);
				$("#tblLapCancel").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapCancel").click(function(){
	toastr.remove();
	isiLaporanCancel();
});

/*================ LAPORAN UPGRADE =================*/
function isiLaporanUpgrade(){
	$('#tblLapUpgrade').dataTable().fnDestroy();		
	var idcabang=$('#lblidcabang').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_lap_upgrade.php",
		data:{idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh laporan upgrade sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 		
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].tglupgrade+'</td>'+
						'<td class="text-primary" align="center" style="vertical-align:middle;">'+data[i].noreg+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nmcustomer+'</td>'+					
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].jenis+'</td>'+
						'<td class="text-muted" align="left" style="vertical-align:middle;">'+data[i].nmlokasi+'-'+data[i].kavling+'-'+data[i].type+'</td>'+						
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].hrglama+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].hrgbaru+'</td>'+
						'<td class="text-info" align="right" style="vertical-align:middle;">'+data[i].jmlbayar+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<a href="print-invoice-upgrade-'+data[i].mdinvoice+'.html" target="_blank" class="btn btn-tool text-muted"><i class="fas fa-print"></i></a> '+
						'</td>'+
					'</tr>';			
                }				
				$('#isitabelLapUpgrade').html(html);
				$("#tblLapUpgrade").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshLapUpgrade").click(function(){
	toastr.remove();
	isiLaporanUpgrade();
});

/////////////// PRINT & EXCEL LAPORAN ////////////
$("#cmdExcelLapCustomer").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/excel_lap_customer.php?idcabang='+ idcabang);
});		

$("#cmdExcelLapKP").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/excel_lap_kartu_piutang.php?idcabang='+ idcabang);
});		

$("#cmdPrintLapKP").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/print-lap-kartu-piutang.php?idcabang='+ idcabang);
});		

$("#cmdExcelLapKarTitip").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/excel_lap_kartu_titipan.php?idcabang='+ idcabang);
});		

$("#cmdPrintLapKarTitip").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/print-lap-kartu-titipan.php?idcabang='+ idcabang);
});		

$("#cmdExcelLapTTP").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapTTP").val();
	var tglakhir = $("#txttglakhirLapTTP").val();	
	window.open('laporan-excel/excel_lap_titipan.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdPrintLapTTP").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapTTP").val();
	var tglakhir = $("#txttglakhirLapTTP").val();	
	window.open('laporan-excel/print-lap-titipan.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdExcelLapCashIn").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapCashIn").val();
	var tglakhir = $("#txttglakhirLapCashIn").val();	
	window.open('laporan-excel/excel_lap_cashin.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdPrintLapCashIn").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapCashIn").val();
	var tglakhir = $("#txttglakhirLapCashIn").val();	
	window.open('laporan-excel/print-lap-cashin.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdExcelLapITJ").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapITJ").val();
	var tglakhir = $("#txttglakhirLapITJ").val();	
	window.open('laporan-excel/excel_lap_itj.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		
			
$("#cmdPrintLapITJ").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapITJ").val();
	var tglakhir = $("#txttglakhirLapITJ").val();	
	window.open('laporan-excel/print-lap-itj.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdExcelLapDP").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapDP").val();
	var tglakhir = $("#txttglakhirLapDP").val();	
	window.open('laporan-excel/excel_lap_dp.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdPrintLapDP").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapDP").val();
	var tglakhir = $("#txttglakhirLapDP").val();	
	window.open('laporan-excel/print-lap-dp.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdExcelLapPIT").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapPIT").val();
	var tglakhir = $("#txttglakhirLapPIT").val();	
	window.open('laporan-excel/excel_lap_angsuran.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});	

$("#cmdPrintLapPIT").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapPIT").val();
	var tglakhir = $("#txttglakhirLapPIT").val();	
	window.open('laporan-excel/print-lap-angsuran.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});	
	
$("#cmdPrintLapCO").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapCO").val();
	var tglakhir = $("#txttglakhirLapCO").val();	
	window.open('laporan-excel/print-lap-cashout.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});			

$("#cmdExcelLapCO").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapCO").val();
	var tglakhir = $("#txttglakhirLapCO").val();	
	window.open('laporan-excel/excel_lap_cashout.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdExcelLapFEE").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapFEE").val();
	var tglakhir = $("#txttglakhirLapFEE").val();	
	window.open('laporan-excel/excel_lap_bayar_fee.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdPrintLapFEE").click(function(){
	var idcabang=$('#lblidcabang').val();
	var tglawal = $("#txttglawalLapFEE").val();
	var tglakhir = $("#txttglakhirLapFEE").val();	
	window.open('laporan-excel/print-lap-bayar-fee.php?idcabang='+ idcabang + '&tglawal='+tglawal+ '&tglakhir='+tglakhir);
});		

$("#cmdExcelLapHutangFee").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/excel_lap_hutang_fee.php?idcabang='+ idcabang);
});	

$("#cmdPrintLapHutangFee").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/print-lap-hutang-fee.php?idcabang='+ idcabang);
});	
	
$("#cmdExcelLapCancel").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/excel_lap_cancel.php?idcabang='+ idcabang);
});	

$("#cmdExcelLapUpgrade").click(function(){
	var idcabang=$('#lblidcabang').val();
	window.open('laporan-excel/excel_lap_upgrade.php?idcabang='+ idcabang);
});	