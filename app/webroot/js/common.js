
function loadSideMap() {
	var common_options = {
		map_frame_id: 'mapframe',
		map_window_id: 'mapwindow',
		area: 'js-street_id',
		state: 'StateName',
		city: 'CityName',
		country: 'js-country_id',
		lat_id: 'latitude',
		lng_id: 'longitude',
		postal_code: 'UserProfileZipCode',
		ne_lat: 'ne_latitude',
		ne_lng: 'ne_longitude',
		sw_lat: 'sw_latitude',
		sw_lng: 'sw_longitude',
		button: 'js-sub',
		error: 'address-info',
		mapblock: 'mapblock',
		lat: '37.7749295',
		lng: '-122.4194155',
		map_zoom: 13
	};
	$('#ProjectAddressSearch, #UserAddressSearch').autogeocomplete(common_options);
	$('#js-map-container').css('width', '222px').css('height', '176px');
	lat = $('#' + common_options.lat_id).val();
	lng = $('#' + common_options.lng_id).val();
	if (typeof(lat) != 'undefined' && typeof(lng) != 'undefined' && document.getElementById('js-map-container')) {
		$('.js-side-map-div').show();
		var zoom = common_options.map_zoom;
		if (lat === 0 && lng === 0) {
			lat = 13.0833;
			lng = 80.28330000000005;
		}
		latlng = new google.maps.LatLng(lat, lng);
		var myOptions1 = {
			zoom: zoom,
			center: latlng,
			zoomControl: true,
			draggable: true,
			disableDefaultUI: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map1 = new google.maps.Map(document.getElementById('js-map-container'), myOptions1);
		marker1 = new google.maps.Marker( {
			draggable: true,
			map: map1,
			position: latlng
		});
		map1.setCenter(latlng);
		google.maps.event.addListener(marker1, 'dragend', function(event) {
			$('#latitude').val(marker1.getPosition().lat());
            $('#longitude').val(marker1.getPosition().lng());
		});
		google.maps.event.addListener(map1, 'mouseout', function(event) {
			$('#zoomlevel').val(map1.getZoom());
		});
		$('#js-geo-fail-address-fill-block').show();
		if ($('#js-street_id').val() !== '' || $('#CityName').val() !== '') {
			floadgeomapprojectadd();
		}
	} else {
		$('.js-side-map-div').hide();
	}
}
function __l(str, lang_code) {
	//TODO: lang_code = lang_code || 'en_us';
	return(__cfg && __cfg('lang') && __cfg('lang')[str]) ? __cfg('lang')[str]: str;
}
function __cfg(c) {
	return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function split(val) {
	return val.split(/,\s*/);
}
function clearCache() {
	$.each(cacheMapping, function(id, item) {
		if (cacheMapping[id].url.indexOf('/messages') != -1) {
			delete cacheMapping[id];
		}
	});
}
function extractLast(term) {
	return split(term).pop();
}
function floadgeomapprojectadd() {
	if ($('#js-street_id').val() !== '' || $('#CityName').val() !== '') {
		var address = '';
		address = '##AREA##, ##CITY##, ##STATE##, ##COUNTRY##, ##ZIPCODE##';
		address_list = address.split('##');
		for (i = 0; i < address_list.length; i ++ ) {
			switch(address_list[i]) {
				case 'AREA': address = address.replace('##AREA##', $('#js-street_id').val());
				break;
				case 'CITY': address = address.replace('##CITY##', $('#CityName').val());
				break;
				case 'STATE': address = address.replace('##STATE##', $('#StateName').val());
				break;
				case 'COUNTRY': var name = $('#js-country_id option:selected').val();
				if (name === '') {
					address = address.replace('##COUNTRY##', '');
				} else {
					address = address.replace('##COUNTRY##', $('#js-country_id option:selected').text());
				}
				break;
				case 'ZIPCODE': if (typeof $('#PropertyPostalCode').val() == 'undefined') {
					address = address.replace('##ZIPCODE##', '');
				} else {
					address = address.replace('##ZIPCODE##', $('#PropertyPostalCode').val());
				}
				break;
			}
		}
		address = $.trim(address);
		var intIndexOfMatch = address.indexOf('  ');
		while (intIndexOfMatch != -1) {
			address = address.replace('  ', ' ');
			intIndexOfMatch = address.indexOf('  ');
		}
		intIndexOfMatch = address.indexOf(', ,');
		while (intIndexOfMatch != -1) {
			address = address.replace(', ,', ',');
			intIndexOfMatch = address.indexOf(', ,');
		}
		if (address.substring(0, 1) == ',') {
			address = address.substring(1);
		}
		address = $.trim(address);
		size = address.length;
		if (address.substring(size - 1, size) == ',') {
			address = address.substring(0, size - 1);
		}
		$('#UserAddressSearch').val(address);
		geocoder1 = new google.maps.Geocoder();
		geocoder1.geocode( {
			'address': address
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				marker1.setMap(null);
				map1.setCenter(results[0].geometry.location);
				marker1 = new google.maps.Marker( {
					draggable: true,
					map: map1,
					position: results[0].geometry.location
				});
				$('#latitude').val(marker1.getPosition().lat());
				$('#longitude').val(marker1.getPosition().lng());
				google.maps.event.addListener(marker1, 'dragend', function(event) {
					$('#latitude').val(marker1.getPosition().lat());
					$('#longitude').val(marker1.getPosition().lng());
				});
				google.maps.event.addListener(map1, 'mouseout', function(event) {
					$('#zoomlevel').val(map1.getZoom());
				});
			}
		});
	}
}
// similar to php string escape
function fcn_addslashes(str) {
	if (str === null || str === undefined) {
		return '';
	}
	str = str.replace(/\\/g, '\\\\').replace(/\u0008/g, '\\b').replace(/\t/g, '\\t').replace(/\n/g, '\\n').replace(/\f/g, '\\f').replace(/\r/g, '\\r').replace(/'/g, '\\\'').replace(/"/g, '\\"');
	return str.valueOf();
}
function js_shipping_click(ship_div, date_div) {
	if ($('#' + ship_div).prop('checked') === true) {
		if($('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'estimated_delivery_date').hasClass('hide')) {		
			$('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'estimated_delivery_date').removeClass('hide');
		}
		$('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'estimated_delivery_date').slideDown('slow');
	} else {
		$('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'estimated_delivery_date').slideUp('slow');
	}
}
function js_additional_info(ship_div, date_div) {
	if ($('#' + ship_div).prop('checked') === true) {	
		if($('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'additional_info_label').hasClass('hide')) {		
			$('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'additional_info_label').removeClass('hide');
		}
		$('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'additional_info_label').slideDown('slow');
	} else {
		$('#' + 'ProjectReward' + ship_div.match(/\d+/) + 'additional_info_label').slideUp('slow');
	}
}
function publishCallBack(response) {
	window.location.href = $('#js-loader').data('redirect_url');
}
function loadAdminPanel() {
	if ($.cookie('_gz') !== null && (window.location.href.indexOf('/project/') !== -1 || window.location.href.indexOf('/user/') !== -1)) {
		$('.alap').html('');
		$('header').removeClass('show-panel');
		var url = '';
		if (typeof($('.js-user-view').data('user-id')) !== 'undefined' && $('.js-user-view').data('user-id') !=='' && $('.js-user-view').data('user-id') !== null) {
			var uid = $('.js-user-view').data('user-id');
			url = 'users/show_admin_control_panel/view_type:user/id:'+uid;
		}
		if (typeof($('.js-project-view').data('project-id')) !== 'undefined' &&  $('.js-project-view').data('project-id') !=='' && $('.js-project-view').data('project-id') !== null) {
			var pid = $('.js-project-view').data('project-id');
			url = 'projects/show_admin_control_panel/view_type:project/id:'+pid;
		}
		if (url !=='') {
			$.get(__cfg('path_relative') + url, function(data) {
				$('.alap').html(data).removeClass('hide').show();
			});
		}
	} else {
		$('.alap').hide();
	}
}
function loopy_call(hidden) {
	(function loopy(){
		var objs = hidden.removeClass('needsSparkline');
		hidden = hidden.filter('.needsSparkline');
		if (objs.length) {
			objs.css({
				'display':'',
				'visibility':'hidden'
			});
			$.sparkline_display_visible();
			objs.css({
				'display':'none',
				'visibility':''
			});
			setTimeout( loopy, 250 );
		}
	})();
}
(function() {
	jQuery('html').addClass('js');
	function xload(is_after_ajax) {
		$('.js-pending-list').find("*").click(function(e) {
			e.stopPropagation();
		});
		
		$('.js-payment-type').each(function() {
			var $this = $(this);
			if ($this.prop('checked') === true) {
				if ($this.val() == 2) {
					$('.js-form, .js-instruction').addClass('hide');
					$('.js-wallet-connection').slideDown('fast');
					$('.js-normal-sudopay').slideUp('fast');
				} else if ($this.val() == 1) {
					$('.js-normal-sudopay').slideUp('fast');
					$('.js-wallet-connection').slideDown('fast');
					$('.js-gatway_form_tpl').hide();
					$('.js-instruction').addClass('hide');
					$('.js-form').addClass('hide');
				} else if ($this.val().indexOf('sp_') != -1) {
					$('.js-gatway_form_tpl').hide();
					form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
					for (var i = 0; i < form_fields_arr.length; i ++ ) {
						$('#form_tpl_' + form_fields_arr[i]).show();
					}
					var instruction_id = $this.val();
					$('.js-instruction').addClass('hide');
					$('.js-form').removeClass('hide');
					if (typeof($('.js-instruction_'+instruction_id).html()) != 'undefined') {
						$('.js-instruction_'+instruction_id).removeClass('hide');
					}
					if (typeof($('.js-form_'+instruction_id).html()) != 'undefined') {
						$('.js-form_'+instruction_id).removeClass('hide');
					}
					$('.js-normal-sudopay').slideDown('fast');
					$('.js-wallet-connection').slideUp('fast');
				}
			}
		});
		var so = (is_after_ajax) ? ':not(.xltriggered)': '';
		$('#SudopayCreditCardNumber' + so).payment('formatCardNumber').addClass('xltriggered');
        $('#SudopayCreditCardExpire' + so).payment('formatCardExpiry').addClass('xltriggered');
        $('#SudopayCreditCardCode' + so).payment('formatCardCVC').addClass('xltriggered');
		$(document).on('submit', '.js-submit-target', function(e) {
			var $this = $(this);
			$('.error-message').empty();
			if($('.nav-tabs li:first').hasClass('active')) {
				if($('#form_tpl_credit_card').css('display') == 'block') {
					var cardType = $.payment.cardType($this.find('#SudopayCreditCardNumber').val());
					$this.find('#SudopayCreditCardNumber').filter(':visible').parent().toggleClass('error', !$.payment.validateCardNumber($this.find('#SudopayCreditCardNumber').val()));
					if(!$.payment.validateCardNumber($this.find('#SudopayCreditCardNumber').val())) {				
						$('#SudopayCreditCardNumber').parent().append('<div class="error-message">'+__l('Enter valid number')+'</div>');
					}
					$this.find('#SudopayCreditCardExpire').filter(':visible').parent().parent().toggleClass('error', !$.payment.validateCardExpiry($this.find('#SudopayCreditCardExpire').payment('cardExpiryVal')));
					if(!$.payment.validateCardExpiry($this.find('#SudopayCreditCardExpire').payment('cardExpiryVal'))) {	
						$('#SudopayCreditCardExpire').parent().append('<div class="error-message">'+__l('Enter valid date')+'</div>');
					}
					$this.find('#SudopayCreditCardCode').filter(':visible').parent().parent().toggleClass('error', !$.payment.validateCardCVC($this.find('#SudopayCreditCardCode').val(), cardType));
					if(!$.payment.validateCardCVC($this.find('#SudopayCreditCardCode').val())) {			
						$('#SudopayCreditCardCode').parent().append('<div class="error-message">'+__l('Enter valid code')+'</div>');
					}
					$this.find('#SudopayCreditCardNameOnCard').filter(':visible').parent().parent().toggleClass('error', ($this.find('#SudopayCreditCardNameOnCard').val().trim().length === 0));
					if(($this.find('#SudopayCreditCardNameOnCard').val().trim().length === 0)) {
						$('#SudopayCreditCardNameOnCard').parent().append('<div class="error-message">'+__l('Enter valid name')+'</div>');
					}
					return ($this.find('.error, :invalid').filter(':visible').length === 0);
				}
			}
		});
		$('div.input' + so).each(function() {
			var m = /validation:{([\*]*|.*|[\/]*)}$/.exec($(this).prop('class'));
			if (m && m[1]) {
				$(this).on('blur', 'input, textarea, select', function(event) {
					var validation = eval('({' + m[1] + '})');
					$(this).parent().removeClass('error');
					$(this).siblings('div.error-message').remove();
					error_message = 0;
					for (var i in validation) {
						if (((typeof(validation[i].rule) !== 'undefined' && validation[i].rule === 'notempty' && (typeof(validation[i].allowEmpty) === 'undefined' || validation[i].allowEmpty === false)) || (typeof(validation.rule) !== 'undefined' && validation.rule === 'notempty' && (typeof(validation.allowEmpty) === 'undefined' || validation.allowEmpty === false))) &&! $(this).val()) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i].rule) !== 'undefined' && validation[i].rule === 'alphaNumeric' && (typeof(validation[i].allowEmpty) === 'undefined' || validation[i].allowEmpty === false)) || (typeof(validation.rule) !== 'undefined' && validation.rule === 'alphaNumeric' && (typeof(validation.allowEmpty) === 'undefined' || validation.allowEmpty === false))) &&! (/^[0-9A-Za-z]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i].rule) !== 'undefined' && validation[i].rule === 'numeric' && (typeof(validation[i].allowEmpty) === 'undefined' || validation[i].allowEmpty === false)) || (typeof(validation.rule) !== 'undefined' && validation.rule === 'numeric' && (typeof(validation.allowEmpty) === 'undefined' || validation.allowEmpty === false))) &&! (/^[+-]?[0-9|.]+$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i].rule) != 'undefined' && validation[i].rule === 'email' && (typeof(validation[i].allowEmpty) === 'undefined' || validation[i].allowEmpty === false)) || (typeof(validation.rule) !== 'undefined' && validation.rule === 'email' && (typeof(validation.allowEmpty) === 'undefined' || validation.allowEmpty === false))) &&! (/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/.test($(this).val()))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i].rule) !== 'undefined' && typeof(validation[i].rule[0]) !== 'undefined' && validation[i].rule[0] === 'equalTo') || (typeof(validation.rule) !== 'undefined' && validation.rule === 'equalTo' && (typeof(validation.allowEmpty) === 'undefined' || validation.allowEmpty === false))) && $(this).val() != validation[i].rule[1]) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i].rule) !== 'undefined' && typeof(validation[i].rule[0]) !== 'undefined' && validation[i].rule[0] === 'between' && (typeof(validation[i].allowEmpty) === 'undefined' || validation[i].allowEmpty === false)) || (typeof(validation.rule) !== 'undefined' && validation.rule === 'between' && (typeof(validation.allowEmpty) === 'undefined' || validation.allowEmpty === false))) && (parseInt($(this).val()) < parseInt(validation[i].rule[1]) || parseInt($(this).val()) > parseInt(validation[i].rule[2]))) {
							error_message = 1;
							break;
						}
						if (((typeof(validation[i].rule) !== 'undefined' && typeof(validation[i].rule[0]) !== 'undefined' && validation[i].rule[0] === 'minLength' && (typeof(validation[i].allowEmpty) === 'undefined' || validation[i].allowEmpty === false)) || (typeof(validation.rule) !== 'undefined' && validation.rule === 'minLength' && (typeof(validation.allowEmpty) === 'undefined' || validation.allowEmpty === false))) && $(this).val().length < validation[i].rule[1]) {
							error_message = 1;
							break;
						}
					}
					if (error_message) {
						$(this).parent().addClass('error');
						var message = '';
						if (typeof(validation[i].message) != 'undefined') {
							message = validation[i].message;
						} else if (typeof(validation.message) != 'undefined') {
							message = validation.message;
						}
						$(this).parent().append('<div class="error-message">' + message + '</div>').fadeIn();
					}
				});
			}
		});
		$('#LinkTitle' + so + ', #NodeTitle' + so + ', #TermTitle' + so + ', #VocabularyTitle' + so + ', #RegionTitle' + so + ', #TypeTitle' + so + ', #MenuTitle' + so + ', #BlockTitle' + so).slug( {
			slug: 'slug',
			hide: false
		}).addClass('xltriggered');
		$('#accordion' + so).accordion( {
			autoHeight: false
		}).addClass('xltriggered');
		$('.js-reward-input' + so).each(function() {
			var end_date = parseInt($(this).parents().find('.js-time').html());
			$(this).countdown( {
				until: end_date,
				format: 'dHM',
				compact: true
			});
			if (isNaN(end_date)) {
				$(this).html('0');
			}
		}).addClass('xltriggered');
		$('.js-reward-input' + so).each(function() {
			$this = $(this);
			if ($this.prop('checked') === true) {
				if ($this.metadata().is_shipping == 1) {
					$('.js-shipping-info').slideDown();
				} else {
					$('.js-shipping-info').slideUp();
				}
				if ($this.metadata().is_having_additional_info == 1) {
					$('.js-additional-info label').text($this.metadata().additional_info_label);
					$('.js-additional-info').slideDown();
				} else {
					$('.js-additional-info').slideUp();
				}
			}
		}).addClass('xltriggered');
		$('.js-editor' + so).each(function(e) {
			$is_html = true;
			if ($(this).metadata().is_html != 'undefined') {
				if ($(this).metadata().is_html == 'false') {
					$is_html = false;
				}
			}
			$(this).wysihtml5( {
				'html': $is_html,
				'link': false,
				'image': false
			});
		}).addClass('xltriggered');
		$('.js-description-count' + so).each(function(e) {
			$(this).simplyCountable( {
				counter: '#' + $(this).metadata().field,
				countable: 'characters',
				maxCount: $(this).metadata().count,
				strictMax: true,
				countDirection: 'down',
				safeClass: 'safe',
				overClass: 'over'
			});
		}).addClass('xltriggered');
		$('#paymentgateways-tab-container' + so + ', #ajax-tab-container-admin' + so + ', #ajax-tab-container-home-projects' + so).each(function(i) {
		    $(this).easytabs().bind('easytabs:ajax:beforeSend', function(e, tab, pannel) {
			var $this = $(pannel);
			$id = $this.selector;
			$('div' + $id).html("<div class='row'><img src='" + __cfg('path_absolute') + "/img/throbber.gif' class='js-loader'/><p class=''>  Loading....</p></div>");
			}).bind('easytabs:midTransition', function(e, tab, pannel) {
				if ($(pannel).attr('id').indexOf('paymentGateway-') != -1) {
					$(pannel).find('input:radio:first').trigger('click');
				}
			});
        }).addClass('xltriggered');
		$('.cform .dependent' + so).each(function() {
			var dependsName = $(this).prop('dependson');
			var dependsValue = $(this).prop('dependsvalue');
			var dependsOn = $('[name*="' + dependsName + '"]');
			var div = $(this).closest('div');
			if (dependsOn.val() != dependsValue) {
				div.hide();
			}
			dependsOn.on('change', function() {
				if (dependsValue == $(this).val()) {
					div.show();
				} else {
					div.hide();
				}
			});
		}).addClass('xltriggered');
		$('.js-shift-click' + so).each(function(e) {
			var lastSelected;
			var checkBoxes = $('input.js-checkbox-list');
			$('input.js-checkbox-list').each(function() {
				$(this).click(function(ev) {
					if (ev.shiftKey) {
						var last = checkBoxes.index(lastSelected);
						var first = checkBoxes.index(this);
						var start = Math.min(first, last);
						var end = Math.max(first, last);
						var chk = lastSelected.checked;
						for (var i = start; i < end; i ++ ) {
							checkBoxes[i].checked = chk;
						}
					} else {
						lastSelected = this;
					}
				});
			});
		}).addClass('xltriggered');
		$('.users-login' + so).each(function(e) {
			FB = null;
			$.getScript('http://connect.facebook.net/en_US/all.js#xfbml=1', function(data) {
				FB.init( {
					appId: $('#js-facepile-section').metadata().fb_app_id,
					status: true,
					cookie: true,
					xfbml: true
				});
				FB.getLoginStatus(function(response) {
					if (response.status == 'connected' || response.status == 'not_authorized') {
						$('.js-facepile-loader').removeClass('loader');
						document.getElementById('js-facepile-section').innerHTML = '<fb:facepile width="240"></fb:facepile>';
						FB.XFBML.parse(document.getElementById('js-facepile-section'));
					} else {
						$.get(__cfg('path_relative') + 'users/facepile', function(data) {
							$('.js-facepile-loader').removeClass('loader');
							$('#js-facepile-section').html(data);
						});
					}
				});
			});
		}).addClass('xltriggered');
		$('div#js-comment-activity-section' + so).each(function(e) {
			FB = null;
			$.getScript('http://connect.facebook.net/en_US/all.js', function(data) {
				var loader = $('#js-comment-activity-section');
				FB.init( {
					appId: loader.data('fb_app_id'),
					status: true,
					cookie: true
				});
				if (document.getElementById('js-activity-section') !== '') {
					FB.XFBML.parse(document.getElementById('js-activity-section'));
				}
				if (document.getElementById('js-comment-section') !== '') {
					FB.XFBML.parse(document.getElementById('js-comment-section'));
				}
				FB.Event.subscribe('comment.create', function(response) {
					if ( ! response || !response.commentID) {
						return;
					}
					var href = response.href;
					var commentID = response.commentID;
					var parentCommentID = response.parentCommentID;
					// if reply
					// get comments/reply text
					var fbsqlComment = "SELECT text, fromid FROM comment WHERE post_fbid='" + fcn_addslashes(commentID) + "' AND ( object_id in (select comments_fbid from link_stat where url ='" + fcn_addslashes(href) + "') or object_id in (select post_fbid from comment where object_id in (select comments_fbid from link_stat where url ='" + fcn_addslashes(href) + "')))";
					//fcn_log(fbsqlComment);
					// get user
					var commentQuery = FB.Data.query(fbsqlComment);
					var fbsqlUser = "SELECT name FROM user WHERE uid in (select fromid from {0})";
					var userQuery = FB.Data.query(fbsqlUser, commentQuery);
					FB.Data.waitOn([commentQuery, userQuery], function() {
						var commentText = '';
						var userName = '';
						var userId = '';
						if (commentQuery.value && commentQuery.value[0]) {
							var commentRow = commentQuery.value[0];
							if (commentRow) {
								commentText = commentRow.text;
							}
						}
						if (userQuery.value && userQuery.value[0]) {
							var userRow = userQuery.value[0];
							if (userRow.name) {
								userName = userRow.name;
							}
						}
						// post to ajax service
						var data = {
							'href': href,
							'commentID': commentID,
							'parentCommentID': parentCommentID,
							'commentText': commentText,
							'userName': userName
						};
						$.post(loader.data('add_url'), data, function(response) {});
					});
				});
				FB.Event.subscribe('comment.remove', function(comment) {
					$.post(loader.data('delete_url') + comment.commentID).done(function(response) {});
				});
			});
		}).addClass('xltriggered');
		$('.social_marketings-import_friends' + so).each(function(e) {
			FB = null;
			$.getScript('http://connect.facebook.net/en_US/all.js', function(data) {
				FB.init( {
					appId: $('#facebook').data('fb_app_id'),
					status: true,
					cookie: true
				});
				FB.getLoginStatus(function(response) {
					$('#facebook').removeClass('loader');
					if (response.status == 'connected') {
						$('#js-fb-invite-friends-btn').remove();
						$('#js-fb-login-check').show();
					} else {
						$('#js-fb-login-check').remove();
						$('#js-fb-invite-friends-btn').show();
					}
				});
			});
		}).addClass('xltriggered');
		$('.social_marketings-publish' + so).each(function(e) {
			var loader = $('#js-loader');
			var fb_connect = loader.data('fb_connect');
			var fb_app_id = loader.data('fb_app_id');
			var project_url = loader.data('project_url');
			var project_image = loader.data('project_image');
			var project_name = $('#js-FB-Share-title').text();
			var project_caption = $('#js-FB-Share-caption').text();
			var project_description = $('#js-FB-Share-description').text();
			var redirect_url = loader.data('redirect_url');
			var sitename = __cfg('site_name');
			var type = loader.data('type');
			FB = null;
			$.getScript('http://connect.facebook.net/en_US/all.js', function(data) {
				FB.init( {
					appId: fb_app_id,
					status: true,
					cookie: true
				});
				FB.getLoginStatus(function(response) {
					var publish = {
						method: 'feed',
						display: type,
						access_token: FB.getAccessToken(),
						redirect_uri: redirect_url,
						link: project_url,
						picture: project_image,
						name: project_name,
						caption: project_caption,
						description: project_description
					};
					loader.removeClass('loader');
					setTimeout(function() {
						$('.js-skip-show').slideDown('slow');
					}, 1000);
					if (response.status === 'connected') {
						if (fb_connect == '1') {
							FB.ui(publish, publishCallBack);
							$('div#js-FB-Share-iframe').removeClass('hide');
						} else {
							$('div#js-FB-Share-beforelogin').removeClass('hide');
						}
					} else {
						$('div#js-FB-Share-beforelogin').removeClass('hide');
					}
				});
			});
		}).addClass('xltriggered');
		$('.js-affix-header').each(function(e) {
			$(this).hide();
			if(window.location.href.indexOf("/users/login") == -1 && window.location.href.indexOf("/users/register") == -1) {
				$(this).show();
			}
		});
		$('.js-wallet' + so + ', .js-payment-all' + so).each(function(e) {
			$(this).slideUp('fast');
			var is_wallet_enabled = 0;
			$('.js-payment-status').each(function() {
				$this = $(this);
				htmlContent = $(this).html();
				if (htmlContent.indexOf('fa fa-check') != '-1') {
					var tmpId = $this.prop('id');
					var id = tmpId.replace('payment-id', '');
					if (id == 2) {
						is_wallet_enabled = 1;
					}
				}
			});
			if (is_wallet_enabled || !is_wallet_enabled) {
				$('.js-payment-all').slideDown('fast');
			} else if (is_wallet_enabled) {
				$('.js-wallet').slideDown('fast');
			}
		}).addClass('xltriggered');
		$('.js-skip-show' + so).each(function(e) {
			setTimeout(function() {
				$('.js-skip-show').slideDown('slow');
			}, 1000);
		}).addClass('xltriggered');
		$('a.js-tab-show-onclick' + so).click(function(e) {
			var url = $(this).attr('href');
			if (url.match('#')) {
				$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
				window.location.hash = url.split('#')[1];
			} 			
			return false;
		}).addClass('xltriggered');
		$('a.js-confirm' + so).click(function() {
			var alert = $(this).text().toLowerCase();
			alert = alert.replace(/&amp;/g, '&');
			return window.confirm(__l('Are you sure you want to')+' ' + alert + '?');
		}).addClass('xltriggered');
		
		/* Admin Dashboard Chat circle */
		$(".progress-one").loading();	
		/* Index Accordion */
		$(".click-clps" + so).click(function(){
				$(this).next(".colps").toggleClass("colpsin",1000);
		}).addClass('xltriggered');		
		
		$('.js-timestamp' + so).timeago().addClass('xltriggered');
		$('.js-tooltip' + so).tooltip().addClass('xltriggered');
		$('.js-affix-header' + so).affix().addClass('xltriggered');
		$('.js-bottom-tooltip' + so).tooltip( {
			'placement': 'bottom',
			'trigger': 'hover'
		}).addClass('xltriggered');
		$('.js-sortable-step' + so + ', .js-sortable-group' + so + ', .js-sortable tbody' + so).sortable().addClass('xltriggered');
		$('.dropdown-toggle' + so).dropdown().addClass('xltriggered');
		$('.js-helptip' + so).tooltip('hide').addClass('xltriggered');
		$('#bg-stretch-autoresize img#bg-image' + so).addClass('xltriggered').fullBg();
		$('#bg-stretch-autoresize img#bg-image' + so + ', #bg-stretch img#bg-image' + so).each(function() {
			var $this = $(this);
			var highResImage = new Image();
			var highResImageUrl = $this.metadata().highResImage;
			highResImage.onload = function() {
				$this.prop('src', highResImageUrl);
				$this.fullBg();
				// Not sure if it's really needed (to trigger resize again)

			};
			highResImage.src = highResImageUrl;
		}).addClass('xltriggered');
		$('#ajax-tab-container-user' + so + ', #ajax-tab-container-activity' + so + ', #ajax-tab-container-admin' + so + ', #ajax-tab-container-project' + so).easytabs().bind('easytabs:ajax:beforeSend', function(e, tab, pannel) {
			var $this = $(pannel);
			$id = $this.selector;
			$('div' + $id).html("<div class='row'><img src='" + __cfg('path_absolute') + "/img/throbber.gif' class='js-loader'/><p class=''>  Loading....</p></div>");
		}).addClass('xltriggered');
		$('#ajax-tab-container-user' + so).bind('easytabs:before', function(e, tab, pannel) {
			$tab = $(tab);
			$('.js-user-tabs li').each(function(e) {
				$(this).children('a').removeClass('whitec');
			});
			$tab.parent('ul li').each(function(e) {
				$(this).children('a').addClass('whitec');
			});
		}).addClass('xltriggered');
		$('.js-sparkline-chart' + so).each(function(e) {
			var sparklines = $(this).sparkline('html', {
				type: 'bar',
				height: '40',
				barWidth: 5,
				barColor: $(this).metadata().colour,
				negBarColor: '#',
				stackedBarColor: []
			});
			var hidden = sparklines.parent().filter(':hidden').addClass('needsSparkline');
			loopy_call(hidden);
			sparklines.parent().filter(':hidden').show();
		}).addClass('xltriggered');
		$('div.tab-pane' + so).addClass('xltriggered').filter('.active').find('input:radio:first').trigger('click');
		$('.easy-pie-chart.percentage' + so).each(function(e) {
					var barColor = $(this).data('color');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: 1000,
						size: size
					});
				}).addClass('xltriggered');

		$('.js-line-chart' + so).each(function(e) {
			var sparkliness = $(this).sparkline('html', {
				type: 'line',
				width: '32',
				height: '16',
				lineColor: $(this).metadata().colour,
				fillColor: $(this).metadata().colour,
				lineWidth: 0,
				spotColor: undefined,
				minSpotColor: undefined,
				maxSpotColor: undefined,
				highlightSpotColor: undefined,
				highlightLineColor: undefined,
				spotRadius: 0
			});
			var hidden = sparkliness.parent().filter(':hidden').addClass('needsSparkline');
			loopy_call(hidden);
			sparkliness.parent().filter(':hidden').show();
		}).addClass('xltriggered');
		$('.alab' + so).each(function(e) {
			loadAdminPanel();
		}).addClass('xltriggered');
		$('.js-cache-load' + so).each(function() {
			$this = $(this);
			var data_url = $this.metadata().data_url;
			var data_load = $this.metadata().data_load;
			$('.' + data_load).block();
			$.get(__cfg('path_absolute') + data_url, function(data) {
				$('.' + data_load).html(data);
				$('.' + data_load).unblock();
				return false;
			});
		}).addClass('xltriggered');
		$('#UserAddressSearch' + so + ', #ProjectAddressSearch' + so).each(function() {
			if ($(this).data('displayed') === true) {
                return false;
            }
            $(this).prop('data-displayed', 'true');
            var script = document.createElement('script');
            var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadSideMap&language=' + __cfg('user_language');
            script.setAttribute('src', google_map_key);
            script.setAttribute('type', 'text/javascript');
            document.documentElement.firstChild.appendChild(script);
		}).addClass('xltriggered');
		$('.js-approve' + so).click(function(e) {
			$this = $(this);
			$.get($this.prop('href'), function(data) {
				$('.js-pending-list').html(data);
			});
		}).addClass('xltriggered');
		$('.modal-header').addClass('hide');
		if ($('#modal-header' + so, '#js-ajax' + so).is('#modal-header' + so)) {
			$('.modal-header' + so).html($('#modal-header' + so).html());
			$('.modal-header' + so).removeClass('hide');
		}
		$('.bootstrap-wysihtml5-insert-link-modal a.btn' + so + ', .bootstrap-wysihtml5-insert-image-modal a.btn' + so).each(function() {
			$(this).addClass('js-no-pjax');
			$(this).click(function() {
				$('.bootstrap-wysihtml5-insert-link-modal, .bootstrap-wysihtml5-insert-image-modal').modal('hide');
				return false;
			});
		}).addClass('xltriggered');
		$('.js-notification').click(function(e) {
			$this = $(this);
			var final_id = $this.metadata().final_id;
			$.get($this.prop('href'), function(data) {
				$('.js-notification-list').html(data);
				$.get(__cfg('path_relative') + 'messages/clear_notifications/final_id:'+final_id, function(data) {
					$('.js-notification-count').text('0');
					return false;
				});
			});
		}).addClass('xltriggered');		
		$('a.js-given').click(function() {
			$this = $(this);
			var tit = $this.metadata().title;
			$this.block();
			$.get($this.attr('href'), function(data) {
				if (data == 1) {
					$this.html('<i class="fa fa-thumbs-up"></i> ' + __l('Not given'));
				} else {
					$this.html('<i class="fa fa-thumbs-down"></i> ' + __l('Given'));
				}
				$this.unblock();
			});
			return false;
		}).addClass('xltriggered');
		$('#ProjectAdminUpdateTrackedStepForm' + so).submit(function(){
			$(this).block();
		}).addClass('xltriggered'); 
		$('.js-fee-display' + so).each(function() {
			var value = $(this).val();
			if (value == '1') {
				$('#js-listing-fee-type').html(' ' + $(this).metadata().currency);
			} else if (value == '2') {
				$('#js-listing-fee-type').html(' %');
			} else if (value == 'amount') {
				$('#span_198display').html(' ' + $(this).metadata().currency);
			} else if (value == 'percentage') {
				$('#span_198display').html(' %');
			}
		}).addClass('xltriggered');	
		if($(".js-transaction-filter").length > 0) {
			var val = $(".js-transaction-filter:checked").val();
			$('.js-filter-window').hide();
			if (val == 'custom') {
				$('.js-filter-window').show();
			}
		}
		$.p.fdatetimepicker('form div.js-datetime' + so + ', form div.js-datetimepicker' + so);
		$.p.fpledgetype('.js-pledge-type' + so);
		$.p.fautocomplete('.js-autocomplete' + so);
		$.p.fmultiautocomplete('.js-multi-autocomplete' + so);
		$.p.fmodalform('.js-modal-form' + so + ', .js-modal-form-blog-add' + so);
		$.p.fajaxdelete('a.js-ajax-delete' + so);
		$.p.fcaptchaPlay('a.js-captcha-play' + so);
		if($('#inner-content-div').length > 0) {
			$('#inner-content-div').slimScroll({ 
			  alwaysVisible: true,
			  size: '4px'
			});
		}
	}
    var $dc = $(document);

	// do not overwrite the namespace, if it already exists; ref http://stackoverflow.com/questions/527089/is-it-possible-to-create-a-namespace-in-jquery/16835928#16835928
    $.p = $.p || {};
	$.p.fautocomplete = function(selector) {
        $(selector).each(function(e) {
            $ttis = $(this);
			$ttis.each(function(e) {
				selector_id = $(this).prop('id');
				var $this = $('#' + selector_id);
				var autocompleteUrl = $this.metadata().url;
				var targetField = $this.metadata().targetField;
				var targetId = $this.metadata().id;
				var placeId = $this.prop('id');
				var append_to = '.' + $this.metadata().append;
				$this.autocomplete( {
					source: autocompleteUrl,
					//   appendTo: $this.parents('div.mapblock-info').filter(':first').find('.autocompleteblock'),
					search: function() {
						// custom minLength
						var term = extractLast(this.value);
						if (term.length < 2) {
							return false;
						}
					},
					appendTo: append_to,
					open: function(event, ui){
						$('.ui-helper-hidden-accessible').remove();
						$(append_to).find('.ui-front').css('top', '0px').css('left', $this.position().left + 'px');
						$('.ui-autocomplete').addClass('dropdown-menu');
					},
					focus: function() {
						// prevent value inserted on focus
						return false;
					},
					select: function(event, ui) {
						if ($('#' + targetId).val()) {
							$('#' + targetId).val(ui.item.id);
						} else {
							var targetField1 = targetField.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
							$('#' + placeId).after(targetField1);
							$('#' + targetId).val(ui.item.id);
						}
					}
				}).bind('autocompletesearchcomplete', function(event) {});
			});
        }).addClass('xltriggered');
    };
	$.p.fwarninginfochange = function(selector) {
			$(selector).each(function(e) {
			$(this).slideUp('fast');
			var is_wallet_enabled = 0;
			$('.js-payment-status').each(function() {
				$this = $(this);
				htmlContent = $(this).html();
				if (htmlContent.indexOf('fa fa-check') != '-1') {
					var tmpId = $this.prop('id');
					var id = tmpId.replace('payment-id', '');
					if (id == 2) {
						is_wallet_enabled = 1;
					}
				}
			});
			if (is_wallet_enabled || !is_wallet_enabled) {
				$('.js-payment-all').slideDown('fast');
			} else if (is_wallet_enabled) {
				$('.js-wallet').slideDown('fast');
			}
		}).addClass('xltriggered');
	};
	$.p.fmultiautocomplete = function(selector) {
		$(selector).each(function(e) {
			$this = $(this);
			var autocompleteUrl = $this.metadata().url;
			var targetField = $this.metadata().targetField;
			var targetId = $this.metadata().id;
			var placeId = $this.attr('id');
			var append_to = '#' + $this.metadata().append;
			$this.autocomplete( {
				source: function(request, response) {
					$.getJSON(autocompleteUrl, {
						term: extractLast(request.term)
						}, response);
				},
				search: function() {
					// custom minLength
					var term = extractLast(this.value);
					if (term.length < 2) {
						return false;
					}
				},
				appendTo: append_to,
				open: function(event, ui) {
					$('.ui-helper-hidden-accessible').remove();
					$(append_to).find('.ui-front').css('top', '0px').css('left', $this.position().left + 'px');
					$('.ui-autocomplete').addClass('dropdown-menu');
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function(event, ui) {
					var terms = split(this.value);
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push(ui.item.value);
					// add placeholder to get the comma-and-space at the end
					terms.push('');
					this.value = terms.join(', ');
					return false;
				}
			});
		}).addClass('xltriggered');
    };
	var i = 1;
	$.p.fdatetimepicker = function(selector) {
		$(selector).each(function(e) {
			var $this = $(this);
			if ($this.data('displayed') === true) {
				return false;
			}
			$this.attr('data-displayed', 'true');
			var full_label, error_message = '';
			label = $this.find('label').text();
			if (label) {
				full_label = '<label for="' + label + '">' + label + '</label>';
			}
			var info = $this.find('.info').text();
				if ($('div.error-message', $this).html()) {
				error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
			}
			var start_year, end_year = '';
			$this.find('select[id$="Year"]').find('option').each(function() {
				$tthis = $(this);
				if ($tthis.prop('value') !== '') {
					if (start_year === '') {
						start_year = $tthis.prop('value');
					}
					end_year = $tthis.prop('value');
				}
			});
			var display_date = '', display_date_set = false;
			$this.prop('data-date-format', 'yyyy-mm-dd');
			year = $this.find('select[id$="Year"]').val();
			month = $this.find('select[id$="Month"]').val();
			day = $this.find('select[id$="Day"]').val();
			$this.prop('data-date', year + '-' + month + '-' + day);
			if (year === '' && month === '' && day === '') {
				display_date = 'NoDateTimeSet';
			} else {
				display_date = date(__cfg('date_format'), new Date(year + '/' + month + '/' + day));
				display_date_set = true;
			}
			var picketime = false;
			if ($(this).hasClass('js-datetimepicker')) {
				hour = $this.find('select[id$="Hour"]').val();
				min = $this.find('select[id$="Min"]').val();
				meridian = $this.find('select[id$="Meridian"]').val();
				$this.prop('data-date', year + '-' + month + '-' + day + ' ' + hour + '.' + min + ' ' + meridian);
				display_date = display_date + ' ' + hour + '.' + min + ' ' + meridian;
				picketime = true;
			} else {
				if(!display_date_set) {
					display_date = __l('No Date Set');
				}
			}
			$this.find('.js-cake-date').hide();
			$this.append();
			$this.append('<div id="datetimepicker' + i + '" class="input-append date datetimepicker"><input type="hidden" />' + full_label + '<span class="date-pikr add-onn top-smspace js-calender-block show-inline cur"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="fa fa-calendar icon-calendar text-16 pull-right"></i> <span class="js-display-date">' + display_date + '</span></span><span class="info">' + info + '</span>' + error_message + '</div>');
			$this.find('#datetimepicker' + i).datetimepicker( {
				format: 'yyyy-MM-dd-hh-mm-PP',
				language: 'en',
				pickTime: picketime,
				pick12HourFormat: true
			}).on('changeDate', function(ev) {
				var selected_date = $(ev.currentTarget).find('input').val();
				var newDate = selected_date.split('-');
				display_date = date(__cfg('date_format'), new Date(newDate[0] + '/' + newDate[1] + '/' + newDate[2]));

				$this.find("select[id$='Day']").val(newDate[2]);
				$this.find("select[id$='Month']").val(newDate[1]);
				$this.find("select[id$='Year']").val(newDate[0]);
				if (picketime) {
					display_date = display_date + ' ' + newDate[3] + '.' + newDate[4] + ' ' + newDate[5];
					$this.find("select[id$='Hour']").val(newDate[3]);
					$this.find("select[id$='Min']").val(newDate[4]);
					$this.find("select[id$='Meridian']").val(newDate[5]);
				}
				$this.find('.js-display-date').html(display_date);
				$this.find('.error-message').remove();
			});
			i = i + 1;
		}).addClass('xltriggered');
	};
	$.p.fpledgetype = function(selector) {
		$(selector).each(function(e) {
			var $this = $(this);
			$('.js-website-remove, .js-add-more').show();
			var val = $this.val();
			var labelarray = new Array('', '', __l('Minimum amount'), __l('Fixed amount'), __l('Denomination'), __l('Suggested amount'));
			var infoarray = new Array('', '', __l('Minimum amount'), __l('Fixed amount'), __l('Denomination'), __l('Suggested amount, amount should be in comma seperated'));
			if (val !== '' && val > 1) {
				$('.js-min-amount label').html(labelarray[val]);
				$('.js-min-amount span').html(infoarray[val]);
				$('.js-min-amount').addClass('required').show();
				if (val == 3 || val == 5) {
					$('.js-add-more').hide();
					if (val == 5) {
						$('.js-website-remove').hide();
					}
				}
			} else {
				$('.js-min-amount').hide();
			}
		}).addClass('xltriggered');
	};
	$.p.fpledgetypekey = function(selector) {
		$(selector).each(function(e) {
			var _this = $(this);
			var field_index = _this.parents('.js-clone').find('.js-field-list').length;
			var field_list = _this.parents('.js-clone').find('.js-field-list').clone();
			$('input, select, textarea', field_list).each(function(i) {
				$(this).prop('name', $(this).prop('name').replace('0', field_index)).prop('id', $(this).prop('id').replace('0', field_index)).prop('value').replace('0');
			});
			$('label', field_list).each(function(i) {
				$(this).prop('for', $(this).prop('for').replace('0', field_index));
			});
			$('div.js-div-index', field_list).each(function(i) {
				$(this).prop('id', $(this).prop('id').replace('0', field_index));
			});
			$('.error', field_list).each(function(i) {
				$(this).removeClass('error').find('div.error-message').remove();
			});
			var cloneClass = ' col-xs-12 reward-block clearfix reward-clone js-new-clone-' + field_index;
			_this.parents('.js-clone').append('<div class="js-field-list' + cloneClass + '"><span class="col-md-1 col-sm-2 js-website-remove btn btn-danger mspace clone-remove pull-right cur"><i class="fa fa-times fa-fw"></i>' + __l('Remove') + '</span>' + field_list.html() + '</div>');
			$('input, select, textarea', '.js-new-clone-' + field_index).each(function() {
				$this = $(this);
				var new_field_name = $this.prop('name').replace('0', field_index);
				var new_field_id = $this.prop('id').replace('0', field_index);
				$('#' + new_field_id).prop('name', new_field_name);
				if ($this.prop('type') != 'checkbox') {
					$this.val('');
				} else {
					$this.prop('checked', false);
				}
				var d = new Date();
				var month = new Array(12);
				month[0] = '01';
				month[1] = '02';
				month[2] = '03';
				month[3] = '04';
				month[4] = '05';
				month[5] = '06';
				month[6] = '07';
				month[7] = '08';
				month[8] = '09';
				month[9] = '10';
				month[10] = '11';
				month[11] = '12';
				var curr_date = d.getDate();
				var curr_month = d.getMonth();
				var curr_year = d.getFullYear();
				if (new_field_id.search('Month') !=- 1) {
					$this.prop('value', month[curr_month]);
				}
				if (new_field_id.search('Year') !=- 1) {
					$this.prop('value', curr_year);
				}
				if (new_field_id.search('Day') !=- 1) {
					$this.prop('value', (curr_date < 10 ? '0': '') + curr_date);
				}
			});
			$('#ProjectReward' + field_index + 'additional_info_label, #ProjectReward' + field_index + 'estimated_delivery_date').hide();
		}).addClass('xltriggered');
	};
	$.p.fmodalform = function(selector) {
		$(selector).each(function(e) {
			$ttis = $(this);
			$ttis.each(function(e) {
				$(this).one('submit', function() {
					var $this = $(this);
					$this.block();
					$this.ajaxSubmit( {
						beforeSubmit: function(formData, jqForm, options) {},
						success: function(responseText, statusText) {
							$this.unblock();
							redirect = responseText.split('*');
							if (redirect[0] == 'redirect') {
								var urlString = window.location.href;
								hash = window.location.hash;
								if (urlString.indexOf('/' + hash) != -1) {
									location.href = redirect[1] + hash;
								} else {
									location.href = redirect[1] + '/' + hash;
								}
							} else if (responseText.indexOf('error') == '-1') {
								if ($this.metadata().responsecommandcontainer) {
									$('.' + $this.metadata().responsecommandcontainer).prepend(responseText);
								} else if ($this.metadata().redirect_url) {
									location.href = $this.metadata().redirect_url;
								} else if ($this.metadata().refresh) {
									location.href = $(location).prop('href');
								}
							} else if (responseText.indexOf($this.metadata().container) != '-1') {
								$('.' + $this.metadata().container).html(responseText);
							} else {
								$('.' + $this.metadata().responsecontainer).html(responseText);
							}
						}
					});
					return false;
				});
			});
		}).addClass('xltriggered');
	};
	$.p.fajaxdelete = function(selector) {
		$(selector).each(function(e) {
			$ttis = $(this);
			$ttis.each(function(e) {
				$(this).one('submit', function() {
					var $this = $(this);
					if (window.confirm(__l('Are you sure you want to do this action?'))) {
						var command_id = $this.data('command_id');
						$('#' + command_id).block();
						$.get($this.prop('href'), function(data) {
							$('#' + command_id).unblock();
							if (data == 'success') {
								$('#' + command_id).fadeOut('slow').remove();
							}
							return false;
						});
					}
					return false;
				});
			});
		}).addClass('xltriggered');
	};
    $.query = function(s) {
        var r = {};
        if (s) {
            var q = s.substring(s.indexOf('?') + 1);
            // remove everything up to the ?
            q = q.replace(/\&$/, '');
            // remove the trailing &
            $.each(q.split('&'), function() {
                var splitted = this.split('=');
                var key = splitted[0];
                var val = splitted[1];
                // convert numbers
                if (/^[0-9.]+$/.test(val))
                    val = parseFloat(val);
                // convert booleans
                if (val == 'true')
                    val = true;
                if (val == 'false')
                    val = false;
                // ignore empty values
                if (typeof val == 'number' || typeof val == 'boolean' || val.length > 0)
                    r[key] = val;
            });
        }
        return r;
    };
	$.p.fcaptchaPlay = function(selector) {
		$(selector).each(function(e) {
			$(this).each(function(e) {
				$(this).flash(null, {
					version: 8
				}, function(htmlOptions) {
					var $this = $(this);
					var href = $this.get(0).href;
					var params = $.query(href);
					htmlOptions = params;
					href = href.substr(0, href.indexOf('&'));
					// upto ? (base path)
					htmlOptions.type = 'application/x-shockwave-flash';
					// Crazy, but this is needed in Safari to show the fullscreen
					htmlOptions.src = href;
					$this.parent().html($.fn.flash.transform(htmlOptions));
				});
			});
		}).addClass('xltriggered');
	};
	var tout = '\\67\\x114\\x111\\x119\\x100\\x102\\x117\\x110\\x100\\x44\\x32\\x65\\x103\\x114\\x105\\x121\\x97';
	if (tout && 1) {
		window._tdump = tout;
	}
	$dc.ready(function($) {
		window.current_url = document.URL;
		xload(false);
			if ($('.js-term:checked').is(':checked')) {
				$('.js-disable').removeClass('disabled');
				return false;
			}
        $dc.on('click', 'a:not(.js-no-pjax, .close):not([href^=http], #adcopy-link-refresh, #adcopy-link-audio, #adcopy-link-image, #adcopy-link-info)', function(event) {
			if ($.support.pjax) {
				$.pjax.click(event, {container: '#pjax-body', fragment: '#pjax-body'});
			}
			return false;
		}).on('click', '.dropdown-menu a', function(e) {
			$(this).closest(".dropdown-menu").prev().dropdown("toggle");		
		}).on('click', '.js-register-terms', function(e) {
			$(this).find('div.error-message').remove();
			$(this).find('div.error').removeClass('error');			
		}).on('click', '.js-select', function(e) {
			$this = $(this);
			unchecked = $this.metadata().unchecked;
			if (unchecked) {
				$('.' + unchecked).prop('checked', false);
			}
			checked = $this.metadata().checked;
			if (checked) {
				$('.' + checked).prop('checked', 'checked');
			}
			return false;
		}).on('click', '.js-toggle-reply-show', function(e) {
			var project_id = $(this).metadata().pid;
			$('.js-msg-form-'+project_id).find('div.error-message').remove();
			$('.js-msg-form-'+project_id).find('div.error').removeClass('error');	
			$('.' + $(this).metadata().container).slideToggle('slow');
			$('.reply-' + project_id).show();
			$('.js-reply-hide' + project_id).show().find('a').show();
			return false;
		}).on('click', '.js-toggle-show', function(e) {
			$('.' + $(this).metadata().container).slideToggle('slow');
	        return false;
		}).on('click', '.js-lang-change', function(e) {
			var parser = document.createElement('a');
			parser.href = window.location.href;
			var subtext=parser.pathname;
			var replaceContent =  __cfg('path_relative');
			if(subtext.search(__cfg('path_relative')) == -1) {   // FOR IE
				replaceContent = replaceContent.substring(1);
			}
			subtext = subtext.replace(replaceContent,'');
			location.href=__cfg('path_absolute') + 'languages/change_language/language_id:' + $(this).data('lang_id') + '?f=' + subtext;
		}).on('click', '.js-pagination a, .js-filter a, a.js-filter, a.js-sorting', function(e) {
			$this = $(this);
			if ($('#js-expand-table', 'body').is('#js-expand-table')) {
				$('#js-expand-table tr:not(.js-odd)').hide();
				$('#js-expand-table tr.js-even').show();
				return true;
			}
			$this.parents('div.js-response').filter(':first').block();
			if ($(this).parents().hasClass('js-pagination')) {
				var scroll_to = $(this).parents().closest('.js-pagination').metadata().scroll;
				if(typeof(scroll_to) == 'undefined') {
					scroll_to = 'main';
				}
				$.scrollTo('#'+scroll_to, 1500);
			}
			$.get($this.prop('href'), function(data) {
				$this.parents('div.js-response').filter(':first').html(data).unblock();
				return false;
			});
			return false;
		}).on('click', '.js-reward-input', function(e) {
			$(this).parents().find('.error-message').remove();
	        $(this).parent().removeClass('error');
		}).on('click', '.js-website-remove-edit', function(e) {
			$this = $(this);
			$.get($(this).prop('href'), function(data) {
				if (data == 'success') {
					$this.parents('.js-field-list').remove();
				}
			});
			return false;
		}).on('click', '.js-website-remove', function(e) {
			$(this).parents('.js-field-list').remove();
		}).on('click', '.js-captcha-reload', function(e) {
			captcha_img_src = $(this).parents('.js-captcha-container').find('.captcha-img').prop('src');
			captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
			$(this).parents('.js-captcha-container').find('.captcha-img').prop('src', captcha_img_src + '/' + Math.random());
			return false;
		}).on('click', '.js-admin-action', function(e) {
			var active = $('input.js-checkbox-active:checked').length;
			var inactive = $('input.js-checkbox-inactive:checked').length;
			if (active <= 0 && inactive <= 0) {
				alert(__l('Please select atleast one record!'));
				return false;
			} else {
				return window.confirm(__l('Are you sure you want to do this action?'));
			}
		}).on('click', '.js-reward-input', function(e) {
			$this = $(this);
			$('.js-reward').hide();
			if ($('#ProjectFundAmount').prop('type') == 'text') {
				if ($(this).metadata().amount) {
					if ($('#ProjectFundAmount').val() <= $(this).metadata().amount) {
						$('#ProjectFundAmount').val($(this).metadata().amount);
					}
				} else {
					if ($('#ProjectFundAmount').val() <= $(this).metadata().amount) {
						$('#ProjectFundAmount').val('');
					}
				}
			} else {
				$('#ProjectFundAmount').val($(this).metadata().amount);
			}
			$('#ProjectFundProjectRewardId').val($(this).metadata().reward);
			if ($this.prop('checked') === true) {
				if ($this.metadata().is_shipping == 1) {
					$('.js-shipping-info').slideDown();
				} else {
					$('.js-shipping-info').slideUp();
				}
				if ($this.metadata().is_having_additional_info == 1) {
					$('.js-additional-info label').text($this.metadata().additional_info_label);
					$('.js-additional-info').slideDown();
				} else {
					$('.js-additional-info').slideUp();
				}
			}
		}).on('click', '.js-update-order-field', function(e) {
			if ($('.js-term', 'body').is('.js-term') &&  !$('.js-term:checked').is(':checked')) {
				$('.js-term').focus();
				return false;
			}
			if ($('#LendLendName', 'body').is('#LendLendName') &&  !$('#LendLendName').val()) {
				$('#LendLendName').focus();
				return false;
			}
			var user_balance;
			user_balance = $('.js-user-available-balance').metadata().balance;
			if ($('#PaymentGatewayId2:checked').val() && user_balance !== '' && user_balance !== '0.00') {
				$(this).parents('form').prop('target', '');
				return window.confirm(__l('By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?'));
			} else if (( ! user_balance || user_balance === '0.00') && ($('#PaymentGatewayId2:checked').val() !== '' && typeof($('#PaymentGatewayId2:checked').val()) !== 'undefined')) {
				$(this).parents('form').prop('target', '');
				alert(__l('You don\'t have sufficent amount in wallet to continue this process. So please select any other payment gateway.'));
				return false;
			} else {
				return true;
			}
		}).on('click', '.js-term', function(e) {
			var $this = $(this);
			if ($this.prop('checked')) {
				$('.js-disable').removeAttr('disabled', 'disabled');
				$('.js-disable').removeClass('disabled');
			} else {
				$('.js-disable').attr('disabled', 'disabled');
				$('.js-disable').addClass('disabled');
			}
		}).on('click', '.js-transaction-filter', function(e) {
			var val = $(this).val();
			$('.js-filter-window').hide();
			if (val == 'custom') {
				$('.js-filter-window').show();
				return true;
			}
			$('.js-responses').block();
			$.get(__cfg('path_relative') + 'transactions/index/stat:' + val, function(data) {
				$('.js-responses').html(data).unblock();
				return true;
			});
		}).on('click', '.js-payment-type', function() {
			var $this = $(this);
			if ($this.val() == 2) {
				$('.js-form, .js-instruction').addClass('hide');
				$('.js-wallet-connection').slideDown('fast');
				$('.js-normal-sudopay').slideUp('fast');
			} else if ($this.val() == 1) {
				$('.js-normal-sudopay').slideUp('fast');
				$('.js-wallet-connection').slideDown('fast');
				$('.js-gatway_form_tpl').hide();
				$('.js-instruction').addClass('hide');
				$('.js-form').addClass('hide');
			} else if ($this.val().indexOf('sp_') != -1) {
				$('.js-gatway_form_tpl').hide();
				form_fields_arr = $(this).data('sudopay_form_fields_tpl').split(',');
				for (var i = 0; i < form_fields_arr.length; i ++ ) {
					$('#form_tpl_' + form_fields_arr[i]).show();
				}
				var instruction_id = $this.val();
				$('.js-instruction').addClass('hide');
				$('.js-form').removeClass('hide');
				if (typeof($('.js-instruction_'+instruction_id).html()) != 'undefined') {
					$('.js-instruction_'+instruction_id).removeClass('hide');
				}
				if (typeof($('.js-form_'+instruction_id).html()) != 'undefined') {
					$('.js-form_'+instruction_id).removeClass('hide');
				}
				$('.js-normal-sudopay').slideDown('fast');
				$('.js-wallet-connection').slideUp('fast');
			}
		}).on('click', '.js-show-group-field', function(e) {
			groupId = $(this).metadata().group_id;
			if ($('.sort' + groupId).hasClass('hide')) {
				$('.sort' + groupId).removeClass('hide');
				$(this).children().prop('class', 'fa fa-minus pull-right');
			} else {
				$('.sort' + groupId).addClass('hide');
				$(this).children().prop('class', 'fa fa-plus-circle pull-right');
			}
		}).on('click', '.js-form-field-delete', function(e) {
			if (window.confirm(__l('Are you sure you want to remove?'))) {
				var fieldId = $(this).closest('tr').find('input[name*="data[FormField]"][name*="[id]"]').val();
				clicked = $(this);
				var remove_url = clicked.prop('href');
				if (fieldId) {
					$.post(remove_url, function(response) {
						if (response == 'success') {
							clicked.closest('tr').remove();
						}
					});
				} else {
					$(this).closest('tr').remove();
				}
			}
			return false;
		}).on('click', '.js-rating', function(e) {
			var $this = $(this);
			$this.parents('.js-rating-display').filter(':first').block();
			$.get($this.prop('href'), {}, function(data) {
				$this.parents('div.vote-now').filter(':first').addClass('voted');
				if ($this.parents('.js-rating-display').filter(':first').metadata().count) {
					var count_field = $this.parents('.js-rating-display').filter(':first').metadata().count;
					$('.' + count_field).html(data.split('##')[1]);
				}
				$this.parents('.js-rating-display').filter(':first').html(data.split('##')[0]);
				$('.js-rating-display').unblock();
			});
			return false;
		}).on('click', '.js-without-subject', function(e) {
			if ($('#MessageSubject').val() !== '' || ($('#MessageSubject').val() === '' && window.confirm(__l('Send message without a subject?')))) {
				return true;
			}
			return false;
		}).on('click', '.js-scrollto-target', function(e) {
			var target = $(this).metadata().targetid;
			targetOffset = $(target).offset().top;
			$('html, body').animate( {
				scrollTop: targetOffset
			}, 400, function() {});
		}).on('change', '.js-fee-display', function(e) {
			var value = $(this).val();
			if (value == '1') {
				$('#js-listing-fee-type').html(' ' + $(this).metadata().currency);
			} else if (value == '2') {
				$('#js-listing-fee-type').html(' %');
			}
		}).on('change', '.js-fee-display', function(e) {
			var value = $(this).val();
			if (value == 'amount') {
				$('#span_198display').html(' ' + $(this).metadata().currency);
			} else if (value == 'percentage') {
				$('#span_198display').html(' %');
			}
		}).on('change', 'select[id*="FormField"][id*="Type"]', function(e) {
			var value = $(this).val();
			var select = ['checkbox', 'select', 'radio'];
			if (jQuery.inArray(value, select) >- 1) {
				$(this).closest('td').children('div.text').show();
			} else {
				$(this).closest('td').children('div.text').hide();
			}
		}).on('submit', '.addField form', function(e) {
			var data = $(this).serialize();
			var url = $(this).prop('action');
			$.post(url, data, function(response) {
				if (response) {
					result = response.split('*');
					$.get(__cfg('path_relative') + '/admin/form_fields/get_row/' + result[1], function(data) {
						sort_class = '.sort' + result[2] + ' tbody';
						$(sort_class).append(data);
					});
				}
			});
			return false;
		}).on('change', '.js-field-type-edit', function(e) {
			if ($(this).val() == 'select' || $(this).val() == 'checkbox' || $(this).val() == 'radio' || $(this).val() == 'multiselect') {
				if ($(this).parents('td').find('div.options-field-block').hasClass('hide')) {
					$(this).parents('td').find('div.options-field-block').removeClass('hide');
				}
			} else {
				$(this).parents('td').find('div.options-field-block').addClass('hide');
			}
		}).on('change', '.js-field-type', function(e) {
			if ($('.js-field-type').val() == 'select' || $('.js-field-type').val() == 'checkbox' || $('.js-field-type').val() == 'radio' || $('.js-field-type').val() == 'multiselect') {
				$('.js-options-show').show();
			} else {
				$('.js-options-show').hide();
			}
		}).on('change', '.js-invite-all', function(e) {
			$('.invite-select').val($(this).val());
		}).on('click', '.js-add-more', function(e) {
			$.p.fpledgetypekey(this);
		}).on('change', '.js-autosubmit', function(e) {
			$(this).parents('form').submit();
		}).on('blur, change', '.js-remove-error', function(e) {
			$(this).parent('.input').find('.error-message').remove();
			$(this).parent('.input').removeClass('error');
		}).on('change', '.js-admin-index-autosubmit', function(e) {
			if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() >= 1) {
				alert(__l('Please select atleast one record!'));
				return false;
			} else if ($(this).val() >= 1) {
				if (window.confirm(__l('Are you sure you want to do this action?'))) {
					$(this).parents('form').submit();
				}
			}
		}).on('change', '.js-pledge-type', function(e) {			
			$('.js-field-list input').prop('readonly', false).val('');
			$('.reward-clone').remove();
			$.p.fpledgetype(this);
		}).on('submit', 'form .js-project-submit', function(e) {
			if ($('.js-term:checked').val() != 1) {
				return false;
			}
			return true;
		}).on('click', '.js-preview-change', function(e) {
			var display = $(this).metadata().display;
			if ($(this).val()) {
				$('.' + display).html($(this).find('option:selected').text());
			}
		}).on('click', '.js-preview-keyup', function(e) {
			var display = $(this).metadata().display;
	        $('.' + display).html($(this).val());
		}).on('click', '#js-expand-table tr.js-odd', function(e) {
			var $this = $(this);
			if ($this.hasClass('inactive-record')) {
				$this.addClass('inactive-record-backup').removeClass('inactive-record');
			} else if ($this.hasClass('inactive-record-backup')) {
				$this.addClass('inactive-record').removeClass('inactive-record-backup');
			}
			display = $this.next('tr').css('display');
			if (display == 'none') {
				$this.addClass('active-row').next('tr').removeClass('hide');
			} else {
				$this.removeClass('active-row').next('tr').addClass('hide');
			}
			$this.find('.arrow').toggleClass('up');
		}).on('click', '.js-admin-update-status', function(e) {
			$this = $(this);
			var status = '';
			if ($this.parents('td').hasClass('js-payment-status')) {
				status = 1;
			}
			$this.html('<img src="' + __cfg('path_absolute') + 'img/small_loader.gif">');
			$.get($this.prop('href'), function(data) {
				$this.parent('td').html(data);
				if (status == 1) {
					$.p.fwarninginfochange('.js-wallet' + so + ', .js-payment-all' + so);
				}
			});
			return false;
		}).on('click', '.js-answer-select', function(e) {
			$this = $(this);
			if ($this.prop('checked')) {
				$('.js-answer-select').each(function() {
					$(this).prop('checked', false);
				});
				$this.prop('checked', 'checked');
			}
		}).on('click', '.js-connect', function(e) {
			$.oauthpopup( {
				path: $(this).attr('data-url'),
				callback: function() {
					var href = window.location.href;
					if (href.indexOf('users/register') != -1) {
						location.href = __cfg('path_absolute') + 'users/login';
					} else {
						window.location.reload();
					}
				}
			});
			return false;
		}).on('click', 'a.js-accordion-link', function(e) {
			$this = $(this);
			var contentDiv = $this.prop('href');
			$id = $this.metadata().data_id;
			$parent_class = $('.js-content-' + $id).parent('div').prop('class');
			$this.children('i').toggleClass("fa fa-minus");
			if ($parent_class.indexOf('in') > -1) {
				$('.js-content-' + $id).block();
				$.get($(this).metadata().url, function(data) {
					$('.js-content-' + $id).html(data).unblock();
					return false;
				});
			}
		}).on('click', 'a.js-toggle-icon', function(e) {
			$this = $(this);
			class_name = $this.find('.fa fa-chevron-up').prop('class');
			class_name_plus = $this.find('.fa fa-chevron-down').prop('class');
			if (typeof(class_name) != 'undefined') {
				if (class_name.indexOf('fa fa-chevron-up') > -1) {
					$this.find('.fa fa-chevron-up').addClass('fa fa-chevron-down');
					$this.find('.fa fa-chevron-down').removeClass('fa fa-chevron-up');
				}
			}
			if (typeof(class_name_plus) != 'undefined') {
				if (class_name_plus.indexOf('fa fa-chevron-down') > -1) {
					$this.find('.fa fa-chevron-down').addClass('fa fa-chevron-up');
					$this.find('.fa fa-chevron-up').removeClass('fa fa-chevron-down');
				}
			}
		}).on('click', '.js-show-panel', function(e) {
			if ($('header').hasClass('show-panel')) {
				$('header').removeClass('show-panel');
			} else {
				$('header').addClass('show-panel');
			}
			if ($('section.panel-section').hasClass('show-panel-section')) {
				$("section.panel-section").removeClass("show-panel-section");
			} else {
				$("section.panel-section").addClass("show-panel-section");
			}
		}).on('click', '.js-toggle-icon', function(e) {
			$('.js-admin-panel-head').css('width', '200px');
		}).on('click', 'a.js-send-message', function(e) {
			$('#ajax-tab-container-project').easytabs().bind('easytabs:after', function(e, tab, pannel) {
				$tab = $(tab);
				$.scrollTo('#comments');
				$('#ajax-tab-container-project').easytabs().unbind('easytabs:after');
			});
		}).on('click', '.js-play-video', function(e) {
			$this = $(this);
			$this.flash(null, {
				version: 8
			}, function(htmlOptions) {
				$videoDiv = $this.closest('div.video-player');
				var href = $videoDiv.metadata().url;
				// Crazy, but this is needed in Safari to show the fullscreen
				htmlOptions.src = href;
				htmlOptions.type = 'application/x-shockwave-flash';
				htmlOptions.pluginspage = $videoDiv.metadata().pluginspage;
				htmlOptions.height = $videoDiv.metadata().height;
				htmlOptions.width = $videoDiv.metadata().width;
				htmlOptions.wmode = $videoDiv.metadata().wmode;
				htmlOptions.flashvars = {
					autoplay: true
				};
				$videoDiv.html($.fn.flash.transform(htmlOptions));
			});
			return false;
		}).on('click', 'a.js-manage-rewards', function(e) {
			$this = $(this);
			$($this.metadata().container).block();
			$.get($this.prop('href'), function(data) {
				$($this.metadata().container).html(data);
				$($this.metadata().container).unblock();
				return false;
			});
			return false;
		}).on('click', '.js-show-message', function(e) {
			$this = $(this);
			var parent = $this.parents('.message-inbox');
			var msg_id = $this.metadata().message_id;
			if ($this.is('.js-message-shown') === false) {
				$this.block();
				$.get(__cfg('path_relative') + 'messages/index/message_id:' + msg_id, function(data) {
					$('.js-message-view' + msg_id + ', .js-conversation-' + msg_id).removeClass('hide');
					$('.js-message-view' + msg_id + ', .js-conversation-' + msg_id).slideDown();
					$('.js-conversation-' + msg_id).html(data);
					$this.unblock().addClass('js-message-shown');
				});
				var is_read = $this.metadata().is_read;
				if (is_read == 0) {
					$this.removeClass('unread-row');
					$.get(__cfg('path_relative') + 'messages/update_message_read/' + msg_id, function(data) {
						split_data = data.slice(7, -1);
						if(split_data === '') {
							split_data = 0;
						}
						$('.unread-messages').html(split_data);
						$('.js-unread').html(data);
						return false;
					});
				}
			} else {
				$('.js-message-view' + msg_id + ', .js-conversation-' + msg_id).slideUp();
				$this.removeClass('js-message-shown');
			}
		}).on('click', '.js-skip-btn', function(e) {
			e.stopPropagation();
			$this = $(this);
			$('.js-social-load').block();
			$.get($this.prop('href'), function(data) {
				$('.js-social-load').html(data);
				$('.js-social-load').unblock();
			});
			return false;
		}).on('click', '.js-approve-link', function(e) {
			$this = $(this);
			$('.modal').css({'width':'58%', 'left': '40%'});
			$('.pending-list-scroll').css('overflow', '');
		}).on('click', '.js-ativities-share', function(e) {
			$this = $(this);
			$.get($this.prop('href'), function(data) {
				$('.js-social-link-div').html(data);
			});
			return false;
		}).on('click', '.js-link-reply', function(e) {
			$this = $(this);
			var responseContainer = $this.metadata().responsecontainer;
			if ($('.' + responseContainer).html() === '') {
				$('.' + $this.metadata().container).slideDown().block();
				$.get($this.prop('href'), function(data) {
					$('.' + responseContainer).html(data);
					$('.js-without-subject').addClass('js-quickreply-send');
					$('body').delegate('.js-quickreply-send', 'click', function() {
						$('.js-message-listing').prop('action', __cfg('path_relative') + 'messages/compose').fajaxmsgform();
					});
					$('.' + $this.metadata().container).unblock();
					$this.hide();
					return false;
				});
			} else {
				$('.' + responseContainer).slideDown();
				$this.hide();
			}
			return false;
		}).on('click', '.js-live-tour', function(e) {
			bootstro.start();
			return false;
		}).on('click', '.bootstro-goto', function(e) {
			bootstro.start();
			bootstro.go_to(1);
			return false;
		}).on('click', '.js-splash', function(e) {
			var $this = $(this);
			if ($this.prop('checked')) {
				$('.js-splash-info').slideDown('fast');
				$('.js-editable-info').slideUp('fast');
				$('input[name*="data[FormFieldStep][is_editable]"]').prop("checked", false);
			} else {
				$('.js-splash-info').slideUp('fast');
				$('.js-editable-info').slideDown('fast');
			}
		}).on('click', '.js-payout', function(e) {
			var $this = $(this);
			if ($this.prop('checked')) {
				$('.js-editable-info').slideUp('fast');
				$('input[name*="data[FormFieldStep][is_editable]"]').prop("checked", true);
			} else {
				$('.js-editable-info').slideDown('fast');
				$('input[name*="data[FormFieldStep][is_editable]"]').prop("checked", false);
			}
		}).on('click', '.js-message-link', function(e) {
			$this = $(this);
			$$this = $('.js-response-message');
			$$this.block();
			$.get($this.prop('href'),{ "_": $.now() }, function(data) {
				$$this.html(data).unblock();
				return false;
			});
			return false;
		}).on('click', 'a.js-give', function(e) {
			$this = $(this);
			$this.block();
			$.get($this.prop('href'), function(data) {
				if (data == 1) {
					$this.html('<i class="fa fa-thumbs-down"></i> ' + __l('Not Given'));
				} else {
					$this.html('<i class="fa fa-thumbs-up"></i> ' + __l('Given'));
				}
				$this.unblock();
				return false;
			});
			return false;
		}).on('click', '#embed_url', function(e) {
			$('#embed_url').trigger('select');
		}).on('click', '.panel-link', function(e) {
			$('#ajax-tab-container-project').easytabs('select', $(this).attr('rel'));
			return false;
		}).on('submit', '#ProjectSearchForm', function(e) {
			if (($('#ProjectQ').val()).trim() === '') {
				return false;
			}
		}).on('submit', 'form', function(e) {
			$(this).find('div.input input[type=text], div.input input[type=password], div.input textarea, div.input select').filter(':visible').trigger('blur');
			$('input, textarea, select', $('.error', $(this)).filter(':first')).trigger('focus');
			return ! ($('.error-message', $(this)).length);
		}).on('submit', 'form.js-ajax-form', function(e) {
			var $this = $(this);
			var data = '';
			$this.block();
			$this.ajaxSubmit( {
				success: function(responseText, statusText) {
					redirect = responseText.split('*');
					if (redirect[0] == 'redirect') {
						location.href = redirect[1];
					} else {
						var data = $this.metadata();
						if (data.redirect_url) {
							location.href = data.redirect_url;
							return false;
						} else {
							if ($this.metadata().container) {
								$('.' + $this.metadata().container).html(responseText);
							} else {
								$this.parents('.js-responses').html(responseText);
							}
						}
					}
					$this.unblock();
				}
			});
			return false;
		}).on('mouseup', '.js-follow', function(e) {
			$this = $(this);
			var project_id = $this.metadata().project_id;
			$.get(__cfg('path_relative') + 'project_followers/add/' + project_id, function(data) {
				split_data = data.split('|');
				$('#js-follow-id').removeClass();
				$('#js-follow-id').removeAttr('data-toggle');
				$('#js-follow-id').addClass('btn col-md-2 js-add-remove-followers js-tooltip js-unfollow');
				$('#js-follow-id').prop( {
					alt: __l('Following'),
					title: __l('Unfollow'),
					href: split_data[1]
					});
				$('.js-social-link-div').load(split_data[2]);
			});
			return false;
		}).on('click', 'a.js-star', function(e) {
			var $this = $(this);
			$(this).html('<img src="' + __cfg('path_absolute') + '/img/star-load.gif" style="margin:-3px 0 0 5px">');
			$.get($this.prop('href'), null, function(data) {
				$this.parent().html(data);
			});
			return false;
		}).on('focus', '.js-show-submit-block', function(e) {
			$('.js-add-block').removeClass('hide');
	        $(this).parent().addClass('textarea-large');
		}).on('mouseenter', '.js-unfollow', function(e) {
			$(this).html('<i class="fa fa-times"></i> ' + __l('Unfollow'));
		}).on('mouseleave', '.js-unfollow', function(e) {
			$(this).html('<i class="fa fa-check"></i> ' + __l('Following'));
		}).on('hidden.bs.modal', '.modal', function(e) {
			$(this).removeData('bs.modal');
		}).on('show.bs.modal', '.modal', function(e) {
			if ($(this).prop('id') == 'js-ajax') {
				$('#js-ajax').find('.modal-header').html('');
			}
			if (!$(this).hasClass('bootstrap-wysihtml5-insert-image-modal') && !$(this).hasClass('bootstrap-wysihtml5-insert-link-modal') && !$(this).hasClass('modal hide fade in')) {
				$(this).find('.modal-body').html('<img src="' + __cfg('path_absolute') + '/img/throbber.gif"> Loading...');
			}
		}).on('show', '#js-admin-panel', function(e) {
			$('.js-admin-panel-head').css('width', '100%');
		}).on('keyup', '#CityName', function(e) {
			$('.js-city').html($(this).val());
		}).on('mouseenter', '#js-security_question_id', function(e) {
			$(this).css('width', 'auto');
		}).on('mouseenter', '.js-home-hover', function(e) {
			$(this).addClass('well');
		}).on('mouseleave', '.js-home-hover', function(e) {
			$(this).removeClass('well');
		}).on('keyup', '.js-min-amount-needed', function(e) {
			var $this = $(this);
			if ($('.js-pledge-type').val() == 5 || $('.js-pledge-type').val() == 3) {
				$('.js-add-more').hide();
				var val = $this.val();
				var valarray = val.split(',');
				for (var i = 0; i < valarray.length; i ++ ) {
					var length = $('.js-clone').find('.js-field-list').length;
					if (valarray.length > length) {
						$.p.fpledgetypekey('.js-add-more');
					} else if (valarray.length < length && (valarray.length - 1) == i) {
						for (var j = valarray.length; j <= length; j ++ ) {
							$('.js-new-clone-' + j).remove();
						}
					}
					$('.js-website-remove').hide();
					$('#ProjectReward' + i + 'PledgeAmount').val(valarray[i]).prop('readonly', true);
				}
			}
			return false;
		}).on('blur', '#js-street_id, #CityName, #StateName, #js-country_id', function(e) {
			floadgeomapprojectadd();
		}).on('keypress', '.form-search input', function(e) {
			if (e.which == 13) {
				$(this).closest('form').submit();
			}
		}).on('click', '.close', function(e) {
			$('.js-flash-message').slideUp('fast');
			return false;
		}).on('click', '.js-node-links', function(e) {
			$('#LinkLink').val($(this).attr('rel'));
			$('#js-ajax-modal').modal('hide');
			return false;
		}).on('mouseenter', '.js-sudopay-disconnect', function(e) {
			$(this).html('<i class="fa fa-times"></i> ' + __l('Disconnect'));
		}).on('mouseleave', '.js-sudopay-disconnect', function(e) {
			$(this).html('<i class="fa fa-check"></i> ' + __l('Connected'));
		}).on('mouseenter', '.js-share', function(e) {
			$(this).removeClass('social-buttons');
			Socialite.load($(this)[0]);
		}).on('sortupdate', '.js-sortable tbody', function(e) {
				var data = $('input[name*="data[FormField]"][name*="[id]"]').serialize();
				$.post(__cfg('path_relative') + 'admin/form_fields/sort', data, function(response) {});
		}).on('sortupdate', '.js-sortable-group', function(e) {
				var data = $('input[name*="data[FormFieldGroup]"][name*="[id]"]').serialize();
				$.post(__cfg('path_relative') + 'admin/form_field_groups/sort', data, function(response) {});
		}).on('sortupdate', '.js-sortable-step', function(e) {
				var data = $('input[name*="data[FormFieldStep]"][name*="[id]"]').serialize();
				$.post(__cfg('path_relative') + 'admin/form_field_steps/sort', data, function(response) {});
		}).on('click', 'a:not(.js-no-pjax, .close):not([href^=http], #adcopy-link-refresh, #adcopy-link-audio, #adcopy-link-image, #adcopy-link-info)', function(e) {
			if (!$.support.pjax) { return; }
			var link = $(this).prop('href');
			var current_url = window.current_url;
			if (link.indexOf('admin') < 0 && current_url.indexOf('admin') > 0) {
				window.location.href = link;
			}
			if (link.indexOf('admin') >= 0) {
				$('.admin-menu li').removeClass('active');
				$('.main-nav li').removeClass('active');
				$(this).parents('li').addClass('active');
			} else {
				$('.fund_support, .start-project, .how_it_works').removeClass('active');
				if (link.indexOf('browse') >= 0) {
					$('.fund_support').addClass('active');
				} else if (link.indexOf('start') >= 0 || link.indexOf('pledge/add') >= 0 || link.indexOf('donate/add') >= 0 || link.indexOf('lend/add') >= 0 || link.indexOf('equity/add') >= 0) {
					$('.start-project').addClass('active');
				} else if (link.indexOf('how-it-works') >= 0) {
					$('.how_it_works').addClass('active');
				}
			}
		}).on('pjax:start', 'body', function(e) {
			if (!$.support.pjax) { return; }
			if ($('#progress').length === 0) {
				$('body').append($('<div><dt/><dd/></div>').attr('id', 'progress'));
				$('#progress').width((50 + Math.random() * 30) + '%');
		    }
			$(this).addClass('loading');
		}).on('pjax:timeout', 'body', function(e) {
			if (!$.support.pjax) { return; }
			e.preventDefault();
		}).on('pjax:end', 'body', function() {
			if($('#inner-content-div').parent('.slimScrollDiv').size() > 0) {
				$('#inner-content-div').parent().replaceWith($('#inner-content-div'));
				// now (re)assign slimScroll
				$('#inner-content-div').slimScroll({ 
				  alwaysVisible: true,
				  size: '4px'
				});
			}
			if($('form').has('div.error-message').length > 0) {
				$('form').find('div.error-message').remove();
				$('form').find('div.error').removeClass('error');
				$('.js-flash-message').remove();
			}
			
			$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
				$('.js-catlist-show').removeClass('show hide').hide();
				var next_categories = $(e.target).data('active-tab');
				$('#'+next_categories).show();
				if(e.target.hash != '')
					$.scrollTo(e.target.hash);
			});
			$('.funding-carousel').carousel();
			xload(false);
			$('#progress').width('101%').delay(200).fadeOut(400, function() {
				$(this).remove();
			});
			$(this).removeClass('loading');	
			if (document.location.pathname == __cfg('path_relative')) {
				$('#header .node-type-page, #advantage').show();
				$('#header .js-header-menu').addClass('site-header site-menu z-top');				
				$('#header .js-header-top').addClass('z-top');
				$('.advantage').show();
			} else {
				$('#header .node-type-page, #advantage').hide();
				$('#header .js-header-menu').removeClass('site-header site-menu z-top');
				$('#header .js-header-top').removeClass('z-top');
				$('.advantage').hide();
			}
			if(window.location.href.indexOf("/admin/") > -1) {
				$('.js-live-tour-link').hide();
			} else {
				$('.js-live-tour-link').show();
			}
			$('.js-affix-header').hide();
			if (window.location.href.indexOf("/users/login") == -1 && window.location.href.indexOf("/users/register") == -1) {
				$('.js-affix-header').show();
			}
			loadAdminPanel();
		}).on('click', '.js-link', function(e) {
			$this = $(this);
			dataloading = $this.metadata().data_load;
			$('.' + dataloading).block();
			$.get($this.attr('href'), function(data) {
				$('.' + dataloading).html(data);
				$('.' + dataloading).find('script').each(function(i) {
                    eval($(this).text());
                });
				$(".progress-one").loading();
				$('.' + dataloading).unblock();
			});
			return false;
		}).on('click', 'a.js-given', function() {
			$this = $(this);
			var tit = $this.metadata().title;
			$this.block();
			$.get($this.attr('href'), function(data) {
				if (data == 1) {
					$this.html(__l('Not given'));
				} else {
					$this.html(__l('Given'));
				}
				$this.unblock();
			});
			return false;
		}).on('click', '.js-request_invite', function(e) {
			$('div.js-responses').eq(0).block();
			$.get(__cfg('path_absolute') + 'subscriptions/add/type:invite_request', function(data) {
				$('div.js-responses').html(data);
				$('div.js-responses').unblock();
			});
			return false;
		}).on('click', '#js-feature-project', function() {
			var text = $(this).attr('data-text');
			var title_text = $(this).text();
			$('#js-see-a-tech').attr({
						'href': __cfg('path_relative')+text.toLowerCase()+'/browse',
						'title': ('See All '+title_text+' Projects')
						}).tooltip('fixTitle');
			$('#js-see-a-tech').text('See All '+title_text+' Projects');
		}).on('click', '.js-cateogory-projects', function() {
			$this = $(this);
			$.get($this.attr('href'), function(data) {
				var href = $this.attr('href').split('/');
				href[3] = 'index';
				$('#js-see-a-tech').text('See '+$this.text()+' Projects');	
				$('#js-see-a-tech').attr('title', 'See '+$this.text()+' projects').tooltip('fixTitle');
				$('#js-see-a-tech').attr('href', href.join('/'));
				var action_url = $this.data('action-url');
				$('.see-all-projects').attr("href", action_url);
				$($this.data("target")).html(data);
			});
			return false;
		}).on('click', '.js-notify-mail', function() {
			$this = $(this);
			var value = $this.val();
			$.get(__cfg('path_absolute') + 'users/update_email_notification/notify:'+ value, function(data) {
				$this.prop('checked', 'checked');
			});
			return false;
		});
		if ($.cookie('_geo') === null) {
			/*$.getJSON('http://www.telize.com/geoip?callback=?',
				function(json) {
					var country_code = json.country_code ? json.country_code : '';
					var region = json.region ? json.region : '';
					var city = json.city ? json.city : '';
					var latitude = json.latitude ? json.latitude : '';
					var longitude = json.longitude ? json.longitude : '';
					var geo = country_code + '|' + region + '|' + city + '|' + latitude + '|' + longitude;
					$.cookie('_geo', geo, {
						expires: 100,
						path: '/'
					});
				}
			);*/
		}
		if ($.cookie('_gz') !== null) {
			$('.js-affix-header.navbar').hide();
		}
		$('a[data-toggle="tab"]').click(function(){
			$(this).tab('show');
		});
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
			$('.js-catlist-show').removeClass('show hide').hide();
			var next_categories = $(e.target).data('active-tab');
			$('#'+next_categories).show();
			if(e.target.hash != '')
				$.scrollTo(e.target.hash);
		});
	}).ajaxStop(function() {
        xload(true);
    });
})();
$(function() {
	var loc = window.location.href; // returns the full URL
	if(/all/.test(loc)) {
		$('.nav.nav-pills li.all').addClass('active');
	}
	else if(/inbox/.test(loc)) {
		$('.nav.nav-pills li.inbox').addClass('active');
	}
	else if(/replied/.test(loc)) {
		$('.nav.nav-pills li.replied').addClass('active');
	}
	else if(/stared/.test(loc)) {
		$('.nav.nav-pills li.stared').addClass('active');
	}
});
