<ul class="nav justify-content-end fixed-top" style="background-color: #c6c0c0;">
    <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">目前使用者:{{Session::get('name')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{Route('logout')}}">登出</a>
    </li>
</ul>

