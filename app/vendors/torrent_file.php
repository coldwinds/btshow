<?php

/**
 * sample:
 * $x = new TorrentFile();
 * var_dump($x->parse_file("vertigo2.torrent"));
 *
 */
class TorrentFile{
	private $s='';
	private $o=0;
	private $info_hash='';
	private function destr(){
		$d=strpos($this->s,':',$this->o);
		if($d===FALSE){
			return FALSE;
		}
		$l=substr($this->s,$this->o,$d-$this->o);
		if($l==='0'){ 
			$this->o+=2;
			return ''; //allow 0-byte string
		}
		if($l=intval($l)){
			$this->o=$d+1+$l;
			if($this->o>strlen($this->s)){
				log('destr(): string not complete',3);
				return FALSE;
			}
			return substr($this->s,$d+1,$l);
		}else{
			return FALSE;
		}
	}
	private function deint(){
		$d=strpos($this->s,'e',$this->o);
		if($d===FALSE){
			return FALSE;
		}
		$this->o++;
		$l=substr($this->s,$this->o,$d-$this->o);
		$this->o=$d+1;
		if($l==='0')
			return 0;
		if($l=intval($l))
			return $l;
		else{
			return FALSE;
		}
	}
	private function delst(){
		$r=array();
		$l=strlen($this->s);
		$this->o++;
		if($this->o===$l)return FALSE; //no end
		while($this->s[$this->o]!=='e'){
			$t=$this->deobj();
			if($this->o===$l)return FALSE; //no end
			if($t===FALSE)return FALSE;
			$r[]=$t;
		}
		$this->o++;
		return $r;
	}
	private function dedic(){
		$r=array();
		$l=strlen($this->s);
		$this->o++;
		if($this->o===$l)return FALSE; //no end
		while($this->s[$this->o]!=='e'){
			$k=$this->destr();
			if($this->o===$l)return FALSE; //no end
			if($k===FALSE)return FALSE;
			$d1=$this->o;
			$v=$this->deobj();
			$d2=$this->o;
			if($k==='info')$this->info_hash=sha1(substr($this->s,$d1,$d2-$d1));
			if($this->o===$l)return FALSE; //no end
			if($v===FALSE)return FALSE;
			$r[$k]=$v;
		}
		$this->o++;
		return $r;
	}
	private function deobj(){
		$c=$this->s[$this->o];
		if($c==='i')return $this->deint();
		if($c==='l')return $this->delst();
		if($c==='d')return $this->dedic();
		return $this->destr();
	}
	private function defile(){
		$r=array();
		$l=strlen($this->s);
		while($this->o<$l){
			$t=$this->deobj();
			if($t===FALSE)return FALSE;
			$r[]=$t;
		}
		return $r;
	}
	public function __construct($i){
		$this->s=$i;
	}
/*
give an array like this:
Array
(
    [announce] => http://tk.greedland.net/announce
    [announce-list] => Array
        (
            [0] => http://tracker.dmhy.org:8000/announce
            [1] => udp://tracker.dmhy.org:8000/announce
            [2] => http://tk.greedland.net/announce
            [3] => http://tk2.greedland.net/announce
            [4] => http://bt.popgo.net:7456/announce
            [5] => http://tracker.ktxp.com:6868/announce
            [6] => http://tracker.ktxp.com:7070/announce
            [7] => udp://tracker.ktxp.com:6868/announce
            [8] => udp://tracker.ktxp.com:7070/announce
        )
    [date_created] => 1222692215
    [info_hash] => 4bc1965e65340ea033a90b931f1b06591fd96edf
    [private] => 
    [comment] => 
    [size] => 121914692
    [files] => Array
        (
            [0] => Array
                (
                    [size] => 121914692
                    [path] => [AME][World_Destruction][10][848x480][BIG5].rmvb
                )
        )
)

*/
	public function parse(){
		function array_flatten($a,&$b=array()){
			foreach($a as $v)
				if(is_array($v))
					$b=&array_flatten($v,$b);
				else
					$b[]=$v;
			return $b;
		}
		$f=$this->defile();

		$r=array(
			'announce' => $f[0]['announce'],
			'announce-list' => array_unique(array_flatten($f[0]['announce-list'])),
			'date_created' => $f[0]['creation date'],
			'info_hash' => $this->info_hash,
			'private' => $f[0]['private'],
			'comment' => $f[0]['comment'],
			'size' => 0,
		);
		$r['files']=array();
		if(is_array($f[0]['info']['files'])){ //multi-file mode
			$n=$f[0]['info']['name']."/";
			foreach($f[0]['info']['files'] as $file){
				$r['files'][]=array('size'=>$file['length'],'path'=>$n.implode('/',$file['path']));
				$r['size']=bcadd($r['size']+$file['length']);
			}
			$r['files'][]=array('size'=>$r['size'],'path'=>$n);
		}else{ //single file mode
			$r['files'][]=array('size'=>$f[0]['info']['length'],'path'=>$f[0]['info']['name']);
			$r['size']=$f[0]['info']['length'];
		}
		return $r;
	}
}
?>
