<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resp['code'] = 200;
        $resp['message'] = 'List all posts';
        $resp['data'] = Article::paginate(5);
        return response()->json($resp);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'image' => 'nullable'
            // 'image|mimes:jpg,png,jpeg,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
        ]);

        if ($validator->fails()) {
            return response()->json(["message"=>'Validation Error.', $validator->errors()], 400);
        }
        
        // if ($request->file('image')) {
        //     $data['image'] = $request->file('image')->store('images');
        // }

        $data['image'] = (isset($data['image'])) ? "images/".$data['image'] : "images/placeholder.png" ;
        $data['user_id'] = auth()->user()->id;
        $data['image'] = "images/".$data['image'];
        $post = Article::create($data);

        $resp['code'] = 201;
        $resp['message'] = 'Post Succesfully created';
        $resp['data'] = $post;
        return response()->json($resp, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resp['code'] = 201;
        $resp['message'] = 'Show detail';
        $resp['data'] = Article::findOrFail($id);
        return response()->json($resp);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => 'required|max:255',
            'content' => 'nullable',
            'image' => 'nullable',
            // 'image|mimes:jpg,png,jpeg,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(["error"=>'Validation Error.', $validator->errors(), "data" => $data], 400);
        }
        //     if($request->file('image')) {
        //         if($request->oldImage) {
        //             Storage::delete($request->oldImage);
        //         }
        //         $data['image'] = $request->file('image')->store('images');
        //     }
        // $data['user_id'] = auth()->user()->id;
        Article::where('id', $id)->update($data);

        $resp['code'] = 200;
        $resp['message'] = 'Posts successfully updated';
        $resp['data'] = Article::findOrFail($id);
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resp['deleted-data'] = Article::findOrFail($id);
        if ($resp['deleted-data']->image != "images/placeholder.png") {
            Storage::delete($resp['deleted-data']->image);
        }
        Article::destroy($resp['deleted-data']->id);
        $resp['message'] = 'Post successfully deleted';
        return response()->json($resp);
    }
}
