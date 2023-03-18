<?php $__env->startSection('main_content'); ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
.trees, .trees ul {
    margin:0;
    padding:0;
    list-style:none
}
.trees ul {
    margin-left:1em;
    position:relative
}
.trees ul ul {
    margin-left:.5em
}
.trees ul:before {
    content:"";
    display:block;
    width:0;
    position:absolute;
    top:0;
    bottom:0;
    left:0;
    border-left:1px solid
}
.trees li {
    margin:0;
    padding:0 1em;
    line-height:2em;
    color:#369;
    font-weight:700;
    position:relative
}
.trees ul li:before {
    content:"";
    display:block;
    width:10px;
    height:0;
    border-top:1px solid;
    margin-top:-1px;
    position:absolute;
    top:1em;
    left:0
}
.trees ul li:last-child:before {
    background:#ECF0F5;
    height:auto;
    top:1em;
    bottom:0
}
.indicator {
    margin-right:5px;
}
.trees li a {
    text-decoration: none;
    color:#369;
}
.trees li button, .trees li button:active, .trees li button:focus {
    text-decoration: none;
    color:#369;
    border:none;
    background:transparent;
    margin:0px 0px 0px 0px;
    padding:0px 0px 0px 0px;
    outline: 0;
}
</style>
<script>
	function show(id,type)
	{
		var id = id; var type = type;
		$.ajax({
				   type: 'POST', url: '<?php echo e(URL::to('show_data')); ?>', data: {
				'id': id, 'type': type, '_token': '<?php echo e(csrf_token()); ?>'
			}, success: function (e) {			
				document.getElementById("log").innerHTML=e;
			}
			   });
	}
</script>
<div class="container" style="margin-top:30px;">
    <div class="row">
        <br></br>
        <div class="col-md-3">
            
            <ul id="tree2">
                <li><a href="#" onclick="show(9999,1);">Global</a>

                    <ul> 
						<?php $__currentLoopData = $allZoneData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="#" onclick="show(<?php echo e($zone->zone_code); ?>,2);"><?php echo e($zone->zone_name); ?> Zone</a>
                            <ul>
							<?php
							$allAreaData   = DB::table( 'tbl_area' )
												->where( 'zone_code', $zone->zone_code )
												 ->where( 'status', 1 )
												 ->get();
							?>
								<?php $__currentLoopData = $allAreaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="#" onclick="show(<?php echo e($area->area_code); ?>,3);"><?php echo e($area->area_name); ?> Area</a>
									<?php
									$allBranchData   = DB::table( 'tbl_branch' )
														->where( 'area_code', $area->area_code )
														->where('branch_name', 'NOT LIKE', '%-%')
														 ->where( 'status', 1 )
														 ->get();
									?>
                                    <ul>
										<?php $__currentLoopData = $allBranchData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="#" onclick="show(<?php echo e($branch->br_code); ?>,4);"><?php echo e($branch->branch_name); ?></a></li>
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
		<div class = "col-md-9" id="log" style="margin-left: -55px;">
			
		</div>
		
				
    </div>
</div>
<script>
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("trees");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

</script>
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>