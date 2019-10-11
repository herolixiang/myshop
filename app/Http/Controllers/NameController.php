<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NameController extends Controller
{

    public function login()
    {
        return view('name.login');
    }

    public function login_do(Request $request)
    {
        $yan_name=request()->yan_name;
        $yan_pwd=request()->yan_pwd;
        // dd($info);
        $res=DB::table('yan')->where('yan_name','=',$yan_name)->where('yan_pwd','=',$yan_pwd)->first();
        if(!empty($res)) {
            session(['name'=>$yan_name]);
            echo "<script>alert('登录成功');location.href='/name/add';</script>";
        }else{
            echo "<script>alert('登录失败,用户名和密码不正确');location.href='login';</script>";
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query=request()->all();
        $where = [];
        if ($query['name']??'') {
            $where[]=['name','like',"%$query[name]%"];
        }
        if ($query['nian']??'') {
            $where['nian']= $query['nian'];
        }

         $pagesize=config('app.pageSize');
         $data=DB::table('name')->where($where)->paginate($pagesize);
         return view('/name/list',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('name.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $data=$request->except(['_token']);
        //时间戳
        $data['time']=time();
        $res=DB::table('name')->insert($data);
       // dd($res);
       if ($res) {
           return redirect('/name/list');
       }else{
           return error('添加失败','/name/add');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=DB::table('name')->where(['id'=>$id])->first();
        // dd($data);
        return view('name.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $data=$request->except(['_token']);
         $id=$request->id;
        // echo $li_id;exit;
        $res=DB::table('name')->where(['id'=>$id])->update($data);
        if ($res) {
            return redirect('/name/list');
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
         $res=DB::table('name')->where('id','=',$id)->delete();
        //dd($res);
        if ($res) {
            return redirect('/name/list');
        }
    }


    public function signin()
    {
        //把格式化时间转成时间戳
        $isContinue=false; //是否连续签到
        //签到功能
        $signData=DB::table('sign')->where("user_id",1)->orderBy("sign_id","DESC")->first();
        if($signData) {
            //判断今日是否签到
            //time获取当前时间戳
            $sign_time=$signData->sign_time;
            //获取当前凌晨时间
            //date得到格式化时间
            $time0 =date("Y-m-d"); //当前0晨格式化时间
            //strtotime吧格式化时间转成时间戳
            $time0 =strtotime($time0);
            if($sign_time > $time0){
                //报错 今日已签到
                echo '今日已签到';die;
            }
            //判断时间是否是连续签到 昨天0晨 - 昨天24点（今天0晨）
            if($sign_time<$time0 && $sign_time>$time0-86400) {
                $isContinue = true;
            }
        }
        //签到 签到记录表入库
        DB::table('sign')->insert(
            [
                'sign_time'=>time(),
                'user_id'=>1
            ]
        );
        //送分 修改用户积分
        $fen=10;
        $sign_day=5;
        $res =DB::table('user1')
        ->where('user_id',1)
        ->update(['fen'=>$fen,'sign_day'=>$sign_day]);
        echo '签到成功';die;
    }
}
