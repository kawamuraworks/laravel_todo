@extends('template.template_design')



<body>
    @section('menubar')

    @section('content')
        <div class="container-sub">
            <div class="alert alert-info">下記の項目を削除します。よろしいですか？</div>

            <form action="/todo_list/del" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id }}">

                <div class="form-group">
                    <label for="item_name">項目名</label>
                    <p class="sub box">{{ $item->item_name }}</p>
                </div>

                <div class="form-group">
                    <label for="user_id">担当者</label>
                    @foreach ($user_list as $user)
                        @if ($item->user_id == $user->id)
                            <p class="sub box">{{ $user->family_name . ' ' . $user->first_name }}</p>
                        @endif
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="expire_date">期限</label>
                    <p class="sub box">{{ $item->expire_date }}</p>
                </div>

                <div class="form-group">
                    @if ($item->finished_date != '')
                        <input type="checkbox" <?php echo 'checked'; ?> disabled>完了
                    @else
                        <input type="checkbox" disabled>完了
                    @endif
                </div>

                <div class="form-group">
                    <input type="submit" value="削除" class="btn btn-primary mb-3">
                    <a href="/todo_list" class="btn btn-border mb-3">キャンセル</a>
                </div>

            </form>
        </div>

    @endsection
</body>

</html>
