
@extends('layouts.app')

@section('title', 'Contact Us')
@section('css')
    <style>
        body {background-color: #F0F0F0;}
        .invalid-feedback {display: block;}
    </style>
@endsection
@section('content')
<section>
    <div class="page-banner">
        <div class="container">
            <div class="page-banner__tittle">
                <h1>Contact Us</h1>
                <p> <span></span> </p>
            </div>
        </div>
    </div>
</section>

<section class="contact-infomation"> 
    <div class="container">
        <div class="row">
            {{-- <div class="col-lg-5 col-md-6">
                <div class="contact-infomation__item contact-infomation__form">
                    <h5>Get in Touch</h5>
                    <form action="#">
                        <label >Your name *</label>
                        <input type="text" name="name" >
                        <label >Email *</label>
                        <input type="text" name="email" >
                        <label >Message *</label>
                        <textarea name="message" cols="30" rows="8"></textarea>
                        <input class="footer-form__submit" type="submit" value="SUBCRIBE">
                    </form>
                </div>
            </div> --}}
            <div class="col-lg-7 col-md-6">
                <div class="contact-infomation__item contact-infomation__item--padding">
                    <div class=" contact-infomation__info">
                        <h5>Contact Information</h5>
                        {{-- <p>Cras ut varius magna. Morbi sed orci id sapien ultricies malesu. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta veritatis soluta, earum doloremque eius consectetur, facere nostrum fugit nam consequuntur quisquam tempore eos! Quisquam, accusamus.</p> --}}
                        <div class="contact-infomation__info__address">
                            <div class="contact-infomation__info__address-item">
                                {{-- <img src="{{asset('frontend/images/contact-addresst.png')}}" alt="contact-addresst"> --}}
                                <i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;&nbsp;
                                <span>Prince Turki road , Riyadh 11457</span>
                            </div>
                            <div class="contact-infomation__info__address-item">
                                {{-- <img src="{{asset('frontend/images/contact-mail.png')}}" alt="contact-mail"> --}}
                                <i class="fas fa-envelope"></i>&nbsp;&nbsp;&nbsp;
                                <span>info@hihome.sa</span>
                            </div>
                            <div class="contact-infomation__info__address-item">
                                {{-- <img src="{{asset('frontend/images/contact-phone.png')}}" alt="contact-phone"> --}}
                                <i class="fas fa-phone"></i>&nbsp;&nbsp;&nbsp;
                                <span>+966 50 542 3361</span>
                            </div>
                        </div>
                    </div>
                    <div class="contact-infomation__working-time">
                        <h5>Working Hours</h5>
                        <p>Sunday - Thursday : 8.am - 6.pm</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-infomation__map">
            <i class="fas fa-map-marker-alt"></i>
            <iframe src="https://maps.google.com/maps?q=riyadh&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed">
            </iframe>
        </div>
    </div>


</section>

@endsection

@section('script')
    
@endsection