<?php
function bdecode($s){
	$o=0;
	$ih='';
	function destr(&$s,&$o,&$ih){
		$d=strpos($s,':',$o);
		if($d===false)return false;
		$l=substr($s,$o,$d-$o);
		if($l==='0'){ 
			$o+=2;
			return ''; //allow 0-byte string
		}
		if($l=intval($l)){
			$o=$d+1+$l;
			if($o>strlen($s))//string not complete
				return false;
			return substr($s,$d+1,$l);
		}else	return false;
	}
	function deint(&$s,&$o,&$ih){
		$d=strpos($s,'e',$o);
		if($d===false)return false;
		$o++;
		$l=substr($s,$o,$d-$o);
		$o=$d+1;
		if($l==='0')
			return 0;
		if($l=intval($l))
			return $l;
		else	return false;
	}
	function delst(&$s,&$o,&$ih){
		$r=array();
		$l=strlen($s);
		$o++;
		if($o===$l)return false; //no end
		while($s[$o]!=='e'){
			$t=deobj($s,$o,$ih);
			if($o===$l)return false; //no end
			if($t===false)return false;
			$r[]=$t;
		}
		$o++;
		return $r;
	}
	function dedic(&$s,&$o,&$ih){
		$r=array();
		$l=strlen($s);
		$o++;
		if($o===$l)return false; //no end
		while($s[$o]!=='e'){
			$k=destr($s,$o,$ih);
			if($o===$l)return false; //no end
			if($k===false)return false;
			$d1=$o;
			$v=deobj($s,$o,$ih);
			$d2=$o;
			if($k==='info')$ih=sha1(substr($s,$d1,$d2-$d1));
			if($o===$l)return false; //no end
			if($v===false)return false;
			$r[$k]=$v;
		}
		$o++;
		return $r;
	}
	function deobj(&$s,&$o,&$ih){
		$c=$s[$o];
		if($c==='i')return deint($s,$o,$ih);
		if($c==='l')return delst($s,$o,$ih);
		if($c==='d')return dedic($s,$o,$ih);
		return destr($s,$o,$ih);
	}
	function defile(&$s,&$o,&$ih){
		$r=array();
		$l=strlen($s);
		while($o<$l){
			$t=deobj($s,$o,$ih);
			if($t===false)return false;
			$r[]=$t;
		}
		return $r;
	}

	function array_flatten($a,&$b=array()){
		foreach($a as $v)
			if(is_array($v))
				$b=&array_flatten($v,$b);
			else
				$b[]=$v;
		return $b;
	}

	$f=defile($s,$o,$ih);
	if(!$f
	|| !$f[0]
	|| !$f[0]['announce']
	|| strlen($ih)!==40 
	|| !ctype_xdigit($ih))
		return false;

	$f[0]['info']['pieces']='';

	$r=array(
		'announce' => $f[0]['announce'],
		'announce-list' => array_unique(array_flatten($f[0]['announce-list'])),
		'creation date' => $f[0]['creation date'],
		'infohash' => $ih,
		'private' => $f[0]['private'],
		'comment' => $f[0]['comment'],
		'size' => 0,
	);
	$encoding = $f[0]['encoding'];
	$r['files']=array();
	if(is_array($f[0]['info']['files'])){ //multi-file mode
		$name = $f[0]['info']['name'];
		if(isset($f[0]['info']['name.utf-8']))
			$name = $f[0]['info']['name.utf-8'];
		elseif(strlen($encoding)){
			$s = iconv($encoding, 'utf8//IGNORE', $name);
			if($s && $name === iconv('utf8',"$encoding//IGNORE", $s))
				$name = $s;
		}
		$n=$name."/";
		foreach($f[0]['info']['files'] as $file){
			$path = $file['path'];
			if(isset($file['path.utf-8']))
				$path = $file['path.utf-8'];
			elseif(strlen($encoding)){
				$s = iconv($encoding, 'utf8//IGNORE', $path);
				if($s && $path === iconv('utf8',"$encoding//IGNORE", $s))
					$path = $s;
			}
			$r['files'][]=array('size'=>$file['length'],'path'=>$n.implode('/',$path));
			$r['size']=bcadd($r['size'],$file['length']);
		}
		$r['files'][]=array('size'=>$r['size'],'path'=>$n);
	}else{ //single file mode
		$name = $f[0]['info']['name'];
		if(isset($f[0]['info']['name.utf-8']))
			$name = $f[0]['info']['name.utf-8'];
		elseif(strlen($encoding)){
			$s = iconv($encoding, 'utf8//IGNORE', $name);
			if($s && $name === iconv('utf8',"$encoding//IGNORE", $s))
				$name = $s;
		}
		$r['files'][]=array('size'=>$f[0]['info']['length'],'path'=>$name);
		$r['size']=$f[0]['info']['length'];
	}
	return $r;
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
?>
