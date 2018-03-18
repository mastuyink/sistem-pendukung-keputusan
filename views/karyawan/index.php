<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TKaryawanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'List Karyawan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkaryawan-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-success btn-lg btn-flat fa fa-plus-square']) ?>
    </p>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Data Nilai</h3>
            </div>
            
            <div class="box-body" style="">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'panel'=>['type'=>'primary'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nip',
            'nama',
            [
                'header'=> 'L/P',
                'format' => 'raw',
                'value' => function($model){
                    return $model->jenisKelamin($model->id_jk);
                }
            ],
            // [
            //     'header'=> 'TTL',
            //     'format' => 'raw',
            //     'value'=> function($model){
            //         $tgl_lahir = new DateTime($model->tanggal_lahir);
            //         $hari_ini = new DateTime();
            //         $selisih = $hari_ini->diff($tgl_lahir);
            //         return "<center>".$model->idTempatLahir->tempat_lahir.", ".date('d-m-Y',strtotime($model->tanggal_lahir))."<br><b>".$selisih->y." Tahun</b></center>";
            //     }
            // ],
            // [
            //     'header'=> 'Tanggal Kerja',
            //     'format' => 'raw',
            //     'value'=> function($model){
            //         $tgl_lahir = new DateTime($model->tanggal_kerja);
            //         $hari_ini = new DateTime();
            //         $selisih = $hari_ini->diff($tgl_lahir);
            //         return "<center>".date('d-m-Y',strtotime($model->tanggal_kerja))."<br><b>".$selisih->y." Tahun</b></center>";
            //     }
            // ],
            [
                'header'=> 'Bidang',
                'format' => 'raw',
                'value'=> 'idBidang.bidang'
            ],
            [
                'header'=> 'Jabatan',
                'format' => 'raw',
                'value'=> 'idJabatan.jabatan'
            ],
            // [
            //     'header'=> 'Lama Menjabat',
            //     'format' => 'raw',
            //     'value'=> function($model){
            //         $tanggal_menjabat = new DateTime($model->tanggal_menjabat);
            //         $hari_ini = new DateTime();
            //         $selisih = $hari_ini->diff($tanggal_menjabat);
            //         return "<center>".date('d-m-Y',strtotime($model->tanggal_menjabat))."<br><b>".$selisih->y." Tahun</b></center>";
            //     }

            // ],
            // [
            //     'header'=> 'Pendidikan<br>Akhir',
            //     'format' => 'raw',
            //     'value'=> function($model){
            //         if ($model->id_pendidikan_akhir > 2) {
            //             return $model->idPendidikanAkhir->pendidikan_akhir."<br>".$model->idJurusanKaryawan->jurusan->jurusan;
            //         }else{
            //             return $model->idPendidikanAkhir->pendidikan_akhir;
            //         }
            //     }
            // ],
            [
                'header' => 'Telp',
                'value' => 'no_telp'
            ],
            // [
            //     'header' => 'Alamat',
            //     'value' => 'alamat'
            // ],
            // [
            //     'header'=> 'Dibuat',
            //     'format' => 'raw',
            //     'value' => function($model){
            //         return date('d-m-Y H:i',strtotime($model->create_at));
            //     }
            // ],
            // [
            //     'header'=> 'Update',
            //     'format' => 'raw',
            //     'value' => function($model){
            //         return date('d-m-Y H:i',strtotime($model->update_at));
            //     }
            // ],

            [
                'header' => 'Action',
                'format' => 'raw',
                'value' => function($model){
                    $edit = Html::a('', ['update','id'=>$model->id], [
                        'class' => 'btn btn-sm btn-primary fa fa-pencil',
                        'data-toggle' => 'tooltip',
                        'title' => 'Update',
                        'id' => 'btn-update-'.$model->id
                    ]);
                    $delete = Html::a('', ['delete','id'=>$model->id], [
                        'class'       => 'btn btn-sm btn-danger fa fa-trash',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Delete',
                        'id' => 'btn-delete-'.$model->id,
                        'data'        => [
                                'confirm' => 'Anda Yakin Ingin Menghapus Data Karyawan <b>'.$model->nama.' </b> ? <br>Seluruh Data Yang Terkait Juga Akan Ikut Dihapus..',
                                'method'  => 'post',
                        ],
                    ]);
                    $detail = Html::button('', [
                        'class'       => 'btn btn-sm btn-warning fa fa-eye btn-detail-karyawan',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Lihat Detail',
                        'id'          => 'btn-detail-karyawan'.$model->id,
                        'id-karyawan' => $model->id
                    ]);
                    return $detail." ".$edit." ".$delete;
                }
            ]
        ],
    ]); ?>
</div></div></div></div>
</div>
<?php

$this->registerJs('
$(".btn-detail-karyawan").on("click",function(){
    $("#modal-detail-karyawan").modal();
    $.ajax({
        url: "'.Url::to(['detail-karyawan']).'",
        type: "POST",
        data: {
            id_karyawan : $(this).attr("id-karyawan")
        },
        success: function(data){
            $(".modal-body").html(data);
        }
    })
});

    ', \yii\web\View::POS_READY);
 ?>

<!--  MODAL START -->
<div class="modal fade" id="modal-detail-karyawan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Detail Karyawan</h4>
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
 <!-- MODAL END -->