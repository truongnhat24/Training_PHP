<?php
class product_model extends main_model
{
	public function addRecord($datas) {
		$fields = $values = '';
		$i=0;
		foreach($datas as $k=>$v) {
			if($i) {
				$fields .=',';
				$values .=',';
			}
			$fields .= $k;
			$values .= "'".$v."'";
			$i++;
		}
		$fields .= ', created_at';
		$values .= ', CURDATE()';
		$query = "INSERT INTO $this->table ($fields) VALUES ($values)";
		return mysqli_query($this->con,$query);
	}

    public function getRecord($id=null, $fields='*', $options=null) {
		$conditions = '';
		if(isset($options['conditions'])) {
			$conditions .= ' and '. $options['conditions'];
		}
		$query = "SELECT $fields FROM $this->table where product_id=$id".$conditions;
		$result = mysqli_query($this->con,$query);
		if($result) {
			//$record = mysqli_fetch_array($result);
			//$record = mysqli_fetch_row($result);
			$record = mysqli_fetch_assoc($result);
		} else $record=false;
		return $record;
	}

    public function editRecord($id,$datas){
		$setDatas = '';
		$i=0;
		foreach($datas as $k=>$v) {
			if($i) {
				$setDatas .=',';
			}
			$setDatas .= $k."='".$v."'";
			$i++;
		}
		$setDatas .= ", updated_at = CURDATE()";
        $query = "UPDATE $this->table SET $setDatas WHERE product_id='$id'";
		return mysqli_query($this->con,$query);
        //$result = mysqli_query($this->con,$query) or die("MySQL error: " . mysqli_error($this->con) . "<hr>\nQuery: $query");
    }

	public function delRecord($id=null, $conditions=null) {
		if($conditions)	$conditions = ' and '.$conditions;
		$query = "DELETE FROM $this->table WHERE product_id=$id".$conditions;
		return mysqli_query($this->con,$query);
	}

    public static function convertToList($mysqliObject) {
    	$arrReturn = [];
    	while($row = mysqli_fetch_array($mysqliObject)) {
    		$arrReturn[$row['product_id']] = $row['cat_name'];
    	}
    	return $arrReturn;
	}
}