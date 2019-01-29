/**
*
* @copyright 	Copyright (c) 2016 {@link http://www.agriya.com Agriya Infoway}
* @license 		http://www.agriya.com Agriya Infoway Licence
* @version 		Services Team
*/


$(document).ready(function(){
	/* Side Menu 
			========= */
		$('.menubari').click(function(){
			if (!$(this).next(".hedr").hasClass("showhide"))	{
				$(this).next(".hedr").addClass("showhide")
				$(this).next(".hedr").removeClass("header-sm-xs")
				$(this).parent(".parnt-accord").siblings(".hedr").removeClass('showhide');
				
			}else {
				$(this).next(".hedr").removeClass("showhide")
				$(this).next(".hedr").addClass("header-sm-xs")
			}
		});
		
		$('.menubari').click(function(){
		$(this).find('i').toggleClass('fa-angle-double-left fa-angle-double-right')
		$(this).toggleClass('menucolor menutrans')
		$(".headmenu ul li").toggleClass("menuli")
		$(".headmenu ul").toggleClass("menuhed")
		$(".headmenu").toggleClass("menuheader")
		
		if (!$(this).hasClass("menumove")) {
			$(this).addClass("menumove")	
		}else {
			$(this).removeClass("menumove")
		}
	});
   /* Bs DropDown 
			========= */
		$('.dropdown,.dropup').on('show.bs.dropdown', function(e){
		  $(this).find('.dropdown-menu').first().stop(true, true).slideDown(400);
		});
		
		$('.dropdown,.dropup').on('hide.bs.dropdown', function(e){
		  $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
		});

	});
