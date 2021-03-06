<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('TODOリスト')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/destyle.css">
    <link rel="stylesheet" href="/css/stylesheet.css">
    <link rel="stylesheet" href="/css/responsive.css">
</head>

<body>
    @section('menubar')
        <header>
            <div class="top-wrapper">

                <nav class="navbar navbar-expand-lg navbar-light k-nav-color">
                    <div class="container-fluid">
                        <h1>TODOリスト</h1>

                        <!-- レスポンシブ対応のボタン -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="operation">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="/todo_list" class="k-btn-border-nav nav-link active k-nav-link"
                                            aria-current="page">作業一覧</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/todo_list/entry"
                                            class="k-btn-border-nav nav-link active k-nav-link">作業登録</a>
                                    </li>

                                    <!-- ドロップダウン -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle k-nav-color" href="#" id="navbarDropdown"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="k-login-user">ログインユーザー：{{ $user->family_name . " " . $user->first_name }}さん</span>

                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a href="todo_list"
                                                    class="dropdown-item k-dropdown-btn-nav k-dropdown-item">ユーザー一覧</a></li>
                                            <li><a href="logout"
                                                    class="dropdown-item k-dropdown-btn-nav k-dropdown-item">ログアウト</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="search">
                                <form method="post" action="/todo_list/search" class="d-flex">
                                    @csrf
                                    <input type="text" class="form-control me-2" name="input" placeholder="Search"
                                        aria-label="Search">
                                    <button type="submit" class="k-btn-border-nav" value="find">検索</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </nav>

                <div class="container-fluid">
                    @if ($input == '')
                        <p>作業一覧</p>
                    @elseif ($input == 'entry')
                        <p>作業登録</p>
                    @elseif ($input == 'edit')
                        <p>作業修正</p>
                    @elseif ($input == 'del')
                        <p>削除確認</p>
                    @else
                        <p>検索ワード：{{ $input }}</p>
                    @endif
                </div>

            </div>
        </header>
    @show

    <div class="container-main">
        @yield('content')
    </div>

    <!-- JavaScriptは、「bootstrap」を使用 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>
