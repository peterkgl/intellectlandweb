$(document).ready(function(){
	$('.menu-toggle').click('click',function(){
		$('.nav').toggleClass('showing');
		$('.nav ul').toggleClass('showing');
	});

    $('.logout').click(function(){
        session_start();
        session_destroy();
        header('location:index.html');
    });

	// slideshow

	var fadeShow = $(".background").fadeShow({
			correctRatio: true,
			shuffle: true,
			speed: 5000,
			images: ['img/africa1.jpg',
					 'img/africa2.jpg',
					 'img/africa3.jpg'
					 ]
		});
$('.contact-form').validate({
    rules: {
        name: required,
        message: required
    },
        email: {
            email: required,
            email: true
        },
    messages: {
        name: 'Please fill  thi field',
        message: 'Please fill  thi field'
    }
});