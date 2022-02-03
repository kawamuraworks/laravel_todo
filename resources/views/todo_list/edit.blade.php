@extends('template.template_design')



<body>
    @section('menubar')

    @section('content')
        <div class="container-sub">
            <div class="alert alert-info">作業内容を修正してください</div>

            <form action="/todo_list/entry" method="post">
                @csrf
                <div class="form-group">
                    <label for="item_name">項目名</label>
                        <input type="text" name="item_name" id="item_name" class="sub" value="{{ $item->item_name }}">
                </div>

                <div class="form-group">
                    <label for="user_id">担当者</label>
                    <select name="user_id" id="user_id" class="sub">
                        <option>--選択してください</option>
                        @foreach ($user_list as $user)
                            <option value="{{ $user->id }}">{{ $user->family_name . ' ' . $user->first_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="expire_date">期限</label>
                        <input type="date" name="expire_date" id="expire_date" class="sub"  value="{{ $item->expire_date }}">
                </div>

                <div class="form-group">
                    <input type="submit" value="修正" class="btn btn-primary mb-3">
                    <a href="/todo_list" class="btn btn-border mb-3">キャンセル</a>
                </div>

            </form>
        </div>

    @endsection
</body>

</html>
