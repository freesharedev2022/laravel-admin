<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CategoryController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */


    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('Quản lý danh mục');
            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Sửa danh mục');
            $content->body($this->form($id)->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Tạo danh mục');
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Category::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->name('Tên danh mục');
            $grid->parent_id('Danh mục cha')->display(function ($parent) {
                return (Category::find($parent)) ? Category::find($parent)->name : '';
            });
            $grid->slug('Đường dẫn');

            $grid->model()->orderBy('id', 'desc');


          $grid->filter(function($filter){
            $filter->like('name', 'Tên danh mục');
          });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id = null)
    {
        return Admin::form(Category::class, function (Form $form) use ($id) {

            $form->text('name', 'Tên danh mục')->rules('required', ['required' => 'Bạn phải nhập trường này']);
            $arrCate = (new Category)->listCate();
            $form->select('parent_id', 'Danh mục cha')->options($arrCate);
            $form->saved(function (Form $form) {});
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->body(Admin::show(Category::findOrFail($id), function (Show $show) {
                $show->id('ID');
                $show->id('name');
            }));
        });
    }

    public function destroy($id)
    {
    }
}
