

        <div class="col-md-2">
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 200px;">
                <ul class="nav nav-pills flex-column mb-auto" style="text-align: left;">
                    <li class="nav-item">

                        <a href="{{route('personalinfor.edit',Session::get('empid'))}}" class="nav-link link-dark">
                            修改個人資料
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark" >

                          <font color="red">我要請假</font>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark">

                            <font color="red">個人請假單查詢</font>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employees.index')}}" class="nav-link link-dark">

                            員工資料管理
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark">

                            <font color="red">  請假單簽核</font>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="b-example-divider"></div>
        </div>








