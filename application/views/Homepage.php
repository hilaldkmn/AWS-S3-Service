<?php $this->load->view("head");?>

<div class="container">

	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#yukleme">Yükleme</a></li>
		<li><a data-toggle="tab" href="#resimler">Galeri</a></li>
	</ul>

	<div class="tab-content">
		<div id="yukleme" class="tab-pane fade in active">
			<!-- Dropzone -->
			<form action="<?php echo base_url("Upload");?>" class="dropzone" id="fileupload">
			</form>
		</div>
		<div id="resimler" class="tab-pane fade">
			<h2>Galeri</h2>
			<div id="gallery" class="carousel slide" style="width:50%;" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
				<?php foreach($resimler as $k => $v){?>
					<li data-target="#gallery" data-slide-to="<?php echo $k;?>" <?php echo ($k==0)?"class='active'":"";?>class="active"></li>
				<?php } ?>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner">

				<?php foreach($resimler as $k => $v){?>
					<div class="item <?php echo ($k == 0)?"active":""; ?>">
						<img src="<?php echo $v["url"];?>" alt="<?php echo $v["url"];?>" style="width:100%;">
						<div class="carousel-caption">
							<p><?php echo $v["url"];?></p>
						</div>
					</div>
				<?php } ?>

				</div>

				<!-- Left and right controls -->
				<a class="left carousel-control" href="#gallery" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#gallery" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("foot");?>

<script>
	// Add restrictions
	Dropzone.options.fileupload = {
		acceptedFiles: 'image/*',
		maxFilesize: 1 // MB
	};
</script>
</body>

</html>
