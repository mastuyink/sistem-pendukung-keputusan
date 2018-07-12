<?php 
use yii\helpers\Html;
?>
	<?php foreach ($jumlahKriteria as $index => $value): ?>
		<div class="col-md-2">
			<?php $idKriteria = $value['id'] ?>
			<label class="label-control"><?= $value['kriteria'] ?></label>
			<?= Html::textInput("nilai[$idKriteria]", $value = null, ['class' => 'form-control form-nilai']); ?>
		</div>
	<?php endforeach; ?>
<?php
$this->registerJs("
$('.form-nilai').keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
            	return;
        } else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }
        }
        
});
$('.form-nilai').on('change blur keyup',function(){
	var nilai = $(this).val();
        if (nilai > 100) {
        	$(this).val(100); 
        	alert('Nilai Maksimal 100');
        	return false;
        }
        return true;
});
	", \yii\web\View::POS_READY);
 ?>