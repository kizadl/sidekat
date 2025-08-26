/*================ TABELDASHBOARD =================*/
$('#txtcarilokasi').on('keydown',function (e) {
  if (e.keyCode == 13) {
    var kata = $("#txtcarilokasi").val();
    if (kata.length >= 2) {
      $.ajax({
        type: 'POST',
        url: 'aksi/cari_lokasi.php',
        data: {
          kata: kata
        },
        dataType: 'json',
        beforeSend: function (e) {
          $("#loading").fadeIn();
          document.body.style.cursor = "wait";
        },
        success: function (resp) {
          $("#loading").fadeOut("slow");
          document.body.style.cursor = "default";
          if (resp.length >= 1) {
            pencarianLokasi();
          } else if (resp.length <= 0) {
            alert("Data tidak diketemukan");
            $("#txtcarilokasi").val("");
            $("#txtcarilokasi").focus();
          } else {
            alert("Data tidak diketemukan");
            $("#txtcarilokasi").val("");
            $("#txtcarilokasi").focus();
          }
        },
        error: function () {
          $("#loading").fadeOut("slow");
          document.body.style.cursor = "default";
          alert("Koneksi ke server terputus");
        },
      });

    } else {
      alert("Kata kunci pencarian kosong")
    }
  }
  
});

$("#cbokecamatanspm").on("change",function(){
	var idkecamatan = $("#cbokecamatanspm").val()
	$.ajax({
	  type:"POST",
	  url : "aksi/ambil_data_desa.php",
	  data:{idkecamatan:idkecamatan},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
		$("#loading").fadeOut("slow");
		$("#cbodesaspm").empty()
		$("#cbodesaspm").append('<option value="">-</option>')
		var i;
		for(i=0; i<data.length; i++){
			$("#cbodesaspm").append('<option value="'+data[i].iddesa+'">'+data[i].nmdesa+'</option>')
		}	 
    hitungGrafikTotalSekolah();
    isiGrafikStatus();
    hitungGrafikRombelSD();
    hitungGrafikRombelSMP();
    hitungGrafikKebutuhanGuruSD();hitungGrafikKebutuhanGuruSDNegeri();
    hitungGrafikKebutuhanGuruSMP();hitungGrafikKebutuhanGuruSMPNegeri();
    isiGrafikAkreditasi();
    isiGrafikPutusSekolah();isiGrafikLulusSekolah();
    isiGafikUsia();isiGrafikSertifikasi();
	  },
	  error: function() {
		$("#loading").fadeOut("slow");
		alert("Koneksi bermasalah periksa internet");
		document.body.style.cursor = "default";					
	  },
	});	
});

$("#cbodesaspm").on("change",function(){
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan != "all" && iddesa != ""){
    hitungGrafikTotalSekolah();
    isiGrafikStatus();
    hitungGrafikRombelSD();
    hitungGrafikRombelSMP();
    hitungGrafikKebutuhanGuruSD();hitungGrafikKebutuhanGuruSDNegeri();
    hitungGrafikKebutuhanGuruSMP();hitungGrafikKebutuhanGuruSMPNegeri();
    isiGrafikAkreditasi();
    isiGrafikPutusSekolah();isiGrafikLulusSekolah();
    isiGafikUsia();isiGrafikSertifikasi();
  }
});

function pencarianLokasi() {
  var kata = $("#txtcarilokasi").val();
  $.ajax({
    type: 'POST',
    url: "aksi/isi_pencarian.php",
    data: {
      kata: kata
    },
    success: function (resp) {
      $("#loading").fadeOut("slow");
      $("#isianModTambahDataLarge").html(resp);
      $("#isianModTambahDataLarge").fadeIn(1000);
      $("#modTambahDataLarge").modal('show');
      $("#txtcarilokasi").val("");
    },
  });
}

Chart.defaults.global.defaultFontColor = "#fff";

var ctx = document.getElementById('umurChart').getContext("2d")
var gradient = ctx.createLinearGradient(0, 0, 0, 200)
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)')
gradient.addColorStop(0, '#b2d1f0')

function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function hitungGrafikTotalSekolah() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_total_sekolah.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_total_sekolah_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_total_sekolah_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    async: false,
    dataType: 'json',
    success: function (data) {
      var labels = [];
      var values = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        labels.push(jum.nmbentuksekolah);
        values.push(jum.jumDetSekolah);

        const allData = [];
        for (let i = 0; i < labels.length; ++i) {
          allData.push({
            label: labels[i],
            data: values[i]
          });
        }

        allData.sort((b, a) => a.data - b.data);

        const sortedLabels = allData.map(e => e.label);
        const sortedData = allData.map(e => e.data);

        var hitChartContent = document.getElementById('hitungUmurChart');
        hitChartContent.innerHTML = '';
        $('#hitungUmurChart').append('<canvas id="umurChart" height="250px"><canvas>');

        var salesChartCanvas = $('#umurChart').get(0).getContext('2d')
        var salesChartData = {
          labels: sortedLabels,
          datasets: [
            {
              label: 'Jumlah',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: gradient,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: sortedData,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: true, color: "#0d6ecf" }
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: false, }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'line',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function isiGrafikStatus() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_status_sekolah.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_status_sekolah_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_status_sekolah_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    beforeSend: function (e) {
      $("#loading").fadeIn();
      document.body.style.cursor = "wait";
    },
    success: function (data) {
      var labels = [];
      var valsw = []; var valneg = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        labels.push(jum.nmbentuksekolah);
        valsw.push(jum.jumSwasta);
        valneg.push(jum.jumNegeri);
      });

      var hitChartContent = document.getElementById('hitungChartContentADMIN');
      hitChartContent.innerHTML = '';
      $('#hitungChartContentADMIN').append('<canvas id="hitungChartADMIN" height="250px"><canvas>');

      var salesChartCanvas = $('#hitungChartADMIN').get(0).getContext('2d')
      var salesChartData = {
        labels: labels,
        datasets: [
          {
            label: 'Negeri',
            backgroundColor: 'rgb(0, 255, 255)',
            borderColor: 'rgb(0, 255, 255)',
            data: valneg,
          },
          {
            label: 'Swasta',
            backgroundColor: 'rgb(255, 105, 180)',
            borderColor: 'rgb(255, 105, 180)',
            data: valsw,
          },
        ]
      }

      var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: true,
          labels: {
            fontColor: 'rgb(255, 255, 255,0.9)'
          }
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
            ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
            gridLines: { display: false },
            barPercentage: 0.6
          }],
          yAxes: [{
            ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
            gridLines: { display: true, color: "#0d6ecf" }
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

function hitungGrafikRombelSD() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_rombel_sd.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_rombel_sd_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_rombel_sd_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        var labels = ["Kelas 1","Kelas 2","Kelas 3","Kelas 4","Kelas 5","Kelas 6"];
        var values = [jum.jumRombel1,jum.jumRombel2,jum.jumRombel3,jum.jumRombel4,jum.jumRombel5,jum.jumRombel6];

        var hitChartContent = document.getElementById('hitungChartRombelSD');
        hitChartContent.innerHTML = '';
        $('#hitungChartRombelSD').append('<canvas id="hitungRombelSD" height="250px"><canvas>');

        var salesChartCanvas = $('#hitungRombelSD').get(0).getContext('2d')
        var salesChartData = {
          labels: labels,
          datasets: [
            {
              label: 'Rombel',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: values,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
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
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: false },
              barPercentage: 0.8
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: true, color: "#0d6ecf" }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function hitungGrafikRombelSMP() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_rombel_smp.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_rombel_smp_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_rombel_smp_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        var labels = ["Kelas 7","Kelas 8","Kelas 9"];
        var values = [jum.jumRombel7,jum.jumRombel8,jum.jumRombel9];

        var hitChartContent = document.getElementById('hitungChartRombelSMP');
        hitChartContent.innerHTML = '';
        $('#hitungChartRombelSMP').append('<canvas id="hitungRombelSMP" height="250px"><canvas>');

        var salesChartCanvas = $('#hitungRombelSMP').get(0).getContext('2d')
        var salesChartData = {
          labels: labels,
          datasets: [
            {
              label: 'Rombel',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: values,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
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
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: false },
              barPercentage: 0.5
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: true, color: "#0d6ecf" }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function hitungGrafikKebutuhanGuruSD() {
  $("#txtjumtotk13").html("0");$("#txtjumtotkmb").html("0");$("#txtjumtotrombel").html("0");
  $("#txtjumtotguru").html("0");$("#txtjumtotidealguru").html("0");$("#txtjumtotkurangguru").html("0");

  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_kebutuhan_sd.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_kebutuhan_sd_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_kebutuhan_sd_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        var labels = ["Guru Kelas","PJOK","Pendidikan Agama","B. Inggris","TIK"];
        var values = [jum.jumgurukelasideal,jum.jumguruPJOKideal,jum.jumguruPAIideal,jum.jumguruBINGideal,jum.jumguruTIKideal];
        
        if (jum.JumGuru < jum.jumguruTOTALideal){var jmlkurangx = "Kurang  " + formatRibuan(jum.kurangguru.toString())}
        else if (jum.JumGuru > jum.jumguruTOTALideal){var jmlkurangx = "Lebih  " + formatRibuan(jum.kurangguru.toString())}

        $("#txtjumtotk13").html(formatRibuan(jum.jumK13.toString()));
        $("#txtjumtotkmb").html(formatRibuan(jum.jumKMB.toString()));
        $("#txtjumtotrombel").html(formatRibuan(jum.jmlrombel.toString()));
        $("#txtjumtotguru").html(formatRibuan(jum.JumGuru.toString()));
        $("#txtjumtotidealguru").html(formatRibuan(jum.jumguruTOTALideal.toString()));
        $("#txtjumtotkurangguru").html(jmlkurangx);
        
        var hitChartContent = document.getElementById('hitungChartKebutuhanSD');
        hitChartContent.innerHTML = '';
        $('#hitungChartKebutuhanSD').append('<canvas id="hitungKebutuhanSD" height="300px"><canvas>');

        var salesChartCanvas = $('#hitungKebutuhanSD').get(0).getContext('2d')
        var salesChartData = {
          labels: labels,
          datasets: [
            {
              label: 'Ideal Kebutuhan Guru',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: values,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
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
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: false },
              barPercentage: 0.4
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: true, color: "#0d6ecf" }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function hitungGrafikKebutuhanGuruSDNegeri() {
  $("#txtjumtotk13N").html("0");$("#txtjumtotkmbN").html("0");$("#txtjumtotrombelN").html("0");
  $("#txtjumtotguruN").html("0");$("#txtjumtotidealguruN").html("0");$("#txtjumtotkurangguruN").html("0");

  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_kebutuhan_sd_negeri.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_kebutuhan_sd_negeri_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_kebutuhan_sd_negeri_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        var labels = ["Guru Kelas","PJOK","Pendidikan Agama","B. Inggris","TIK"];
        var values = [jum.jumgurukelasideal,jum.jumguruPJOKideal,jum.jumguruPAIideal,jum.jumguruBINGideal,jum.jumguruTIKideal];
        
        if (jum.JumGuru < jum.jumguruTOTALideal){var jmlkurangx = "Kurang  " + formatRibuan(jum.kurangguru.toString())}
        else if (jum.JumGuru > jum.jumguruTOTALideal){var jmlkurangx = "Lebih  " + formatRibuan(jum.kurangguru.toString())}

        $("#txtjumtotk13N").html(formatRibuan(jum.jumK13.toString()));
        $("#txtjumtotkmbN").html(formatRibuan(jum.jumKMB.toString()));
        $("#txtjumtotrombelN").html(formatRibuan(jum.jmlrombel.toString()));
        $("#txtjumtotguruN").html(formatRibuan(jum.JumGuru.toString()));
        $("#txtjumtotidealguruN").html(formatRibuan(jum.jumguruTOTALideal.toString()));
        $("#txtjumtotkurangguruN").html(jmlkurangx);
        
        var hitChartContent = document.getElementById('hitungChartKebutuhanSDN');
        hitChartContent.innerHTML = '';
        $('#hitungChartKebutuhanSDN').append('<canvas id="hitungKebutuhanSDN" height="300px"><canvas>');

        var salesChartCanvas = $('#hitungKebutuhanSDN').get(0).getContext('2d')
        var salesChartData = {
          labels: labels,
          datasets: [
            {
              label: 'Ideal Kebutuhan Guru',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: values,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
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
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: false },
              barPercentage: 0.4
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: true, color: "#0d6ecf" }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function hitungGrafikKebutuhanGuruSMP() {
  $("#txtjumtotk13smp").html("0");$("#txtjumtotkmbsmp").html("0");$("#txtjumtotrombelsmp").html("0");
  $("#txtjumtotgurusmp").html("0");$("#txtjumtotidealgurusmp").html("0");$("#txtjumtotkuranggurusmp").html("0");
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_kebutuhan_smp.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_kebutuhan_smp_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_kebutuhan_smp_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        var labels = ["PPKN","B. Indonesia","B. Inggris","Matematika","IPS","IPA","Prakarya","Seni Budaya","PJOK","Agama","TIK","BK"];
        var values = [jum.jumguruPPKNideal,jum.jumguruBINideal,jum.jumguruBINGideal,jum.jumguruMATideal,jum.jumguruIPSideal,jum.jumguruIPAideal,jum.jumguruPrakaryaideal,jum.jumguruSeniideal,jum.jumguruPJOKideal,jum.jumguruPAIideal,jum.jumguruTIKideal,jum.jumguruBKideal];
        
        if (jum.JumGuru < jum.jumguruTOTALideal){var jmlkurangx = "Kurang  " + formatRibuan(jum.kurangguru.toString())}
        else if (jum.JumGuru > jum.jumguruTOTALideal){var jmlkurangx = "Lebih  " + formatRibuan(jum.kurangguru.toString())}

        $("#txtjumtotk13smp").html(formatRibuan(jum.jumK13.toString()));
        $("#txtjumtotkmbsmp").html(formatRibuan(jum.jumKMB.toString()));
        $("#txtjumtotrombelsmp").html(formatRibuan(jum.jmlrombel.toString()));
        $("#txtjumtotgurusmp").html(formatRibuan(jum.JumGuru.toString()));
        $("#txtjumtotidealgurusmp").html(formatRibuan(jum.jumguruTOTALideal.toString()));
        $("#txtjumtotkuranggurusmp").html(jmlkurangx);

        var hitChartContent = document.getElementById('hitungChartKebutuhanSMP');
        hitChartContent.innerHTML = '';
        $('#hitungChartKebutuhanSMP').append('<canvas id="hitungKebutuhanSMP" height="300px"><canvas>');

        var salesChartCanvas = $('#hitungKebutuhanSMP').get(0).getContext('2d')
        var salesChartData = {
          labels: labels,
          datasets: [
            {
              label: 'Ideal Kebutuhan Guru',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: values,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
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
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: false },
              barPercentage: 0.8
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: true, color: "#0d6ecf" }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function hitungGrafikKebutuhanGuruSMPNegeri() {
  $("#txtjumtotk13smpN").html("0");$("#txtjumtotkmbsmpN").html("0");$("#txtjumtotrombelsmpN").html("0");
  $("#txtjumtotgurusmpN").html("0");$("#txtjumtotidealgurusmpN").html("0");$("#txtjumtotkuranggurusmpN").html("0");
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_kebutuhan_smp_negeri.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_kebutuhan_smp_negeri_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_kebutuhan_smp_negeri_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        var labels = ["PPKN","B. Indonesia","B. Inggris","Matematika","IPS","IPA","Prakarya","Seni Budaya","PJOK","Agama","TIK","BK"];
        var values = [jum.jumguruPPKNideal,jum.jumguruBINideal,jum.jumguruBINGideal,jum.jumguruMATideal,jum.jumguruIPSideal,jum.jumguruIPAideal,jum.jumguruPrakaryaideal,jum.jumguruSeniideal,jum.jumguruPJOKideal,jum.jumguruPAIideal,jum.jumguruTIKideal,jum.jumguruBKideal];
        
        if (jum.JumGuru < jum.jumguruTOTALideal){var jmlkurangx = "Kurang  " + formatRibuan(jum.kurangguru.toString())}
        else if (jum.JumGuru > jum.jumguruTOTALideal){var jmlkurangx = "Lebih  " + formatRibuan(jum.kurangguru.toString())}

        $("#txtjumtotk13smpN").html(formatRibuan(jum.jumK13.toString()));
        $("#txtjumtotkmbsmpN").html(formatRibuan(jum.jumKMB.toString()));
        $("#txtjumtotrombelsmpN").html(formatRibuan(jum.jmlrombel.toString()));
        $("#txtjumtotgurusmpN").html(formatRibuan(jum.JumGuru.toString()));
        $("#txtjumtotidealgurusmpN").html(formatRibuan(jum.jumguruTOTALideal.toString()));
        $("#txtjumtotkuranggurusmpN").html(jmlkurangx);

        var hitChartContent = document.getElementById('hitungChartKebutuhanSMPN');
        hitChartContent.innerHTML = '';
        $('#hitungChartKebutuhanSMPN').append('<canvas id="hitungKebutuhanSMPN" height="300px"><canvas>');

        var salesChartCanvas = $('#hitungKebutuhanSMPN').get(0).getContext('2d')
        var salesChartData = {
          labels: labels,
          datasets: [
            {
              label: 'Ideal Kebutuhan Guru',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: values,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
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
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: false },
              barPercentage: 0.8
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: true, color: "#0d6ecf" }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function isiGrafikAkreditasi() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_akreditasi.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_akreditasi_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_akreditasi_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    beforeSend: function (e) {
      $("#loading").fadeIn();
      document.body.style.cursor = "wait";
    },
    success: function (data) {
      var labels = [];
      var valA = []; var valB = []; var valC = []; var valBelum = []; var valTidak = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        labels.push(jum.nmbentuk);
        valA.push(jum.jumA); valB.push(jum.jumB); valC.push(jum.jumC);
        valBelum.push(jum.jumBelum); valTidak.push(jum.jumTidak);
      });

      var hitChartContent = document.getElementById('hitungChartContentAkreditasi');
      hitChartContent.innerHTML = '';
      $('#hitungChartContentAkreditasi').append('<canvas id="hitungChartAkreditasi" height="300px"><canvas>');

      var salesChartCanvas = $('#hitungChartAkreditasi').get(0).getContext('2d')
      var salesChartData = {
        labels: labels,
        datasets: [
          {
            label: 'A',
            backgroundColor: '#00FF00',
            borderColor: '#00FF00',
            data: valA,
          },
          {
            label: 'B',
            backgroundColor: 'rgb(0, 255, 255)',
            borderColor: 'rgb(0, 255, 255)',
            data: valB,
          },
          {
            label: 'C',
            backgroundColor: '#EEE8AA',
            borderColor: '#EEE8AA',
            data: valC,
          },
          {
            label: 'Belum Terakreditasi',
            backgroundColor: '#FFA500',
            borderColor: '#FFA500',
            data: valBelum,
          },
          {
            label: 'Tidak Terakreditasi',
            backgroundColor: 'rgb(255, 0, 0)',
            borderColor: 'rgb(255, 0, 0)',
            data: valTidak,
          },
        ]
      }

      var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: true,
          labels: {
            fontColor: 'rgb(255, 255, 255,0.9)'
          }
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
            ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)' },
            gridLines: { display: false, },
            barPercentage: 0.6
          }],
          yAxes: [{
            ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
            gridLines: { display: true, color: "#0d6ecf" }
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

function isiGrafikPutusSekolah() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_putus_sekolah.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_putus_sekolah_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_putus_sekolah_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    beforeSend: function (e) {
      $("#loading").fadeIn();
      document.body.style.cursor = "wait";
    },
    success: function (data) {
      var valsd = []; var valsmp = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        valsd.push(jum.jumSD);
        valsmp.push(jum.jumSMP);
      });

      var hitChartContent = document.getElementById('hitungChartPutus');
      hitChartContent.innerHTML = '';
      $('#hitungChartPutus').append('<canvas id="hitungPutus" height="250px"><canvas>');

      var salesChartCanvas = $('#hitungPutus').get(0).getContext('2d')
      var salesChartData = {
        labels: ['SD & SMP'],
        datasets: [
          {
            label: 'SD',
            backgroundColor: 'rgb(3, 201, 136)',
            borderColor: 'rgb(3, 201, 136)',
            data: valsd,
          },
          {
            label: 'SMP',
            backgroundColor: 'rgb(255, 105, 180)',
            borderColor: 'rgb(255, 105, 180)',
            data: valsmp,
          },
        ]
      }

      var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: true,
          labels: {
            fontColor: 'rgb(255, 255, 255,0.9)'
          }
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
            ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
            gridLines: { display: false },
            barPercentage: 0.6
          }],
          yAxes: [{
            ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
            gridLines: { display: true, color: "#0d6ecf" }
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

function isiGrafikLulusSekolah() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_lulus_sekolah.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_lulus_sekolah_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_lulus_sekolah_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    beforeSend: function (e) {
      $("#loading").fadeIn();
      document.body.style.cursor = "wait";
    },
    success: function (data) {
      var valsd = []; var valsmp = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        valsd.push(jum.jumSD);
        valsmp.push(jum.jumSMP);
      });

      var hitChartContent = document.getElementById('hitungChartKelulusan');
      hitChartContent.innerHTML = '';
      $('#hitungChartKelulusan').append('<canvas id="hitungKelulusan" height="250px"><canvas>');

      var salesChartCanvas = $('#hitungKelulusan').get(0).getContext('2d')
      var salesChartData = {
        labels: ['SD & SMP'],
        datasets: [
          {
            label: 'SD',
            backgroundColor: 'rgb(3, 201, 136)',
            borderColor: 'rgb(3, 201, 136)',
            data: valsd,
          },
          {
            label: 'SMP',
            backgroundColor: 'rgb(255, 105, 180)',
            borderColor: 'rgb(255, 105, 180)',
            data: valsmp,
          },
        ]
      }

      var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: true,
          labels: {
            fontColor: 'rgb(255, 255, 255,0.9)'
          }
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
            ticks: { fontColor: 'rgb(255, 255, 255,0.6)' },
            gridLines: { display: false },
            barPercentage: 0.6
          }],
          yAxes: [{
            ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
            gridLines: { display: true, color: "#0d6ecf" }
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

function isiGafikUsia() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_total_sekolah.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_total_sekolah_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_total_sekolah_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    async: false,
    dataType: 'json',
    success: function (data) {
      var labels = ["5 Thn","6 Thn","7 Thn","8 Thn","9 Thn","10 Thn","11 Thn","12 Thn","13 Thn","14 Thn","15 Thn","16 Thn","17 Thn","18 Thn"];
      var values = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        //labels.push(jum.nmbentuksekolah);
        values.push(jum.jumDetSekolah);

        var hitChartContent = document.getElementById('hitungChartContentPartisipasi');
        hitChartContent.innerHTML = '';
        $('#hitungChartContentPartisipasi').append('<canvas id="hitungChartPartisipasi" height="250px"><canvas>');

        var salesChartCanvas = $('#hitungChartPartisipasi').get(0).getContext('2d')
        var salesChartData = {
          labels: labels,
          datasets: [
            {
              label: 'Jumlah',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: values,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: true, color: "#0d6ecf" }
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: false, }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function isiGrafikSertifikasi() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "aksi/ambil_grafik_sertifikasi.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "aksi/ambil_grafik_sertifikasi_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "aksi/ambil_grafik_sertifikasi_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    async: false,
    dataType: 'json',
    success: function (data) {
      var labels = [];
      var values = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        document.body.style.cursor = "default";
        $("#loading").fadeOut("slow");

        labels.push(jum.nmbentuksekolah);
        values.push(jum.jumDetSekolah);

        const allData = [];
        for (let i = 0; i < labels.length; ++i) {
          allData.push({
            label: labels[i],
            data: values[i]
          });
        }

        allData.sort((b, a) => a.data - b.data);

        const sortedLabels = allData.map(e => e.label);
        const sortedData = allData.map(e => e.data);

        var hitChartContent = document.getElementById('hitungChartContentSertifikasi');
        hitChartContent.innerHTML = '';
        $('#hitungChartContentSertifikasi').append('<canvas id="hitungChartSertifikasi" height="250px"><canvas>');

        var salesChartCanvas = $('#hitungChartSertifikasi').get(0).getContext('2d')
        var salesChartData = {
          labels: sortedLabels,
          datasets: [
            {
              label: 'Jumlah',
              borderColor: 'rgb(255, 255, 255,0.6)',
              backgroundColor: getRandomColor,
              fill: true,
              pointBorderColor: 'rgba(0, 0, 0, 0)',
              pointBackgroundColor: 'rgba(0, 0, 0, 0)',
              pointHoverBackgroundColor: 'rgb(54, 162, 235)',
              pointHoverBorderColor: 'rgb(54, 162, 235)',
              data: sortedData,
            },
          ]
        }

        var salesChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          elements: {
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 8
            },
          },
          legend: {
            display: false
          },
          animation: {
            animateScale: true,
            animateRotate: true,
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)' },
              gridLines: { display: true, color: "#0d6ecf" }
            }],
            yAxes: [{
              ticks: { display: true, fontColor: 'rgb(255, 255, 255,0.6)', beginAtZero: true },
              gridLines: { display: false, }
            }]
          }

        }
        var salesChart = new Chart(salesChartCanvas, {
          type: 'bar',
          data: salesChartData,
          options: salesChartOptions,
        })
      });
    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function formatRibuan(angka, prefix) {
  var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}
