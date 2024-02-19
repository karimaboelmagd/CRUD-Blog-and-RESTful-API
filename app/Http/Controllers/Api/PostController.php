<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function Index(){

        $posts = PostResource::collection(Post::get());
        return response()->json([
            'Data'=>$posts,
            'message'=>'ok',
            'status'=>200
        ]);
    }//End Method


    public function Show($id){

        $post = Post::find($id);
        if($post){
            return response()->json([
                'Data'=>new PostResource($post),
                'message'=>'Ok',
                'status'=>200
            ]);
        }
        return response()->json([
            'Data'=>$post,
            'message'=>'The Post Not Found',
            'status'=>404
        ]);
    }//End Method


    public function Store(Request $request){
        //Validate data
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()],400);
        }
        //Request is valid, create new POST
        $post = Post::create($request->all());
        return Response()->json([
            'Data'=>new PostResource($post),
            'message'=>'Post Created successfully',
            'status'=> SymfonyResponse::HTTP_CREATED,
        ]);
    }//End Method


    public function Update(Request $request ,$id){
        //Validate data
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()],400);
        }
        // If The Post ID Not Found
        $post=Post::find($id);
        if(!$post){
            return response()->json([
                'Data'=>"",
                'message'=>'The Post Not Found',
                'status'=>
                SymfonyResponse::HTTP_NOT_FOUND
            ]);
        }
        // If The Post ID Found ,UPDATE THE POST
        $post->update($request->all());
        if($post){
            return Response()->json([
                'Data'=>new PostResource($post),
                'message'=>'Post Updated successfully',
                'status'=> SymfonyResponse::HTTP_OK,
            ]);
        }
    }//End Method

    public function Destroy($id){

        $post=Post::find($id);
        // If The Post ID Not Found
        if(!$post){
            return response()->json([
                'Data'=>"Error",
                'message'=>'The Post Not Found',
                'status'=>404
            ]);
        }
        // If The Post ID Found ,DELETE THE POST
        $post->delete($id);
        if($post){
            return Response()->json([
                'Data'=>"",
                'message'=>'Post Deleted successfully',
                'status'=> SymfonyResponse::HTTP_NO_CONTENT,
            ]);
        }
    }//End Method
}
