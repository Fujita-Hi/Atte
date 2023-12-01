<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Form</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/stamp.css') }}" />
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
    <!-- Authentication -->
  </header>
  <main>
    <div class="stamp">
        <p class="stamp__greeting">{{ Auth::user()->name }}さんお疲れ様です！</p>
        <!-- <p>{{session('status')}}</p> -->
        <div class="stamp__list">
            <!-- 勤務開始 -->
            <form action="/" method="post">
              @csrf
              <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
              <input type="hidden" name="name" value="{{ Auth::user()->name }}">
              <input type="hidden" name="email" value="{{ Auth::user()->email }}">
              <input type="hidden" name="status" value="AttendanceStart">
              <button id='btn_attestart' class='stamp__button' >勤怠開始</button>
              @if(session('status', 'AttendanceEnd')!=="AttendanceEnd")
                <script>
                  const button1 = document.querySelector("#btn_attestart");
                  button1.disabled = true;
                  button1.style.color = '#EEEEEE';
                  button1.style.cursor = 'not-allowed';
                </script>
              @endif
            </form>

            <!-- 勤務終了 -->
            <form action="/" method="post">
              @csrf
              <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
              <input type="hidden" name="name" value="{{ Auth::user()->name }}">
              <input type="hidden" name="email" value="{{ Auth::user()->email }}">
              <input type="hidden" name="status" value="AttendanceEnd">
              <button id="btn_atteend" class='stamp__button'>勤怠終了</button>
              @if(session('status', 'AttendanceEnd')==="AttendanceEnd" or session('status', 'AttendanceEnd')==="RestStart")
                <script>
                  const button2 = document.querySelector("#btn_atteend");
                  button2.disabled = true;
                  button2.style.color = '#EEEEEE';
                  button2.style.cursor = 'not-allowed';
                </script>
              @endif
            </form>

            <!-- 休憩開始 -->
            <form action="/" method="post">
              @csrf
              <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
              <input type="hidden" name="name" value="{{ Auth::user()->name }}">
              <input type="hidden" name="email" value="{{ Auth::user()->email }}">
              <input type="hidden" name="status" value="RestStart">
              <button id='btn_reststart' class='stamp__button'>休憩開始</button>
              @if(session('status', 'AttendanceEnd')==="AttendanceEnd" or session('status', 'AttendanceEnd')==="RestStart")
                <script>
                  const button3 = document.querySelector("#btn_reststart");
                  button3.disabled = true;
                  button3.style.color = '#EEEEEE';
                  button3.style.cursor = 'not-allowed';
                </script>
              @endif
            </form>

            <!-- 休憩終了 -->
            <form action="/" method="post">
              @csrf
              <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">
              <input type="hidden" name="name" value="{{ Auth::user()->name }}">
              <input type="hidden" name="email" value="{{ Auth::user()->email }}">
              <input type="hidden" name="status" value="RestEnd">
              <button id='btn_restend' class='stamp__button'>休憩終了</button>
              @if(session('status', 'AttendanceEnd')!=="RestStart")
                <script>
                  const button4 = document.querySelector("#btn_restend");
                  button4.disabled = true;
                  button4.style.color = '#EEEEEE';
                  button4.style.cursor = 'not-allowed';
                </script>
              @endif
            </form>
        </div>
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
