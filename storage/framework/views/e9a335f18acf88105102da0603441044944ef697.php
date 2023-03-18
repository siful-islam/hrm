<?php $__env->startSection('main_content'); ?>
<br></br></br>
	<div class = "box-header">
			<div class = "col-md-12">
			<style>
/*Now the CSS*/

* {
  margin: 0;
  padding: 0;
}
/*added*/

.trees {
  white-space: nowrap;
  overflow: auto; 
  height: 500px;
}

.trees ul {
  padding-top: 20px;
  position: relative;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}

.trees li {
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 5px 0 5px;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
  /*added for long names*/
  
  float: none;
  display: inline-block;
  vertical-align: top;
  white-space: nowrap;
  margin: 0 -2px 0 -2px;
}
/*We will use ::before and ::after to draw the connectors*/

.trees li::before,
.trees li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 1px solid #ccc;
  width: 50%;
  height: 20px;
}

.trees li::after {
  right: auto;
  left: 50%;
  border-left: 1px solid #ccc;
}
/*We need to remove left-right connectors from elements without 
any siblings*/

.trees li:only-child::after,
.trees li:only-child::before {
  display: none;
}
/*Remove space from the top of single children*/

.trees li:only-child {
  padding-top: 0;
}
/*Remove left connector from first child and 
right connector from last child*/

.trees li:first-child::before,
.trees li:last-child::after {
  border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/

.trees li:last-child::before {
  border-right: 1px solid #ccc;
  border-radius: 0 5px 0 0;
  -webkit-border-radius: 0 5px 0 0;
  -moz-border-radius: 0 5px 0 0;
}

.trees li:first-child::after {
  border-radius: 5px 0 0 0;
  -webkit-border-radius: 5px 0 0 0;
  -moz-border-radius: 5px 0 0 0;
}
/*Time to add downward connectors from parents*/

.trees ul ul::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 1px solid #ccc;
  width: 0;
  height: 20px;
}

.trees li a {
  border: 1px solid #ccc;
  padding: 5px 10px;
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  font-size: 11px;
  display: inline-block;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}
/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/

.trees li a:hover,
.trees li a:hover+ul li a {
  background: #c8e4f8;
  color: #000;
  border: 1px solid #94a0b4;
}
/*Connector styles on hover*/

.trees li a:hover+ul li::after,
.trees li a:hover+ul li::before,
.trees li a:hover+ul::before,
.trees li a:hover+ul ul::before {
  border-color: #94a0b4;
}

.husband {
  float: left;
}

.wife {
  margin-left: 10px;
}

.wife::before {
  /* pseudo CSS, will need to be modified */
  
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 1px solid #ccc;
  width: 50%;
  height: 20px;
}

</style>
<div class="trees">
  <ul>
    <li>
      <a href="#">CDIP</a>
     
      <ul>
	  <?php $__currentLoopData = $allZoneData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
          <a href="#"><?php echo e($zone->zone_name); ?></a>
           <ul>
		   <?php
			$allAreaData   = DB::table( 'tbl_area' )
								->where( 'zone_code', $zone->zone_code )
								 ->where( 'status', 1 )
								 ->orderBy( 'area_code', 'ASC' )
								 ->get();
			?>
			<?php $__currentLoopData = $allAreaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <a href="#"><?php echo e($area->area_name); ?></a>
              <ul>
			  <?php
				$allBranchData   = DB::table( 'tbl_branch' )
									->where( 'area_code', $area->area_code )
									//->where( 'area_code', $area->area_code )
									->where('branch_name', 'NOT LIKE', '%-%')
									 ->where( 'status', 1 )
									// ->orderBy( 'br_code', 'DESC' )
									 ->get();
				?>
				<?php $__currentLoopData = $allBranchData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
				$singleData = DB::table( 'branch_locations as bl' )
						 ->leftJoin( 'tbl_branch as b', 'bl.branch_code', '=', 'b.br_code' )
						 ->where( 'bl.branch_location_status', 1 )
						 ->where( 'bl.branch_code', $branch->br_code )
						 ->first();
				?>
                <li>
				  <?php if(!empty($singleData)): ?>	
					  <a href="#">
					<img id="myImg" style = "max-height: 150px;min-height: 150px" class = "myImg img-thumbnail" src = "<?php echo e(asset($singleData->branch_photo)); ?>" alt = "IMAGE"/><br></br><strong><span style="color:blue;">Branch Name: <?php echo e($branch->branch_name); ?></span></strong></br><strong><span style="color:blue;">Branch Code: <?php echo e($branch->br_code); ?></span></strong> </a>
				  <?php else: ?>
					  <a href="#"><?php echo e($branch->branch_name); ?></a>
				  <?php endif; ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </li>			
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>       
          </ul>
        </li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
      </ul>
    </li>
  </ul>
</div>
</div>
	</div>
	<style>
	/* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes  zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media  only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
	</style>
	<script>
	// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
	</script>
	<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>