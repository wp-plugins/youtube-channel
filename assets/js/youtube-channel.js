jQuery(document).ready(function($) {
	// ytc_ar_height = screen.height;
	ytc_ar_height = Math.round(screen.height / 9) * 9;
	ytc_ar_width = (ytc_ar_height/9)*16;
	$('.ytc-fancybox')
		.fancybox({
			openEffect : 'none',
			closeEffect : 'none',
			prevEffect : 'none',
			nextEffect : 'none',
			aspectRatio : true,
			autoDimensions : false,
			width : ytc_ar_width,
			height: ytc_ar_height,
			arrows : false,
			title: null,
			padding : 0,
			helpers : {
				media : {},
				overlay : {
					css : {
						background: "#000"
					}
				}
			},

		});
});