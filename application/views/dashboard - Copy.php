
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
    <section class="content-header">
      <h1>
        Dashboard
        <small>(Today's visitor information)</small>
      </h1>
    </section>
    
    <section class="content">
	
        <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 align="center"><?php echo $total ?></h3>
                  <p align="center">Total visitor's</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3 align="center"><?php echo $total_check_in ?><sup style="font-size: 20px"></sup></h3>
                  <p align="center">Total checked in</p>
                </div>
                <div class="icon">
                  <i class="ion ion-log-in"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-teal">
                <div class="inner">
                  <h3 align="center"><?php echo $total_check_out ?></h3>
                  <p align="center">Total checked out</p>
                </div>
                <div class="icon">
                  <i class="ion ion-log-out"></i> <!--ion-pie-graph-->
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-maroon">
                <div class="inner">
                  <h3 align="center"><?php echo $pending_check_in ?></h3>
                  <p align="center">Pending checked in</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo base_url(); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
		</div>
		<!--bg-red,.bg-yellow,.bg-aqua,.bg-blue,.bg-light-blue,.bg-green,.bg-navy,.bg-teal,.bg-olive,.bg-lime,.bg-orange,.bg-fuchsia,.bg-purple,.bg-maroon,.bg-black-->
		<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-light-blue">
                <div class="inner">
                  <h3 align="center"><?php echo $pending_check_out ?></h3>
                  <p align="center">Pending checked out</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo base_url(); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            
    </section>
</div>