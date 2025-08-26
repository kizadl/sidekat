/*================ GRAFIK DASHBOARD ADMINISTRATOR =================*/
function isiGrafikDasboardAdm() {
	$.ajax({
		type: "POST",
		url: "ikm/aksi/isi_grafik_dashboard_admin.php",
		dataType: 'json',
		beforeSend: function (e) {
			$("#loading").fadeIn(); toastr.remove();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			var labels = [];
			var valtp = []; var valkp = []; var valp = []; var valsp = [];
			myArray = data;
			$.each(myArray, function (index, jum) {
				labels.push(jum.nmBulan);
				valtp.push(jum.jumtp);
				valkp.push(jum.jumkp);
				valp.push(jum.jump);
				valsp.push(jum.jumsp);
			});

			var hitChartContent = document.getElementById('hitungChartContentADMIN');
			hitChartContent.innerHTML = '';
			$('#hitungChartContentADMIN').append('<canvas id="hitungChartADMIN" height="200"><canvas>');

			var salesChartCanvas = $('#hitungChartADMIN').get(0).getContext('2d')
			var salesChartData = {
				labels: labels,
				datasets: [
					{
						label: 'Tidak Puas',
						backgroundColor: '#FF0000',
						borderColor: '#FF0000',
						data: valtp,
					},
					{
						label: 'Kurang Puas',
						backgroundColor: '#FFA500',
						borderColor: '#FFA500',
						data: valkp,
					},
					{
						label: 'Puas',
						backgroundColor: '#90EE90',
						borderColor: '#90EE90',
						data: valp,
					},
					{
						label: 'Sangat Puas',
						backgroundColor: '#87CEFA',
						borderColor: '#87CEFA',
						data: valsp,
					},
				]
			}

			var salesChartOptions = {
				maintainAspectRatio: false,
				responsive: true,
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
						gridLines: { display: false, },
						barPercentage: 0.6
					}],
					yAxes: [{
						ticks: { display: false, beginAtZero: true },
						gridLines: { display: true, }
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
		error: function () {
			$("#loading").fadeOut("slow");
			//toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";
		},
	});
}

/*================ DASHBOARD ADMIN =================*/
function isiDasboardAdm() {
	$.ajax({
		type: "POST",
		url: "ikm/aksi/isi_dashboard_admin.php",
		dataType: 'json',
		beforeSend: function (e) {
			$('#lblDBjumTPADMIN').html(''); $('#lblDBjumKPADMIN').html(''); $('#lblDBjumPADMIN').html(''); $('#lblDBjumSPADMIN').html('');
			$('#lblDBpersenTPADMIN').html(''); $('#lblDBpersenKPADMIN').html(''); $('#lblDBpersenPADMIN').html(''); $('#lblDBpersenSPADMIN').html('');
			$('#lblDBTotjumTPADMIN').html(''); $('#lblDBTotjumKPADMIN').html(''); $('#lblDBTotjumPADMIN').html(''); $('#lblDBTotjumSPADMIN').html('');
			$('#lblDBTotpersenTPADMIN').html(''); $('#lblDBTotpersenKPADMIN').html(''); $('#lblDBTotpersenPADMIN').html(''); $('#lblDBTotpersenSPADMIN').html('');
			$("#loading").fadeIn(); toastr.remove();
			document.body.style.cursor = "wait";
		},
		success: function (data) {
			$('#lblDBjumTPADMIN').html(''); $('#lblDBjumKPADMIN').html(''); $('#lblDBjumPADMIN').html(''); $('#lblDBjumSPADMIN').html('');
			$('#lblDBpersenTPADMIN').html(''); $('#lblDBpersenKPADMIN').html(''); $('#lblDBpersenPADMIN').html(''); $('#lblDBpersenSPADMIN').html('');
			$('#lblDBTotjumTPADMIN').html(''); $('#lblDBTotjumKPADMIN').html(''); $('#lblDBTotjumPADMIN').html(''); $('#lblDBTotjumSPADMIN').html('');
			$('#lblDBTotpersenTPADMIN').html(''); $('#lblDBTotpersenKPADMIN').html(''); $('#lblDBTotpersenPADMIN').html(''); $('#lblDBTotpersenSPADMIN').html('');
			myArray = data;
			$.each(myArray, function (index, jum) {
				$('#lblDBjumTPADMIN').html(jum.jumTP); $('#lblDBjumKPADMIN').html(jum.jumKP); $('#lblDBjumPADMIN').html(jum.jumP); $('#lblDBjumSPADMIN').html(jum.jumSP);
				$('#lblDBpersenTPADMIN').html(jum.perTP); $('#lblDBpersenKPADMIN').html(jum.perKP); $('#lblDBpersenPADMIN').html(jum.perP); $('#lblDBpersenSPADMIN').html(jum.perSP);
				$('#lblDBTotjumTPADMIN').html(jum.jumtottp); $('#lblDBTotjumKPADMIN').html(jum.jumtotkp); $('#lblDBTotjumPADMIN').html(jum.jumtotp); $('#lblDBTotjumSPADMIN').html(jum.jumtotsp);
				$('#lblDBTotpersenTPADMIN').html(jum.perTotTP + " %"); $('#lblDBTotpersenKPADMIN').html(jum.perTotKP + " %"); $('#lblDBTotpersenPADMIN').html(jum.perTotP + " %"); $('#lblDBTotpersenSPADMIN').html(jum.perTotSP + " %");
				$("#loading").fadeOut("slow");
				document.body.style.cursor = "default";
				toastr.info('Refresh report data dashboard sukses');
			});
		},
		error: function () {
			$("#loading").fadeOut("slow");
			//toastr.error('Koneksi bermasalah periksa internet');
			document.body.style.cursor = "default";
		},
	});
}

function isiTabelDashboardAdm() {
	$.ajax({
		type: "POST",
		url: "ikm/aksi/isi_tabel_dashboard_admin.php",
		dataType: 'json',
		success: function (data) {
			$('#tblDashboardADMIN').dataTable().fnDestroy();
			document.body.style.cursor = "default";
			var html = '';
			var i;
			for (i = 0; i < data.length; i++) {
				html +=
					'<tr>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].idunsur + '</td>' +
					'<td align="left" style="vertical-align:middle;">' + data[i].unsur + '</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].jumTP + ' %</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].jumKP + ' %</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].jumP + ' %</td>' +
					'<td align="center" style="vertical-align:middle;">' + data[i].jumSP + ' %</td>' +
					'</tr>';
			}
			$('#isitabelDashboardADMIN').html(html);
			$("#tblDashboardADMIN").dataTable({
				"paging": false, "lengthChange": false, "ordering": true, "info": true, "autoWidth": false, "responsive": true, "select": false, "scrollX": false,
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
