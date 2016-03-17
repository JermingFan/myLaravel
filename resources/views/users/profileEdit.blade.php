@extends('layouts.base')
@section('styles')
    <link href="{{asset('/assets/css/avatar.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('content')
    <div class="container">
        <div class="login-content">
            <div class="login-page">
                <div class="account_grid">
                    <div class="col-md-5 login-right wow fadeInRight" data-wow-delay="0.4s">
    <div class="avatar">
        <div class="imageBox">
            <div class="thumbBox"></div>
            {{--<input type="file" id="file1" name="file"/>--}}
            <div class="spinner" style="display: none">Loading...</div>
        </div>
        <div class="action">
            <div class="new-contentarea tc">
                <a href="javascript:void(0)" class="upload-img">
                    <label for="upload-file">选择</label>
                </a>
                <input type="file" class="" name="upload-file" id="upload-file" />
            </div>
            <input type="button" id="btnCrop"  class="Btnsty_peyton" value="裁切">
            <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+"  >
            <input type="button" id="btnZoomOut" class="Btnsty_peyton" value="-" >
        </div>
        <div class="cropped"></div>
    </div>
                        <form class="form-horizontal" role="form">
                            {!! csrf_field() !!}
                            <div>
                                <span>姓名<label>*</label></span>
                                <input type="text" name="name" id="user_name" value="{{ $user_info->name }}">
                            </div>
                            <div>
                                <span>性别</span>
                                <select id="sex" class="button" name="">
                                    @if($user_info->sex == 0)
                                        <option selected>男</option>
                                        <option>女</option>
                                    @else
                                        <option>男</option>
                                        <option selected>女</option>
                                    @endif
                                </select>
                            </div>
                            <div>
                                <span>求学经历<label>*</label></span>
                                <input type="text" name="name" id="study_mes" value="{{ $user_info->study_mes }}">
                            </div>
                            <div>
                                <span>自我评价<label>*</label></span>
                                <input type="text" name="name" id="self_evaluation" value="{{ $user_info->personal_main }}">
                            </div>
                            <div>
                                <span>技能介绍<label>*</label></span>
                                <input type="text" name="name" id="personal_main" value="{{ $user_info->personal_main }}">
                            </div>
                            <input type="button" value="确定" onclick="uploadProfile()">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('/assets/js/uploadimg.js')}}"></script><!--    上传图片js  -->
    <script src="{{asset('/assets/js/cropbox.js')}}"></script>
    <script type="text/javascript">
        $(window).load(function() {
            var options = {
                thumbBox: '.thumbBox',
                spinner: '.spinner',
                imgSrc: '/assets/images/avatar.jpg'
            };
            var cropper = $('.imageBox').cropbox(options);
            $('#upload-file').on('change', function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    options.imgSrc = e.target.result;
                    cropper = $('.imageBox').cropbox(options);
                };
                reader.readAsDataURL(this.files[0]);
                this.files = [];
            });
            $('#btnCrop').on('click', function() {
                var img = cropper.getDataURL();
                $('.cropped').html('');
                $('.cropped').append('<img src="'+img+'" align="absmiddle" id="img_source" style="width:100px;margin-top:5px;border-radius:100px;box-shadow:0 0 15px #262626;"><p>100px*100px</p>');
                $('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:150px;margin-top:5px;border-radius:150px;box-shadow:0 0 15px #262626;"><p>150px*150px</p>');
            });
            $('#btnZoomIn').on('click', function(){
                cropper.zoomIn();
            });
            $('#btnZoomOut').on('click', function(){
                cropper.zoomOut();
            })
        });

        //个人信息的上传
        function uploadProfile()
        {
            var user_name = $("#user_name").val();
            var sex = $("#sex").get(0).selectedIndex;
            var study_mes = $("#study_mes").val();
            var self_evaluation = $("#self_evaluation").val();
            var personal_main = $("#personal_main").val();
            $.ajax({
                type:"POST",
                url:"/profile/edit",
                data:{
                    user_name:user_name,
                    sex:sex,
                    study_mes:study_mes,
                    self_evaluation:self_evaluation,
                    personal_main:personal_main
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
                            window.location.href="/profile";
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
@endsection
