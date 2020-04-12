<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {

        $paginator = BlogCategory::paginate(15);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        //dd(__METHOD__);
        $item = new BlogCategory();
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit',
        compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])){
            $data['slug'] = str_slug($data['title']);
        }
    //    Создаст объект но не добавит в БД
    //   $item = new BlogCategory($data);
    //   $item->save();

    //   Создаст объект и добавит в БД
        $item = (new BlogCategory())->create($data);

        if($item){
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        }   else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

        $item = BlogCategory::findOrFail($id);
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = BlogCategory::find($id);
        if (empty($item)){
            return back()
                ->withErrors(['msg' =>"Запись id=[{'$id'}]] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        if (empty($data['slug'])){
            $data['slug'] = str_slug($data['title']);
        }
        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd(__METHOD__);
    }
}
