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
            </table>
        </div>
    @endsection
</body>

</html>
