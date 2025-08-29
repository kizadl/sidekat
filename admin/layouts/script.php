<script>
    function toggleDropdownArsip() {
        var dropdown = document.getElementById("dropdownMenuArsip");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    document.addEventListener("DOMContentLoaded", function () {
        var current = window.location.pathname.split("/").pop(); // ambil nama file
        var arsipPages = [
            "arsip_magang.html",
            "arsip_penelitian.html",
            "arsip_studi_edukasi.html",
            "arsip_kunjungan_kerja.html"
        ];

        if (arsipPages.includes(current)) {
            document.getElementById("dropdownMenuArsip").style.display = "block";
        }
    });
    
    function toggleDropdownIkm() {
        var dropdown = document.getElementById("dropdownMenuIkm");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    document.addEventListener("DOMContentLoaded", function () {
        var current = window.location.pathname.split("/").pop(); // ambil nama file
        var arsipPages = [
            "arsip_magang.html",
        ];

        if (arsipPages.includes(current)) {
            document.getElementById("dropdownMenuIkm").style.display = "block";
        }
    });
</script>

<script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
