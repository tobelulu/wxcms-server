<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\OrderResource;

class FanController extends Controller
{
    // 
    public function footprint(Request $request){
        $user = $request->user();
        $data = $user->bookmarks(\App\Models\Article::class)->get();
        $articles = ArticleResource::collection($data);
        return response()->json($articles);
    }

    public function like(Request $request){
        $user = $request->user();
        $data = $user->likes(\App\Models\Article::class)->get();
        $articles = ArticleResource::collection($data);
        return response()->json($articles);
    }


    public function getme(Request $request){
        $user = $request->user();
        $user->task = $user->todaytask();
        $user->task->total = intval( $user->task->total );
        $user->avatar = $user->avatar?$user->avatar:'https://image.weilanwl.com/img/square-3.jpg';
        
        $user->name = $user->name?$user->name:'游客'.$user->id;
        
        return response()->json($user);
    }

    public function order(Request $request){
        $user = $request->user();
        $orders = OrderResource::collection($user->orders);
        return response()->json($orders);
    }

    public function getuserinfo(Request $request){
        $user = $request->user();
        $user->task = $user->todaytask();
        $user->task->total = intval( $user->task->total );
        $user->avatar = $user->avatar?$user->avatar:'https://image.weilanwl.com/img/square-3.jpg';
        
        $user->name = $user->name?$user->name:'游客'.$user->id;
        
        return response()->json($user);
    }

    public function pointlog(Request $request){
        $user = $request->user();
        $pointlogs = $user->pointlogs()->orderBy('id','desc')->get();
        return response()->json($pointlogs);
    }

    public function tasklog(Request $request){
        $user = $request->user();
        $logs = $user->tasks()->orderBy('id','desc')->get();
        return response()->json($logs);
    }

    /**
     * 每日组队
     */
    public function team(Request $request){
        $user = $request->user();
        return response()->json($user);
    }
}
