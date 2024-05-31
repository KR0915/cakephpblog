<?php

class PostsController extends AppController{
    public $helpers=array('Html','Form');//HtmlとFormヘルパー
    //全記事取得のAPI
    public function index(){
        $this->set('posts',$this->Post->find('all'));//viewで使うposts変数にPostテーブルからすべての値をもってくる　記事の一覧を引っ張て来て変数にセットする。
        $this->set('title_for_layout','記事一覧');
    }
    //個別事取得用API
    public function view($id=null){//idを初期値にしている
        $this->Post->id=$id;//idを特定している
        $this->set('post',$this->Post->read());//特定したidから読み取りをしている。
    }
    //追加用API
    public function add(){
        if ($this->request->is('post')){//postでデータが入ってきたら次の事をやりなさい
            if ($this->Post->save($this->request->data)){//渡されたデータを基にpostモデルにセーブする　ifうまくいった場合elseうまくいかなかった場合
                $this->Session->setFlash('Success');
                $this->redirect(array('action'=>'index'));//うまくいった場合indexにリダイレクトする
            }else{
                $this->Session->setFlash('failed!');//うまくいかなかった場合エラーメッセージを返す
            }
        }
    }
    //編集用API
    public function edit($id=null){
        $this->Post->id=$id;//
        if($this->request->is('get')){
            $this->request->data=$this->Post->read();
        }else{
            if($this->Post->save($this->request->data)){
                $this->Session->setFlash('Success!');
                $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->setFlash('failed');
            }
        }
    }
    //削除用API
    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->request->is('ajax')) {
            if ($this->Post->delete($id)) {
                $this->autoRender = false;
                $this->autoLayout = false;
                $response = array('id' => $id);
                $this->header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        }
        $this->redirect(array('action'=>'index'));
    }

}