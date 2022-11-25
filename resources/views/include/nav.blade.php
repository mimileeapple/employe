{{--<script>var myModal = document.getElementById('myModal')--}}
{{--    var myInput = document.getElementById('myInput')--}}

{{--    myModal.addEventListener('shown.bs.modal', function () {--}}
{{--        myInput.focus()--}}
{{--    })--}}
{{--</script>--}}
<style>
    .modal-backdrop.show{
        z-index: 0;
    }

</style>
<ul class="nav justify-content-end fixed-top" style="background-color: #c6c0c0;">

    <!-- Button trigger modal -->


    <a href="#" style="padding-top: 3px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <img src="{{ URL::asset('img/notice.png') }}"></a>

    <span style="border-radius: 50%;height: 20px;width: 20px;display: inline-block;background: #f30303;vertical-align: top;">
      <span style="display: block;color: #FFFFFF;height: 20px;line-height: 20px;text-align: center"> {!! Session::get('j') !!}</span>
 </span>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">簽核通知</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="{{route('leavefake.edit',Session::get('empid'))}}"> 你有{!! Session::get('j') !!}筆請假單未處理</a><br>
                    <a href="#">你有0筆請款單未處理</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <div>



    </div>
    <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">目前使用者:{{Session::get('name')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{Route('logout')}}">登出</a>
    </li>
</ul>

