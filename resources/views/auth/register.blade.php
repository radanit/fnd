@extends('layouts.app')

@section('content')
<body>
<div class="container" dir="{{__('app.dir')}}">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card" style="height:100%">
                <div class="card-header">{{ __('auth.Register') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="name" type="text" placeholder="{{ __('auth.Name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="{{ __('auth.E-Mail Address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="{{ __('auth.Password') }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" placeholder="{{ __('auth.Confirm Password') }}" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('auth.Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<div class="col-md-8">
			<div id="carouselControls" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselControls" data-slide-to="0" class="active"></li>
					<li data-target="#carouselControls" data-slide-to="1"></li>
					<li data-target="#carouselControls" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
					<img class="d-block w-100"  src="{{URL::asset('/images/slideshows/1.jpg')}}"  style="vertical-align:center" alt="First slide">
					</div>
					<div class="carousel-item">
					<img class="d-block w-100" src="{{URL::asset('/images/slideshows/3.jpg')}}" style="vertical-align:center" alt="Second slide">
					</div>
					<div class="carousel-item">
					<img class="d-block w-100" src="{{URL::asset('/images/slideshows/4.jpg')}}" style="vertical-align:center"alt="Third slide">
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
        </div>
	</div>
	<!-- Footer -->
	<footer class="page-footer font-small blue-grey lighten-5 mt-3 navbar-fixed-bottom">
		<div style="background-color: #21d192;">
		  <div class="container ">
			<!-- Grid row-->
			<div class="row py-2 d-flex align-items-center text-center">
			  <!-- Grid column -->
			  <div class="col-md-12 col-lg-12 text-center text-md">
				<!-- Facebook -->
				<a class="fb-ic" href="#!">
				  <i class="fab fa-facebook-f text-white mr-4"> </i>
				</a>
				<!-- Twitter -->
				<a class="tw-ic" href="#!">
				  <i class="fab fa-twitter text-white mr-4"> </i>
				</a>
				<!-- Google +-->
				<a class="gplus-ic" href="#!">
				  <i class="fab fa-google-plus-g text-white mr-4"> </i>
				</a>
				<!--Linkedin -->
				<a class="li-ic" href="#!">
				  <i class="fab fa-linkedin-in text-white mr-4"> </i>
				</a>
				<!--Instagram-->
				<a class="ins-ic" href="#!" >
				  <i class="fab fa-instagram text-white mr-4"> </i>
				</a>
			  </div>
			  <!-- Grid column -->
			</div>
			<!-- Grid row-->
		  </div>
		</div>
		<!-- Footer Links -->
		<div class="container text-justify text-md-right mt-3">
		  <!-- Grid row -->
		  <div class="row mt-3 dark-grey-text">
			<!-- Grid column 
			<div class="col-md-3 col-lg-4 col-xl-3 mb-4">-->
			<div class="col-md-11 col-lg-12 col-xl-11 mb-12">
			  <!-- Content -->
			  <h6 class="text-uppercase font-weight-bold">{{ __('app.customerCompanyName') }}</h6>
			  <hr class="teal accent-3 mb-2 mt-0 d-inline-block mx-auto" style="width: 60px;">
			  <p>مجهز به پیشرفته ترین دستگاه سونوگرافی داپلر رنگی پروبهای ترانس واژینال-رادیولوژی ساده-رنگی و opg-و فتوگرافی .</p>
			</div>
			<!-- Grid column -->
			<!-- Grid column -->
			<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
			  <!-- Links 
			  <h6 class="text-uppercase font-weight-bold">{{ __('app.howToUseTheService') }}</h6>
			  <hr class="teal accent-3 mb-2 mt-0 d-inline-block mx-auto" style="width: 60px;">
			  <p>
				<a class="dark-grey-text" href="#!">{{ __('app.help') }}</a>
			  </p>
			  <p>
				<a class="dark-grey-text" href="#!">{{__('app.termsOfUse')}}</a>
			  </p>
			  <p>
				<a class="dark-grey-text" href="#!">{{ __('app.frequentlyAskedQuestions') }}</a>
			  </p>
			  <p>
				<a class="dark-grey-text" href="#!">{{ __('app.privacy') }}</a>
			  </p>-->
			</div>
			<!-- Grid column -->
			<!-- Grid column -->
			<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
			  <!-- Links 
			  <h6 class="text-uppercase font-weight-bold">{{ __('app.usefulLinks') }}</h6>
			  <hr class="teal accent-3 mb-2 mt-0 d-inline-block mx-auto" style="width: 60px;">
			  <p>
				<a class="dark-grey-text" href="#!">Your Account</a>
			  </p>
			  <p>
				<a class="dark-grey-text" href="#!">Become an Affiliate</a>
			  </p>
			  <p>
				<a class="dark-grey-text" href="#!"></a>
			  </p>
			  <p>
				<a class="dark-grey-text" href="#!"></a>
			  </p>-->
			</div>
			<!-- Grid column -->
			<!-- Grid column -->
			<div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
			  <!-- Links
			  <h6 class="text-uppercase font-weight-bold">{{ __('app.contact') }}</h6>
			  <hr class="teal accent-3 mb-2 mt-0 d-inline-block mx-auto" style="width: 60px;">
			  <p class="text-justify">
				<i class="fas fa-home mr-3"></i> {{ __('app.customerAddress') }}</p>
			  <p>
				<i class="fas fa-envelope mr-3"></i> {{ __('app.customerEmail') }}</p>
			  <p>
				<i class="fas fa-phone mr-3"></i> {{ __('app.customerTel') }}</p>
			  <p>
				<i class="fas fa-print mr-3"></i> {{ __('app.customerFax') }}
			  </p> -->
			</div>
			<!-- Grid column -->
		  </div>
		  <!-- Grid row -->
		</div>
		<!-- Footer Links -->
		<!-- Copyright -->
		<div class="footer-copyright text-center text-black-50 py-2">
			<small><strong>{{ __('app.designDate') }}&copy; {{ __('app.footerMsg') }}<i class="fa fa-heart heart red"></i><a href="http://radanit.ir">{{ __('app.companyName') }}</a> </strong>.</small>
		</div>
		<!-- Copyright -->
	  </footer>
	<!-- Footer -->
</div>
</body>
@endsection
