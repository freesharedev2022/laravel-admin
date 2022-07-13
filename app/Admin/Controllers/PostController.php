<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Posts;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PostController extends Controller
{
  use ModelForm;

  public function index()
  {
    return Admin::content(function (Content $content) {
      $content->header('Quản lý bài viết');
      $content->body($this->grid());
    });
  }

  public function edit($id)
  {
    return Admin::content(function (Content $content) use ($id) {
      $content->header('Sửa cửa bài viết');
      $content->body($this->form($id)->edit($id));
    });
  }

  public function create()
  {
    return Admin::content(function (Content $content) {
      $content->header('Tạo bài viết');
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
    return Admin::grid(Posts::class, function (Grid $grid) {
      $grid->id('ID')->sortable();
      $grid->title('Tiêu đề')->sortable();
      $grid->image('Ảnh đại diện')->image();
      $grid->description("Mô tả")->display(function ($stt){
        return $stt;
      });

      $grid->created_at("Ngày tạo")->display(function ($date){
        return date('H:i:s d/m/Y', strtotime($date));
      });

      $grid->status("Trạng thái")->display(function ($status){
        return $status ? "Phê duyệt" : 'Chưa phê duyệt';
      });

      $grid->model()->orderBy('id', 'desc');

      $grid->filter(function($filter){
        $filter->like('title', 'Tiêu đề');
        $filter->equal('status', 'Bài đã duyệt')->select([0=>"Bài chưa duyệt", 1=>"Bài đã duyệt"]);
      });
    });
  }

  protected function form($id = null)
  {
    return Admin::form(Posts::class, function (Form $form) use ($id) {
      $arrCate = (new Category)->listCate();
      $form->text('title', 'Tiêu đề')->rules('required', ['required' => 'Bạn phải nhập trường này']);
      $form->textarea('description', 'Mô tả');
      $form->image("image");
      $form->ckeditor('content', 'Nội dung');
      $form->select('category_id', 'Danh mục')->options($arrCate);
      $form->multipleSelect('category_other', "Danh mục khác")->options($arrCate);
      $form->switch("status")->default(true);
      $form->saved(function (Form $form) {});
    });
  }

  public function show($id)
  {
    return Admin::content(function (Content $content) use ($id) {
      $content->body(Admin::show(Posts::findOrFail($id), function (Show $show) {
        $show->id('ID');
        $show->title('Tiêu đề');
        $show->descrition('Mô tả');
        $show->content('Nội dung')->display(function ($data){
          return $data;
        });
        $show->image('Ảnh đại diện')->image();
      }));
    });
  }

  public function destroy($id)
  {
  }
}
