<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        
        if (\Auth::check()) {    //認証済みの場合
            $user = \Auth::user();
            $status = $user->tasks()->orderBy("created_at","desc")->paginate(10);
            $tasks = $user->tasks()->orderBy("created_at","desc")->paginate(10);
            $data = [
                "user" => $user,
                "status" => $status,
                "tasks" => $tasks,
            ];
        }
        
        //dashboardビューでそれら(タスク一覧)を表示
        return view("dashboard", $data);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        //メッセージ作成ビューを表示
        return view("tasks.create",[
            "task"=> $task,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //バリデーション
        $request->validate([
            "content" => "required",
            "status" => "required|max:10",
        ]);
        
        //認証済みユーザとしてタスクを作成
        $request->user()->tasks()->create([
            "status" => $request->status ,
            "content" => $request->content ,
        ]);
        
        //トップページへリダイレクトさせる
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        
        return view("tasks.show",[
            "task" => $task,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        return view("tasks.edit",[
            "task" => $task,
        ]);
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
        //バリデーション
        $request->validate([
            "content" => "required",
            "status" => "required|max:10",
        ]);
        
        $task = Task::findOrFail($id);
        
        //タスクの更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        
        //認証済みユーザがそのタスク登録者である場合はタスクを削除
        if(\Auth::id() === $task->user_id) {
            $task->delete();
            return redirect('/')
                ->with("success","Delete Successful");
        }
        
        return redirect('/')
            ->with("Delete Failed");
    }
}
