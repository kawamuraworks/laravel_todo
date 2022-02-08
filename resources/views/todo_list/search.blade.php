@extends('template.template_design')

<body>
    @section('menubar')

    @section('content')
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

                @foreach ($items as $k => $v)
                    <!-- 1行目 及び 偶数行は背景に色をつける -->
                    @if ($k == 0 || $k % 2 == 0)
                        <tr class="even-color">
                    @else
                        <tr>
                    @endif

                    <!-- 項目名 -->
                    @if ($v->finished_date != '')
                        <td class="item_name finish">{{ $v->item_name }}</td>
                    @elseif ($v->expire_date < $today)
                        <td class="item_name delay">{{ $v->item_name }}</td>
                    @else
                        <td class="item_name">{{ $v->item_name }}</td>
                    @endif

                    <!-- 担当者 -->
                    @if ($v->finished_date != '')
                        <td class="finish">{{ $v->user->family_name . ' ' . $v->user->first_name }}</td>
                    @elseif ($v->expire_date < $today)
                        <td class="delay">{{ $v->user->family_name . ' ' . $v->user->first_name }}</td>
                    @else
                        <td>{{ $v->user->family_name . ' ' . $v->user->first_name }}</td>
                    @endif

                    <!-- 登録日 -->
                    @if ($v->finished_date != '')
                        <td class="finish">{{ $v->registration_date }}</td>
                    @elseif ($v->expire_date < $today)
                        <td class="delay">{{ $v->registration_date }}</td>
                    @else
                        <td>{{ $v->registration_date }}</td>
                    @endif

                    <!-- 期限日 -->
                    @if ($v->finished_date != '')
                        <td class="finish">{{ $v->expire_date }}</td>
                    @elseif ($v->expire_date < $today)
                        <td class="delay">{{ $v->expire_date }}</td>
                    @else
                        <td>{{ $v->expire_date }}</td>
                    @endif

                    <!-- 完了日 -->
                    @if ($v->finished_date != '')
                        <td class="finish finished_date">{{ $v->finished_date }}</td>
                     @elseif ($v->expire_date < $today)
                        <td class="delay finished_date">未</td>
                    @else
                        <td class="finished_date">未</td>
                    @endif

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
                                <form method="get" action="/todo_list/edit">
                                    <input type="hidden" name="id" value="{{ $v->id }}">
                                    <span class="k-mobile-margin"><button type="submit"
                                            class="btn-border">修正</button></span>
                                </form>
                            </div>

                            <div>
                                <!-- 操作（削除ボタン） -->
                                <form method="get" action="/todo_list/del">
                                    <input type="hidden" name="id" value="{{ $v->id }}">
                                    <span class="k-mobile-margin"><button type="submit"
                                            class="btn-border">削除</button></span>
                                </form>
                            </div>
                        </div>
                    </td>
                    </td>
                @endforeach

            </table>

        </div>

        {{-- {{ $items->appends(['sort' => $sort])->links() }} --}}
        <!-- 戻るボタン -->
        <div class="table_back">
            @if ($input != '')
                <a href="/todo_list" class="btn-border">戻る</a>
            @endif
        </div>

        {{ $items->appends(['sort' => $sort])->links() }}
    @endsection
</body>

</html>
