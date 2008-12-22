<?php

/**
 * sample:
 * $x = new TorrentFile();
 * var_dump($x->parse_file("vertigo2.torrent"));
 *
 */
class TorrentFile {
    var $index;
    var $source;
    var $final_array;


    function handler() {
        $char = $this->source[$this->index];

        if (is_numeric($char)) return $this->handler_string();
        if ($char == 'i') {
            ++$this->index;
            return $this->handler_int();
        }
        if ($char=='l') {
            ++$this->index;
            return $this->handler_list();
        }
        if ($char=='d') {
            ++$this->index;
            return $this->handler_dictonary();
        }

        die("MAIN HANDLER: UNEXPECTED CHAR (position: $this->index): ".$char);
    }


    function handler_int() {
        $current_char='';
        $number = "";

        while (($current_char = $this->source[$this->index]) != 'e') {
            ++$this->index;
            $number .= $current_char;
        }

        ++$this->index;

        return (int) $number;
    }



    function handler_string(){
        $size ="";
        while($this->source[$this->index] != ':') {
            $size .= $this->source[$this->index];
            ++$this->index;
        }

        $i = ++$this->index;
        $this->index += $size;

        $x= substr($this->source, $i, $size);

        return $x;
    }

    function handler_list() {
        $return_list = array();

        while ($this->source[$this->index] != 'e') {
            $this->index1 = $this->index;
            $return_list[] = $this->handler();
            if ($this->index1 == $this->index) die("INFINITE LOOP IN THE LIST");
        }
        ++$this->index;

        return $return_list;
    }

    function handler_dictonary() {
        $return_dict = array();
		$is_info = false;
		
        while ($this->source[$this->index] != 'e') {
            $this->index1 = $this->index;
            $dic_name = $this->handler_string();
            if($dic_name === 'info') {//is info_hash
            	$start_index = $this->index;
            	$is_info = true;
            }
            $return_dict[$dic_name] = $this->handler();
	        if($is_info){//calculate info_hash
				$info_str = substr($this->source, $start_index, ($this->index - $start_index));
				$return_dict['info_hash'] = sha1($info_str);
				$is_info = false;
			}
            if ($this->index1 == $this->index) die("INFINITE LOOP IN THE DICTONARY");
        }
        ++$this->index;
        return $return_dict;
    }


    function parse_file($filename) {
        $this->source = file_get_contents($filename);

        $this->index = 0;
        $filesize = strlen($this->source);

        $this->final_array=array();

        while($this->index<$filesize) {
            $this->index1 = $this->index;
            $this->final_array[] =$this->handler();
            if ($this->index1 == $this->index) die("INFINITE LOOP IN THE ROOT LIST");
        }
        
        $this->source = '';
        return $this->final_array;
    }
}

?>