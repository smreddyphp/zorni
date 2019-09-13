<html>
<body>
<?php
        if($document->file_type == "audio")
        {
        ?>
        <center><audio controls>
	  <source src="<?= base_url() ?>medical_slips/<?= $document->medical_slip ?>" type="audio/ogg">
	  <source src="<?= base_url() ?>medical_slips/<?= $document->medical_slip ?>" type="audio/mpeg">					
	</audio></center>
	<?php                                        
        }
        else
        {
        ?>        
        <center><video src="<?= base_url() ?>medical_slips/<?= $document->medical_slip ?>" width="800" height="500" controls>					  					 
	</video></center>
        <?php                                        
        }
        ?>
	</body>	
</html>