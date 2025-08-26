<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Faq Question Pengaduan</h5>
        <p class="fs--1 mb-0 text-white">Pertanyaan dan jawaban umum pengaduan</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3">

    <div class="row mb-0 mt-0 g-3">
        <div class="col-xxl-12">

            <div class="accordion border rounded overflow-hidden" id="accordionFaq">
                <?php
                $sqlx = ("SELECT p.id_faq,p.judul_faq,p.uraian_faq FROM faq_ppdb p ORDER BY p.id_faq DESC");
                $result = mysqli_query($dbconn, $sqlx);
                $data = array();
                $no = 0;
                while ($t = mysqli_fetch_array($result)) {
                    $no++;

                    $idfaq = $t['id_faq'];
                    $judulfaq = $t['judul_faq'];
                    $uraianfaq = $t['uraian_faq'];
                    echo "

 <div class='card shadow-none rounded-bottom-0 border-bottom'>
 <div class='accordion-item border-0'>
     <div class='card-header p-0' id='faqAccordionHeading$idfaq'>
         <button class='accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start rounded-0 shadow-none' data-bs-toggle='collapse' data-bs-target='#collapseFaqAccordion$idfaq' aria-expanded='false' aria-controls='collapseFaqAccordion$idfaq'><span class='fas fa-caret-right accordion-icon me-3' data-fa-transform='shrink-2'></span><span class='fw-medium font-sans-serif text-900 fs--1'>$judulfaq</span></button>
     </div>
     <div class='accordion-collapse collapse' id='collapseFaqAccordion$idfaq' aria-labelledby='faqAccordionHeading$idfaq' data-parent='#accordionFaq'>
         <div class='accordion-body p-0'>
             <div class='card-body pt-2'>
                 <p class='ps-3 mb-0 fs--1'>$uraianfaq</p>
             </div>
         </div>
     </div>
 </div>
</div>
";
                }
                ?>

            </div>
        </div>

    </div>
</div>

</div>

<div class="modal-footer float-right">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Close</button>
</div>