<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('blog.index');
})->name('blog.index');

Route::get('post/{id}', function ($id) {
    if ($id == 1) {
        $post = [
            'title' => 'Learning Laravel',
            'content' => 'This blog post will get you right on track with Laravel!'
        ];
    } else {
        $post = [
            'title' => 'Something else',
            'content' => 'Some other content'
        ];
    }
    return view('blog.post', ['post' => $post]);
})->name('blog.post');

Route::get('about', function () {
    return view('other.about');
})->name('other.about');

Route::group(['prefix' => 'admin'], function() {
    Route::get('', function () {
        return view('admin.index');
    })->name('admin.index');

    Route::get('create', function () {
        return view('admin.create');
    })->name('admin.create');

    Route::post('create', function(\Illuminate\Http\Request $request, \Illuminate\Validation\Factory $validator) {
        $validation = $validator->make($request->all(), [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation);
        }
        return redirect()
            ->route('admin.index')
            ->with('info', 'Post created, Title: ' . $request->input('title'));
    })->name('admin.create');

    Route::get('edit/{id}', function ($id) {
        if ($id == 1) {
            $post = [
                'title' => 'Learning Laravel',
                'content' => 'This blog post will get you right on track with Laravel!'
            ];
        } else {
            $post = [
                'title' => 'Something else',
                'content' => 'Some other content'
            ];
        }
        return view('admin.edit', ['post' => $post]);
    })->name('admin.edit');

    Route::post('edit', function(\Illuminate\Http\Request $request, \Illuminate\Validation\Factory $validator) {
        $validation = $validator->make($request->all(), [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation);
        }
        return redirect()
            ->route('admin.index')
            ->with('info', 'Post edited, new Title: ' . $request->input('title'));
    })->name('admin.update');
});