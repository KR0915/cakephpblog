<?php

class CommentsController extends AppController{
    public $helpers=array('Html','Form');
    //追加用API
    public function add(){
        if($this->request->is('post')){
            if($this->Comment->save($this->request->data)){
                $this->Session->setFlash('Success');
                $this->redirect(array('controller'=>'posts','action'=>'index',$this->data['Comment']['post_id']));
            }else{
                $this->Session->setFlash('failed');
            }
        }
    }
    //削除用API
    public function delete($id){
        if($this->request->is('ajax')){
            if($this->Comment->delete($id)){
                $this->autoRender=false;
                $this->autoLayout=false;
                $response=array('id'=>$id);
                $this->header('Content-Type:application/json');
                echo json_encode($response);
                exit();
            }
        }
        $this->redirect(array('controller'=>'posts', 'action'=>'index'));
    }
}