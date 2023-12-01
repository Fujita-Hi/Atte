<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Attetime;
use Carbon\Carbon;
use DateTime;

class AtteController extends Controller
{
  public function create(Request $request)
  {
    $form = $request->all();
    Attetime::create($form);
    session() -> put('status', $request->__get('status'));
    return redirect('/');
  }

  public function attedata(Request $request)
  {
      // 今日の日付で絞り込んだデータを取得
      $date = new Carbon();
      if($request->__get('date') === NULL){
        $date = Carbon::today();
      } else{
        $date = new Carbon($request->__get('date'));
      }
      $timedata = Attetime::whereDate('created_at', $date)->get();
      
      // Userモデルでソート
      $timedata = $timedata->sortBy('created_at');
      $timedata = $timedata->sortBy('name');

      $attedata = [];
      $atte = [
          'name' => NULL,
          'AttendanceStart' => NULL,
          'AttendanceEnd' => NULL,
          'RestTime' => NULL,
          'AtteTime' => NULL,
        ];
      $astime = new Carbon();
      $aetime = new Carbon();
      $attetime = new Carbon();
      $rstime = new Carbon();
      $retime = new Carbon();
      $resttime = new Carbon();
      $totalresttime = new Carbon();

      foreach ($timedata as $time) {
        $atte['name'] = $time['name'];
        $status = $time['status'];
        if($status === 'AttendanceStart'){
          $astime = $time['created_at'];
          $atte['AttendanceStart'] = $time['created_at']->format('H:i:s');
        } elseif($status === 'AttendanceEnd'){
          $aetime = $time['created_at'];
          $atte['AttendanceEnd'] = $time['created_at']->format('H:i:s');
          $attetime = Carbon::parse($astime)->diffInSeconds(Carbon::parse($aetime));
          $atte['AtteTime'] = Carbon::createFromTimestamp($attetime)->subHours(9)->format('H:i:s');
          $attedata[] = $atte;
          $atte = [
            'name' => $time['name'],
            'AttendanceStart' => NULL,
            'AttendanceEnd' => NULL,
            'RestTime' => NULL,
            'AtteTime' => NULL,
          ];
        } elseif($status === 'RestStart'){
          $rstime = $time['created_at'];
        } elseif($status === 'RestEnd'){
          $retime = $time['created_at'];
          if($resttime === NULL){
            $resttime = Carbon::parse($rstime)->diffInSeconds(Carbon::parse($retime));
            $totalresttime = $resttime;
          }else{
            $resttime = Carbon::parse($rstime)->diffInSeconds(Carbon::parse($retime));
            $totalresttime = $resttime + $resttime;
          }
          
          $atte['RestTime'] = Carbon::createFromTimestamp($totalresttime)->subHours(9)->format('H:i:s');
        }
      }
      $perPage = 5;
      $coll = collect($attedata);
      $data = $this->paginate($coll);
      // ビューにデータを渡す
      return view('attendance', compact('data'),['nowdate' => $date]);
  }
  private function paginate($items, $perPage = 5, $page = null, $options = ['path'=>'/attendance']){
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $items instanceof Collection ? $items : Collection::make($items);
      return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
  }

  public function dayupdate()
  {
    $username = Auth::user()->name;
    $latestdata = Attetime::where('name', $username)->latest()->first();
    $yddate = Carbon::now()->subDay()->endOfDay();
    $yesterdayEndOfDay = Carbon::yesterday()->endOfDay();
    $form = [
      'name' => $latestdata['name'],
      'email' => $latestdata['email'],
      'status' => null,
      'created_at' => $yddate,
      'updated_at' => $yddate,
    ];
    if($latestdata['status'] !== 'AttendanceEnd'){
      if($latestdata['status'] === 'RestStart'){
        $form['status'] = 'RestEnd';
        
        Attetime::insert($form);
      }
      $form['status'] = 'AttendanceEnd';
      Attetime::insert($form);
    }
    session() -> put('status', $form['status']);
    return redirect('/');
  }
}
