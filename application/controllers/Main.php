<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$namefile = "WIKI_flatfile1.txt";
		$link = base_url();
		$link .="data/".$namefile;
		//echo "$link";
		$mUnigram = $this->unigram(file_get_contents($link));
		$mBigram = $this->bigram(file_get_contents($link),$mUnigram);
		//echo "a";
		//$mBigram = $this->ngram(2,file_get_contents($link),$mUnigram,$link);
		
		// echo "<pre>";
		// print_r($mBigram);
		// echo "</pre>";
		

		$data1 = $mUnigram;
		$data2 = $mBigram;
		
		usort($mUnigram, function($a, $b) {
		    return $a['jumlah'] < $b['jumlah'];
		});

		usort($mBigram, function($a, $b) {
		    return $a['jumlah'] < $b['jumlah'];
		});

		$unigram10besar = array_slice($mUnigram,0,10);
		$bigram10besar = array_slice($mBigram,0,10);
		// echo "<pre>";
		// print_r($unigram10besar);
		// echo "</pre>";
		// echo "<pre>";
		// print_r($bigram10besar);
		// echo "</pre>";

		$data = array(
            'mUnigram' => $data1,
            'mBigram' => $data2,
            'unigram10besar' => $unigram10besar,
            'bigram10besar' => $bigram10besar,
        );

		$this->load->view('index',$data);
	}

	public function unigram($data){
		
		$data = preg_replace('/[\`\~\#\$\%\^\&\*\-\=\{\}\;\“\”\�\–\"\<\>\,\+\(\)\'\:\[\]\_]/'," ",$data);
		$data = preg_replace('!\s+!', ' ', $data);
		$data = preg_split('/[\s]/',$data);
		//print_r($data);
		$mUnigram = array();
		$i=0;
		$max = count($data)-1;
		foreach ($data as $kata) {
			$kata=strtolower($kata);
			if($i!=0 && $i!=$max){
				if(array_key_exists($kata,$mUnigram)){
					$mUnigram[$kata]["jumlah"]++;
				}else{
					$mUnigram[$kata] = array(
						'kata' => $kata,
						'jumlah' => 1,
						);
				}
			}
			$i++;
		}
		return $mUnigram;
		
	}

	public function bigram($data,$mUnigram){
		
		$data = preg_split('/[\n.?!]/',$data);
		$data = preg_replace('/[\`\~\#\$\%\^\&\*\-\=\{\}\;\“\”\�\–\"\<\>\,\+\(\)\'\:\[\]\_]/'," ",$data);
		$data = preg_replace('!\s+!', ' ', $data);
		$data = preg_replace('/\n/', '', $data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		$mBigram = array();
		$i=0;
		$subkalimat = array();
		foreach ($data as $kalimat) {
			$subkalimat[] = explode(" ", $kalimat);
			
			if($subkalimat[$i][0] == " "){
				$subkalimat[$i][0] = "START";
				for($j = count($subkalimat[$i])-1; $j>0;$j--){
					if($subkalimat[$i][$j] == "" || $subkalimat[$i][$j] == "\n" || $subkalimat[$i][$j] == " "){
						unset($subkalimat[$i][$j]);
					}
					$subkalimat[$i][$j] = strtolower($subkalimat[$i][$j]);
					
				}
			}else{
				for($j = count($subkalimat[$i]); $j>0;$j--){
					$subkalimat[$i][$j] = strtolower($subkalimat[$i][$j-1]);
					if($subkalimat[$i][$j] == "" || $subkalimat[$i][$j] == "\n" || $subkalimat[$i][$j] == " "){
						unset($subkalimat[$i][$j]);
					}
				}
				$subkalimat[$i][0] = "START";
			}

			$subkalimat[$i][count($subkalimat[$i])] = "END";
			if(count($subkalimat[$i]) == 2){
				//echo $subkalimat[$i][0]."+ ";
				unset($subkalimat[$i]);
			}else{
				for($j = 1; $j<count($subkalimat[$i]);$j++){
					if(isset($subkalimat[$i][$j])){
					//echo $subkalimat[$i][$j]." ";
						if(array_key_exists($subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],$mBigram)){
							$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]]["jumlah"]++;
						}else{
							$mBigram[$subkalimat[$i][$j-1]." ".$subkalimat[$i][$j]] = array(
								'bigram' => $subkalimat[$i][$j-1]." ".$subkalimat[$i][$j],
								'kata' => $subkalimat[$i][$j-1],
								'jumlah' => 1,
								);
						}
					}else{
					//echo "aaaa ";
						$var = 1;
						while(!isset($subkalimat[$i][$j])){
							$var++;
							$j++;
						}
						if(array_key_exists($subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j],$mBigram)){
							$mBigram[$subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j]]["jumlah"]++;
						}else{
							$mBigram[$subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j]] = array(
								'bigram' => $subkalimat[$i][$j-$var]." ".$subkalimat[$i][$j],
								'kata' => $subkalimat[$i][$j-$var],
								'jumlah' => 1,
								);
						}
					}
				}
			}
					//echo "bbb ";
			$i++;
		}
		// echo "<pre>";
		// print_r($subkalimat);
		// echo "</pre>";
		
		foreach ($mBigram as $mBigramProb) {
			if(isset($mUnigram[$mBigramProb['kata']]['jumlah'])){
				$mBigram[$mBigramProb['bigram']]['prob'] = $mBigramProb['jumlah']/$mUnigram[$mBigramProb['kata']]['jumlah'];
			}else{
				$mBigram[$mBigramProb['bigram']]['prob'] = $mBigramProb['jumlah']/count($subkalimat);
			}
		}

		return $mBigram;
	}

	public function ngram($n,$data,$mUnigram,$link){
		
		$data = preg_split('/[\.\?\!\n]/',$data);
		$data = preg_replace('/[\`\~\#\$\%\^\&\*\-\=\{\}\;\“\”\�\–\"\<\>\,\+\(\)\'\:\[\]\_℃]/'," ",$data);
		$data = preg_replace('!\s+!', ' ', $data);
		$data = preg_replace('/\n/', '', $data);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		$mBigram = array();
		$i=0;
		$nGram = array();
		foreach ($data as $kalimat) {
			$subkalimat[] = explode(" ", $kalimat);
			if($subkalimat[$i][0] == " "){
				$subkalimat[$i][0] = "START";
				for($j = count($subkalimat[$i])-1; $j>0;$j--){
					if($subkalimat[$i][$j] == "" || $subkalimat[$i][$j] == "\n" || $subkalimat[$i][$j] == " "){
						unset($subkalimat[$i][$j]);
					}
					$subkalimat[$i][$j] = strtolower($subkalimat[$i][$j]);
					
				}
			}else{
				for($j = count($subkalimat[$i]); $j>0;$j--){
					$subkalimat[$i][$j] = strtolower($subkalimat[$i][$j-1]);
					if($subkalimat[$i][$j] == "" || $subkalimat[$i][$j] == "\n" || $subkalimat[$i][$j] == " "){
						unset($subkalimat[$i][$j]);
					}
				}
				$subkalimat[$i][0] = "START";
			}
			$subkalimat[$i][count($subkalimat[$i])+1] = "END";
			
			if(count($subkalimat[$i]) < $n || count($subkalimat[$i]) ==2){
				unset($subkalimat[$i]);
			}else{
				// echo "<pre>";
				// print_r($kalimat);
				// echo "</pre>";
				// echo "<pre>";
				// print_r($subkalimat[$i]);
				// echo "</pre>";
				$stat=0;
				for($j = 1; $j<count($subkalimat[$i]);$j++){
					$temp = array();
					// echo "<pre>";
					// print_r($subkalimat[$i]);
					// echo "</pre>";
					if($j == 2 && !isset($subkalimat[$i][1])){
						$j++;
						if(!isset($subkalimat[$i][$j])){
							while(!isset($subkalimat[$i][$j])){
								$j++;
							}
							$stat++;
						}else{
							$stat++;
						}
					}
					if(!isset($subkalimat[$i][$j])){
						while(!isset($subkalimat[$i][$j])){
							$j++;
						}
						$stat++;
					}else{
						$stat++;
					}
					$stat++;
					// echo"<pre>";
					// print_r($subkalimat[$i]);
					// echo"</pre>";
					//echo "$stat<br>";
					if($stat>$n-1){
						$k=$j;
						$l=$n-1;
						$statNext = 0;
						while($k>=0 && $l>=0){
							if(!isset($subkalimat[$i][$k])){
								$k--;
							}else{
								$temp[$l] = $subkalimat[$i][$k];
								$l--;					
								$k--;
							}
						}
						if($l != -1){
							$statNext = 1;
						}

						if($statNext == 0){

							$ngram="";
							for($l=0;$l<$n-1;$l++){
								$ngram.=$temp[$l]." ";
							}
							$ngram.=$temp[$l];

							if(array_key_exists($ngram,$nGram)){
								$nGram[$ngram]["jumlah"]++;
								// echo $ngram;
								// echo"1~~~~";
								// echo $nGram[$ngram]["jumlah"]."<br>";
							}else{
								// echo $ngram;
								// echo"#####$n#####<br>";
								$nGram[$ngram] = array(
									'ngram' => $ngram,
									'kata' => $temp[0],
									'prob' => 1,
									'jumlah' => 1,
									);
							}
						}
					}
				}
			}
			$i++;		
			
		}

		foreach ($nGram as $nGramProb) {
			if(isset($mUnigram[$nGramProb['kata']]['jumlah'])){
				$nGram[$nGramProb['ngram']]['prob'] = $nGram[$nGramProb['ngram']]['prob']*$nGramProb['jumlah']/$mUnigram[$nGramProb['kata']]['jumlah'];
			}else{
				$nGram[$nGramProb['ngram']]['prob'] = $nGram[$nGramProb['ngram']]['prob']*$nGramProb['jumlah']/count($subkalimat);
			}
		}

		$x = $n;
		if($x>2){
			$x--;
			$arrX = "";
			$arrX = $this->ngram($x,file_get_contents($link),$mUnigram,$link);
			//echo $arrX['ahmad END']['kata'];
			foreach ($nGram as $nGramProb) {
				$xx = 1;
				$key = "";
				//echo $nGramProb['ngram'];
				while($xx <= $x){
					if($xx == 1){
						$key=explode(" ",$nGramProb['ngram'])[$xx];
						
					}else{
						$key.=" ";
						$key.=explode(" ",$nGramProb['ngram'])[$xx];
					}
					$xx++;
				}
				
				if(isset($arrX[$key]['jumlah'])){
					// echo "<pre>";
					// echo $nGram[$nGramProb['ngram']]['ngram']."+";
					// echo $nGram[$nGramProb['ngram']]['prob'];
					// echo "</pre>";
					$nGram[$nGramProb['ngram']]['prob'] = $nGram[$nGramProb['ngram']]['prob']*$arrX[$key]['prob'];
					// echo "<pre>after>>>$x||";
					// echo $key."+";
					// echo $nGram[$nGramProb['ngram']]['prob'];
					// echo "</pre>";
				}
			}
			//print_r($arrX);
			//$nGram = array_merge($nGram,$arrX);
		}

				// echo "<pre>";
				// print_r($nGram);
				// echo "</pre>";
			return $nGram;			
	}

	public function cekNgram(){
		$namefile = "WIKI_flatfile1.txt";
		$link = base_url();
		$link .="data/".$namefile;
		$n = $_POST['nGram'];
		$mUnigram = $this->unigram(file_get_contents($link));
		$mBigram = $this->bigram(file_get_contents($link),$mUnigram);
		//$mBigram = $this->ngram(2,file_get_contents($link),$mUnigram,$link);

		$nGram = $this->ngram($n,file_get_contents($link),$mUnigram,$link);
		
		// echo "<pre>";
		// print_r($mBigram);
		// echo "</pre>";
		

		$data1 = $mUnigram;
		$data2 = $mBigram;
		$data3 = $nGram;
		// echo "<pre>";
		// print_r($data3);
		// echo "</pre>";
		
		usort($mUnigram, function($a, $b) {
		    return $a['jumlah'] < $b['jumlah'];
		});

		usort($mBigram, function($a, $b) {
		    return $a['jumlah'] < $b['jumlah'];
		});

		usort($nGram, function($a, $b) {
		    return $a['jumlah'] < $b['jumlah'];
		});

		$unigram10besar = array_slice($mUnigram,0,10);
		$bigram10besar = array_slice($mBigram,0,10);
		$ngram10besar = array_slice($nGram,0,10);
		// echo "<pre>";
		// print_r($unigram10besar);
		// echo "</pre>";
		// echo "<pre>";
		// print_r($bigram10besar);
		// echo "</pre>";

		$data = array(
            'mUnigram' => $data1,
            'mBigram' => $data2,
            'nGram' => $data3,
            'unigram10besar' => $unigram10besar,
            'bigram10besar' => $bigram10besar,
            'ngram10besar' => $ngram10besar,
        );

		$this->load->view('index',$data);
	}
}

