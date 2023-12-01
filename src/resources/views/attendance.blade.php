<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
  <link rel="stylesheet" href="{{ asset('resources/views/vendor/pagination/bootstrap-4.blade.php') }}" />
</head>

<body>
  <header class="header">
    <h1 class="header__title">
        Atte
    </h1>
    <nav class="header__nav">
        <ul class="header__nav-list">
            <li class="header__nav-item"><a class="header__nav-item-link" href="/">ホーム</a></li>
            <li class="header__nav-item"><a class="header__nav-item-link" href="/attendance">日付一覧</a></li>
            <li class="header__nav-item">
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a class="header__nav-item-link" href="route('logout')"
                          onclick="event.preventDefault();
                                      this.closest('form').submit();">
                      {{ __('ログアウト') }}
                  </a>
              </form>
            </li>
        </ul>
    </nav>
  </header>
  <main>
    <div>
      <div class="display__date">
        <form action="/attendance" method="post">
          @csrf
          @php
            $subdate = clone $nowdate;
            $subdate->subDay();
            $adddate = clone $nowdate;
            $adddate->addDay();
          @endphp
          <input type="hidden" name="date" value="{{old('date',$subdate)}}">
          <button class="date__button"><</button>
        </form>
        <p>{{$nowdate->format('Y-m-d')}}</p>
        <form action="/attendance" method="post">
          @csrf
          <input type="hidden" name="date" value="{{old('date',$adddate)}}">
          <button class="date__button">></button>
        </form>
      </div>
      <table>
        <tr>
          <th>名前</th>
          <th>勤務開始</th>
          <th>勤務終了</th>
          <th>休憩時間</th>
          <th>勤務時間</th>
        </tr>
        @foreach ($data as $atte)
          <tr>
            <td>{{ $atte['name'] }}</td>
            <td>{{ $atte['AttendanceStart'] }}</td>
            <td>{{ $atte['AttendanceEnd'] }}</td>
            <td>{{ $atte['RestTime'] }}</td>
            <td>{{ $atte['AtteTime']}}</td>
          </tr>
        @endforeach
      </table>
      {{ $data->appends(['date' => request('date')])->links()}}
    </div>
  </main>
  <footer>
    <small class="footer__copyright">Atte,inc.</small>
  </footer>
</body>
<script type="text/javascript">
    // 日付変更時に/daychangeに遷移
    function Checkdate() {
        // 現在の時刻を取得
        var now = new Date();
        // 指定の時刻（00:00）になったらリダイレクト
        if (now.getHours() === 0 && now.getMinutes() === 0) {
          window.location.href = '/daychange';
        }
    };
    window.onload = Checkdate;
    //5s毎にcheckdateを実行
    setInterval(Checkdate, 5000);
</script>
</html>