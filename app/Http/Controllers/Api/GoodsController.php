<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\Order;
use App\Models\PointLog;
use App\Http\Resources\GoodsResource;
use Carbon\Carbon;

class GoodsController extends Controller
{
    //
    
    public function index(Request $request){
        $appid = $request->user()->appid;
        $data = Goods::where('lower_at','>',Carbon::now())->where('appid','=',$appid)->simplePaginate(10);
        $goodes = GoodsResource::collection($data);
        return response()->json($goodes);
    }

    public function buy(Request $request){
        $appid = $request->user()->appid;
        $goods_id = $request->get('goods_id');
        $num = $request->get('num');
        $goods = Goods::where('appid','=',$appid)->findOrFail($goods_id);
        $user = $request->user();
        if($goods->lower_at < date('Y-m-d H:i:s')) return response()->json(['message'=>'商品已过期']);
        if($goods->stock < $num ) return response()->json(['message'=>'库存不足']);
        
        $order = new Order;
        $order->user_id = $user->id;
        $order->appid = $appid;
        $order->goods_id = $goods->id;
        $order->name = $goods->name;
        $order->num = $num;
        $order->point = $goods->point;
        $order->point_total = $num * $goods->point;
        $order->cash_total = $num * $goods->cash_value;
        $order->cover = $goods->cover;
        $order->lower_at = $goods->invalid_at?$goods->invalid_at:$goods->lower_at; // 失效时间等值商品设置的卷无效时间

        if($user->point < $order->point_total) return response()->json(['message'=>'剩余积分不足']);
        // todo 允许部分商品用剩余积分进行结算?
        if( $user->current_point < $order->point_total ) return response()->json(['message'=>'当前可用积分不足']);

        // 用户扣减积分
        $user->point -= $order->point_total; 
        $user->current_point -= $order->point_total;
        $goods->out += $num; // 加销量
        $goods->stock -= $num; //减库存
        $user->save(); // 保存用户数据
        
        $log = new PointLog;
        $log->user_id = $user->id;
        $log->change = -$order->point_total;
        $log->appid = $appid;
        $log->intro = '消耗积分';
        $log->save();

        $goods->save(); // 保存商品
        $order->save(); // 保存订单
        // todo 下单通知
        return response()->json($order);

    }

}
