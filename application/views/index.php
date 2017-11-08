<html>
<head>
	<title>Language Model : N-Gram</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/main.css">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap.min.css">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/font-awesome.min.css"> 
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
	<style>
		.colorgraph {
	  height: 5px;
	  border-top: 0;
	  background: #c4e17f;
	  border-radius: 5px;
	  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
	  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
		}
  </style>
</head>
<body>
	
	<div class="container">
		<div class="row" style="margin-top:20px">
		  	<?php
				$total = 0;
				foreach ($mUnigram as $kata) {
					$total+=$kata['jumlah'];
				}
				echo "<div class='col-md-4'>";
				echo "Sumber corpus: wikipedia</br>";
				echo "</br>Jumlah kata pada korpus=".$total;
				echo "</br>Jumlah vocab/unigram=".count($mUnigram);
				echo "</br>Jumlah bigram=".count($mBigram)."</br>";
				echo "</div>";
				
				echo "<div>";
				echo "Disusun oleh:<br>";
				echo "Ahmad Zainal A 1404862<br>";
				echo "Ibeb ????<br>";
				echo "Mira Nurhayati 1403754<br><br>";
				echo "</div>";
			?>
		  <div class="col-sm-6">
				<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<fieldset>
						<h2>Language Model - N Gram</h2>
						<hr class="colorgraph">
						<div class="form-group">
								<div class="row"><h3>&nbsp;&nbsp;&nbsp;Cek probabilitas bigram</h3></div>
		            <input type="text" name="kAwal" id="kAwal" class="form-control input-lg" placeholder="Kata Pertama" required>
						</div>
						<div class="form-group">
							<input type="text" name="kTujuan" id="kTujuan" class="form-control input-lg" placeholder="Kata Kedua" required>
						</div>
						<div class="row">
							<div class="col-sm-6">
		          	<input type="submit" class="btn btn-lg btn-primary btn-block" value="Cek">
							</div>
						</div>
					</fieldset>
				</form>

				<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<fieldset>
						<hr class="colorgraph">
						<div class="form-group">
								<div class="row"><h3>&nbsp;&nbsp;&nbsp;Generator Kalimat</h3></div>
		            <input type="text" name="kAwal" id="kAwal" class="form-control input-lg" placeholder="Kata Pertama" required>
						</div>
						<div class="form-group">
							<input type="number" name="n" id="n" min=1 class="form-control input-lg" placeholder="Jumlah Kata" required>
						</div>
						<div class="row">
							<div class="col-md-6">
		          	<input type="submit" class="btn btn-lg btn-primary btn-block" value="Proses">
							</div>
						</div>
					</fieldset>
				</form>

				<?php echo form_open('Main/cekNgram'); ?>
  					<fieldset>
						<hr class="colorgraph">
						<div class="form-group">
								<div class="row"><h3>&nbsp;&nbsp;&nbsp;Cek 10 Besar N-Gram</h3></div>
		            <input type="text" name="nGram" id="nGram" class="form-control input-lg" placeholder="N" required>
						</div>
						<div class="row">
							<div class="col-md-6">
		          	<input type="submit" class="btn btn-lg btn-primary btn-block" value="Cek">
							</div>
						</div>
					</fieldset>
				<?php echo form_close(); ?>
						 

				<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<fieldset>
						<hr class="colorgraph">
						<div class="form-group">
								<input class="form-control" type="hidden" name="random">
								<div class="row"><h3>&nbsp;&nbsp;&nbsp;Generator Kalimat Random</h3></div>
						</div>
						<div class="row">
							<div class="col-md-6">
		          	<input type="submit" class="btn btn-lg btn-primary btn-block" value="Generate">
							</div>
						</div>
					</fieldset>
				</form>
			</div>

			<div class="table-responsive" style="text-align:center;">
		  <table class="table" id="result" style="font-size:24pt; text-align:center;">
		    <?php
		    error_reporting(0);
		    ini_set('display_errors',0);

		    if(isset($_POST['random'])){
		    	echo "<h4>Kalimat dengan Kata Awal Random dilanjutkan berdasarkan Probabilitas</h4>";
		    	$j=0;
		    	foreach ($mBigram as $kata) {
		    		if(strcmp($kata['kata'],"START") == 0){
		    			$pertama[$j] = $kata;
		    			$j++;
		    		}
		    	}
		    	$rand = rand(0,$j);
		    	$stat = 0;
		    	$next[0] = $pertama[$rand];
		    	//echo "$j ".$rand."</br>";
		    	$m =0;
		    	while($stat == 0 && $m < 40){
		    		$m++;
		    		$kalimat = explode(" ",$next[0]['bigram'])[0];
		    		$nextKata = explode(" ",$next[0]['bigram'])[1];
		    		echo $kalimat." ";
		    		$pertama= array();
		    		$j=0;
		    		foreach ($mBigram as $kata) {
			    		if(strcmp($kata['kata'],$nextKata) == 0){
			    			$pertama[$j] = $kata;
			    			$j++;
			    		}
			    	}
			    	if($j==0){
			    		echo "$nextKata END";
			    		$stat = 1;
			    	}else if($m == 40){
			    		echo "STOP (perulangan beberapa kata yang sama yang tak kunjung berhenti)";
			    		
			    	}else{

			    		//print_r($data[0])."</br>";
			    		usort($pertama, function($a, $b) {
						    return $a['prob'] < $b['prob'];
						});
						$next = array_slice($pertama,0,1);
				    	
				    	if(strcmp(explode(" ",$next[0]['bigram'])[1],"END")==0){
				    		$stat = 1;
				    		echo $next[0]['bigram'];
				    	}
			    	}
		    	}
		    }
		    ?>
		  </table>
		</div>
		<br>
		<div class="table-responsive" style="text-align:center;">
		  <table class="table table-info" id="result" style="font-size:24pt; text-align:center;">
		    <?php
		    if(isset($_POST['kTujuan'])){
		    	$kata = $_POST['kAwal'];
		    	$bigram = $kata." ".$_POST['kTujuan'];
		    	echo "<h4>Probabilitas Bigram ($bigram)</h4>";
		    	if($mBigram[$bigram]){
		    		echo(($mBigram[$bigram]['prob']*100)."%");
		    	}else{
		    		echo "0%";
		    	}
		    }

		    if(isset($_POST['n'])){
		    	$kata = $_POST['kAwal'];
		    	$n = $_POST['n'];
		    	echo "<h4>Kalimat dengan Kata Awal=$kata, dengan maksimal kalimat=$n kata</h4>";
		    	for ($i=0; $i < $n ; $i++) { 
		    		$data = array();
		    		$j=0;
		    		if($i==0){
		    			$prob = $mBigram["START ".$kata]['prob'];
		    			if($prob){
		    				echo "START $kata(".($prob*100)."%) ";
		    			}else{
		    				echo "START $kata(0%) ";
		    			}
		    		}else if($i == $n-1){
		    			$prob = $mBigram[$kata." END"]['prob'];
		    			if($prob){
		    				echo "$kata(".($prob*100)."%) "."END";
		    			}else{
		    				echo "$kata(0%) END";
		    			}
		    		}else if(strcmp($kata,"END")==0){
		    			$i=$n;
		    			echo "END";
		    		}else{
		    			$prob = $mBigram[$temp." ".$kata]['prob'];
		    			if($prob){
		    				echo "$kata(".($prob*100)."%) ";
		    			}else{
		    				echo "$kata(0%) ";
		    			}
		    		}
		    		foreach ($mBigram as $bigram) {
		    			if(strcmp($bigram['kata'],$kata) == 0){
		    				$data[$j] = $bigram;
		    				$j++;
		    			}
		    		}

		    		//print_r($data[0])."</br>";
		    		usort($data, function($a, $b) {
					    return $a['prob'] < $b['prob'];
					});
					$temp = $kata;
					$next = array_slice($data,0,1);
		    		$kata = explode(" ",$next[0]['bigram'])[1];
		    	}
		    }
		    ?>
		  </table>
		</div>
		<br>
		<br>
		<div class="col-sm-4">
		<div class="table-responsive" style="text-align:center; align:right">
		  <table class="table table-bordered" id="awalmula" style="font-size:12pt; text-align:center">
		  <h4>10 Besar N-gram</h4>
		  <thead>
		  	<th>N-Gram</th><th>Frekuensi</th><th>Probabilitas</th>
		  </thead>
		  <tbody>
		    <?php
		    	if(isset($nGram)){
		    		$total = 0;
		    	foreach ($ngram10besar as $kata) {
		    		echo"
		    		<tr>
		    			<td>".
		    			$kata['ngram']
		    			."</td><td>".
		    			$kata['jumlah']
		    			."</td><td>".
		    			$kata['prob']
		    			."</td>
		    		</tr>
		    		";
		    	}
		    	$total = count($nGram);
		    	echo "<tr><td colspan='3'>10 dari :$total</td></tr>";
		    	}
		    ?>
		  </table>
		</div>
		<div class="table-responsive" style="text-align:center; align:right">
		  <table class="table table-bordered" id="awalmula" style="font-size:12pt; text-align:center">
		  <h4>10 Besar Unigram</h4>
		  <thead>
		  	<th>Unigram</th><th>Frekuensi</th>
		  </thead>
		  <tbody>
		    <?php
		    	$total = 0;
		    	foreach ($unigram10besar as $kata) {
		    	?>
		    		<tr class="table-info">
		    			<td> <?php
		    			echo $kata['kata'];
		    			?>
		    			</td><td>
		    			<?php echo $kata['jumlah']; ?>
		    			</td>
		    		</tr>

		    		<?php
		    	}
		    	$total = count($mUnigram);
		    	?>
		    	<tr class= 'table-warning'><td colspan='2'> <?php echo "10 dari:".$total; ?></td></tr>
		    </tbody>
		  </table>
		</div>
		<div class="table-responsive" style="text-align:center;">
		  <table class="table table-bordered" id="track" style="text-align:center;">
		  	<h3>10 Besar Bigram</h3>
		  	<thead>
		  		<th>Bigram</th>
		  		<th>Frekuensi</th>
		  	</thead>
		    <?php
		    	$total = 0;
		    	foreach ($bigram10besar as $kata) {
		    ?>
		    		<tr>
		    			<td>
		    			<?php echo $kata['bigram']; ?>
		    			</td><td>
		    			<?php echo $kata['jumlah']; ?>
		    			</td>
		    		</tr>
		    <?php		
		    	}
		    	$total = count($mBigram);
		    ?>
		    <tr><td colspan='2'><?php echo "10 dari : ".$total; ?></td></tr>
		  </table>
		</div>
		<br>
		
	</div>
</div>

</div>
	<div class="container">
	</div>
</body>

</html>