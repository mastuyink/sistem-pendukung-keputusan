<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TKaryawanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Data Karyawan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tkaryawan-index">
<p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-success btn-lg btn-flat fa fa-plus-square']) ?>
</p>
<div class="row">
    <?php  
    // $this->render('_search', [
    //     'model' => $searchModel,
    //     'listKaryawan' => $listKaryawan
    //     ]); 
        ?>
</div>
    
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Tabel Karyawan</h3>
            </div>
            
            <div class="box-body" style="">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'panel'=>['type'=>'primary'],
        'options' => [
            'style' => 'overflow: auto; word-wrap: break-word;'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'header'=> 'NIP',
                'format' => 'raw',
                'attribute' => 'nip',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map($listKaryawan, 'nip', 'nip'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                      ],
                'filterInputOptions'=>['placeholder'=>'Semua NIP...'],
                'value'=> function($model){
                    return $model->nip;
                }
            ],
            [
                'header'=> 'Nama',
                'attribute' => 'nama',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map($listKaryawan, 'nama', 'nama'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                      ],
                'filterInputOptions'=>['placeholder'=>'Semua Karyawan...'],
                'value'=> function($model){
                    return $model->nama;
                }
            ],
            [
                'header'              => 'L/P',
                'format'              => 'raw',
                'attribute'           => 'id_jk',
                //'filterType'          => GridView::FILTER_SELECT2,
                'filter'              => ['1'=>'Laki-Laki','2'=>'Perempuan'], 
                // 'filterWidgetOptions' => [
                //     'pluginOptions'=>['allowClear'=>true],
                //       ],
                'filterInputOptions'=>['prompt'=>'Semua...','class'=>'form-control'],
                'value' => function($model){
                    return $model->jenisKelamin($model->id_jk);
                }
            ],
            [
                'header'     => 'Bidang',
                'format'     => 'raw',
                'attribute'  => 'id_bidang',
                'filterType' =>GridView::FILTER_SELECT2,
                'filter'     =>$listBidang, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                      ],
                'filterInputOptions'=>['placeholder'=>'Semua...'],
                'value'=> function($model){
                    return $model->idBidang->bidang;
                }
            ],
            [
                'header'              => 'Jenis Karyawan',
                'format'              => 'raw',
                'attribute'           => 'jenis_karyawan',
                'hAlign' => 'center',
                'filterType'          =>GridView::FILTER_SELECT2,
                'filter'              =>ArrayHelper::map([['value'=>'THL/STAFF','text'=>'THL/STAFF'],['value'=>'PNS','text'=>'PNS']], 'value', 'text'), 
                'filterWidgetOptions' =>[
                    'pluginOptions'=>['allowClear'=>true],
                      ],
                'filterInputOptions'=>['placeholder'=>'Semua...'],
                'value'=> function($model){
                    if ($model->jenis_karyawan != 'PNS') {
                        return $model->jenis_karyawan;
                    }else{
                        $tombolPilihJabatan = Html::a('', ['/karyawan/pilih-jabatan','id_karyawan'=>$model->id], [
                            'class' => 'bg-navy btn btn-xs btn-flat fa fa-briefcase',
                            'data-toggle'=>'tooltip',
                            'title' => 'Pilih Jabatan',
                        ]);
                        if (!empty($model->idJabatanKaryawan)) {
                           $jabatan = $model->idJabatanKaryawan->idJabatan->jabatan.'<br>'.date('d-m-Y',strtotime($model->idJabatanKaryawan->tanggal_menjabat));
                        }else{
                            $jabatan = 'Pilih Jabatan' ;
                        }
                        
                        if (Yii::$app->user->identity->level > 1) {
                            return $jabatan;
                        }else{
                         return $jabatan.'<br>'.$tombolPilihJabatan;
                        }
                    }
                }
            ],
            [
                'header' => 'Telp',
                'value' => 'no_telp'
            ],

            [
                'header' => 'Action',
                'format' => 'raw',
                'width' => '175px;',
                'value' => function($model){
                    $edit = Html::a('', ['update','id'=>$model->id], [
                        'class' => 'btn btn-xs btn-flat btn-primary fa fa-pencil',
                        'data-toggle' => 'tooltip',
                        'title' => 'Update',
                        'id' => 'btn-update-'.$model->id
                    ]);
                    $delete = Html::a('', ['delete','id'=>$model->id], [
                        'class'       => 'btn btn-xs btn-flat btn-danger fa fa-trash',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Delete',
                        'id' => 'btn-delete-'.$model->id,
                        'data'        => [
                                'confirm' => 'Anda Yakin Ingin Menghapus Data Karyawan <b>'.$model->nama.' </b> ? <br>Seluruh Data Yang Terkait Juga Akan Ikut Dihapus..',
                                'method'  => 'post',
                        ],
                    ]);
                    $detail = Html::button('', [
                        'class'       => 'btn btn-xs btn-flat btn-warning fa fa-eye btn-detail-karyawan',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Lihat Detail',
                        'id'          => 'btn-detail-karyawan'.$model->id,
                        'id-karyawan' => $model->id
                    ]);
                    if ($model->id_user == NULL) {
                        $btnUser = Html::button('', [
                            'class'       => 'btn btn-xs btn-flat btn-info fa fa-user-plus btn-pilih-user',
                            'data-toggle' => 'tooltip',
                            'title'       => 'Pilih User',
                            'id'          => 'btn-detail-karyawan'.$model->id,
                            'id-karyawan' => $model->id
                        ]);
                    }else{
                        $btnUser = Html::a('', ['hapus-user','id_karyawan'=>$model->id], [
                            'class'       => 'btn btn-xs btn-flat btn-danger fa fa-user-times btn-hapus-user',
                            'data-toggle' => 'tooltip',
                            'title'       => 'Hapus User',
                            'id' => 'btn-delete-'.$model->id,
                            'data'        => [
                                    'confirm' => 'Anda Yakin Ingin Menghapus User Karyawan <b>'.$model->nama.' </b> ?',
                                    'method'  => 'post',
                            ],
                        ]);
                    }

                    
                    

                    if (Yii::$app->user->identity->level == 1) {
                        return $detail."".$btnUser."".$edit."".$delete;
                    }else{
                        return $detail;
                    }
                    
                }
            ]
        ],
    ]); ?>
</div></div></div></div>
</div>
<?php

$this->registerJs('
$(".btn-detail-karyawan").on("click",function(){
    $("#modal").modal();
    $("#modal").find(".modal-title").html("Detail Karyawan");
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
$(".btn-pilih-user").on("click",function(){
    $("#modal").modal();
    $("#modal").find(".modal-title").html("Pilih User");
    $.ajax({
        url: "'.Url::to(['pilih-user']).'?id_karyawan="+$(this).attr("id-karyawan"),
        type: "GET",
        success: function(data){
            $(".modal-body").html(data);
        },
        error: function(data){
            $(".modal-body").html("<center><b>ERROR</b></center>"+data);
        }
    })
});

    ', \yii\web\View::POS_READY);
 ?>

<!--  MODAL START -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
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