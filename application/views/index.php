<html>
<head>
	<title>Minimum Edit Distance</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/main.css">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/bootstrap.min.css">
  	<link rel="stylesheet" href="<?php echo base_url();?>/css/font-awesome.min.css">  	
	
</head>
<body>
	<?php
		$namefile = "WIKI_flatfile1.txt";
		$link = base_url();
		$link .="data/".$namefile;
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<div class="container">
		<div class="row"><h3>cek probabilitas 2 kata</h3></div>
			<div class="row">
				<div class="row">Input Kata Awal</div>
				<div class="row">
					<div class="col-md-4">
						<input class="form-control" type="text" name="kAwal" id="kAwal" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="row">Input Kata Kedua / yang mengikuti</div>
				<div class="row">
					<div class="col-md-4">
						<input class="form-control" type="text" name="kTujuan" id="kTujuan" required>
					</div>
				</div>
			</div>
			<div class="row"><button class="btn btn-info" colspan="2" name="submit">Submit</button></div>
		<br>
	</form>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<div class="container">
		<div class="row"><h3>Generator kalimat</h3></div>
			<div class="row">
				<div class="row">Input Kata Awal</div>
				<div class="row">
					<div class="col-md-4">
						<input class="form-control" type="text" name="kAwal" id="kAwal" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="row">Banyak kata</div>
				<div class="row">
					<div class="col-md-4">
						<input class="form-control" type="number" min=1 name="n" id="n" required>
					</div>
				</div>
			</div>
			<div class="row"><button class="btn btn-info" colspan="2" name="submit">Submit</button></div>
		<br>
	</form>
	<form action='<?php echo base_url(); ?>Main/cekNgram' method="post">
	<div class="container">
		<div class="row"><h3>Cek 10 besar N-Gram</h3></div>
			<div class="row">
				<div class="row">N</div>
				<div class="row">
					<div class="col-md-4">
						<input class="form-control" type="number" name="nGram" id="nGram" required>
					</div>
				</div>
			</div>
			<div class="row"><button class="btn btn-info" colspan="2" name="submit">Submit</button></div>
		<br>
	</form>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<div class="container">
		<input class="form-control" type="hidden" name="random">
		<div class="row"><h3>Random Kalimat</h3></div>
			<div class="row"><button class="btn btn-info" colspan="2" name="submit">Generate</button></div>
		<br>
	</form>
		<div class="table-responsive" style="text-align:center;">
		  <table class="table" id="result" style="font-size:24pt; text-align:center;">
		    <?php

		    if(isset($_POST['random'])){
		    	
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
		  <table class="table" id="result" style="font-size:24pt; text-align:center;">
		    <?php
		    if(isset($_POST['kTujuan'])){
		    	$kata = $_POST['kAwal'];
		    	$bigram = $kata." ".$_POST['kTujuan'];
		    	if($mBigram[$bigram]){
		    		echo(($mBigram[$bigram]['prob']*100)."%");
		    	}else{
		    		echo "0%";
		    	}
		    }

		    if(isset($_POST['n'])){
		    	$kata = $_POST['kAwal'];
		    	$n = $_POST['n'];
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
		<div class="table-responsive" style="text-align:center;">
		  <table class="table" id="awalmula" style="font-size:24pt">
		    <?php
		    	$total = 0;
		    	foreach ($unigram10besar as $kata) {
		    		echo"
		    		<tr>
		    			<td>".
		    			$kata['kata']
		    			."</td><td>".
		    			$kata['jumlah']
		    			."</td>
		    		</tr>
		    		";
		    	}
		    	$total = count($mUnigram);
		    	echo "<tr><td colspan='2'>10 dari:$total</td></tr>";
		    ?>
		  </table>
		</div>
		<br>
		<div class="table-responsive" style="text-align:center;">
		  <table class="table" id="track" style="text-align:center;">
		    <?php
		    	$total = 0;
		    	foreach ($bigram10besar as $kata) {
		    		echo"
		    		<tr>
		    			<td>".
		    			$kata['bigram']
		    			."</td><td>".
		    			$kata['jumlah']
		    			."</td>
		    		</tr>
		    		";
		    	}
		    	$total = count($mBigram);
		    	echo "<tr><td colspan='2'>10 dari :$total</td></tr>";
		    ?>
		  </table>
		</div>
		<br>
		<div class="table-responsive" style="text-align:center;">
		  <table class="table" id="ngram" style="text-align:right;">
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
	</div>
</body>

</html>