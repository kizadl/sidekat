
                <!---------------- tabel jam mengajar ------------------>
                <div class="col-xxl-12" id="area-halaman-jam-mengajar" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol <strong>Tambah Data</strong> untuk menambahkan data,
                                        Tombol <strong>Refresh</strong> untuk merefresh data <strong>Jam Mata Pelajaran</strong><br />
                                        Tombol &nbsp;&nbsp;<span class="fas fa-edit"></span> &nbsp;&nbsp;<strong>(Ikon edit)</strong> untuk edit data,
                                        Tombol &nbsp;&nbsp;<span class="fas fa-trash-alt"></span> &nbsp;&nbsp;<strong>(Ikon hapus)</strong> untuk hapus data <strong>Jam Mata Pelajaran</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Jam Mata Pelajaran</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdTambahJam"><span class="d-none d-sm-inline-block ms-1">Tambah Data</span></button>
                                                <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshJam"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelJamMapel" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center align-middle">No.</th>
                                                    <th class="sort text-center align-middle">Kode Mapel</th>
                                                    <th class="sort text-center align-middle">Mata Pelajaran</th>
                                                    <th class="sort text-center align-middle">Jam</th>
                                                    <th class="sort text-center align-middle">Pendidikan</th>
                                                    <th class="sort text-center"></th>
                                                    <th class="sort text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelJamMapel" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir jam mengajar ------------------>

                <!---------------- tabel rombel SD ------------------>
                <div class="col-xxl-12" id="area-halaman-rombel-SD" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol <strong>Refresh</strong> untuk menampilkan data,
                                        Tombol <strong>Export</strong> untuk export excel data <strong>Rombongan Belajar</strong><br />
                                        Tombol &nbsp;&nbsp;<span class="fas fa-cog"></span> &nbsp;&nbsp;<strong>(Ikon Pembelajaran)</strong> untuk menampilkan detail <strong>Pembelajaran Sekolah</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Rombongan Belajar - Sekolah Dasar (SD)</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="180px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterrombelSD" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data</option>
                                                                <option value="KMB">Merdeka Belajar</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshRombelSD"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>

                                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExcelRombelSD"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelRombelSD" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center align-middle">No.</th>
                                                    <th class="sort text-center align-middle">NPSN</th>
                                                    <th class="sort text-center align-middle">Nama Sekolah</th>
                                                    <th class="sort text-center align-middle">Status</th>
                                                    <th class="sort text-center align-middle">Rombel</th>
                                                    <th class="sort text-center align-middle">1</th>
                                                    <th class="sort text-center align-middle">2</th>
                                                    <th class="sort text-center align-middle">3</th>
                                                    <th class="sort text-center align-middle">4</th>
                                                    <th class="sort text-center align-middle">5</th>
                                                    <th class="sort text-center align-middle">6</th>
                                                    <th class="sort text-center align-middle">K13</th>
                                                    <th class="sort text-center align-middle">KMB</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelRombelSD" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir rombel SD ------------------>

                <!---------------- tabel rombel SMP ------------------>
                <div class="col-xxl-12" id="area-halaman-rombel-SMP" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol <strong>Refresh</strong> untuk menampilkan data,
                                        Tombol <strong>Export</strong> untuk export excel data <strong>Rombongan Belajar</strong><br />
                                        Tombol &nbsp;&nbsp;<span class="fas fa-cog"></span> &nbsp;&nbsp;<strong>(Ikon Pembelajaran)</strong> untuk menampilkan detail <strong>Pembelajaran Sekolah</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Rombongan Belajar - Sekolah Menengah Pertama (SMP)</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="180px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterrombelSMP" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data</option>
                                                                <option value="KMB">Merdeka Belajar</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshRombelSMP"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>

                                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExcelRombelSMP"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelRombelSMP" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center align-middle">No.</th>
                                                    <th class="sort text-center align-middle">NPSN</th>
                                                    <th class="sort text-center align-middle">Nama Sekolah</th>
                                                    <th class="sort text-center align-middle">Status</th>
                                                    <th class="sort text-center align-middle">Rombel</th>
                                                    <th class="sort text-center align-middle">7</th>
                                                    <th class="sort text-center align-middle">8</th>
                                                    <th class="sort text-center align-middle">9</th>
                                                    <th class="sort text-center align-middle">K13</th>
                                                    <th class="sort text-center align-middle">KMB</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelRombelSMP" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir rombel SMP ------------------>

                <!---------------- tabel kebutuhan SD ------------------>
                <div class="col-xxl-12" id="area-halaman-kebutuhan-SD" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol <strong>Refresh</strong> untuk menampilkan data,
                                        Tombol <strong>Export</strong> untuk export excel data <strong>Kebutuhan Guru</strong><br />
                                        Tombol &nbsp;&nbsp;<span class="fas fa-cog"></span> &nbsp;&nbsp;<strong>(Ikon Pembelajaran)</strong> untuk menampilkan detail <strong>Pembelajaran Sekolah</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Kebutuhan Guru - Sekolah Dasar (SD)</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="180px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterkebutuhanSD" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data</option>
                                                                <option value="KMB">Merdeka Belajar</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshKebutuhanSD"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExcelKebutuhanSD"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelKebutuhanSD" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th rowspan="2" class="sort text-center align-middle">No.</th>
                                                    <th rowspan="2" class="sort text-center align-middle">NPSN</th>
                                                    <th rowspan="2" class="sort text-center align-middle">Nama Sekolah</th>
                                                    <th rowspan="2" class="sort text-center align-middle">Status</th>
                                                    <th colspan="3" class="sort text-center" style="background:#F5F5DC;">Rombel</th>
                                                    <th colspan="2" class="sort text-center">PTK</th>
                                                    <th colspan="4" class="sort text-center" style="background:#F5F5DC;">Status Kepegawaian</th>
                                                    <th colspan="6" class="sort text-center"><span class="text-danger">Guru Pengampu</span> : <span class="text-primary">Ideal Kebutuhan Guru</span></th>
                                                    <!--th colspan="5" class="sort text-center" style="background:#F5F5DC;">Guru Mapel</th-->
                                                    <th rowspan="2" class="sort text-center align-middle" style="background:#F5F5DC;">+/-</th>
                                                    <th rowspan="2" class="sort text-center"></th>
                                                </tr>
                                                <tr>
                                                    <th class="sort text-center" style="background:#F5F5DC;">K13</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">KMB</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">Rombel</th>

                                                    <th class="sort text-center">PTT</th>
                                                    <th class="sort text-center">Guru</th>

                                                    <th class="sort text-center" style="background:#F5F5DC;">PNS</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">PPPK</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">GTT</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">HONORER</th>

                                                    <th class="sort text-center">Kelas</th>
                                                    <th class="sort text-center">PJOK</th>
                                                    <th class="sort text-center">PAI</th>
                                                    <th class="sort text-center">BING</th>
                                                    <th class="sort text-center">TIK</th>
                                                    <th class="sort text-center">Jumlah</th>

                                                    <!--th class="sort text-center" style="background:#F5F5DC;">Kelas</!--th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">PJOK</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">PAI</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">BING</th>
                                                    <th-- class="sort text-center" style="background:#F5F5DC;">TIK</th-->
                                                   
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelKebutuhanSD" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir kebutuhan SD ------------------>


                <!---------------- tabel kebutuhan SMP ------------------>
                <div class="col-xxl-12" id="area-halaman-kebutuhan-SMP" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol <strong>Refresh</strong> untuk menampilkan data,
                                        Tombol <strong>Export</strong> untuk export excel data <strong>Kebutuhan Guru</strong><br />
                                        Tombol &nbsp;&nbsp;<span class="fas fa-cog"></span> &nbsp;&nbsp;<strong>(Ikon Pembelajaran)</strong> untuk menampilkan detail <strong>Pembelajaran Sekolah</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Kebutuhan Guru - Sekolah Menengah Pertama (SMP)</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="180px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterkebutuhanSMP" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data</option>
                                                                <option value="KMB">Merdeka Belajar</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshKebutuhanSMP"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>

                                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExcelKebutuhanSMP"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelKebutuhanSMP" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th rowspan="2" class="sort text-center align-middle">No.</th>
                                                    <th rowspan="2" class="sort text-center align-middle">NPSN</th>
                                                    <th rowspan="2" class="sort text-center align-middle">Nama Sekolah</th>
                                                    <th rowspan="2" class="sort text-center align-middle">Status</th>
                                                    <th colspan="3" class="sort text-center" style="background:#F5F5DC;">Rombel</th>
                                                    <th colspan="2" class="sort text-center">PTK</th>
                                                    <th colspan="4" class="sort text-center" style="background:#F5F5DC;">Status Kepegawaian</th>
                                                    <th colspan="13" class="sort text-center"><span class="text-danger">Guru Pengampu</span> : <span class="text-primary">Ideal Kebutuhan Guru</span></th>
                                                    <!--th colspan="5" class="sort text-center" style="background:#F5F5DC;">Guru Mapel</th-->
                                                    <th rowspan="2" class="sort text-center align-middle" style="background:#F5F5DC;">+/-</th>
                                                    <th rowspan="2" class="sort text-center"></th>
                                                </tr>
                                                <tr>
                                                    <th class="sort text-center" style="background:#F5F5DC;">K13</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">KMB</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">Rombel</th>

                                                    <th class="sort text-center">PTT</th>
                                                    <th class="sort text-center">Guru</th>

                                                    <th class="sort text-center" style="background:#F5F5DC;">PNS</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">PPPK</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">GTT</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">HONORER</th>

                                                    <th class="sort text-center">PKN</th>
                                                    <th class="sort text-center">BIN</th>
                                                    <th class="sort text-center">BING</th>
                                                    <th class="sort text-center">MAT</th>
                                                    <th class="sort text-center">IPS</th>
                                                    <th class="sort text-center">IPA</th>
                                                    <th class="sort text-center">Prakarya</th>
                                                    <th class="sort text-center">Seni</th>
                                                    <th class="sort text-center">PJOK</th>
                                                    <th class="sort text-center">Agama</th>
                                                    <th class="sort text-center">TIK</th>
                                                    <th class="sort text-center">BK</th>
                                                    <th class="sort text-center">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelKebutuhanSMP" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir kebutuhan SMP ------------------>

                <!---------------- tabel PTK ------------------>
                <div class="col-xxl-12" id="area-halaman-PTK" style="display:none">
                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card bg-light h-lg-100">
                                <div class="card-body d-flex align-items-center">
                                    <p class="fs--1 mt-0 mb-0">
                                        Tombol <strong>Refresh</strong> untuk menampilkan data,
                                        Tombol <strong>Export</strong> untuk export excel data <strong>Kepegawaian (PTK)</strong><br />
                                        Tombol &nbsp;&nbsp;<span class="fas fa-user-friends"></span> &nbsp;&nbsp;<strong>(Ikon Pegawai)</strong> untuk menampilkan detail <strong>Kepegawaian (PTK)</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-xxl-12">
                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center g-0">
                                        <div class="col-auto">
                                            <h6 class="fs-0 mb-0">Data Kepegawaian (PTK)</h6>
                                        </div>

                                        <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                                            <div id="table-purchases-replace-element">
                                                <table>
                                                    <tr>
                                                        <td width="300px">
                                                            <select class="form-select js-choice px-3 fs--1" id="cbofilterPTK" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="semua">Semua Data</option>
                                                                <option value="SD">Sekolah Dasar (SD)</option>
                                                                <option value="SMP">Sekolah Menengah Pertama (SMP)</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <button class="btn btn-falcon-default btn-sm me-1" type="button" id="cmdRefreshPTK"><span class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdExcelPTK"><span class="d-none d-sm-inline-block ms-1">Export</span></button>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabelPTK" class="table table-sm table-striped mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th rowspan="2" class="sort text-center align-middle">No.</th>
                                                    <th rowspan="2" class="sort text-center align-middle">NPSN</th>
                                                    <th rowspan="2" class="sort text-center align-middle">Nama Sekolah</th>
                                                    <th rowspan="2" class="sort text-center align-middle">Status</th>

                                                    <th colspan="2" class="sort text-center">PTK</th>
                                                    <th colspan="4" class="sort text-center" style="background:#F5F5DC;">Status Kepegawaian</th>

                                                    <th rowspan="2" class="sort text-center align-middle"></th>
                                                </tr>
                                                <tr>

                                                    <th class="sort text-center">PTT</th>
                                                    <th class="sort text-center">Guru</th>

                                                    <th class="sort text-center" style="background:#F5F5DC;">PNS</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">PPPK</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">GTT</th>
                                                    <th class="sort text-center" style="background:#F5F5DC;">HONORER</th>

                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabelPTK" />
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!---------------- akhir tabel PTK ------------------>

