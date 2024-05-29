<?php

class PostsController extends AppController{
    public $helpers=array('Html','Form');
    //全記事取得のAPI
    public function index(){
        $this->set('posts',$this->Post->find('all'));//viewに渡すときにthisを使う findはデータをもって来いという指示
        $this->set('title_for_layout','記事一覧');
    }
    //全記事取得用API
    public function view($id=null){
        $this->Post->id=$id;
        $this->set('post',$this->Post->read());
    }
    //追加用API
    public function add(){
        if ($this->request->is('post')){
            if ($this->Post->save($this->request->data)){
                $this->Session->setFlash('Success');
                $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->setFlash('failed!');//うまくいかなかった場合エラーメッセージを返す
            }
        }
    }
    //編集用API
    public function edit($id=null){
        $this->Post->id=$id;
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