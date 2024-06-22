<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from templates.seekviral.com/trimba3/forms/Reaction Survey/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Feb 2023 07:20:20 GMT -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Questionnaire Multistep With Side Image</title>

	<!-- bootstrap css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css')}}">

	<!-- Font awesome 6 -->
	<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">

	<!-- custom styles -->
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/responsive.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/animation.css')}}">

    <!-- color sceme -->
    <link rel="stylesheet" href="{{ asset('frontend/css/colorvariants/default.css')}}" id="defaultscheme">

</head>
<body>
    <main class="overflow-hidden">
		<div class="row h-100">

			<!-- side area -->
			<div class="slideup side col-md-5 order-c">
				<div class="side-inner">
					<img src="{{asset('frontend/images/side-img.png')}}" alt="side image">
				</div>
			</div>
			<div class="slidedown col-md-7 h-100">
				<div class="wrapper">
					<div class="contact d-none">
						<i class="fa-solid fa-phone"></i>
						<article>
							<h5>Need Help ?</h5>
							<span>Call an Expert  +93892384</span>
						</article>
					</div>
                    @yield('content-app')
                </div>
			</div>
		</div>
	</main>

	<div class="bg-partical-2">
		<img src="{{asset('frontend/images/partical_2.png')}}" alt="Partical">
	</div>
    <!-- bootstrap JS -->
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var url = "{{ url('/') }}";
    </script>
    <!-- custom JS -->
    <script src="{{asset('frontend/js/custom.js')}}"></script>
    <!-- colorswitcher -->
    <script src="{{asset('frontend/js/callswitcher.js')}}"></script>
</body>

<!-- Mirrored from templates.seekviral.com/trimba3/forms/Reaction Survey/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Feb 2023 07:20:31 GMT -->
</html>
