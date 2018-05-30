<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <!-- <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div> -->
            <!-- <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div> -->
        </div>

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->

    <!-- MENU NON LOGIN -->
    <?php if(Yii::$app->user->isGuest): ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Cek Nilai', 'icon' => 'circle-o', 'url' => '/laporan/karyawan',],
                    ['label' => 'Login','icon' => 'sign-in', 'url' => ['user/login']],
                    
                ],
            ]
        ) ?>
    <!-- MENU ADMIN -->
    <?php elseif(Yii::$app->user->identity->level == 1): ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Admin', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Karyawan',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Karyawan', 'icon' => 'circle-o', 'url' => '/karyawan/index',],
                            ['label' => 'Jabatan', 'icon' => 'circle-o', 'url' => '/jabatan/index',],
                            ['label' => 'Bidang', 'icon' => 'circle-o', 'url' => '/bidang/index',],
                            ['label' => 'Pendidikan Akhir', 'icon' => 'circle-o', 'url' => '/pendidikan-akhir/index',],
                            ['label' => 'Jurursan', 'icon' => 'circle-o', 'url' => '/jurusan/index',],
                            
                        ],
                    ],
                    [
                        'label' => 'Penilaian',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Penilaian', 'icon' => 'circle-o', 'url' => '/penilaian/index',],
                            ['label' => 'Hasil Akhir', 'icon' => 'circle-o', 'url' => '/penilaian/hasil-akhir',],
                            ['label' => 'Kriteria', 'icon' => 'circle-o', 'url' => '/kriteria/index',],
                            
                        ],
                    ],
                    [
                        'label' => 'Laporan',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Bulanan', 'icon' => 'circle-o', 'url' => '/laporan/bulanan',],
                            ['label' => 'Per Karyawan', 'icon' => 'circle-o', 'url' => '/laporan/karyawan',],
                            
                        ],
                    ],
                    ['label' => 'User', 'icon' => 'user', 'url' => '/user',],
                    ['label' => 'Gambar', 'icon' => 'user', 'url' => '/gambar/index',],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    
                ],
            ]
        ) ?>
    <?php elseif(Yii::$app->user->identity->level == 2): ?>
        
        <!-- MENU KEPALA DINAS -->
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Kepala Dinas', 'options' => ['class' => 'header']],
                    
                    ['label' => 'Laporan Penilaian', 'icon' => 'circle-o', 'url' => '/laporan/bulanan',],
                    ['label' => 'Kriteria', 'icon' => 'circle-o', 'url' => '/kriteria/index',],
                    
                ],
            ]
        ) ?>
    <?php elseif(Yii::$app->user->identity->level == 3): ?>
         
        <!-- MENU KABID -->
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Kepala Bidang', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Karyawan',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Karyawan', 'icon' => 'circle-o', 'url' => '/karyawan/index',],
                            
                        ],
                    ],
                    [
                        'label' => 'Penilaian',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Penilaian', 'icon' => 'circle-o', 'url' => '/penilaian/index',],
                            ['label' => 'Hasil Akhir', 'icon' => 'circle-o', 'url' => '/penilaian/hasil-akhir',],
                            ['label' => 'Kriteria', 'icon' => 'circle-o', 'url' => '/kriteria/index',],
                            
                        ],
                    ],
                    [
                        'label' => 'Laporan',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Bulanan', 'icon' => 'circle-o', 'url' => '/laporan/bulanan',],
                            ['label' => 'Per Karyawan', 'icon' => 'circle-o', 'url' => '/laporan/karyawan',],
                            
                        ],
                    ],
                    
                ],
            ]
        ) ?>
    <?php endif; ?>

    </section>

</aside>
