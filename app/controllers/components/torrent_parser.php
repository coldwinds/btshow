<?php
class TorrentParserComponent extends Object {
	function parse_file($file_name){
		// some codes return array();
		
		App::import('Vendor','Bdecode');
		$obj = new Bdecode();
		return $obj->parse_file($file_name);
	}
	
	/*
if(isset($torrent_info[0]['info']['files'])){
				foreach ( $torrent_info[0]['info']['files'] as $value ){
					$file = array();
					$file['length']= (int)$value['length'];
					if(is_array($value['path'])){
						$file['name'] = $value['path'][0];
					}else{
						if(isset($value['path.utf-8'])){
							$file['name']= $value['path.utf-8'];
						}else{
							$file['name']= $value['path'];
						}
					}
					$file_list[] = $file;
					$count_file_size += (int) $value['length'];
				}
			}
			if(isset($torrent_info[0]['info']['length'])){
				$count_file_size += (int) $torrent_info[0]['info']['length'];
				$file = array();
				$file['name'] = $torrent_info[0]['info']['name.utf-8'];
				$file['length'] = $torrent_info[0]['info']['length'];
				$file_list[] = $file;
			}	 

	 */
}
?>