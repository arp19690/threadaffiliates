jQuery(function ($) {
    "use strict";
	var bodyEl = $("body"),
		content = $('#content-wrap'),
		openbtn = $('#open-button'),
		closebtn = $('#close-button' ),
		isOpen = false;

	function init() {
		initEvents();
	}

	function initEvents() {
		openbtn.click(function(e) {		
			toggleMenu();
			e.stopPropagation();
		});
		if( closebtn ) {
			closebtn.click(function() {		
				toggleMenu();
			});
		}
		content.click(function(e) {		
			var target = e.target;
			if( isOpen && target !== openbtn ) {
				toggleMenu();
			}
		});		
	}
	function toggleMenu() {		
		if( isOpen ) {
			bodyEl.removeClass('show-menu');
		}
		else {
			bodyEl.addClass('show-menu');
		}
		isOpen = !isOpen;
	}
	init();

});

jQuery(function ($) {
    "use strict";
    $(".mega .fa-angle-right").click(function (e) {
    	e.preventDefault();		
        var _parent = $(this).parent();
        var _dropdown = _parent.next('.dropdown-menu');
        var _grandparent = _parent.parent();        
        if(_grandparent.hasClass('open')) {
        	_grandparent.removeClass('open');
        	_dropdown.slideUp("normal");
			$(this).removeClass('fa-angle-down');
			$(this).addClass('fa-angle-right');
        } else {			
        	_grandparent.addClass('open');        	
        	_dropdown.slideDown("normal"); 
			$(this).removeClass('fa-angle-right');
			$(this).addClass('fa-angle-down');
        }
    })
    $(".mega .fa-angle-right").mouseover(function (e) {       
        e.preventDefault();
        return false;        
    })
    $("#off-canvas-menu li a").mouseover(function (e) {       
        e.preventDefault();
        return false;
        
    })	
});