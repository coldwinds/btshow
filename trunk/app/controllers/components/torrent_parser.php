<?php
class TorrentParserComponent extends Object {
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
	function parse_file($file_name){
		// some codes return array();
		App::import('Vendor','TorrentFile');
		$obj = new TorrentFile();
		$torrent_info = $obj->parse_file($file_name);

		$array = array();

		$array['announce'] = $torrent_info[0]['announce'];
		if(isset($torrent_info[0]['info']['announce-list'])){
			$array['announce-list'] = $torrent_info[0]['announce-list'];
		}
		$array['date_created'] = $torrent_info[0]['creation date'];
		$array['info_hash'] = $torrent_info[0]['info_hash'];

		if(isset($torrent_info[0]['info']['private'])){
			$array['private'] = $torrent_info[0]['info']['private'];
		}

		$file_list = array();
		$count_file_size = 0;
		if(isset($torrent_info[0]['info']['files'])){
			foreach ( $torrent_info[0]['info']['files'] as $value ){
				$file = array();
				$file['size']= (int)$value['length'];
				if(is_array($value['path'])){
					$file['path'] = $value['path'][0];
				}else{
					if(isset($value['path.utf-8'])){
						$file['path']= $value['path.utf-8'];
					}else{
						$file['path']= $value['path'];
					}
				}
				$file_list[] = $file;
				$count_file_size += (int) $value['length'];
			}
		}
		if(isset($torrent_info[0]['info']['length'])){
			$count_file_size += (int) $torrent_info[0]['info']['length'];
			$file = array();
			$file['size'] = $torrent_info[0]['info']['length'];
			$file['path'] = $torrent_info[0]['info']['name.utf-8'];
			$file_list[] = $file;
		}

		$array['size'] = $count_file_size;
		$array['files'] = $file_list;
			
		return $array;
	}

	function parse_file2($file_name){
		App::import('Vendor','Bdecode');
		$obj = new Bdecode ($file_name);
		return $obj->parse();
	}

}
?>