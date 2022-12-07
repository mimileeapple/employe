<div class="col-md-2">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 200px;">
        <ul class="nav nav-pills flex-column mb-auto" style="text-align: left;">
            <li class="nav-item">
                <a href="{{route('personalinfor.edit',Session::get('empid'))}}" class="nav-link link-dark">
                    修改個人資料
                </a>
            </li>
            <li>
                <a href="{{route('leavefake.index')}}" class="nav-link link-dark">
                    我要請假
                </a>
            </li>
            <li>
                <a href="{{route('leavefake.show',Session::get('empid'))}}" class="nav-link link-dark">
                    個人請假單查詢
                </a>
            </li>
            <li>
                <a href="{{route('Pay.show',Session::get('empid'))}}" class="nav-link link-dark">
                    申請出差旅費
                </a>
            </li>

            <li>
                <a href="#" class="nav-link link-dark">
                    <font color="red">個人出勤查詢</font>
                </a>
            </li>
            <li>
                <a href="{{route('leavefake.edit',Session::get('empid'))}}" class="nav-link link-dark">
                    請假單簽核
                </a>
            </li>
            <li>
                <a href="{{route('showtripsign',['id'=>Session::get('empid')])}}" class="nav-link link-dark">
                    出差旅費單簽核
                </a>
            </li>
            <li>
                <a href="{{route("employees.index")}}" class="nav-link link-dark">
                    <font color="blue">員工資料管理</font>
                </a>
            </li>
            <li>
                <a href="{{route("finshorder")}}" class="nav-link link-dark">
                    <font color="blue">員工請假(結案)</font>
                </a>
            </li>

            <li>
                <a href="{{route("showleaveall")}}" class="nav-link link-dark">
                    <font color="blue">員工請假總表</font>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark">
                    <font color="red">員工出勤總表</font>
                </a>
            </li>
            <li>
                <a href="{{route("creatboard.create")}}" class="nav-link link-dark">
                    公佈欄管理
                </a>
            </li>
        </ul>
    </div>
    <div class="b-example-divider"></div>
</div>








