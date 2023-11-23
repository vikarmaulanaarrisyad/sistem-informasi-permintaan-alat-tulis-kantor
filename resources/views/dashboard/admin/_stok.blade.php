<div class="row">
    <div class="col-lg-6 col-6">

        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalBarangMasukHariIni }}</h3>
                <p>Total Barang Masuk Hari ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-download"></i>
            </div>
            <p class="small-box-footer">Tanggal : {{ tanggal_indonesia(date('Y-m-d')) }} <i
                    class="fas fa-arrow-circle-right"></i>
            </p>
        </div>
    </div>

    <div class="col-lg-6 col-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $totalPengajuanHariIni }}</h3>
                <p>Total Barang Keluar Hari ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-upload"></i>
            </div>
            <p class="small-box-footer">Tanggal : {{ tanggal_indonesia(date('Y-m-d')) }} <i
                    class="fas fa-arrow-circle-right"></i>

        </div>
    </div>
</div>
