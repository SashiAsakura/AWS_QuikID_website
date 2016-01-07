function initScroll(){
	$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
	});
	
	// scroll body to 0px on click
    $('#back-to-top').click(function () {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    
    $('#back-to-top').tooltip('show');
}

function initTabs() {
	$('.year-news').click(function (e) {
	  var year = $(this).attr('id');
	  e.preventDefault();
	  var url = "getpress.php?year="+year;
	  //something has to be displayed during waiting... 
	  $("#content"+year).html('<div class="loading"></div>');
	  
	  var query = $.ajax(url);
	  query.done(function(data){
	  	  $("#content"+year).html(data);
	  	  initPages()
	  });
	  query.fail(function(data){
		  $("#content"+year).html("sorry unable to load data");
		  initPages()
	  });
	  
	  //$(this).tab('show')
	})
}

function initPages(){
	$('.pageSelBtns').click(function(e){
		var id = $(this).attr('id');
		e.preventDefault();
		var arr = id.split('-');
		//arr[0] selpage
		var year = arr[1];
		var page = arr[2];
		//alert('page: '+arr[2]+' year: '+arr[1]);
		var url = "getpress.php?year="+year+'&page='+page;
		//something has to be displayed during waiting... 
		$("#content"+year).html('<div class="asdasd">loading....</div>');
		
		var query = $.ajax(url);
		query.done(function(data){
			//alert('asdasd');
			  $("#content"+year).html(data);
			  initPages();
		});
		query.fail(function(data){
		  $("#content"+year).html("sorry unable to load data");
		});
	});
}

function initBlogPages(){
	$('.blogPageSelBtns').click(function(e){
		var id = $(this).attr('id');
		e.preventDefault();
		var arr = id.split('-');
		//arr[0] selpage
		var year = arr[1];
		var page = arr[2];
		//alert('page: '+arr[2]+' year: '+arr[1]);
		var url = "getblogpress.php?year="+year+'&page='+page;
		//something has to be displayed during waiting... 
		$("#content"+year).html('<div class="asdasd">loading....</div>');
		
		var query = $.ajax(url);
		query.done(function(data){
			  $("#content"+year).html(data);
			  initBlogPages();
		});
		query.fail(function(data){
		  $("#content"+year).html("sorry unable to load data");
		});
	}
	);
}

function initBlogTabs(){
	$('.year-blog-news').click(function (e) {
	  var year = $(this).attr('id');
	  e.preventDefault();
	  var url = "getblogpress.php?year="+year;
	  //something has to be displayed during waiting... 
	  $("#content"+year).html('<div class="asdasd">loading....</div>');
	  
	  var query = $.ajax(url);
	  query.done(function(data){
	  	  $("#content"+year).html(data);
	  	  initBlogPages();
	  });
	  query.fail(function(data){
		  $("#content"+year).html("sorry unable to load data");
		  initBlogPages();
	  });
	  
	  //$(this).tab('show')
	});
}

function initSubscribe() {
	$("#sfname").keyup(function(e) {
		subscribeNext_Keyup(e.keyCode, 0);
        return false;
	});
	$("#scompany").keyup(function(e){
		subscribeNext_Keyup(e.keyCode, 1);
        return false;
	});
	$("#semail").keyup(function(e){
		subscribeNext_Keyup(e.keyCode, 2);
        return false;
	});
	$("#subscribe_next_btn").click(subscribeNext_Click);
	$("#subscribe_btn").click(subscribeEmail);
}

function subscribeEmail() {
    var url = "forms.php";
	
	$("#subscribe-form").hide();
	$("#subscribing-state").show();
	
	var query = $.post(url, {
        form: 1,
		fname: $("#sfname").val(),
        company: $("#scompany").val(),
		email: $("#semail").val()
	});
	query.done(function(data) {
		$("#subscribe-form").show();
		$("#subscribing-state").html(data);

	});
	query.fail(function(data) {
		$("#subscribe-form").show();
		$("#subscribing-state").text("We are sorry, but we experienced some problems, please try again later");
	});
}

var current = 0;
function subscribeNext_Click(){
    subscribeNext_Keyup(13, current);
    return false;
}

function subscribeNext_Keyup(keyCode, step){
	if (keyCode != 13) return false;
	var now;
	var next;
	switch (step) {
		case 0:
			now = $('#sfname');
			if (now.val().length > 0) {
				now.hide();
                $('#subscribe_next_btn').hide();
				next = $('#scompany');
				next.show("slow", function(){
                    $(this).focus();
                    $('#subscribe_next_btn').show();
                }); 
				//next.focus();
				$('#sfstep').html('2/3');
				current = 1;
				$("#subscribing-state").hide();
				$("#subscribing-state").html('');
			} else {
				$("#subscribing-state").html('Name is required.');
				$("#subscribing-state").show();
                now.focus();
			}
		break;
		case 1:
			now = $('#scompany');
			now.hide();
			$('#subscribe_next_btn').hide();
			next = $('#semail');
			next.show(function(){
                $(this).focus();
                $('#subscribe_btn').show();
            });
			//next.focus();
			$('#sfstep').html('3/3');
			current = 2;
		break;
		case 2:
			next = $('#subscribe_btn').click();
		break;
	}
    return false;
}

function initDownload() {
	$("#download_btn_windows").click(downloadQuikIDWindows);
	$("#download_btn_android").click(downloadQuikIDAndroid);
}

function downloadQuikIDWindows(){
	var url = "forms.php";
	
	$("#download-state").html = 'Requesting...';
	$("#download-state").show();
	
	var query = $.post(url,{
			form: 2,
			user: $("#dusr").val(),
			email: $("#demail").val(),
			fname: $("#dfname").val(),
			company: $("#dcompany").val(),
			phone: $('#dphone').val(),
			app: 1, //Windows
			version: $('#dqid-windowsversion').val()
	});
	
	query.done(function (data) {
		$("#download-state").html(data);
	});
	query.fail(function(data) {
		$("#download-form").show();
		$("#download-state").text("Sorry, we are experiencing some technical difficulties. Please try again later.");
	});
	
	return false;
}

function downloadQuikIDAndroid(){
	var url = "forms.php";
	
	$("#download-state").html('Requesting...');
	$("#download-state").show();
	
	var query = $.post(url,{
			form: 2,
			user: $("#dusr").val(),
			email: $("#demail").val(),
			phone: $('#dphone').val(),
			fname: $("#dfname").val(),
			company: $("#dcompany").val(),
			phone: $('#dphone').val(),
			app: 2, //Android
			version: $('#dqid-androidversion').val()
	});
	
	query.done(function (data) {
		$("#download-state").html(data);
	});
	query.fail(function(data) {
		$("#download-form").show();
		$("#download-state").text("Sorry, we are experiencing some technical difficulties. Please try again later.");
	});
	
	return false;
}


function initDiscovery() {
	$("#discovery_btn").click(requestDiscovery);
}

function requestDiscovery(){
    var url = "forms.php";
	
	$("#discovery-form").hide();
	$("#discovery-state").html("Requesting...");
	$("#discovery-state").show();
	
	var query = $.post(url, {
        form: 3,
		fname: $("#dfname").val(),
        email: $("#demail").val(),
		company: $("#dcompany").val(),
		phone: $("#dphone").val()
	});
	query.done(function(data) {
		$("#discovery-state").html(data);
	});
	query.fail(function(data) {
		$("#discovery-form").show();
		$("#discovery-state").text("We are sorry, but we experienced some problems, please try again later");
	});
}

function initContact(){
	$("#contact_btn").click(contact);
}

function contact(){
    var url = "forms.php";
	
	$("#commentForm").hide();
	
	var query = $.post(url, {
        form: 4,
		fname: $("#inputName").val(),
        email: $("#inputEmail").val(),
		company: $("#inputCompany").val(),
		phone: $("#inputPhone").val(),
		interest: $("#inputSelect option:selected").text(),
		message: $("#inputMessage").val(),
		adv: $("#cadv").is(":checked") ? 1 : 0
	});
	
	query.done(function(data) {
		$("#contactStatus").html(data);

	});
	query.fail(function(data) {
		$("#commentForm").show();
		$("#contactStatus").html("<div class=\"error-box\">We are sorry, but we experienced some problems, please try again later</div>");
	});
}

$(document).ready(function ($) {
	initScroll();
	initTabs();
	initPages();
	initBlogPages();
	initBlogTabs();
	initSubscribe();
	initDownload();
	initDiscovery();
	initContact();
	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
		event.preventDefault();
		return $(this).ekkoLightbox();
	});
});

/* Resources Tab*/
$('a[data-toggle="tab"]').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})


/* Modal View Vertical Center*/
function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog");
    var offset = ($(window).height() - $dialog.height()) / 2;
    // Center modal vertically in window
    $dialog.css("margin-top", offset);
}

$('.modal').on('show.bs.modal', centerModal);
$(window).on("resize", function () {
    $('.modal:visible').each(centerModal);
});



/* New Awards*/
(function($){
    $.fn.lbSlider = function(options) {
        var options = $.extend({
            leftBtn: '.leftBtn',
            rightBtn: '.rightBtn',
            visible: 3,
            autoPlay: false,  // true or false
            autoPlayDelay: 10  // delay in seconds
        }, options);
        var make = function() {
            $(this).css('overflow', 'hidden');
            
            var thisWidth = $(this).width();
            var mod = thisWidth % options.visible;
            if (mod) {
                $(this).width(thisWidth - mod); // to prevent bugs while scrolling to the end of slider
            }
            
            var el = $(this).children('ul');
            el.css({
                position: 'relative',
                left: '0'
            });
            var leftBtn = $(options.leftBtn), rightBtn = $(options.rightBtn);

            var sliderFirst = el.children('li').slice(0, options.visible);
            var tmp = '';
            sliderFirst.each(function(){
                tmp = tmp + '<li>' + $(this).html() + '</li>';
            });
            sliderFirst = tmp;
            var sliderLast = el.children('li').slice(-options.visible);
            tmp = '';
            sliderLast.each(function(){
                tmp = tmp + '<li>' + $(this).html() + '</li>';
            });
            sliderLast = tmp;

            var elRealQuant = el.children('li').length;
            el.append(sliderFirst);
            el.prepend(sliderLast);
            var elWidth = el.width()/options.visible;
            el.children('li').css({
                float: 'left',
                width: elWidth
            });
            var elQuant = el.children('li').length;
            el.width(elWidth * elQuant);
            el.css('left', '-' + elWidth * options.visible + 'px');

            function disableButtons() {
                leftBtn.addClass('inactive');
                rightBtn.addClass('inactive');
            }
            function enableButtons() {
                leftBtn.removeClass('inactive');
                rightBtn.removeClass('inactive');
            }

            leftBtn.click(function(event){
                event.preventDefault();
                if (!$(this).hasClass('inactive')) {
                    disableButtons();
                    el.animate({left: '+=' + elWidth + 'px'}, 300,
                        function(){
                            if ($(this).css('left') == '0px') {$(this).css('left', '-' + elWidth * elRealQuant + 'px');}
                            enableButtons();
                        }
                    );
                }
                return false;
            });

            rightBtn.click(function(event){
                event.preventDefault();
                if (!$(this).hasClass('inactive')) {
                    disableButtons();
                    el.animate({left: '-=' + elWidth + 'px'}, 300,
                        function(){
                            if ($(this).css('left') == '-' + (elWidth * (options.visible + elRealQuant)) + 'px') {$(this).css('left', '-' + elWidth * options.visible + 'px');}
                            enableButtons();
                        }
                    );
                }
                return false;
            });

            if (options.autoPlay) {
                function aPlay() {
                    rightBtn.click();
                    delId = setTimeout(aPlay, options.autoPlayDelay * 1000);
                }
                var delId = setTimeout(aPlay, options.autoPlayDelay * 1000);
                el.hover(
                    function() {
                        clearTimeout(delId);
                    },
                    function() {
                        delId = setTimeout(aPlay, options.autoPlayDelay * 1000);
                    }
                );
            }
        };
        return this.each(make);
    };
})(jQuery);

/* Mega Dropdown NavBar*/

$(function() {
    if($(window).width() >= 768){
	  $(".dropdown").hover(            
		  function() {
			  $('.dropdown-menu', this).stop().fadeIn("fast");				   
		  },
		  function() {
			  $('.dropdown-menu', this).stop().fadeOut("fast");			  
		  }
	  );
	}else{
        
    }
});

/* NAVIGATION CUSTOMIZATION */
$(function(){
	/* COMPANY PAGE */
	var hash = window.location.hash;
	if ($('ul.side-list').length > 0){ //we are on the company page
	
		$('ul.side-list a').click(function (e) {
			window.location.hash = $(this).attr('href')
		});
		
		$(window).on('hashchange', function(e) {
			var hash = window.location.hash;
			if (hash) {
				//alert('hash change')
				$('html,body').animate({scrollTop: 0}, 1000);	
				$('ul.side-list a[href="' + hash + '"]').tab('show');
				$('.company ul.nav-list a').removeClass('on');
				$('.company ul.nav-list a[href="' + window.location + '"]').addClass('on');
			}
		});
		
		if (hash){ //go to hash
			$('ul.nav a[href="' + hash + '"]').tab('show');
			$('.company ul.nav-list a[href="' + window.location + '"]').addClass('on');
			$('html,body').animate({scrollTop: 0}, 1000);	
		}
		else window.location.hash = '#about'; //go to about
	}
	
	/* ALL PAGES (with nav-list)*/
	$('.nav-list').hover(
		function (e) {
			$('ul.nav-list a').removeClass('on');
		}, 
		function (e)  {
			$('ul.nav-list a[href="' + window.location + '"]').addClass('on');
	});
});

/* Tool Tip Initialization*/
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


/* Load Data*/
$(".pressNews").click(function(){
    $( ".in_news" ).load( "content/innews.html" );
});

$(".pressVideos").click(function(){
    $( ".videos-thumb" ).load( "content/videos.html" );
});

/* REQUEST DISCOVERY / DOWNLOAD FORM */
$.fn.extend({
	setCursorPosition: function(position){
		if(this.length == 0) return this;
		return $(this).setSelection(position, position);
	},

	setSelection: function(selectionStart, selectionEnd) {
		if(this.length == 0) return this;
		input = this[0];

		if (input.createTextRange) {
			var range = input.createTextRange();
			range.collapse(true);
			range.moveEnd('character', selectionEnd);
			range.moveStart('character', selectionStart);
			range.select();
		} else if (input.setSelectionRange) {
			input.focus();
			input.setSelectionRange(selectionStart, selectionEnd);
		}

		return this;
	},

	focusEnd: function(){
		this.setCursorPosition(this.val().length);
		return this;
	},

	getCursorPosition: function() {
		var el = $(this).get(0);
		var pos = 0;
		if('selectionStart' in el) {
			pos = el.selectionStart;
		} else if('selection' in document) {
			el.focus();
			var Sel = document.selection.createRange();
			var SelLength = document.selection.createRange().text.length;
			Sel.moveStart('character', -el.value.length);
			pos = Sel.text.length - SelLength;
		}
		return pos;
	},

	insertAtCursor: function(myValue) {
		return this.each(function(i) {
			if (document.selection) {
			  //For browsers like Internet Explorer
			  this.focus();
			  sel = document.selection.createRange();
			  sel.text = myValue;
			  this.focus();
			}
			else if (this.selectionStart || this.selectionStart == '0') {
			  //For browsers like Firefox and Webkit based
			  var startPos = this.selectionStart;
			  var endPos = this.selectionEnd;
			  var scrollTop = this.scrollTop;
			  this.value = this.value.substring(0, startPos) + myValue + 
							this.value.substring(endPos,this.value.length);
			  this.focus();
			  this.selectionStart = startPos + myValue.length;
			  this.selectionEnd = startPos + myValue.length;
			  this.scrollTop = scrollTop;
			} else {
			  this.value += myValue;
			  this.focus();
			}
	  	})
	}
});


$(window).load(function(){
	$('.down_text').keydown(function(e){
		if (e.which == 13){
		$('#download_btn').click();
		}
	});

	$('#dcompany').keydown(function(e){
		if (e.which == 9){
			e.preventDefault();
			$('#dphone').setCursorPosition(1);
		}
		
	});
});


/* Footer Bottom*/
$(function () {
   var docHeight = $(window).height();
   var footerHeight = $('#footer').height();
   var footerTop = $('#footer').position().top + footerHeight;

   if (footerTop < docHeight) {
    $('#footer').css('margin-top', 10+ (docHeight - footerTop) + 'px');
   }
});


//Flickr Gallery 
$(document).ready(function() {
       $.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=136456652@N06&format=json&jsoncallback=?", function(data) {
               var target = ".photoGrid"; // Where is it going?
               for (i = 0; i <= 9; i = i + 1) { // Loop through the 10 most recent, [0-9]
                       var pic = data.items[i];
                       var liNumber = i + 1; // Add class to each LI (1-10)
                       $(target).append("<div class='flickrList flickr-image no-" + liNumber + "'><a data-tooltip='" + pic.title + "' href='" + pic.link + "' class='imgDesc'><img src='" + pic.media.m + "' /></a></div>");
               }
       });
});

//136456652@N06 fusionpipe flickr id

$(function() {
  var defaults = {
    itemSelector: ".flickrList", // item selecor ;-)
    resize: true, // automatic reload grid on window size change
    rowHeight: $(window).height() / 5, 
	// looks best, but needs highres thumbs
    callback: function() {} // fires when layouting grid is done
  };

  $(window).load(function() { // or use https://github.com/desandro/imagesloaded
    $('.photoGrid').photoGrid({
      //rowHeight: "200"
    });
  });
  
});
