<?php
App::uses('AppController','Controller');

class UsersController extends AppController {
    //AuthFilter関数でAUthComponentにすべてのコントローラのindexとviewアクションでログインを必要としないように伝えました。サイトに登録していない訪問者にエントリを読み込またり、リストを読み込ませないようにした。
    public function beforeFilter() {
        parent::beforeFilter();
        //ユーザー自身による登録とログアウトを許可する
        $this->Auth->allow('add', 'logout');
    }

    public function index() {
        $this->user->recursive=0;
        $this->set('users',$this->paginate());
    }

    public function view($id=null) {
        $this->user->id=$id;
        if (!$this->User->exists()){
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }
    //user追加用API
    public function add() {
        if ($this->request->is('post')){
            $this->user->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action'=>'index'));
            }
            $this->Flash->error(
                __('The user could not be saved Please, try again.')
            );
        }
    }
    //idを特定し、編集する。
    public function edit($id=null) {
        $this->User->id=$id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if($this->User->save($this->request->data)){
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action'=>'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        }else{
            $this->request->data=$this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
    }
    //削除API　idを特定し、削除する
    public function delete($id=null){
        //Prior to 2.5 use
        //$this->request->onlyAllow('post')
        $this->request->allowMethod('post');

        $this->User->id=$id;
        if(!$this->User->delete()){
            throw new NotFoundException(__('Invalid user'));
        }
        if($this->User->delete()){
            $this->Flash->success(__('User deleted'));
            return$this->redirect(array('action'=>'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        return $this->redirect(array('action'=>'index'));
    }
    //login用API
    public function login() {
        if ($this->request->is('post')){
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            }else{
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }
    //logout用API
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
}