<?php
class ValidateDeletionBehavior extends CActiveRecordBehavior
{
	public $relations = array();

	public function beforeDelete($event) {
		foreach($this->relations as $relation) {
// 			$objects = $this->Owner->getRelated($relation);
			try {
				if($this->Owner->getRelated($relation)) return false;
			} catch (Exception $e){
				return true;
			}
// 				{
// 				if(is_array($objects)) {
// 					foreach($objects as $object)
// 					{         
// 						$object->delete();
// 					}
// 				}
// 				else
// 				{
// 					$objects->delete();
// 				}
// 			}
		}

		return true;
	}
}
?>