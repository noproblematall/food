
@extends('layouts.app')

@section('title', 'Terms')
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
                <h1>FAQ</h1>
                <p> <span></span> </p>
            </div>
        </div>
    </div>
</section>

<section class="contact-infomation"> 
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="contact-infomation__item contact-infomation__item--padding" id="faq">
                    <div class=" contact-infomation__info">
                        <a href="#faq1" data-toggle="collapse"><h5>Who is Hihome?</h5></a>
                        <p id="faq1" class="collapse" data-parent="#faq">Hihome is a trade-mark and registered company in the Saudi chamber of commerce, registration number 357507. We are here to provide cultural experience through eating with locals in Saudi Arabia.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq2" data-toggle="collapse"><h5>What is my duty as a host with Hihome?</h5></a>
                        <p id="faq2" class="collapse" data-parent="#faq">Your duty as a host is to show your guest the hospitality of your culture and invite your guest to have a traditional meal at your home or farm.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq3" data-toggle="collapse"><h5>I am a female and I can’t welcome males at my home, can I be a host with Hihome?</h5></a>
                        <p id="faq3" class="collapse" data-parent="#faq">Yes, you can add this remark on your page when you register with Hihome.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq4" data-toggle="collapse"><h5>Home much should I expect to be paid from being a host with Hihome?</h5></a>
                        <p id="faq4" class="collapse" data-parent="#faq">It depends on demand, the more good reviews you get the better your chances will be to get more guests. Prices are set by you as a host.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq5" data-toggle="collapse"><h5>What‘s the price range I should require for being a host?</h5></a>
                        <p id="faq5" class="collapse" data-parent="#faq">The recommended range is 250-500 SAR per person.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq6" data-toggle="collapse"><h5>What‘s the commission of Hihome?</h5></a>
                        <p id="faq6" class="collapse" data-parent="#faq">20% additional to the price you set.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq7" data-toggle="collapse"><h5>Do I need to have a traditional place at home to be a host with Hihome?</h5></a>
                        <p id="faq7" class="collapse" data-parent="#faq">No, however, some guests might prefer visiting a host who has a traditional place.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq8" data-toggle="collapse"><h5>Can family members or friends participate and help me as a host welcoming the guests?</h5></a>
                        <p id="faq8" class="collapse" data-parent="#faq">Yes</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq9" data-toggle="collapse"><h5>What type of food should I serve?</h5></a>
                        <p id="faq9" class="collapse" data-parent="#faq">Traditional food or a dish that you think your house make it in a unique way!</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq10" data-toggle="collapse"><h5>Should the food be home made or I can get it from a restaurant?</h5></a>
                        <p id="faq10" class="collapse" data-parent="#faq">As a main goal for Hihome is to create an authentic cultural experience at homes, therefore, food is preferred to be homemade.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq11" data-toggle="collapse"><h5>I can’t welcome guests at my home, may I host them at a rented place outside my home?</h5></a>
                        <p id="faq11" class="collapse" data-parent="#faq">No, Hihome aims to create an authentic cultural experience at homes or private farms.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq12" data-toggle="collapse"><h5>Can I host gusts to sleep at my house through hihome? </h5></a>
                        <p id="faq12" class="collapse" data-parent="#faq">No, hihome is a platform to only book eating experiences with locals. </p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq13" data-toggle="collapse"><h5>At what time should I expect guest to come?</h5></a>
                        <p id="faq13" class="collapse" data-parent="#faq">Guests welcoming time is set by the host. It should be on your page when you register with Hihome and it could be breakfast, Lunch or dinner time.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq14" data-toggle="collapse"><h5>How long will the guests stay with me?</h5></a>
                        <p id="faq14" class="collapse" data-parent="#faq">3 hours on average but you can set the preferred times in your profile.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq15" data-toggle="collapse"><h5>How many guests can I welcome at a time?</h5></a>
                        <p id="faq15" class="collapse" data-parent="#faq">It is up to you and the capacity of your home. But It is recommended to have no more than 4 guests per host. However, If a family member or a friend will be there with you, it will help you with bigger numbers.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq16" data-toggle="collapse"><h5>I can’t speak foreign languages, can I still be a host with Hihome?</h5></a>
                        <p id="faq16" class="collapse" data-parent="#faq">Yes, you can add this remark on your page when you register with Hihome.</p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq17" data-toggle="collapse"><h5>I want to participate as a host with Hihome just for the cultural experience and I don’t want any financial benefit, is this possible?</h5></a>
                        <p id="faq17" class="collapse" data-parent="#faq">You can only take the minimum recommended charge but not less than that. </p>
                        
                    </div>
                    <hr>
                    <div class=" contact-infomation__info">
                        <a href="#faq18" data-toggle="collapse"><h5>What topics am I allowed to speak about and what topics not to speak about?</h5></a>
                        <p id="faq18" class="collapse" data-parent="#faq">Quite general topics, it depends on the guests interests. You should avoid discussing political and controversial topics.</p>
                        
                    </div>                    
                    
                </div>
            </div>
        </div>

    </div>


</section>

@endsection

@section('script')
    
@endsection