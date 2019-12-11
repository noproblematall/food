@extends('layouts.app')

@section('title', 'About Us')
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
                <h1>Once Upon a house</h1>
                <p> <span></span> </p>
            </div>
        </div>
    </div>
</section>

<section class="user_dashboard mt-3 mb-3">
    <div class="container p-3">
        <div class="row user_content">            
            {{-- <div class="col-12 p-4 text-right">
                <h3>عن حيهم</h3>
                <p>"حيّهم!" هكذا نرحب بالضيف في بيوتنا.</p>
                <p>نهدف عبر هذه المنصة إلى تقديم تجربة ثقافية فريدة من نوعها تتيح للزوار والمهتمين التعرف على ثقافة </p>
                <p>المنطقة من خلال زيارة أحد سكانها وتناول وجبة محلية مع أهلها.</p>
                <p>الرؤية: ان نكون المنصة الموثوقة العربية الأولى لتمكين المحليين من استقبال الضيوف وتعريفهم عن ثقافتهم</p>
                <p>المختلفة.</p>
                <p>المهمة:</p>
                <p>1- إعطاء صورة إيجابية عن المملكة بطريقة بسيطة وواقعية من خلال السعوديون أنفسهم.</p>
                <p>2- تعزيز ثقافة الحوار بين الثقافات في المجتمع.</p>
            </div> --}}
            <div class="col-12 p-4">
                <h3>About us</h3>
                <p>Hihome is the English translation to welcome in Arabic.</p>
                <p>We aim through this platform to introduce our culture to visitors and interested persons through experiencing Saudi food with locals at their homes.</p>
                <p><b>Vision</b></p>
                <p>To be the first trusted Arabic platform in providing cultural experiences through empowering locals and welcoming guests all around the world.</p>
                <p><b>Mission</b></p>
                <p>1- To show the real culture of Saudi in an authentic way through the Saudis themselves.</p>
                <p>2- To promote the cross cultural dialogue between people from different backgrounds</p>
            </div>
        </div>
       
    </div>
</section>

@endsection

@section('script')
    
@endsection