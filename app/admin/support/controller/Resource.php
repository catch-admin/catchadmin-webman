<?php
namespace app\admin\support\controller;

trait Resource
{
    public function index()
    {
        return $this->success($this->model->getList());
    }


    public function store()
    {
        return $this->success($this->model->storeBy($this->request->all()));
    }


    public function show($id)
    {
        return $this->success($this->model->firstBy($id));
    }

    public function update($id)
    {
        return $this->success($this->model->updateBy($id, $this->request->all()));
    }


    public function destroy($id)
    {
        return $this->success($this->model->deleteBy($id));
    }

    public function enable($id)
    {
        return $this->success($this->model->toggleBy($id));
    }
}
