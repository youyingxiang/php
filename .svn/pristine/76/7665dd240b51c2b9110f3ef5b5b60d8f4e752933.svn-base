
<!--
*	主模板文件
*	@ 韩更生 20150827
-->

<?php $this->beginContent('main.basic.tpl');?>
	<body class="no-skin">

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb" id="breadcrumbs_nav">

						</ul><!-- /.breadcrumb -->

						<!-- #section:basics/content.searchbox -->
						<div class="nav-search" id="nav-search">
							<!--
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="搜索 ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
							-->

						</div><!-- /.nav-search -->

						<!-- /section:basics/content.searchbox -->
					</div>

					<!-- /section:basics/content.breadcrumbs -->

					<div class="page-content">

						<?php echo $dorisContent;?>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->


		</div><!-- /.main-container -->


	</body>
	<?php
		ob_start();//因为这里的main.js.tpl需要在其它JS加载之后才加载，所以这里以变量的形式传递
			//extract($this->vals);
			//include "main.js.tpl";
			$mainPageJsContent  = ob_get_contents();
		ob_end_clean();
		$this->assign("mainPageJsContent",$mainPageJsContent);//这个可不用加
	?>
<?php $this->endContent();?>