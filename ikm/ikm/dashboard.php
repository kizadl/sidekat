    <!-- AREA DASHBOARD ADMINISTRATOR -->
    <div class="container-fluid" id="area-dashboard-ikm-admin" style="display:none">

      <div class="callout callout-info">
        <h3 class="card-title"><i class="fas fa-th mr-1"></i>&nbsp;&nbsp;<span id="kopdashboardADMIN"></span></h3>
        <span class="float-right" id="koptgldashboardADMIN"></span>
        <br>
      </div>

      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h4><span id="lblDBjumTPADMIN"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenTPADMIN"></span> <small>%</small></h4>
              <p>Tidak Puas</p>
            </div>
            <div class="small-box-footer" id="koptgldashboard1ADMIN"></div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h4><span id="lblDBjumKPADMIN"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenKPADMIN"></span> <small>%</small></h4>
              <p>Kurang Puas</p>
            </div>
            <div class="small-box-footer" id="koptgldashboard2ADMIN"></div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h4><span id="lblDBjumPADMIN"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenPADMIN"></span> <small>%</small></h4>
              <p>Puas</p>
            </div>
            <div class="small-box-footer" id="koptgldashboard3ADMIN"></div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h4><span id="lblDBjumSPADMIN"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenSPADMIN"></span> <small>%</small></h4>
              <p>Sangat Puas</p>
            </div>
            <div class="small-box-footer" id="koptgldashboard4ADMIN"></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Grafik Per Bulan (12 Bulan Terakhir)
              </h3>
            </div>
            <div class="card-body">
              <div class="chart" id="hitungChartContentADMIN">
                <canvas id="hitungChartADMIN" height="200"></canvas>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-danger" id="lblDBTotpersenTPADMIN"></span>
                    <h5 class="description-header" id="lblDBTotjumTPADMIN"></h5>
                    <span class="description-text">TIDAK PUAS</span>
                  </div>
                </div>
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-warning" id="lblDBTotpersenKPADMIN"></span>
                    <h5 class="description-header" id="lblDBTotjumKPADMIN"></h5>
                    <span class="description-text">KURANG PUAS</span>
                  </div>
                </div>
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success" id="lblDBTotpersenPADMIN"></span>
                    <h5 class="description-header" id="lblDBTotjumPADMIN"></h5>
                    <span class="description-text">PUAS</span>
                  </div>
                </div>
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                    <span class="description-percentage text-info" id="lblDBTotpersenSPADMIN"></span>
                    <h5 class="description-header" id="lblDBTotjumSPADMIN"></h5>
                    <span class="description-text">SANGAT PUAS</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Persentase Unsur Penilaian IKM (12 Bulan Terakhir)
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table width="100%" class="table table-striped table-hover table-bordered table-sm" id="tblDashboardADMIN">
            <thead class="thead-default">
              <tr>
                <th width="5%" style="vertical-align:middle;">
                  <center>No</center>
                </th>
                <th width="71%" style="vertical-align:middle;">
                  <center>Unsur Penilaian</center>
                </th>
                <th width="6%" style="vertical-align:middle;">
                  <center>Tidak</center>
                </th>
                <th width="6%" style="vertical-align:middle;">
                  <center>Kurang</center>
                </th>
                <th width="6%" style="vertical-align:middle;">
                  <center>Puas</center>
                </th>
                <th width="6%" style="vertical-align:middle;">
                  <center>Sangat</center>
                </th>
              </tr>
            </thead>
            <tbody id="isitabelDashboardADMIN"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- AREA LAPORAN -->
    <div class="container-fluid" id="area-laporan-ikm" style="display:none">

      <div class="callout callout-info">
        <h3 class="card-title"><i class="fas fa-th mr-1"></i>&nbsp;&nbsp;<span id="koplaporan"></span></h3>
        <div class="form-group row" style="display:block;">
          <table class="float-right" style="display:block;">
            <tr>
              <td width="145px">
                <div class="input-group">
                  <input type="date" class="form-control datepicker-input" data-target="#reservation" id="txttglawal" style="width:50px;height:31px;font-size:13.5px;">
                </div>
              </td>
              <td align="center">&nbsp;s/d&nbsp;</td>
              <td width="145px">
                <div class="input-group">
                  <input type="date" class="form-control datepicker-input" data-target="#reservation" id="txttglakhir" style="width:50px;height:31px;font-size:13.5px;">
                </div>
              </td>
              <td align="center">&nbsp;</td>
              <td>
                <button class="btn btn-default btn-sm" id="cmdRefreshLaporan">Refresh</button>
              </td>
            </tr>
          </table>
        </div><br>
      </div>

      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h4><span id="lblDBjumTPlaporan"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenTPlaporan"></span> <small>%</small></h4>
              <p>Tidak Puas</p>
            </div>
            <div class="small-box-footer"></div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h4><span id="lblDBjumKPlaporan"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenKPlaporan"></span> <small>%</small></h4>
              <p>Kurang Puas</p>
            </div>
            <div class="small-box-footer"></div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h4><span id="lblDBjumPlaporan"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenPlaporan"></span> <small>%</small></h4>
              <p>Puas</p>
            </div>
            <div class="small-box-footer"></div>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h4><span id="lblDBjumSPlaporan"></span></h4>
              <h4 class="float-right"><span id="lblDBpersenSPlaporan"></span> <small>%</small></h4>
              <p>Sangat Puas</p>
            </div>
            <div class="small-box-footer"></div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Data Hasil Survei Kepuasan Masyarakat
          </h3>
          <div class="card-tools">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-sm">Cetak Laporan</button>
              <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                <span class="sr-only">Toggle Dropdown</span>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                  <a class="dropdown-item" href="#" onclick="LaporanSurvei();">Laporan Hasil Survei</a>
                  <a class="dropdown-item" href="#" onclick="rekapUmur();">Klasifikasi Umur</a>
                  <a class="dropdown-item" href="#" onclick="rekapKelamin();">Klasifikasi Jenis Kelamin</a>
                  <a class="dropdown-item" href="#" onclick="rekapPendidikan();">Klasifikasi Pendidikan</a>
                  <a class="dropdown-item" href="#" onclick="rekapPekerjaan();">Klasifikasi Pekerjaan</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" onclick="LaporanDetail();">Tabel Detail Hasil Rurvei</a>
                  <a class="dropdown-item" href="#" onclick="LaporanKritik();">Kritik / Saran</a>
                </div>
              </button>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table width="100%" class="table table-striped table-hover table-bordered table-sm" id="tblDashboardlaporan">
            <thead class="thead-default">
              <tr>
                <th width="5%" style="vertical-align:middle;">
                  <center>No</center>
                </th>
                <th width="25%" style="vertical-align:middle;">
                  <center>Nama</center>
                </th>
                <th width="5%" style="vertical-align:middle;">
                  <center>Umur</center>
                </th>
                <th width="4%" style="vertical-align:middle;">
                  <center>L/P</center>
                </th>
                <th width="8%" style="vertical-align:middle;">
                  <center>Pend.</center>
                </th>
                <th width="22%" style="vertical-align:middle;">
                  <center>Pekerjaan</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U1</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U2</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U3</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U4</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U5</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U6</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U7</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U8</center>
                </th>
                <th width="3%" style="vertical-align:middle;">
                  <center>U9</center>
                </th>
                <th width="4%" style="vertical-align:middle;">
                  <center>Jml</center>
                </th>
              </tr>
            </thead>
            <tbody id="isitabelDashboardlaporan"></tbody>
          </table>
        </div>
      </div>

    </div><!-- /.container-fluid -->