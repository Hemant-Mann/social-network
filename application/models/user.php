<?php
class User extends Shared\Model {  
    /**
    * @column
    * @readwrite
    * @type text
    * @length 100
    *
    * @validate required, alpha, min(3), max(32)
    * @label first name
    */
    protected $_first;
    
    /**
    * @column
    * @readwrite
    * @type text
    * @length 100
    *
    * @validate required, alpha, min(3), max(32)
    * @label last name
    */
    protected $_last;
    
    /**
    * @column
    * @readwrite
    * @type text
    * @length 100
    * @index
    *
    * @validate required, max(100)
    * @label email address
    */
    protected $_email;
    
    /**
    * @column
    * @readwrite
    * @type text
    * @length 100
    * @index
    *
    * @validate required, min(8), max(32)
    * @label password
    */
    protected $_password;

    /**
    * @column
    * @readwrite
    * @type text
    * @length 100
    * @index
    */
    protected $_notes;

    public function isFriend($id) {
        $friend = Friend::first([
            "user = ?" => $this->getId(),
            "friend = ?" => $id,
            "live = ?" => true
        ]);
        
        if (!empty($friend)) {
            return true;
        }
        return false;
    }
    
    public static function hasFriend($id, $friend) {
        $user = new self([
            "id" => $id
        ]);
        return $user->isFriend($friend);
    }

    public function getFile() {
        return File::first([
            "user = ?" => $this->id,
            "live = ?" => true,
            "deleted = ?" => false
            ], ["*"], "id", "DESC"
        );
    }
}
?>
