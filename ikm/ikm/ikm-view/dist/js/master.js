/*================ GRAFIK DASHBOARD =================*/
/*
function isiGrafikDasboard(){
	var idcabang=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_grafik_dashboard_out.php",
		data: {idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			
			var labels = [];// labelnya
			var values = [];// datanya	
			myArray = data;
			$.each(myArray, function(index, jum) {
				labels.push(jum.nmBulan);
				values.push(jum.jumtotal);
			});				
					
   var hitChartContent = document.getElementById('hitungChartContentCOUT');
  hitChartContent.innerHTML = '';
  $('#hitungChartContentCOUT').append('<canvas id="hitungChartCOUT" height="350"><canvas>');
  
  var salesChartCanvas = $('#hitungChartCOUT').get(0).getContext('2d')
  var salesChartData = {
    labels  : labels,
    datasets: [
      {
        label               : 'Total ',
		backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE"],
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius         : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : values,
      },
    ]
  }

  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
	animation: {
	  animateScale: true,
	  animateRotate: true
	},
	tooltips: {
	  mode: 'index',
	  intersect: false,
	  enabled: true,
      callbacks: {
        label: function (tooltipItems, data) {
            return data.datasets[tooltipItems.datasetIndex].label + ' : ' + tooltipItems.yLabel.toLocaleString();
        }
     },	
	},
	hover: {
	  mode: 'nearest',
	  intersect: true
	},	
    scales: {
      xAxes: [{
        gridLines : {display : false,},
		barPercentage: 0.6
      }],
      yAxes: [{
		ticks: {display: false,beginAtZero: true},
        gridLines : {display : true,}
      }]
    }
  }
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'bar', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )

//////////////////////////////////////////////////////////////////// 				
				$("#loading").fadeOut("slow");	
				document.body.style.cursor = "default";

		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});		
}

function isiGrafikDasboardIN(){
	var idcabang=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_grafik_dashboard_in.php",
		data: {idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			
			var labels = [];// labelnya
			var values = [];// datanya	
			myArray = data;
			$.each(myArray, function(index, jum) {
				labels.push(jum.nmBulan);
				values.push(jum.jumtotal);
			});				
					
   var hitChartContent = document.getElementById('hitungChartContentCIN');
  hitChartContent.innerHTML = '';
  $('#hitungChartContentCIN').append('<canvas id="hitungChartCIN" height="350"><canvas>');
  
  var salesChartCanvas = $('#hitungChartCIN').get(0).getContext('2d')
  var salesChartData = {
    labels  : labels,
    datasets: [
      {
        label               : 'Total ',
		backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE"],
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius         : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : values,
      },
    ]
  }


  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
	animation: {
	  animateScale: true,
	  animateRotate: true
	},
	tooltips: {
	  mode: 'index',
	  intersect: false,
      enabled: true,
      callbacks: {
        label: function (tooltipItems, data) {
            return data.datasets[tooltipItems.datasetIndex].label + ' : ' + tooltipItems.yLabel.toLocaleString();
        }
     },						   
	},
	hover: {
	  mode: 'nearest',
	  intersect: true
	},	
    scales: {
      xAxes: [{
        gridLines : {display : false,},
		barPercentage: 0.6
      }],
      yAxes: [{
		ticks: {display: false,beginAtZero: true,},
        gridLines : {display : true,}
      }]
    }
  }
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'bar', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )

//////////////////////////////////////////////////////////////////// 				
				$("#loading").fadeOut("slow");	
				document.body.style.cursor = "default";

		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});		
}

/*================ DASHBOARD =================*/
/*
function isiDasboard(){
	var idcabang=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_dashboard.php",
		data: {idcabang:idcabang},
        dataType : 'json',			
		beforeSend: function(e) {
			$('#txttotkavlingDasboard').html('');$('#txtlakuDasboard').html('');$('#txtbelumlakuDasboard').html('');$('#txtusercancelDasboard').html('');
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			$('#txttotkavlingDasboard').html('');$('#txtlakuDasboard').html('');$('#txtbelumlakuDasboard').html('');$('#txtusercancelDasboard').html('');		
			$('#txttotCINDashboard').html('');$('#txttotCOUTDashboard').html('');	
			myArray = data;
			$.each(myArray, function(index, jum) {
				$('#txttotkavlingDasboard').html(jum.JumKavling);$('#txtlakuDasboard').html(jum.kavlaku);
				$('#txtbelumlakuDasboard').html(jum.kavbelum);$('#txtusercancelDasboard').html(jum.cusCancel);	
				$('#txttotCINDashboard').html(jum.JumCashIn);$('#txttotCOUTDashboard').html(jum.JumCashOut);	
				//document.body.style.cursor = "default";
				//toastr.info('Refresh report data dashboard sukses')		
			});	
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});		
}

/*================ TRANSAKSI PENDIDIKAN =================*/
function isiMasterPendidikan(){
	$('#tblPendidikan').dataTable().fnDestroy();	
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_pendidikan.php",
		data: {idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
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
				$("#tblPendidikan").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});	
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
		url :"aksi/pendidikan/tambah_pendidikan.php",
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
		url :"aksi/pendidikan/edit_pendidikan.php",	
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

/*================ MASTER PEKERJAAN =================*/
function isiMasterPekerjaan(){
	$('#tblPekerjaan').dataTable().fnDestroy();	
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_pekerjaan.php",
		data: {idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
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
				$("#tblPekerjaan").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});	
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
		url :"aksi/pekerjaan/tambah_pekerjaan.php",
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
		url :"aksi/pekerjaan/edit_pekerjaan.php",	
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

/*================ MASTER INSTANSI =================*/
function isiMasterInstansi(){
	$('#tblInstansi').dataTable().fnDestroy();		
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_instansi.php",
		data:{idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh master data instansi sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 		
					'<tr>'+
						'<td align="center" style="vertical-align:middle;">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].nminstansi+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].alamat+'</td>'+
						'<td align="left" style="vertical-align:middle;">'+data[i].kota+'</td>'+
						'<td align="left" class="text-muted" style="vertical-align:middle;">'+data[i].telepon+'</td>'+
						'<td align="left" class="text-info" style="vertical-align:middle;">'+data[i].email+'</td>'+
						'<td align="center" style="vertical-align:middle;">'+
							'<button class="btn btn-tool text-info btnEditInstansi" data-id="'+data[i].idinstansi+'"><i class="fas fa-pencil-alt"></i></button> '+
							'<button class="btn btn-tool text-danger btnHapusInstansi" data-id="'+data[i].idinstansi+'" data-nama="'+data[i].nminstansi+'" data-ketinduk="'+data[i].ketinduk+'"><i class="far fa-trash-alt"></i></button>'+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelInstansi').html(html);
				$("#tblInstansi").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshInstansi").click(function(){
	toastr.remove();
	isiMasterInstansi();
});

$("#cmdTambahInstansi").click(function(){
	toastr.remove();
	$.ajax({
		type:"POST",
		url :"aksi/instansi/tambah_instansi.php",	
		success:function(resp){
			$("#isianModInstansi").html(resp);
			$("#isianModInstansi").fadeIn(1000);
			$("#ModTambahInstansi").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTambahInstansi").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelInstansi').on('click','.btnEditInstansi',function(){
	toastr.remove();
	var idinstansi = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"aksi/instansi/edit_instansi.php",	
		data:{idinstansi:idinstansi},
		success:function(resp){
			$("#isianModInstansiedit").html(resp);
			$("#isianModInstansiedit").fadeIn(1000);
			$("#ModEditInstansi").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditInstansi").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelInstansi').on('click','.btnHapusInstansi',function(){
	toastr.remove();
	$("#cmdHapusInstansi").removeAttr("disabled");
	$("#cmdBatalHapusInstansi").removeAttr("disabled");
	$(".modal-body").css("opacity", "");
	$('#pesanHapusInstansi').html('');
	$('#txtidInstansiHapus').val('');$('#txtketindukInstansiHapus').val('');$('#txtnminstansiHapus').val('');

	var idinstansi = $(this).data('id');var nminstansi = $(this).data('nama');
	var ketinduk = $(this).data('ketinduk');
	$('#txtidInstansiHapus').val(idinstansi);$('#txtketindukInstansiHapus').val(ketinduk);
	$('#txtnminstansiHapus').val(nminstansi);

	$('#pesanHapusInstansi').html('Yakin, Anda menghapus data instansi<br><b>'+ nminstansi +'</b>');
	$("#ModHapusInstansi").modal({backdrop:'static', keyboard:false});
	$("#ModHapusInstansi").modal('show');
});

$("#cmdHapusInstansi").click(function(){
	var idinstansi = $('#txtidInstansiHapus').val();var nminstansi = $('#txtnminstansiHapus').val();
	var ketinduk = $('#txtketindukInstansiHapus').val();
	if(idinstansi.length <= 0){alert('Instansi tidak terdeteksi')}
	else if(ketinduk == "Y"){alert(nminstansi+' terdeteksi sebagai instansi induk\nInstansi induk tidak dapat dihapus')}
	else {
	$.ajax({
		type:"POST",
		url :"aksi/instansi/aksi_hapus.php",
		data:{idinstansi:idinstansi},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdHapusInstansi").attr("disabled","disabled");
			$("#cmdBatalHapusInstansi").attr("disabled","disabled");
		},				
		success:function(resp){
			$("#pesanHapusInstansi").html(resp.msg1);				
			setTimeout(function(){ $('#ModHapusInstansi').modal('hide');},1000);
			isiMasterInstansi();
		},
		error: function() {alert('Koneksi bermasalah periksa internet');
			$("#cmdHapusInstansi").removeAttr("disabled","disabled");
			$("#cmdBatalHapusInstansi").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}
});	
		
/*================ TRANSAKSI OPERATOR =================*/
function isiMasterOperator(){
	$('#tblOperator').dataTable().fnDestroy();	
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_operator.php",
		data:{idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
			document.body.style.cursor = "default";
			toastr.info('Refresh tabel data operator sukses')
            var html = '';
            var i;
                for(i=0; i<data.length; i++){
                    html += 
					'<tr>'+
						'<td align="center" style="vertical-align:middle;'+data[i].warna+';">'+data[i].no+'</td>'+
						'<td align="left" style="vertical-align:middle;'+data[i].warna+';">'+data[i].nmuser+'</td>'+
						'<td align="left" style="vertical-align:middle;'+data[i].warna+';">'+data[i].nminstansi+'</td>'+
						'<td align="left" style="vertical-align:middle;color:#444;'+data[i].warna+';">'+data[i].username+'</td>'+
						'<td align="left" style="vertical-align:middle;color:#444;'+data[i].warna+';">'+data[i].akses+'</td>'+
						'<td align="left" style="vertical-align:middle;'+data[i].warna+';">'+
							'<button class="btn btn-tool text-warning btnAktivasiOperator" data-blokir="'+data[i].blokir+'" data-id="'+data[i].iduser+'" data-nama="'+data[i].nmuser+'" data-instansi="'+data[i].nminstansi+'" data-akses="'+data[i].akses+'"><i class="fas fa-ban"></i></button> '+
						'</td>'+
						'<td align="center" style="vertical-align:middle;'+data[i].warna+';">'+
							'<button class="btn btn-tool text-info btnEditOperator" data-id="'+data[i].iduser+'"><i class="fas fa-pencil-alt"></i></button> '+
							'<button class="btn btn-tool text-danger btnHapusOperator" data-id="'+data[i].iduser+'" data-nama="'+data[i].nmuser+'" data-instansi="'+data[i].nminstansi+'" data-akses="'+data[i].akses+'"><i class="far fa-trash-alt"></i></button>'+
						'</td>'+
					'</tr>';	
                }				
				$('#isitabelOperator').html(html);
				$("#tblOperator").dataTable({"destroy": true,"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollCollapse": false,"scrollX": true,scrollY: false});

				$("#loading").fadeOut("slow");						
		},
		error: function() {
			$("#loading").fadeOut("slow");	
			toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";					
		},
	});	
}

$("#cmdRefreshOperator").click(function(){
	toastr.remove();
	isiMasterOperator();
});

$("#cmdTambahOperator").click(function(){
	toastr.remove();
	$.ajax({
		type:"POST",
		url :"aksi/operator/tambah_operator.php",			
		success:function(resp){
			$("#isianModOperator").html(resp);
			$("#isianModOperator").fadeIn(1000);
			$("#ModTambahOperator").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTambahOperator").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelOperator').on('click','.btnEditOperator',function(){
	toastr.remove();
	var iduser = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"aksi/operator/edit_operator.php",	
		data:{iduser:iduser},
		success:function(resp){
			$("#isianModOperatoredit").html(resp);
			$("#isianModOperatoredit").fadeIn(1000);
			$("#ModEditOperator").modal({backdrop: 'static', keyboard: false}) 
			$("#ModEditOperator").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelOperator').on('click','.btnHapusOperator',function(){
	toastr.remove();
	$("#cmdHapusOperator").removeAttr("disabled");
	$("#cmdBatalHapusOperator").removeAttr("disabled");
	$(".modal-body").css("opacity", "");
	$('#pesanHapusOperator').html('');
	$('#txtidOperatorHapus').val('');

	var iduser = $(this).data('id');
	var nmuser = $(this).data('nama');var akses = $(this).data('akses');var nminstansi = $(this).data('instansi');
	$('#txtidOperatorHapus').val(iduser);

	$('#pesanHapusOperator').html('Yakin, Anda menghapus data operator<br><b>'+ nmuser +'</b> / '+nminstansi);
	$("#ModHapusOperator").modal({backdrop:'static', keyboard:false});
	$("#ModHapusOperator").modal('show');
});

$("#cmdHapusOperator").click(function(){
	var iduser = $('#txtidOperatorHapus').val();
	$.ajax({
		type:"POST",
		url :"aksi/operator/aksi_hapus.php",
		data:{iduser:iduser},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdHapusOperator").attr("disabled","disabled");
			$("#cmdBatalHapusOperator").attr("disabled","disabled");
		},				
		success:function(resp){
			$("#pesanHapusOperator").html(resp.msg1);				
			setTimeout(function(){ $('#ModHapusOperator').modal('hide');},1000);
			isiMasterOperator();
		},
		error: function() {alert('Koneksi bermasalah periksa internet');
			$("#cmdHapusOperator").removeAttr("disabled","disabled");
			$("#cmdBatalHapusOperator").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});			
});	

$('#isitabelOperator').on('click','.btnAktivasiOperator',function(){
	toastr.remove();
	$("#cmdActOperator").removeAttr("disabled");
	$("#cmdBatalActOperator").removeAttr("disabled");
	$(".modal-body").css("opacity", "");
	$('#txtidOperatorAct').val('');
	$('#txtaktivasiOperator').val('');
	
	var iduser = $(this).data('id');var nmuser = $(this).data('nama');var akses = $(this).data('akses');
	var nminstansi = $(this).data('instansi');
	var blokir = $(this).data('blokir');
		
	var statusnya='';var statusnya2='';var ubahsts='';
	if (blokir=='Y'){
		statusnya='Blokir';statusnya2='Tidak Blokir';ubahsts='N';
	}else if (blokir=='N'){
		statusnya='Tidak Blokir';statusnya2='Blokir';ubahsts='Y';	
	}
	
	$('#txtidOperatorAct').val(iduser);
	$('#txtaktivasiOperator').val(ubahsts);
	
	$('#pesanAktivasiOperator').html('Yakin, Anda mengubah status blokir<br><br><b>'+ nmuser +'</b> / '+nminstansi+'<br>Status '+ statusnya + '<br>Ubah menjadi '+ statusnya2);
	$("#ModAktivasiOperator").modal({backdrop:'static', keyboard:false});
	$("#ModAktivasiOperator").modal('show');
});

$("#cmdActOperator").click(function(){
		var iduser=$('#txtidOperatorAct').val();
		var status = $('#txtaktivasiOperator').val();	
		$.ajax({
			type:"POST",
			url :"aksi/operator/aksi_aktivasi.php",
			data:{iduser:iduser,status:status},
			dataType: "json",
			beforeSend: function(e) {
				$("#cmdActOperator").attr("disabled","disabled");
				$("#cmdBatalActOperator").attr("disabled","disabled");
			},				
			success:function(resp){
				$("#pesanAktivasiOperator").html(resp.msg1);						
				setTimeout(function(){ $('#ModAktivasiOperator').modal('hide');},1000);	
				isiMasterOperator();
			},
			error: function() {alert('Koneksi bermasalah periksa internet');
				$("#cmdActOperator").attr("disabled","disabled");
				$("#cmdBatalActOperator").removeAttr("disabled");
				$(".modal-body").css("opacity", "");},
		}); 
});	

/*================ MASTER SOAL =================*/
function isiMasterSoal(){
	$('#tblSoal').dataTable().fnDestroy();		
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
		type:"POST",
		url : "aksi/isi_tabel_soal.php",
		data:{idinstansi:idinstansi},
        dataType : 'json',			
		beforeSend: function(e) {
			$("#loading").fadeIn();toastr.remove();
			document.body.style.cursor = "wait";
		},
		success:function(data){
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
				$("#tblSoal").dataTable({"paging": true,"lengthChange": true,"searching": true,"ordering": true,"info": true,"autoWidth": false,"responsive": true,"select": true,"scrollX": true});
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

$("#cmdTambahSoal").click(function(){
	toastr.remove();
	$.ajax({
		type:"POST",
		url :"aksi/soal/tambah_soal.php",	
		success:function(resp){
			$("#isianModSoal").html(resp);
			$("#isianModSoal").fadeIn(1000);
			$("#ModTambahSoal").modal({backdrop: 'static', keyboard: false}) 
			$("#ModTambahSoal").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	});
});

$('#isitabelSoal').on('click','.btnEditSoal',function(){
	toastr.remove();
	var idsoal = $(this).data('id');
	$.ajax({
		type:"POST",		
		url :"aksi/soal/edit_soal.php",	
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