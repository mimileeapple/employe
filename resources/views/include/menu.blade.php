@php 
    $limit=Session::get('empdata')->syslimit @endphp
<div class="col-md-2">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 200px;">
        <ul class="nav nav-pills flex-column mb-auto" style="text-align: left;">

            <li class="nav-item">
                <a href="{{route('verify')}}" class="nav-link link-dark">回首頁</a></li>

            <div class="dropdown">
                <a class="btn bt-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    請假系統
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li class="nav-item">
                        <a href="{{route('personalinfor.edit',Session::get('empid'))}}" class="nav-link link-dark">
                            修改個人資料</a>
                    </li>
                    <li>
                        <a href="{{route('leavefake.index')}}" class="nav-link link-dark">我要請假</a>
                    </li>
                    <li>
                        <a href="{{route('showmyleave')}}" class="nav-link link-dark">
                            個人請假單查詢
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Pay.show',Session::get('empid'))}}" class="nav-link link-dark">
                            申請出差旅費
                        </a>
                    </li>
                    <li>
                        <a href="{{route('checkin.show',Session::get('empid'))}}" class="nav-link link-dark">
                            個人出勤查詢
                        </a>
                    </li>
                </ul>
            </div>

            @if($limit>2)

                <div class="dropdown">
                    <a class="btn bt-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        請假系統管理(台灣)
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a href="{{route("employees.index")}}" class="nav-link link-dark submenu-item">
                                員工資料管理</a></li>
                        <li><a href="{{route('importcheckin.create')}}" class="nav-link link-dark">上傳考勤表</a></li>
                        <li><a href="{{route("finshorder")}}" class="nav-link link-dark submenu-item">員工請假(結案)</a></li>

                        <li><a href="{{route("showleaveall")}}" class="nav-link link-dark submenu-item">員工請假總表</a></li>
                        <li><a href="{{route("showallemplist")}}" class="nav-link link-dark submenu-item">
                                員工出勤總表</a></li>
                        <li><a href="{{route("selectmonthshowcheckintotal")}}" class="nav-link link-dark submenu-item">
                                員工遲到總表</a></li>

                    </ul>

                </div>

                <div class="dropdown">
                    <a class="btn bt-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        請假系統管理(大陸)</a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a href="{{route("empchina.index")}}" class="nav-link link-dark submenu-item">
                                員工資料管理</a></li>
                        <li><a href="{{route("finshorderchina")}}" class="nav-link link-dark submenu-item">
                                員工請假(結案)</a></li>
                        <li><a href="{{route("showleaveallchina")}}" class="nav-link link-dark submenu-item">
                                員工請假總表</a></li>
                    </ul>

                </div>

                <div class="dropdown">
                    <a class="btn bt-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        我要簽核
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li class="nav-item">
                            <a href="{{route('leavefake.edit',Session::get('empid'))}}" class="nav-link link-dark">
                                請假單簽核</a></li>
                        <li>
                            <a href="{{route('showtripsign',['id'=>Session::get('empid')])}}" class="nav-link link-dark">
                                出差旅費單簽核</a></li>
                        <li>
                            <a href="{{route('showchecksign',['id'=>Session::get('empid')])}}" class="nav-link link-dark">
                                補卡簽核</a></li>
                    </ul>
                </div>
                <li class="nav-item">
                    <a href="{{route("creatboard.create")}}" class="nav-link link-dark">公佈欄管理</a></li>

                <li class="nav-item">
                    <a href="{{route("payoffice.index")}}" class="nav-link link-dark">行政付款申請</a></li>

                <li class="nav-item"><a href="{{route("customer.index")}}" class="nav-link link-dark">客戶資料管理</a></li>

                <li class="nav-item"><a href="{{route("custPI.index")}}" class="nav-link link-dark">客戶PI單</a></li>

                <div class="dropdown"><a class="btn bt-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-bs-toggle="dropdown" aria-expanded="false">物料管理</a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li class="nav-item"><a href="{{route("material.create")}}" class="nav-link link-dark submenu-item">
                                物料XLS轉BOM表</a></li>
                        <li class="nav-item"><a href="{{route("partdata.create")}}" class="nav-link link-dark submenu-item">
                                物料partData維護</a></li>
                    </ul>
                </div>
            @endif
        </ul>
    </div>
    <div class="b-example-divider"></div>
</div>






