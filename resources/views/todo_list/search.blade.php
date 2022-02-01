@extends('template.template_design')

<body>
    @section('menubar')

    @section('content')
        <div class="search">
            <form method="post" action="/todo_list/search" class="d-flex">
                @csrf
                <input type="text" class="form-control me-2" name="input" value="{{ $input }}">
                <button type="submit" class="k-btn-border-nav" value="find">検索</button>
            </form>
        </div>

        <div class="table_list">
            <table>
                <tr>
                    <th>項目名</th>
                    <th>担当者</th>
                    <th>登録日</th>
                    <th>期限日</th>
                    <th>完了日</th>
                    <th>操作</th>
                </tr>

                @if (isset($items))
                    @foreach ($items as $k => $v)
                        <!-- 1行目 及び 偶数行は背景に色をつける -->
                        @if ($k == 0 || $k % 2 == 0)
                            <tr class="even-color">
                            @else
                            <tr>
                        @endif

                        <!-- 【覚書】偶数行への色付けと赤文字や取消線を<tr>で同時に表記すると複雑となるため、$kと$vは<tr>と<td>で分けた -->
                        <!-- 項目名 -->
                        <td>{{ $v->item_name }}</td>

                        <!-- 担当者 -->
                        <td>{{ $v->user->family_name . ' ' . $v->user->first_name }}</td>

                        <!-- 登録日 -->
                        <td>{{ $v->registration_date }}</td>

                        <!-- 期限日 -->
                        <td>{{ $v->expire_date }}</td>

                        <!-- 完了日 -->
                        <td class="finished_date">未</td>

                        <td>
                            <div class="operation-buttons k-mobile-btn">
                                <div>
                                    <!-- 操作（完了ボタン） -->
                                    <form method="post" action="/todo_list/action">
                                        @csrf
                                        <input type="hidden" name="id">
                                        <span class="k-mobile-margin"><button type="submit" class="btn-border"
                                                name="finished_date">完了</button></span>
                                    </form>
                                </div>

                                <div>
                                    <!-- 操作（修正ボタン） -->
                                    <form method="post" action="/todo_list/edit">
                                        @csrf
                                        <input type="hidden" name="id">
                                        <input type="hidden" name="item_name">
                                        <input type="hidden" name="user_id">
                                        <input type="hidden" name="expire_date">
                                        <input type="hidden" name="finished_date">
                                        <span class="k-mobile-margin"><button type="submit"
                                                class="btn-border">修正</button></span>
                                    </form>
                                </div>

                                <div>
                                    <!-- 操作（削除ボタン） -->
                                    <form method="post" action="/todo_list/del">
                                        @csrf
                                        <input type="hidden" name="id">
                                        <input type="hidden" name="item_name">
                                        <input type="hidden" name="user_id">
                                        <input type="hidden" name="expire_date">
                                        <input type="hidden" name="finished_date">
                                        <span class="k-mobile-margin"><button type="submit"
                                                class="btn-border">削除</button></span>
                                    </form>
                                </div>
                            </div>
                        </td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>

    @endsection
</body>

</html>
