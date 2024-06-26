<?php
namespace app\admin\controller\permissions;

use app\admin\controller\CatchController;
use app\admin\model\Admin as AdminModel;
use app\admin\model\LogLogin;
use app\admin\model\LogOperate;
use app\admin\model\permissions\Departments;

class Admin extends CatchController
{
    public function initialize(): void
    {
        $this->model = new AdminModel();
    }

    public function index()
    {
        return $this->success(
            $this->model->setBeforeGetList(function ($query){
                if (! $this->user()->isSuperAdmin()) {
                    $query = $query->whereNotIn('id', config('catch.super_admin'));
                }

                if ($departmentId = \request()->get('department_id')) {
                    $department = new Departments();
                    $followDepartmentIds = $department->findFollowDepartments(\request()->get('department_id'));
                    $followDepartmentIds[] = $departmentId;
                    $query = $query->whereIn('department_id', $followDepartmentIds);
                }

                return $query;
            })->getList()
        );
    }

    public function show($id)
    {
        $admin = $this->model->firstBy($id);

        $admin->setAttr('roles', $admin->roles()->select()->column('id'));
        $admin->setAttr('jobs', $admin->jobs()->select()->column('id'));

        return $this->success($admin);
    }

    public function online()
    {
        if (strtolower($this->request->method()) == 'get') {
            return $this->success($this->user()->permissions());
        }

        return $this->success(
            $this->user()->updateBy($this->uid(), $this->request->all())
        );
    }

    public function loginLog(LogLogin $logLogin)
    {
        $admin = $this->user();

        return $this->success($logLogin->getUserLogBy($admin->isSuperAdmin() ? null : $admin->email));
    }

    public function operateLog(LogOperate $logOperate)
    {
        $scope = $this->request->get('scope', 'self');

        return $this->success($logOperate->setBeforeGetList(function ($builder) use ($scope){
            if ($scope == 'self') {
                return $builder->where('creator_id', $this->uid());
            }
            return $builder;
        })->getList());
    }
}
