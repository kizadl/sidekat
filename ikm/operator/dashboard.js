var peta1 = L.tileLayer('https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 22,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
})
//var vector_kecamatan = L.layerGroup();
var wisatalayer = L.layerGroup();
var travellayer = L.layerGroup();
var hotellayer = L.layerGroup();
var restolayer = L.layerGroup();
// DEKLARASI LAYERGROUP
/*
    // LOOPING UNTUK GET VECTOR KECAMATAN, MEMANGGIL GEOJSON YG DI DATABASE
    $.ajax({
        type: "GET",
        url: "../operator/aksi/ambil_vektor_kecamatan.php",
        dataType: "json",
        method: "GET",
        success: function(data) {
            var i;
            for (i = 0; i < data.length; i++) {
                L.geoJSON(data[i], {
                    style: {
                        color: 'gray',
                        fillColor: getRandomColor(),
                        fillOpacity: 0,
                        weight: 1,
                    },
                }).addTo(vector_kecamatan)
            }
        },
        error: function() {
            console.log('Koneksi bermasalah periksa internet');
        },
    });

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
*/

var latsekolah = $("#lbllatitude").val();
var lonsekolah = $("#lbllongitude").val();

var map = L.map("map", {
    //center: [-8.16884, 113.70224],
    center: [latsekolah, lonsekolah],
    zoom: 22,
    //zoom: 10,
    layers: [peta1, wisatalayer, hotellayer, restolayer],
});

////POSISI ALUN2 JEMBER ////
var marker = L.circleMarker([-8.16884, 113.70224], {
    color: '#3388ff',
    weight: 2,
    fillOpacity: 0.4
}).addTo(map).bindPopup("Pusat Kota");
marker.setRadius(20);


// API UNTUK MARKER
var iconApiKey = "a6bdace0ef044b63b68223c23362f463";
// API UNTUK MARKER

// CUSTOM MARKER/PIN
var userIconSM = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    // iconUrl: `https://api.geoapify.com/v1/icon?size=xx-large&type=awesome&color=lightgreen&icon=user&apiKey=${iconApiKey}`,
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=lightgreen&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});
var travelIconSM = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=green&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});
var blueIconSM = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=blue&icon=house-damage&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [10, 10],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
    shadowSize: [68, 95],
});
var redIconSM = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=red&icon=building&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]

});
var goldIconSM = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=gold&icon=house-user&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});

var userIcon = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    iconUrl: `https://api.geoapify.com/v1/icon?size=xx-large&type=awesome&color=lightgreen&icon=user&apiKey=${iconApiKey}`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});
var travelIcon = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=green&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});
var blueIcon = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=blue&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});
var redIcon = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=red&icon=house-building&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});
var goldIcon = new L.Icon({
    //iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
    iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=gold&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
    iconSize: [4, 6],
    iconAnchor: [8, 10],
    popupAnchor: [1, -18],
    shadowSize: [10, 14]
});


ambilmarkerpendidikan();

function ambilmarkerpendidikan() {
    $.ajax({
        url: "aksi/ambil_marker_pendidikan.php",
        dataType: "json",
        method: "POST",
        success: function (data) {
            const pusatXY = "-8.16884, 113.70224";
            const pusat = pusatXY.split(',');
            var pusatX = pusat[0];
            var pusatY = pusat[1];

            var posisiX = $("#lbllatitude").val();
            var posisiY = $("#lbllongitude").val();

            for (var i = 0; i < data.length; i++) {
                const str2 = data[i].koordinat;
                const words2 = str2.split(',');

                //// menghitung jarak kota
                var markerFromKota = L.circleMarker([pusatX, pusatY]);
                var markerTo2 = L.circleMarker([words2[0], words2[1]]);
                var fromkota = markerFromKota.getLatLng();
                var to2 = markerTo2.getLatLng();
                var jarakkota = fromkota.distanceTo(to2).toFixed(0) / 1000;

                if (data[i].bentuk == "TK") {
                    var marker = L.circleMarker([words2[0], words2[1]], {
                        color: '#3388ff',
                        weight: 2,
                        fillOpacity: 0.1
                    }).bindPopup(
                        '<table>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Nama</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;"><b>' + data[i].nmtempat + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">NPSN</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].npsn + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].alamat + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Desa</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].desa + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kecamatan</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].kecamatan + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kabupaten</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jember" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Propinsi</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jawa Timur" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Status</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].status + '</td>' +
                        '</tr>' +
                        '</table>' +
                        '<br><span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                        '</span>' +
                        '<br><br>' +
                        '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                        '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'
                    ).addTo(wisatalayer)
                    marker.setRadius(8);

                } else if (data[i].bentuk == "SD" || data[i].bentuk == "SPK SD" || data[i].bentuk == "TK" || data[i].bentuk == "KB") {
                    var marker = L.circleMarker([words2[0], words2[1]], {
                        color: '#FF0000',
                        weight: 2,
                        fillOpacity: 0.1
                    }).bindPopup(
                        '<table>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Nama</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;"><b>' + data[i].nmtempat + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">NPSN</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].npsn + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].alamat + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Desa</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].desa + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kecamatan</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].kecamatan + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kabupaten</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jember" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Propinsi</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jawa Timur" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Status</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].status + '</td>' +
                        '</tr>' +

                        '</table>' +
                        '<br><span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                        '</span>' +
                        '<br><br>' +
                        '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                        '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                    ).addTo(hotellayer)
                    marker.setRadius(8);

                } else if (data[i].bentuk == "SMP" || data[i].bentuk == "SMPLB") {
                    var marker = L.circleMarker([words2[0], words2[1]], {
                        color: '#DAA520',
                        weight: 2,
                        fillOpacity: 0.1
                    }).bindPopup(
                        '<table>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Nama</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;"><b>' + data[i].nmtempat + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">NPSN</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].npsn + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].alamat + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Desa</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].desa + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kecamatan</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].kecamatan + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kabupaten</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jember" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Propinsi</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jawa Timur" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Status</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].status + '</td>' +
                        '</tr>' +

                        '</table>' +
                        '<br><span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                        '</span>' +
                        '<br><br>' +
                        '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                        '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                    ).addTo(restolayer)
                    marker.setRadius(8);

                } else if (data[i].bentuk == "SMA" || data[i].bentuk == "SMK") {
                    var marker = L.circleMarker([words2[0], words2[1]], {
                        color: '#663399',
                        weight: 2,
                        fillOpacity: 0.1
                    }).bindPopup(
                        '<table>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Nama</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;"><b>' + data[i].nmtempat + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">NPSN</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].npsn + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].alamat + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Desa</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].desa + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kecamatan</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].kecamatan + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kabupaten</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jember" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Propinsi</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jawa Timur" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Status</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].status + '</td>' +
                        '</tr>' +

                        '</table>' +
                        '<br><span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                        '</span>' +
                        '<br><br>' +
                        '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                        '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                    ).addTo(travellayer)
                    marker.setRadius(8);

                } else if (data[i].bentuk == "SPS" || data[i].bentuk == "Kursus" || data[i].bentuk == "TPA" || data[i].bentuk == "PKBM" || data[i].bentuk == "SLB" || data[i].bentuk == "SDLB" || data[i].bentuk == "SMLB" || data[i].bentuk == "SMPLB") {
                    var marker = L.circleMarker([words2[0], words2[1]], {
                        color: '#90EE90',
                        weight: 2,
                        fillOpacity: 0.1
                    }).bindPopup(
                        '<table>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Nama</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;"><b>' + data[i].nmtempat + '</b></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">NPSN</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].npsn + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].alamat + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Desa</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].desa + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kecamatan</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].kecamatan + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Kabupaten</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jember" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Propinsi</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + "Jawa Timur" + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="vertical-align: top;">Status</td><td style="vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td><td style="vertical-align: top;">' + data[i].status + '</td>' +
                        '</tr>' +

                        '</table>' +
                        '<br><span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                        '</span>' +
                        '<br><br>' +
                        '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                        '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                    ).addTo(travellayer)
                    marker.setRadius(8);

                }
            }
        },
    });
}

$('#map').on('click', 'a', function () {

    const pusatXY = "-8.16884, 113.70224";
    const pusat = pusatXY.split(',');
    var pusatX = pusat[0];
    var pusatY = pusat[1];

    var posisiX = $("#lbllatitude").val();
    var posisiY = $("#lbllongitude").val();

    const koordinat = $(this).data("koordinat");
    const poss = koordinat.split(',');
    var koordinatX = poss[0];
    var koordinatY = poss[1];

    var keterangan = $(this).data("keterangan");
    var ketjarak = $(this).data("ketjarak");

    map.closePopup();

    if (ketjarak == "user") {
        var control = L.Routing.control({
            createMarker: function () {
                return null;
            }, // menghilangkan marker tambahan						
            waypoints: [
                L.latLng(koordinatX, koordinatY),
                L.latLng(posisiX, posisiY)
            ],
            routeWhileDragging: false,
            reverseWaypoints: false,
            fitSelectedRoutes: true,
        }).addTo(map)
        //map.closePopup();
        control.hide();
        //control.spliceWaypoints(0, 1); // <-- removes your route
    } else if (ketjarak == "kota") {
        var control = L.Routing.control({
            createMarker: function () {
                return null;
            }, // menghilangkan marker tambahan					
            waypoints: [
                L.latLng(koordinatX, koordinatY),
                L.latLng(pusatX, pusatY)
            ],
            routeWhileDragging: false,
            reverseWaypoints: false,
            fitSelectedRoutes: true,
        }).addTo(map)
        control.hide();
    }
});

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

$("#lv_kota").click(function () {
    $("#area-halaman-utama").fadeIn();
    $("#area-upload-video").fadeOut("slow");
    $("#area-halaman-sekolah").fadeOut("slow");
    $("#area-upload-foto").fadeOut("slow");
    $("#area-halaman-kegiatan").fadeOut("slow");

    $("#div-video").html("")

    $("#txttransid").val("");
    $("#txttransketerangan").val("");
    $("#txttransnmwilayah").val("");
    map.closePopup();
    var nmwilayah = $(this).data('nama');
    $("#lblkoppeta").text(nmwilayah);
    var keterangan = $(this).data('keterangan');
    $("#txttransketerangan").val(keterangan);
    $("#txttransnmwilayah").val(nmwilayah);
    var koordinat = $(this).data('koordinat');
    const words1 = koordinat.split(',');
    map.setView([words1[0], words1[1]], 10);

    isiHalamanDetail();
});

$('#lv_input_profil').on('click', function () {
    var idsekolah = $("#lblidinstansi").val();
    $.ajax({
        type: "POST",
        url: "aksi/profil/edit_profil.php",
        data: {
            idsekolah: idsekolah
        },
        beforeSend: function (e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success: function (resp) {
            document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
            $("#isianModEditDataLarge").html(resp);
            $("#isianModEditDataLarge").fadeIn(1000);
            $("#modEditDataLarge").modal({
                backdrop: 'static',
                keyboard: false
            })
            $("#modEditDataLarge").modal('show');
        },
        error: function () {
            $("#loading").fadeOut("slow");
            alert("Koneksi bermasalah periksa internet");
            document.body.style.cursor = "default";
        },
    });
});

$('#lv_ptk').on('click', function () {
    var idsekolah = $("#lblidsekolah").val();
    $.ajax({
        type: "POST",
        url: "aksi/ptk/tampilkan-list-ptk.php",
        data: {
            idsekolah: idsekolah
        },
        beforeSend: function (e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success: function (resp) {
            document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
            $("#isianmodDetailLargeXtra").html(resp);
            $("#isianmodDetailLargeXtra").fadeIn(1000);
            $("#modDetailLargeXtra").modal({
                backdrop: 'static',
                keyboard: false
            })
            $("#modDetailLargeXtra").modal('show');
        },
        error: function () {
            $("#loading").fadeOut("slow");
            alert("Koneksi bermasalah periksa internet");
            document.body.style.cursor = "default";
        },
    });
});

$('#lv_input_sarana').on('click', function () {
    var idsekolah = $("#lblidinstansi").val();
    $.ajax({
        type: "POST",
        url: "aksi/profil/edit_data_sarana.php",
        data: {
            idsekolah: idsekolah
        },
        beforeSend: function (e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success: function (resp) {
            document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
            $("#isianModEditDataLarge").html(resp);
            $("#isianModEditDataLarge").fadeIn(1000);
            $("#modEditDataLarge").modal({
                backdrop: 'static',
                keyboard: false
            })
            $("#modEditDataLarge").modal('show');
        },
        error: function () {
            $("#loading").fadeOut("slow");
            alert("Koneksi bermasalah periksa internet");
            document.body.style.cursor = "default";
        },
    });
});

$("#lv_upload_video").click(function () {
    $("#txttransid").val("");
    $("#txttransketerangan").val("");
    $("#txttransnmwilayah").val("");
    map.closePopup();

    $("#area-halaman-utama").fadeOut("slow");
    $("#area-halaman-sekolah").fadeOut("slow");
    $("#area-upload-foto").fadeOut("slow");
    $('#hal-detail-sekolah').html("");
    $("#div-video").html("")
    $("#area-halaman-kegiatan").fadeOut("slow");
    $("#area-upload-video").fadeIn();
});

$("#lv_upload_foto").click(function () {
    $("#txttransid").val("");
    $("#txttransketerangan").val("");
    $("#txttransnmwilayah").val("");
    map.closePopup();

    $("#area-halaman-utama").fadeOut("slow");
    $("#area-halaman-sekolah").fadeOut("slow");
    $('#hal-detail-sekolah').html("");
    $("#div-video").html("")
    $("#area-upload-video").fadeOut("slow");
    $("#area-halaman-kegiatan").fadeOut("slow");
    $("#area-upload-foto").fadeIn();
});

$("#lv_profil").click(function () {
    $("#txttransid").val("");
    $("#txttransketerangan").val("");
    $("#txttransnmwilayah").val("");
    map.closePopup();

    $("#loading").fadeIn();
    document.body.style.cursor = "wait";

    $("#area-halaman-utama").fadeOut("slow");
    $("#area-upload-video").fadeOut("slow");
    $("#area-upload-foto").fadeOut("slow");
    $("#area-halaman-kegiatan").fadeOut("slow");
    $("#area-halaman-sekolah").fadeIn();

    $('#hal-detail-sekolah').html("");
    setTimeout(function () {

        //let player = Plyr.setup('.popin__video-container');
        //player.restart();
        isiVideo()
        isiFotoKelas()
        isiFotoPerpustakaan()
        isiFotoKepsek()
        isiFotoGuru()
        isiFotoPembinaan()
        isiFotoMultimedia()
        isiFotoKomputer()
        isiFotoIPS()
        isiFotoIPA()
        isiFotoBahasa()
        isiFotoWCUmum()
        isiFotoWCSiswa()
        isiFotoWCGuru()
        isiFotoIbadah()
        isiFotoAsrama()

        $("#loading").fadeOut("slow");
        document.body.style.cursor = "default";
    }, 5000);
});

$('#lv_operator').on('click', function () {
    var idoperator = $("#lbleditor").val();
    var idinstansi = $("#lblidinstansi").val();
    $.ajax({
        type: "POST",
        url: "aksi/profil/edit_profil_operator.php",
        data: {
            idoperator: idoperator,
            idinstansi: idinstansi
        },
        beforeSend: function (e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success: function (resp) {
            document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
            $("#isianModEditDataLarge").html(resp);
            $("#isianModEditDataLarge").fadeIn(1000);
            $("#modEditDataLarge").modal({
                backdrop: 'static',
                keyboard: false
            })
            $("#modEditDataLarge").modal('show');
        },
        error: function () {
            $("#loading").fadeOut("slow");
            alert("Koneksi bermasalah periksa internet");
            document.body.style.cursor = "default";
        },
    });
});

function isiHalamanDetail() {
    var idsekolah = $("#lblidinstansi").val();
    //window.scrollTo(0, 0);
    $.ajax({
        type: 'POST',
        url: "aksi/tampilkan/tampilkan-detail-dashboard.php",
        data: {
            idsekolah: idsekolah
        },
        beforeSend: function (e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success: function (resp) {
            $("#loading").fadeOut("slow");
            document.body.style.cursor = "default";
            $("#area-halaman-utama").fadeIn();
            $("#area-upload-video").fadeOut("slow");
            $("#area-upload-foto").fadeOut("slow");
            $("#area-halaman-sekolah").fadeOut("slow");

            $('#hal-detail-sekolah').html(resp);

        },
        error: function () {
            $("#loading").fadeOut("slow");
            document.body.style.cursor = "default";
            alert("Koneksi ke server terputus");
        },
    });
}

function isiVideo() {
    //let player = Plyr.setup('.popin__video-container');
    //player.pause();
    $("#div-video").html("")
    var idsekolah = $("#lblidinstansi").val();
    $("#div-video").html('<source src="../data-media/video/' + idsekolah + '.mp4" type="video/mp4" size="576">')
}

function isiFotoKelas() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "kelas";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery1"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-kelas').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoPerpustakaan() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "perpustakaan";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery2"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-perpustakaan').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoKepsek() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "kepsek";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery3"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-kepsek').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoGuru() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "guru";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery4"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-guru').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoPembinaan() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "pembinaan";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery5"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-pembinaan').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoMultimedia() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "multimedia";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery6"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-multimedia').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoKomputer() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "komputer";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery7"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-komputer').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoIPS() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "ips";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery8"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-ips').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoIPA() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "ipa";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery9"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-ipa').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoBahasa() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "bahasa";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery10"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-bahasa').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoWCUmum() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "wcumum";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery11"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-wcumum').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoWCSiswa() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "wcsiswa";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery12"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-wcsiswa').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoWCGuru() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "wcguru";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery13"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-wcguru').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoIbadah() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "ibadah";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery14"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-ibadah').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}

function isiFotoAsrama() {
    var idsekolah = $("#lblidinstansi").val();
    var ruang = "asrama";
    $.ajax({
        type: "POST",
        url: "aksi/list-file/kelas.php",
        data: {
            idsekolah: idsekolah,
            ruang: ruang
        },
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html +=
                    '<div class="col-3 p-1"><a class="glightbox" href="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" data-gallery="gallery15"><img class="img-fluid rounded" src="../data-media/foto/' + idsekolah + '/' + ruang + '/' + data[i].nmfile + '" alt="" /></a></div>'
            }
            $('#div-asrama').html(html);
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox'
            });
        },
        error: function () {
            console.log('error');
        },
    });
}
