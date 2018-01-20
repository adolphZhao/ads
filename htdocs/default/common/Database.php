<?php
namespace Common;

class Database{

	 public static function fetchPages() {
	 	$data = [
	 		'org'=>[],
	 		'special'=>[]
	 	];
	 	$pages = Cache::get("page_global");

	 	$cols =[
			"video",
	        "delay_time",
	        "video_num",
	        "titles",
        	"ad_authors",
        	"images"
		];

	 	foreach($pages as $key => $item){
	 		if(preg_match('/(?<col>[a-z_]*)(?<id>\d*)/',$key,$matches)){
	 			if (in_array($matches['col'], $cols)){
	 				$data['special'][empty($matches['id'])?0:$matches['id']][$matches['col']] = self::str2arr($matches['col'],$item);
	 			}else{
	 				$data['org'][$matches['col']] = $item;
	 			}
	 		}
	 	}

	 	return $data;
    }

    public static function str2arr($key,$item){
    	$changes = ['titles','ad_authors','ad_originals','images'];
    	if(in_array($key, $changes )&&!is_array($item)){
    		 return  explode("\n", $item);
    	}
    	return $item;
    }

    public static function fetchOneOfColl($coll, $minHash = 6) {
        $now = floor(time() / (60 * $minHash));
        $hashIndex = $now % count($coll);
        return $coll[$hashIndex];
    }
}