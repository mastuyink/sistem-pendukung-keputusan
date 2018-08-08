<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
$color = ['box-primary','box-danger','box-success','box-warning','box-primary','box-danger','box-success','box-warning'];
$this->title = "SPK DISPERINDAG"
?>

<center><h1>SELAMAT DATANG</h1></center>
<div class="row">
<div class="col-md-12">
  <div class="box box-solid">
    <div class="box-header with-border">
    </div>
            <!-- /.box-header -->
      <div class="box-body">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <?php for ($i=0; $i < count($listGambar); $i++): ?>
              <li data-target="#carousel-example-generic" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></li>
            <?php endfor; ?>
          </ol>
          <div class="carousel-inner">
            <?php foreach ($listGambar as $key => $value): ?>
              <div style="min-height: 300px; max-height: 300px;" class="item <?= $key == 0 ? 'active' : '' ?>">
                <?= Html::img('/carrousel/'.$value->nama_gambar, ['alt' => $value->nama_gambar,'style'=>'width:100%; height: auto;']); ?>
                <div class="carousel-caption">
                  <?= $value->caption ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="fa fa-angle-left"></span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="fa fa-angle-right"></span>
          </a>
        </div>
      </div>
            <!-- /.box-body -->
  </div>
          <!-- /.box -->
</div>
</div>
<div class="row col-md-12">
  <div class="box box-info collapsed-box">
    <div class="box-header with-border">  
      <button type="button" class="btn btn-box-tool btn-block" data-widget="collapse">
                <h3 class="box-title">Kriteria Penilaian</h3>
      </button>
              <!-- /.box-tools -->
    </div>
    <div class="box-body" style="">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu">
              <div class="list-group">
                <?php foreach($model as $key => $value): ?>
                  <a href="#" class="list-group-item text-center <?= $key == 0 ? 'active' : '' ?>">
                    <?= $value->kriteria ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bhoechie-tab">
                <?php foreach($model as $key => $value): ?>
                  <div class="bhoechie-tab-content <?= $key == 0 ? 'active' : '' ?>">
                    <div class="row col-md-12">
                      <p class="form-heading"><center><h3><?= $value->kriteria ?></h3></center></p> 
                      <p><?= $value->description ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
  </div>
</div>


<!-- CUSTOM TAB -->
<?php $this->registerJs('
$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings(\'a.active\').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
'
, \yii\web\View::POS_READY); ?>
<?php
$this->registerCss("
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #3c8dbc;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #3c8dbc;
  background-image: #3c8dbc;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #3c8dbc;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
  ")
 ?>