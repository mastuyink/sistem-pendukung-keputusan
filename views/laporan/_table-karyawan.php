<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TLogPenilaianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
app\assets\ChartAsset::register($this);
?>
<?php if($modelPenilaian != null): ?>
    <div class="panel panel-success">
        <div class="panel-body">
            <table class="table table-striped">
                <caption>Data Karyawan</caption>
                <tbody>
                    <tr>
                        <th width="100">NIP</th>
                        <td> : <?= $modelPenilaian[0]->idKaryawan->nip ?></td>
                    </tr>
                    <tr>
                        <th width="100">Nama</th>
                        <td> : <?= $modelPenilaian[0]->idKaryawan->nama ?> (<?= $modelPenilaian[0]->idKaryawan->jenis_karyawan ?>)</td>
                    </tr>
                    <tr>
                        <th width="100">Pend. Akhir</th>
                        <td> : <?= $modelPenilaian[0]->idKaryawan->idPendidikanAkhir->pendidikan_akhir ?>
                            <?php if (isset($modelPenilaian[0]->idKaryawan->idJurusanKaryawan)) {
                                echo $modelPenilaian[0]->idKaryawan->idJurusanKaryawan->idJurusan->jurusan;
                            } ?>
                        </td>
                    </tr>
                    <?php if($modelPenilaian[0]->idKaryawan->jenis_karyawan == $modelPenilaian[0]->idKaryawan::PNS):  ?>
                    <tr>
                        <th width="100">Jabatan</th>
                        <td>: 
                            <?php 
                                if (!empty($modelPenilaian[0]->idKaryawan->idJabatanKaryawan)) {
                                 echo $modelPenilaian[0]->idKaryawan->idJabatanKaryawan->idJabatan->jabatan;
                                }else{
                                    echo '<span class="badge bg-orange">Jabatan Belum Dipilih</span>';
                                }
                            ?>
                            
                            Bidang : <?= $modelPenilaian[0]->idKaryawan->idBidang->bidang ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <th width="100">Bidang</th>
                        <td>: <?= $modelPenilaian[0]->idKaryawan->jenis_karyawan; ?> Bidang : <?= $modelPenilaian[0]->idKaryawan->idBidang->bidang ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
        <div class="col-xs-7"><h4>Data Nilai</h4></div>
        <div class="col-xs-2">
            <?= Html::a('<i class="fa fa-download"></i> Download', ['download-laporan-karyawan','id_karyawan'=>$modelPenilaian[0]->idKaryawan->id], [
                'class' => 'btn btn-sm btn-danger',
                'title' => 'Download Laporan'
            ]); ?>
        </div>
        <div class="col-xs-3">
        <?= Html::dropDownList('tahun', $postData['tahun'], $listTahun, [
            'class' => 'form-control',
            'onchange' => '
                $("#loading-ajax").html("<img src=\'/img/spinner.svg\'>");
                    $.ajax({
                        url: "/laporan/detail-nilai-karyawan",
                        type: "POST",
                        data: {
                            nip: '.$postData['nip'].',
                            nama: "'.$postData['nama'].'",
                            tahun: $(this).val(),
                        },
                        success: function(data){
                            $("#ajax-reload").html(data);
                            $("#loading-ajax").html("");
                        }
                    });
            '
        ]); ?>
        </div>
        </div>
    </div>
<div class="panel-body">
   <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Total Nilai</th>
                    <th>Ranking</th>
                    <th>Detail</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach($modelPenilaian as $key => $valueNilai): ?>
                    <?php
                        $data = [
                            'id_bulan'    => $valueNilai->id_bulan,
                            'id_tahun'    => $valueNilai->id_tahun,
                            'id_karyawan' => $valueNilai->id_karyawan,
                        ];
                     ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td><?= $valueNilai->idTahun->tahun ?></td>
                        <td><?= $valueNilai::ambilNamaBulan($valueNilai->id_bulan) ?></td>
                        <td><?= $valueNilai->total ?></td>
                        <td><?= $valueNilai::ambilRanking($data) ?></td>
                        <td width="25"><?= Html::button('', [
                            'class'       => 'btn btn-xs btn-warning glyphicon glyphicon-modal-window tombol-detail-bulanan',
                            'data-toggle' => 'tooltip',
                            'title'       => 'Lihat Detail',
                            'id-karyawan' => $valueNilai->id_karyawan,
                            'id-bulan'    => $valueNilai->id_bulan,
                            'id-tahun'    => $valueNilai->id_tahun,
                        ]); ?></td>
                    </tr>
                <?php endforeach; ?>
               
            </tbody>
    </table>
</div>
</div>

<!-- CHART START -->
<?php 
$nama            = $modelPenilaian[0]->idKaryawan->nama;
$dataChartArray  = [];
$bulanChartArray = [];

for ($index=0; $index < 6; $index++) { 
    if (isset($modelPenilaian[$index])) {
        array_unshift($dataChartArray, $modelPenilaian[$index]->total);
        array_unshift($bulanChartArray, $modelPenilaian[$index]::ambilNamaBulan($modelPenilaian[$index]->id_bulan).' '.$modelPenilaian[$index]->idTahun->tahun);
    }
}

$dataChartJson = Json::encode($dataChartArray);
$bulanChartJson = Json::encode($bulanChartArray);
$customScript = <<< SCRIPT
  var CHart = Highcharts.chart('chart-container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Grafik Nilai'
    },
    subtitle: {
        text: '$nama'
    },
    xAxis: {
        categories: $bulanChartJson
    },
    yAxis: {
        title: {
            text: 'Jumlah Nilai'
        }

    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            }
        }
    },

    tooltip: {
        
        pointFormat: '<span style="color:{point.color}">{point.name}</span><b>{point.y}</b><br/>'
    },

    series: [
        {
            name: 'Nilai',
            data: $dataChartJson
        },
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }
});
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);

 ?>
 <center><div class="row" id="chart-container" style="width: 100%;min-width: 900px; height: 400px; margin: 0 auto;">HERE</div></center>

<!-- CHART END -->
<?php
$this->registerJs('
$(".tombol-detail-bulanan").on("click",function(){
    var idkaryawan = $(this).attr("id-karyawan");
    var idbulan    = $(this).attr("id-bulan");
    var idtahun    = $(this).attr("id-tahun");

    $("#modal-detail-nilai").modal();

    $.ajax({
        url: "'.Url::to(['/penilaian/detail-nilai']).'",
        type: "POST",
        data: {
            id_bulan: idbulan,
            id_tahun: idtahun,
            id_karyawan: idkaryawan
        },

        success: function(data){
            $(".modal-body").html(data);
        }
    })

})
    ', \yii\web\View::POS_READY);
 ?>

 <div class="modal fade" id="modal-detail-nilai">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Detail Nilai</h4>
              </div>
              <div class="modal-body">
                <center>Mohon Tunggu ...<br><i class="fa fa-spinner fa-spin"></i></center>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Keluar</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php else: ?>
<center><h5>Data Tidak Ditemukan<br>Silahakn Periksa Masukan Anda</h5></center>
<?php endif; ?>
