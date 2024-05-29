<?php

class Comment extends AppModel {
    //すべてのコメントはPostに帰属する
    public $belongsTo = 'Post';
}