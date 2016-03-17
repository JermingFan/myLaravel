@extends('layouts.base')
@section('content')

    <div class="container">
        <div class="shared-hosting">
            <form class="form-horizontal" role="form">
            <h3 class="header-c">项目名称</h3>
            <input type="text" name="name" id="name" value="{{ $user_info->name }}">
            <figure class="float-right"><img src="/assets/images/b1.jpg" width="400px" alt="Placeholder"></figure>
            <div class="about_desc question-answers">
                <div id="qus-1" class="answers">
                    <h4>项目详情</h4>
                    <input type="text" name="name" id="details" value="{{ $user_info->details }}">
                    {{--<p>{{ $user_info->details }}</p>--}}
                </div>
                <div id="qus-2" class="answers">
                    <h4>项目近况</h4>
                    <input type="text" name="name" id="development" value="{{ $user_info->development }}">
                    {{--<p><{{ $user_info->development }}/p>--}}
                </div>
                <div id="qus-3" class="answers">
                    <h4>团队简介</h4>
                    <input type="text" name="name" id="intro" value="{{ $user_info->intro }}">
                    {{--<p>{{ $user_info->intro }}</p>--}}
                </div>
                <div id="qus-4" class="answers">
                    <h4>团队需求</h4>
                    <input type="text" name="name" id="require" value="{{ $user_info->require }}">
                    {{--<p>{{ $user_info->require }}</p>--}}
                </div>
            </div>
            <input type="button" value="确定" onclick="uploadProject()">
            </form>
        </div>
    </div>

@endsection

<script type="text/javascript">
    //我的项目信息上传
    function uploadProject()
    {
        var name = $("#name").val();
        var details = $("#details").val();
        var development = $("#development").val();
        var intro = $("#intro").val();
        var require = $("#require").val();
        $.ajax({
            type:"POST",
            url:"/myProject/edit",
            data:{
                name:name,
                details:details,
                development:development,
                intro:intro,
                require:require
            },
            dataType:"json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(message)
            {
                if(message == '' || message == null)
                {
                    alert('busy!!!');
                }
                else
                {
                    if(message["status"] == 200)
                    {
                        //alert(message.content);
                        window.location.href="/myProject";
                    }
                    else
                    {
                        alert(message.content);
                    }
                }
            },
            error:function()
            {
                alert("请求失败");
            }
        });
    }

</script>
