<h2>Add post</h2>

<?php
echo $this->Form->create('Post');//Formヘルパーを使用する場合にはcreateを使用する。さらに使うModelを選択する
echo $this->Form->input('title');//データベースがvarchar型だったら一行の入力欄を作成
echo $this->Form->input('body',array('rows'=>3));//text型だったらそれに合った入力欄を自動で作成してくれる。
echo $this->Form->end('Save Post');