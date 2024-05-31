<?php
//入力欄でのルール設定
class Post extends AppModel {
    public $hasMany="Comment";
    
    public $validate = array(
        'title' => array(
            'rule' => 'notBlank',
            'message' => 'Not Blank'
        ),
        'body' => array(
            'rule' => 'notBlank'
        )
    );
}