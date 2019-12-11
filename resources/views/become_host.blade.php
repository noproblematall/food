@extends('layouts.app')

@section('title', 'Dashboard')
@section('css')
    <style>
        body {background-color: #F0F0F0;}
        .invalid-feedback {display: block;}
    </style>
@endsection
@php
    $side_bar = session('side_bar');
    $user = auth()->user();
@endphp
@section('content')
<section>
    <div class="page-banner">
        <div class="container">
            <div class="page-banner__tittle">
                @if ($user->role->type == 'host')
                    <h1>Once Upon a house</h1>
                    <p> <span></span> </p>                    
                @else
                    <h1>Once Upon a house</h1>
                    <p> <span></span> </p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="user_dashboard mt-5 mb-5">
    <div class="container p-3">
        <div class="row">
            <div class="col-3 side_bar p-4">
                <div class="row">
                    <div class="col-md-12 text-center">
                        @if ($user->photo()->exists())
                            <img src="{{ asset($user->photo->url) }}" class="custom_avatar_image" alt="User Photo" width="150" id="avatar" height="150" srcset="">
                        @else
                            <div class="custom_avatar_large m-auto">{{ $user->avatar }}</div>
                        @endif
                    </div>
                </div>
                <div class="row mt-3 side_bar_content">
                    @include('side_for_home')
                </div>
            </div>
            <div class="col-1"></div>
            <div class="col-8 user_content p-4">
                <form action="{{ route('become_host_save') }}" method="post" enctype="multipart/form-data">
                    @csrf                    
                    <div>
                        <label for="nameId">Nickname</label><div class="spinner-border spinner-border-sm text-primary ml-2 display_none" style="margin-bottom: 2px;"></div>&nbsp;&nbsp;&nbsp;<span class="" id="check_complete"></span>
                        <input type="text" name="nameId" id="name_id" value="{{ old('nameId') }}">
                        @error('nameId')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="">Photo</label>
                        <div class="custom-file">
                            <label for="photo" class="custom-file-label">Choose file</label>
                            <input type="file" class="custom-file-input" name="photo" id="photo">
                        </div>
                        @error('photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="about_you">About You</label>
                        <textarea name="aboutYou" id="about_you" cols="30" rows="5">{{ old('aboutYou') }}</textarea>
                        @error('aboutYou')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <input class="footer-form__submit" type="submit" value="SAVE">
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $("#photo").change(function() {
                readURL(this);
            });
            $(".custom-file-input").on("change", function() {
                let fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            var timer = null
            $('#name_id').keyup(function(){
                $('#check_complete').text()
                $('.spinner-border-sm').removeClass('display_none');                
                let data = $('#name_id').val()

                if(timer) {
                    clearTimeout(timer);
                }
                
                timer = setTimeout(function(){
                    $.ajax({
                        url: '/check_id',
                        type: 'get',
                        data: {data: data},
                        // beforeSend: function () { $('.spinner-border-sm').removeClass('display_none'); },
                        success: function(data){
                            if (data == 'ok') {
                                $('#check_complete').text('Valid ID')
                                $('#check_complete').css('color', 'blue')
                            } else {
                                $('#check_complete').text('Invalid ID')
                                $('#check_complete').css('color', 'red')
                            }
                        }
                    }).done(function () {
                        $('.spinner-border-sm').addClass('display_none');
                    })
                }, 500);
            })
        })

        function readURL(input) {
            if (input.files && input.files[0]) {
            let reader = new FileReader();
            
            reader.onload = function(e) {
                $('#avatar').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection