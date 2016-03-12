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



                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}

                            <div>
                                <span>姓名<label>*</label></span>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </div>
                            <div>
                                <span>选择（暂留）</span>
                            <select class="button" name="">
                                <option selected>啊啊啊</option>
                                <option>八佰伴</option>
                                <option>吃吃吃</option>
                                <option>大大大</option>
                            </select></div>
                            <div>
                                <span>姓名<label>*</label></span>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </div><div>
                                <span>姓名<label>*</label></span>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </div><div>
                                <span>姓名<label>*</label></span>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </div><div>
                                <span>姓名<label>*</label></span>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </div><div>
                                <span>姓名<label>*</label></span>
                                <input type="text" name="name" value="{{ old('name') }}">
                            </div>




                            <input type="submit" value="确定">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
                $('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:100px;margin-top:5px;border-radius:100px;box-shadow:0 0 15px #262626;"><p>100px*100px</p>');
                $('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:150px;margin-top:5px;border-radius:150px;box-shadow:0 0 15px #262626;"><p>150px*150px</p>');
            });
            $('#btnZoomIn').on('click', function(){
                cropper.zoomIn();
            });
            $('#btnZoomOut').on('click', function(){
                cropper.zoomOut();
            })
        });
    </script>
@endsection
