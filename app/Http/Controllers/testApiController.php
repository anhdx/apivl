<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\User;
use App\Http\Resources\UserCollection;
use App\Http\Requests\userRequest;
use Illuminate\Support\collection;

class TestApiController extends Controller
{
    private $successful;
    public function __construct()
    {

     $this->successful=[
        'Message'=>'Success',
        'status code'=>200,
    ];
}
public function index()
{
    $data =   UserCollection::collection(User::all())->additional([
        'success' =>true,
        'code' =>200
    ]);
    return $data;
}
public function store(userRequest $rq)
{

 $user = new User();
 $users = $user->where('email' ,$rq->email)->first();

 if($users){
    return response()->json([
        'success'=>'false',
        'data'=>["email"=>$rq->email,],
        'errors'=>[
            'Message'=>'email already taken',
            'code'=>'404',
        ],

    ],404);
}
$user->password = $rq->password;
$user->name = $rq->name;
$user->email = $rq->email;
$user->save();
return response()->json([
    'Message'=>'Created',
    'status ' => '201',
    'data'=>$user
],201);

}
public function show($id)
{
    $user = User::find($id);
    if(!$user){
        return response()->json([
            'status '=> 204,
            'message' => 'No content'
        ], 200);
    }
    $data =  new  UserCollection(User::find($id));
    return $data->additional([
        'success' =>true,
        'code' =>200
    ]);
}
public function updatePatch(Request $rq, $id){
    $user = User::find($id);
    if($user ==null){

        return response()->json([
            'Message'=>'No content',
            'status '=> '204'
        ],200);
    }
    $users = $user->where('email' ,$rq->email)
    ->first();
    if($users){

        return response()->json([
            'message'=>'Email already use',
            'code ' => '404',
            'Email'=>$rq->email
        ],404);
    }
    if($rq->all()==null){
        return response()->json([
            'status '=> '204',
            'message' => 'Nothing to update'
        ], 204);

    }
    if(!$user){
        return response()->json([
            'status '=> '404',
            'message' => 'Page Not Found.'
        ], 404);
    }else{
       $user->update($rq->all());
       return response()->json([
        'message'=>'updated',
        'status '=> '200',
        'data'=>$user
    ],200);
   }
}
public function update(userRequest $rq,$id)
{
    $user = User::find($id);
    if(!$user){

        return response()->json([
            'Message'=>'No content',
            'status '=> '204'
        ],200);
    }
    $users = $user->where('email' ,$rq->email)
    ->first();
    if($users){

        return response()->json([
            'message'=>'Email already use',
            'status ' => '404',
            'Email'=>$rq->email
        ],404);
    }
    if($rq->all()==null){
        return response()->json([
            'status '=> '204',
            'message' => 'No content'
        ], 204);

    }
    if (!$rq->name||!$rq->email||!$rq->password) {
        return response()->json([
            'status '=> '404',
            'message' => 'Cant update'
        ], 404);
    }
    if(!$user){
        return response()->json([
            'status '=> '204',
            'message' => 'No content'
        ], 404);
    }else{
       $user->update($rq->all());
       return response()->json([
        'Message'=>'Success',
        'status code'=>200,
        'data'=>$user,
    ],200);
   }
}
public function destroy($id)
{

    $user = User::find($id);
    if(!$user){
        return response()->json([
            'status '=> 204,
            'message' => 'ko ton tai nguoi dung nay'
        ], 200);
    }
    $user->delete();
    return response()->json([
        'Message'=>'Remove success',
        'status '=>200,
        'data'=>$user
    ],200);
}
public function orderByUser(Request $rq){
    $user = User::orderBy($rq->order, $rq->sort)->get();
    return response()->json([
     'Message'=>'Success',
     'status code'=>200,
     'data'=>$user,
 ],200);
}
public function searchApi(Request $rq){
        // dd($rq->q);
    $user = User::where('name','like',"%{$rq->q}%")
    ->orWhere('email','like',"%{$rq->q}%")
    ->get();
    if($rq->q==null){
     return response()->json(['Message'=>'No content','status '=>'204'],200);
 }
 if($user){
    return response()->json([
        'Message'=>'Success',
        'status code'=>200,
        'data'=>$user,
    ],200);
}else{
    return response()->json(['Message'=>'No content','status '=>'204'],200);
}
}

}
