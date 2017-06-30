(function( $ ) {
	'use strict';
	
	var $thumb_nav = false;
	if (bsm_loc.bsm_thumb_nav === "1") {
		var $thumb_nav = true;
	}
	
	var $defaultViewMode=bsm_loc.bsm_view_mode; //full, normal, original
	var $bsmSkin=bsm_loc.bsm_skin; // skin option
	var $tsMargin=30; //first and last thumbnail margin (for better cursor interaction) 
	var $scrollEasing=parseInt(bsm_loc.bsm_easing_option_duration); //scroll easing amount (0 for no easing) 
	var $scrollEasingType="easeOutCirc"; //scroll easing type 
	var $animation = bsm_loc.bsm_animation;
	var	$thumbnailsContainerOpacity=0.8; //thumbnails area default opacity
	var	$thumbnailsOpacity=0.6; //thumbnails default opacity
	
	if ( $thumb_nav ) {
		$thumbnailsContainerOpacity=0;
		$thumbnailsOpacity=0;
	}
	
	var $thumbnailsContainerMouseOutOpacity=0; //thumbnails area opacity on mouse out
	var $nextPrevBtnsInitState="show"; //next/previous image buttons initial state ("hide" or "show")
	var $keyboardNavigation="on"; //enable/disable keyboard navigation ("on" or "off")

	//cache vars
	var $thumbnails_wrapper=$("#bsm-thumbnails-wrapper");
	var $outer_container=$("#bsm-outer-container");
	var $thumbScroller=$(".thumbScroller");
	var $thumbScroller_container=$(".thumbScroller .container");
	var $thumbScroller_content=$(".thumbScroller .content");
	var $thumbScroller_thumb=$(".thumbScroller .thumb");
	var $preloader=$("#bsm-preloader");
	var $toolbar=$("#bsm-toolbar");
	var	$toolbar_a=$("#bsm-toolbar a");
	var $bgimg=$("#bsm-bgimg");
	var $img_title=$("#bsm-img-title");
	var $nextImageBtn=$(".BSMnextImageBtn");
	var $prevImageBtn=$(".BSMprevImageBtn");
	// Set auto slider delay time here
	var $slider_time_delay = parseInt(bsm_loc.bsm_slider_delay);
	var auto_play; // Auto load slider 

	$toolbar_a.click(function(){
		if($defaultViewMode === "full"){
			ImageViewMode('normal');
			$defaultViewMode = "normal";
		} else{
			ImageViewMode('full');
			$defaultViewMode = "full";
		}
	});

	$(window).load(function() {
		$toolbar.data("imageViewMode",$defaultViewMode); //default view mode

		if($defaultViewMode=="full"){
			$toolbar_a.html('<img src="' + bsm_loc.bsm_plugin_url + 'assets/toolbar_n_icon-' + $bsmSkin + '.png" width="50" height="50" />').attr("id", "view-normal").attr("title", "Original Ratio");
		} else {
			$toolbar_a.html('<img src="' + bsm_loc.bsm_plugin_url + 'assets/toolbar_fs_icon-' + $bsmSkin + '.png" width="50" height="50" />').attr("id", "view-max").attr("title", "Full Screen");
		}
		ShowHideNextPrev($nextPrevBtnsInitState);
		$nextImageBtn.css('background-image','url("' + bsm_loc.bsm_plugin_url + 'assets/nextImgBtn-' + $bsmSkin + '.png")');
		$prevImageBtn.css('background-image','url("' + bsm_loc.bsm_plugin_url + 'assets/prevImgBtn-' + $bsmSkin + '.png")');
		
		if( $bsmSkin === "black" ){
			$nextImageBtn.css('opacity','0.7');
			$prevImageBtn.css('opacity','0.7');
		}
		
		//thumbnail scroller
		$thumbScroller_container.css("marginLeft",$tsMargin+"px"); //add margin
		var sliderLeft=$thumbScroller_container.position.left;
		var sliderWidth=$outer_container.width();
		$thumbScroller.css("width",sliderWidth);
		var totalContent=0;
		var fadeSpeed=200;
		
		var $the_outer_container=document.getElementById("bsm-outer-container");
		var $placement=findPos($the_outer_container);
		
		$thumbScroller_content.each(function () {
			var $this=$(this);
			totalContent+=$this.innerWidth();
			$thumbScroller_container.css("width",totalContent);
			$this.children().children().children(".thumb").fadeTo(fadeSpeed, $thumbnailsOpacity);
		});

		$thumbScroller.mousemove(function(e){
			if($thumbScroller_container.width()>sliderWidth){
				var mouseCoords=(e.pageX - $placement[1]);
				var mousePercentX=mouseCoords/sliderWidth;
				var destX=-((((totalContent+($tsMargin*2))-(sliderWidth))-sliderWidth)*(mousePercentX));
				var thePosA=mouseCoords-destX;
				var thePosB=destX-mouseCoords;
				if(mouseCoords>destX){
					$thumbScroller_container.stop().animate({left: -thePosA}, $scrollEasing,$scrollEasingType); //with easing
				} else if(mouseCoords<destX){
					$thumbScroller_container.stop().animate({left: thePosB}, $scrollEasing,$scrollEasingType); //with easing
				} else {
					$thumbScroller_container.stop();  
				}
			}
		});
	
		if(!$thumb_nav) { //Only runs the thumbnail navigation when thumb_nav is set to show.
			setTimeout(function() {
				$thumbnails_wrapper.fadeTo(fadeSpeed, $thumbnailsContainerMouseOutOpacity)
				}, 3000
			);
			
			$thumbnails_wrapper.hover(
				function(){ //mouse over
					var $this=$(this);
					$this.stop().fadeTo("slow", 1);
				},
				function(){ //mouse out
					var $this=$(this);
					$this.stop().fadeTo("slow", $thumbnailsContainerMouseOutOpacity);
				}
			);

			$thumbScroller_thumb.hover(
				function(){ //mouse over
					var $this=$(this);
					$this.stop().fadeTo(fadeSpeed, 1);
				},
				function(){ //mouse out
					var $this=$(this);
					$this.stop().fadeTo(fadeSpeed, $thumbnailsOpacity);
				}
			);
		}
		//on window resize scale image and reset thumbnail scroller
		$(window).resize(function() {
			FullScreenBackground("#bgimg",$bgimg.data("newImageW"),$bgimg.data("newImageH"));
			$thumbScroller_container.stop().animate({left: sliderLeft}, 400,"easeOutCirc"); 
			var newWidth=$outer_container.width();
			$thumbScroller.css("width",newWidth);
			sliderWidth=newWidth;
			$placement=findPos($the_outer_container);
		});

		//load 1st image
		var the1stImg = new Image();
		the1stImg.onload = CreateDelegate(the1stImg, theNewImg_onload);
		the1stImg.src = $bgimg.attr("src");
		$outer_container.data("nextImage",$(".content").first().next().find("a").attr("href"));
		$outer_container.data("prevImage",$(".content").last().find("a").attr("href"));
		
		auto_play = setInterval(function( event ){ 
			load_next_slide(event); 
		}, $slider_time_delay);
	});

	function BackgroundLoadDefault($this,imageWidth,imageHeight,imgSrc){
		$this.fadeOut("fast",function(){
			$this.attr("src", "").attr("src", imgSrc); //change image source
			FullScreenBackground($this,imageWidth,imageHeight); //scale background image
			$preloader.fadeOut("fast",function(){$this.fadeIn("slow");});
			var imageTitle=$img_title.data("imageTitle");
			if(imageTitle){
				$this.attr("alt", imageTitle).attr("title", imageTitle);
				$img_title.fadeOut("fast",function(){
					$img_title.html(imageTitle).fadeIn();
				});
			} else {
				$img_title.fadeOut("fast",function(){
					$img_title.html($this.attr("title")).fadeIn();
				});
			}
		});
	}
	
	//CREDIT: curlybracket - https://wordpress.org/support/topic/crossfading
	function BackgroundLoadCF($this,imageWidth,imageHeight,imgSrc){
		var $clone = $this.clone().addClass('clone').prependTo('#bsm-bg');
		$this.fadeOut("slow",function(){
			$this.attr("src", "").attr("src", imgSrc); //change image source
			FullScreenBackground($this,imageWidth,imageHeight); //scale background image
			$preloader.fadeOut("slow",function(){
				$this.fadeIn("slow", function() {
					 $clone.remove();
				});
			});
			var imageTitle=$img_title.data("imageTitle");
			if(imageTitle){
				$this.attr("alt", imageTitle).attr("title", imageTitle);
				$img_title.fadeOut("fast",function(){
					$img_title.html(imageTitle).fadeIn();
				});
			} else {
				$img_title.fadeOut("fast",function(){
					$img_title.html($this.attr("title")).fadeIn();
				});
			}
		});
	}


	//mouseover toolbar
	if($toolbar.css("display")!="none"){
		$toolbar.fadeTo("fast", 0.45);
	}
	$toolbar.hover(
		function(){ //mouse over
			var $this=$(this);
			$this.stop().fadeTo("fast", 1);
		},
		function(){ //mouse out
			var $this=$(this);
			$this.stop().fadeTo("fast", 0.45);
		}
	);

	//Clicking on thumbnail changes the background image
	$("#bsm-outer-container a").click(function(event){
		event.preventDefault();
		var $this=$(this);
		GetNextPrevImages($this);
		GetImageTitle($this);
		SwitchImage(this);
		ShowHideNextPrev("show");
	}); 

	//WMS Custom Slider Function
	function load_next_slide(event){
		SwitchImage($outer_container.data("nextImage"));
		var $this=$("#bsm-outer-container a[href='"+$outer_container.data("nextImage")+"']");
		GetNextPrevImages($this);
		GetImageTitle($this);
	}

	function load_prev_slide(event){
		SwitchImage($outer_container.data("prevImage"));
		var $this=$("#bsm-outer-container a[href='"+$outer_container.data("prevImage")+"']");
		GetNextPrevImages($this);
		GetImageTitle($this);
	}


	//next/prev images buttons
	$nextImageBtn.click(function(event){
		event.preventDefault();
		load_next_slide(event);
		clearInterval(auto_play);
	});

	$prevImageBtn.click(function(event){
		event.preventDefault();
		load_prev_slide(event);
		clearInterval(auto_play);
	});

	//next/prev images keyboard arrows
	if($keyboardNavigation=="on"){
		$(document).keydown(function(ev) {
			if(ev.keyCode == 39) { //right arrow
				SwitchImage($outer_container.data("nextImage"));
				var $this=$("#bsm-outer-container a[href='"+$outer_container.data("nextImage")+"']");
				GetNextPrevImages($this);
				GetImageTitle($this);
				clearInterval(auto_play);
				return false; // don't execute the default action (scrolling or whatever)
			} else if(ev.keyCode == 37) { //left arrow
				SwitchImage($outer_container.data("prevImage"));
				var $this=$("#bsm-outer-container a[href='"+$outer_container.data("prevImage")+"']");
				GetNextPrevImages($this);
				GetImageTitle($this);
				clearInterval(auto_play);
				return false; // don't execute the default action (scrolling or whatever)
			}
		});
	}

	function ShowHideNextPrev(state){
		if(state=="hide"){
			$nextImageBtn.fadeOut();
			$prevImageBtn.fadeOut();
		} else {
			$nextImageBtn.fadeIn();
			$prevImageBtn.fadeIn();
		}
	}

	//get image title
	function GetImageTitle(elem){
		var title_attr=elem.children("img").attr("title"); //get image title attribute
		$img_title.data("imageTitle", title_attr); //store image title
	}

	//get next/prev images
	function GetNextPrevImages(curr){
		var nextImage=curr.parents(".content").next().find("a").attr("href");
		if(nextImage==null){ //if last image, next is first
			var nextImage=$(".content").first().find("a").attr("href");
		}
		$outer_container.data("nextImage",nextImage);
		var prevImage=curr.parents(".content").prev().find("a").attr("href");
		if(prevImage==null){ //if first image, previous is last
			var prevImage=$(".content").last().find("a").attr("href");
		}
		$outer_container.data("prevImage",prevImage);
	}

	//switch image
	function SwitchImage(img){
		//$preloader.fadeIn("fast"); //show preloader
		var theNewImg = new Image();
		theNewImg.onload = CreateDelegate(theNewImg, theNewImg_onload);
		theNewImg.src = img;
	}

	//get new image dimensions
	function CreateDelegate(contextObject, delegateMethod){
		return function(){
			return delegateMethod.apply(contextObject, arguments);
		}
	}

	//new image on load
	function theNewImg_onload(){
		$bgimg.data("newImageW",this.width).data("newImageH",this.height);
		if( $animation == 'cross' ){
			BackgroundLoadCF($bgimg,this.width,this.height,this.src);
		} else {
			BackgroundLoadDefault($bgimg,this.width,this.height,this.src);
		}
		
	}
	//Image scale function
	function FullScreenBackground(theItem,imageWidth,imageHeight){
		var winWidth=$(window).width();
		var winHeight=$(window).height();
		if($toolbar.data("imageViewMode") === undefined){
			var picHeight = imageHeight / imageWidth;
			var picWidth = imageWidth / imageHeight;
			if($defaultViewMode=="full"){ //fullscreen size image mode
				if ((winHeight / winWidth) < picHeight) {
					$(theItem).attr("width",winWidth);
					$(theItem).attr("height",picHeight*winWidth);
				} else {
					$(theItem).attr("height",winHeight);
					$(theItem).attr("width",picWidth*winHeight);
				};
			} else { //normal size image mode
				if ((winHeight / winWidth) > picHeight) {
					$(theItem).attr("width",winWidth);
					$(theItem).attr("height",picHeight*winWidth);
				} else {
					$(theItem).attr("height",winHeight);
					$(theItem).attr("width",picWidth*winHeight);
				};
			}
			$(theItem).css("margin-left",(winWidth-$(theItem).width())/2);
			$(theItem).css("margin-top",(winHeight-$(theItem).height())/2);
		} else if($toolbar.data("imageViewMode")!="original"){ //scale
			var picHeight = imageHeight / imageWidth;
			var picWidth = imageWidth / imageHeight;
			if($toolbar.data("imageViewMode")=="full"){ //fullscreen size image mode
				if ((winHeight / winWidth) < picHeight) {
					$(theItem).attr("width",winWidth);
					$(theItem).attr("height",picHeight*winWidth);
				} else {
					$(theItem).attr("height",winHeight);
					$(theItem).attr("width",picWidth*winHeight);
				};
			} else { //normal size image mode
				if ((winHeight / winWidth) > picHeight) {
					$(theItem).attr("width",winWidth);
					$(theItem).attr("height",picHeight*winWidth);
				} else {
					$(theItem).attr("height",winHeight);
					$(theItem).attr("width",picWidth*winHeight);
				};
			}
			$(theItem).css("margin-left",(winWidth-$(theItem).width())/2);
			$(theItem).css("margin-top",(winHeight-$(theItem).height())/2);
		} else { //no scale
			$(theItem).attr("width",imageWidth);
			$(theItem).attr("height",imageHeight);
			$(theItem).css("margin-left",(winWidth-imageWidth)/2);
			$(theItem).css("margin-top",(winHeight-imageHeight)/2);
		}
	}

	//Image view mode function
	function ImageViewMode(theMode){
		$toolbar.data("imageViewMode", theMode);
		FullScreenBackground($bgimg,$bgimg.data("newImageW"),$bgimg.data("newImageH"));
		if(theMode=="full"){
			$toolbar_a.html('<img src="' + bsm_loc.bsm_plugin_url + 'assets/toolbar_n_icon-' + $bsmSkin + '.png" width="50" height="50" />').attr("id", "view-normal").attr("title", "Original Ratio");
		} else {
			$toolbar_a.html('<img src="' + bsm_loc.bsm_plugin_url + 'assets/toolbar_fs_icon-' + $bsmSkin + '.png" width="50" height="50" />').attr("id", "view-max").attr("title", "Full Screen");
		}
	}

	//function to find element Position
	function findPos(obj) {
		var curleft = 0;
		var curtop = 0;
		if (obj.offsetParent) {
			curleft = obj.offsetLeft
			curtop = obj.offsetTop
			while (obj = obj.offsetParent) {
				curleft += obj.offsetLeft
				curtop += obj.offsetTop
			}
		}
		return [curtop, curleft];
	}

})( jQuery );
