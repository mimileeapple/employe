<h1>123</h1>
{{$user[0]->name}}
//抓單值寫法


@foreach($user[0] as $key => $value)
    {{$value}}
@endforeach
//抓全部資料寫法

