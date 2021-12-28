
<?php

$total = 0;
$pending_check_in = 0;
$total_check_in = 0;
$pending_check_out = 0;
$total_check_out = 0;

if(!empty($dashboard))
{
    foreach ($dashboard as $df)
    {
		$total = $df->total;
		$pending_check_in = $df->pending_check_in;
		$total_check_in = $df->total_check_in;
		$pending_check_out = $df->pending_check_out;
		$total_check_out = $df->total_check_out;
		
		
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <h1>
        Dashboard
        <small></small>
		 
      </h1>
	  
    </section>
	
    
    <section class="content">
	
	   <div class="box box-primary" style="min-height:480px">
                <div class="box-header">
				</div>
				
	    </div>
        
            
    </section>
</div>