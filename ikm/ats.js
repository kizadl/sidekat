$("#cbokecamatanspm").on("change",function(){
	var idkecamatan = $("#cbokecamatanspm").val()
  var namakecamatan = $("#cbokecamatanspm :selected").text();
  $(".lblkopgrafik1").text(namakecamatan)
	$.ajax({
	  type:"POST",
	  url : "web/aksi/ats/ambil_data_desa.php",
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
			$("#cbodesaspm").append('<option value="'+data[i].nmdesa+'">'+data[i].nmdesa+'</option>')
		}	 
    hitungGrafikTotalSekolah();
    isiGrafikStatus();
    isiGrafikAkreditasi();
    isiGrafikKelamin()
    isiGafikUsia();
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

  var namakecamatan = $("#cbokecamatanspm :selected").text();
  var namadesa = $("#cbodesaspm :selected").text();
  $(".lblkopgrafik1").text(namakecamatan + " - " + namadesa)

  if (idkecamatan != "all" && iddesa != ""){
    hitungGrafikTotalSekolah();
    isiGrafikStatus();
    isiGrafikAkreditasi();
    isiGrafikKelamin()
    isiGafikUsia();
  }
});

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
  if (idkecamatan == "all"){var urlnya = "web/aksi/ats/ambil_grafik_total_sekolah.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "web/aksi/ats/ambil_grafik_total_sekolah_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "web/aksi/ats/ambil_grafik_total_sekolah_desa.php";}
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
  if (idkecamatan == "all"){var urlnya = "web/aksi/ats/ambil_grafik_status_sekolah.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "web/aksi/ats/ambil_grafik_status_sekolah_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "web/aksi/ats/ambil_grafik_status_sekolah_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
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

      document.body.style.cursor = "default";

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
  if (idkecamatan == "all"){var urlnya = "web/aksi/ats/ambil_grafik_akreditasi.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "web/aksi/ats/ambil_grafik_akreditasi_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "web/aksi/ats/ambil_grafik_akreditasi_desa.php";}
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

        var hitChartContent = document.getElementById('hitungChartContentAkreditasi');
        hitChartContent.innerHTML = '';
        $('#hitungChartContentAkreditasi').append('<canvas id="hitungChartAkreditasi" height="250px"><canvas>');

        var salesChartCanvas = $('#hitungChartAkreditasi').get(0).getContext('2d')
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

function isiGrafikKelamin() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "web/aksi/ats/ambil_grafik_kelamin.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "web/aksi/ats/ambil_grafik_kelamin_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "web/aksi/ats/ambil_grafik_kelamin_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      var labels = ["Jenis Kelamin"];
      var valL = []; var valP = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
       // labels.push(jum.nmbentuksekolah);
        valL.push(jum.jumL);
        valP.push(jum.jumP);
      });

      var hitChartContent = document.getElementById('hitungChartKelamin');
      hitChartContent.innerHTML = '';
      $('#hitungChartKelamin').append('<canvas id="hitungKelamin" height="250px"><canvas>');

      var salesChartCanvas = $('#hitungKelamin').get(0).getContext('2d')
      var salesChartData = {
        labels: labels,
        datasets: [
          {
            label: 'Laki-laki',
            backgroundColor: getRandomColor,
            borderColor: 'rgb(0, 255, 255)',
            data: valL,
          },
          {
            label: 'Perempuan',
            backgroundColor: getRandomColor,
            borderColor: 'rgb(255, 105, 180)',
            data: valP,
          },
        ]
      }

      var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false,
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

      document.body.style.cursor = "default";

    },
    error: function () {
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";
    },
  });
}

function isiGafikUsia() {
  var idkecamatan = $("#cbokecamatanspm").val();
  var iddesa = $("#cbodesaspm").val();
  if (idkecamatan == "all"){var urlnya = "web/aksi/ats/ambil_grafik_umur.php";}
  else if (idkecamatan != "all" && iddesa == ""){var urlnya = "web/aksi/ats/ambil_grafik_umur_kecamatan.php";}
  else if (idkecamatan != "all" && iddesa != ""){var urlnya = "web/aksi/ats/ambil_grafik_umur_desa.php";}
  $.ajax({
    type: "POST",
    url: urlnya,
    data:{idkecamatan:idkecamatan,iddesa:iddesa},
    dataType: 'json',
    success: function (data) {
      var labels = ["Kelompok Umur"];
      var val7_12 = []; var val13_15 = [];var val16_18 = [];
      myArray = data;
      $.each(myArray, function (index, jum) {
        val7_12.push(jum.jum7_12);
        val13_15.push(jum.jum13_15);
        val16_18.push(jum.jum16_18);
      });

      var hitChartContent = document.getElementById('hitungChartKelompokUmur');
      hitChartContent.innerHTML = '';
      $('#hitungChartKelompokUmur').append('<canvas id="hitungKelompokUmur" height="250px"><canvas>');

      var salesChartCanvas = $('#hitungKelompokUmur').get(0).getContext('2d')
      var salesChartData = {
        labels: labels,
        datasets: [
          {
            label: '7-12',
            backgroundColor: getRandomColor,
            borderColor: 'rgb(0, 255, 255)',
            data: val7_12,
          },
          {
            label: '13-15',
            backgroundColor: getRandomColor,
            borderColor: 'rgb(255, 105, 180)',
            data: val13_15,
          },
          {
            label: '16-18',
            backgroundColor: getRandomColor,
            borderColor: 'rgb(255, 105, 180)',
            data: val16_18,
          },
        ]
      }

      var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false,
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
		
      $("#loading").fadeOut("slow");
      document.body.style.cursor = "default";

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


$("#cmdLogin").click(function() {
  $("#loginFrm").submit(function(e) {
    return false;
  });
  var name = $("#txtusername").val();
  var nameLength = name.length;
  var pw = $("#txtpassword").val();
  var pwLength = pw.length;
  if (nameLength == 0) {
    $("#txtusername").focus();
    alert("Maaf, username masih kosong");
  } else if (pwLength == 0) {
    $("#txtpassword").focus();
    alert("Maaf, password masih kosong");
  } else if (nameLength && pwLength >= 1) {
    $.ajax({
      type: "POST",
      url: "services/login_user.php",
      data: {
        checkUser: '',
        uid: name,
        pwrd: pw
      },
      beforeSend: function(e) {
        $("#cmdLogin").attr("disabled", "disabled");
        document.body.style.cursor = "wait";
      },
      success: function(resp) {
        document.body.style.cursor = "default";
        $("#cmdLogin").removeAttr("disabled");
        $("#loginMsg").html(resp);
      },
      error: function() {
        alert('Koneksi bermasalah periksa internet');
        document.body.style.cursor = "default";
        $("#cmdLogin").removeAttr("disabled");
      },
    });
  }
});