function loadDashboardCharts() {
	// активность за 7 дней
	var chart = Morris.Bar({
        element: 'dashboard-bar-chart',
        data: [0],
        xkey: 'y',
        ykeys: 'a',
        labels: ['Выполнено'],
        //barColors: ['#e42b28'],
        gridTextSize: '10px',
        hideHover: true,
        resize: true,
        //gridLineColor: '#E5E5E5'
    });
	$.ajax({
        method:'GET',
		cache: false,
	    url: '/dashboard/activity',
	    success: function (response) {
			chart.setData(response);
	    },
	    error: function (response) {}
	});


	if($('#dashboard-donut-chart').length) {
		var donut = Morris.Donut({
		    element: 'dashboard-donut-chart',
		    data: [0],
		    resize: true
		});

		$.ajax({
	        method:'GET',
			cache: false,
		    url: '/dashboard/dailybonus',
		    success: function (response) {
				donut.setData(response);
		    },
		    error: function (response) {}
		});
	}

}

function loadContent(link) {
	$('#page-wrapper').css('opacity', 0.5);
	$( "#page-wrapper" ).load( link + " #page-wrapper > .content", function(responseText, textStatus, XMLHttpRequest) {
		$('title').html(responseText.match(/<title[^>]*>([^<]+)<\/title>/)[1]);
		$('#user_balance').html(responseText.match(/<span id="user_balance"[^>]*>([^<]+)<\/span>/)[1]);
		$('#page-wrapper').css('opacity', 1);
	
		$('ul.nav a').each(function() {
			$(this).removeClass('active');
		});
		$('ul.nav li').each(function() {
			$(this).removeClass('active');
		});
		$('ul.nav ul').each(function() {
			$(this).removeClass('in').height('auto');
		});

		$('.sidebar-nav').removeClass('in');
		
		var url = window.location;
		
		var element = $('ul.nav a').filter(function() {
			return this.href == url;
		}).addClass('active').parent().parent().addClass('in').parent();

		if (element.is('li')) {
			element.addClass('active');
		}


		dashboard = link.indexOf('/dashboard');
		if(dashboard !== -1) {
			loadDashboardCharts();
		}
	} );
}

function getTaskVid() {
    var vid = false;
    var link = $('#task_form input[name="url"]').val();
    var pos = link.indexOf('?v=');
    var poz = link.indexOf('.be/');

    if(link.length==11)
        vid = link;
    else{
        if(pos!==-1)
            vid = link.substring(pos+3,pos+14)
        else if(poz!==-1)
            vid = link.substring(poz+4,poz+15)
    }

    return vid;
}


function parseVideoInfo()
{
	var type_id = $('#task_form #type_id').val();
	var link = $('#task_form input[name="url"]').val();

	$.ajax({
        method:'POST',
		cache: false,
	    url: '/task/parse_info',
	    data: { 'type_id': type_id, 'url': link},
	    success: function (data) {
	        
	        if(typeof(data.title)=='undefined'){
                return;
            }

            if(typeof(data.url) != "undefined") {
                $('#task_form input[name="name"]').val(data.url);
			}

            // if no name in input -> get from video
            if( !$('#task_form input[name="name"]').val().length )
			{
				  $('#task_form input[name="name"]').val(data.title);
				 // document.scr_video.src='//img.youtube.com/vi/'+id+'/mqdefault.jpg';
			}
              
	    },
	    error: function (ajaxContext) {
	        $('#task_form input[name="name"]').val();
	    }
	});
}

$(function() {
    
    //new Clipboard('.copy_clipboard');
    new Clipboard('.copy_clipboard', {
        text: function(trigger) {
            var text;
            var task_id = trigger.getAttribute('data-task-id');
            
            $.ajax({
                dataType: "json",
                url: '/work/get_comment/'+task_id,
                success: function(json) {
                    if(json.comment !== undefined) {
                        text = json.comment;
                        $('#comment_text_'+task_id).val(text);
                    }
					else{
						var n = notify('Нет свободного комментария', 'error', n);
					}
                },
                async:false
            });
			if(text === undefined){
			var n = notify('Нет свободного комментария', 'error', n);
			return false;
			}
			var n = notify('Комментарий скопирован: '+text, 'success', n);
            return text;
        }
    });
    
    if(!Clipboard.isSupported()) {
        $('.comment_text').show();
    }

    var link = window.location.href;
    dashboard = link.indexOf('/dashboard');
    if(dashboard !== -1) {
            loadDashboardCharts();
    }

    $('body').on('change', '#task_form input[name="url"]', function(){
            parseVideoInfo();
    });

    $('body').on('keyup', '#task_form input[name="url"]', function(){
        clearTimeout(timer);
        timer = setTimeout(function(){
                parseVideoInfo();
        },1000)
    });
	
    var location = window.history.location || window.location;
   // Adding popstate event listener to handle browser back button

    window.addEventListener("popstate", function(e) {
        loadContent(location.pathname);
    });

	// меню
	$('body').delegate('.sidebar a.aLink', 'click', function(e) {
		e.preventDefault();
		link = $(this).attr('href');
		if(link == '#' || link == '') {
			return false;
		}
		loadContent(link);
		history.pushState(null, null, link);
	});
	
	// пагинация
	$('body').delegate('.pagination a', 'click', function(e) {
		e.preventDefault();
		loadContent($(this).attr('href'));
		history.pushState(null, null, $(this).attr('href'));
	});
	
	// изменение типа задачи при добавлении
	$('body').delegate('#task_form #type_id', 'change', function() {
		$('#task_form #change_type').val(true);
		$('#page-wrapper').css('opacity', 0.5);
		$.ajax({
			'url': $('#task_form').attr('action')+'?light=true',
			'type': 'POST',
			'data': $('#task_form').serialize(),
			'success': function(result){
				$('#task_form_container').html(result);
                $('#task_form input[name="url"]').val('');
                $('#task_form input[name="name"]').val('');
				$('#page-wrapper').css('opacity', 1);
				taskPositionCalc();
			}
		});
	});

    function calculatePoints(amount) {
        var factor = 22.5;

        if(amount >= 300) {
            factor = 22.5;
        }
        if(amount >= 1200) {
            factor = 26.25;
        }
        if(amount >= 2100) {
            factor = 30;
        }
        if(amount >= 3000) {
            factor = 36;
        }

        return amount * factor;
    }

    $(document).on('change', "#paymentForm input[name='sum']", function () {
        $('#calculatedPoints  > span').html(calculatePoints($(this).val()));
    });

	function taskPositionCalc() {
		$.ajax({
			'url': '/task/position_calc',
			'type': 'POST',
			'data': $('#task_form').serialize(),
			'success': function(result){
				$('#action_cost_position').html(result);
			}
		});
	}

	function actionTargetCalc() {
		var total_cost  	= $('#task_form #total_cost').val();
		var action_cost 	= $('#task_form #action_cost').val();
		var action_target	= total_cost / action_cost;
		if(action_target > 0 && action_target != Infinity) {
			$('#task_form #action_target').val(action_target.toFixed());
		}
		else {
			$('#task_form #action_target').val('');
		}
	}

	// просчет колва выполнений
	$('body').on('keyup', '#task_form #total_cost', function(){
		actionTargetCalc();
	});

	$('body').on('keyup', '#task_form #action_target', function(){
		var action_cost = $('#task_form #action_cost').val();
		var total_cost  = $(this).val() * action_cost;
		if(total_cost > 0) {
			$('#task_form #total_cost').val(total_cost.toFixed());
		}
		else {
			$('#task_form #total_cost').val('');
		}

	});

	// паттерны времени
	$('body').on('click', '.time-select > span', function(){
		$("#extend_time").val($(this).html()).change();
		taskPositionCalc();
	});

	// просчет позиции задачи по цене/времени
	$('body').on('change', '#task_form #action_cost', function(){
		taskPositionCalc();
		actionTargetCalc();
	});

	$('body').on('keyup', '#task_form #action_cost', function(){
		actionTargetCalc();
		clearTimeout(timer);
		timer = setTimeout(function(){
			taskPositionCalc();
		},1000);
	});

	$('body').on('change', '#task_form #extend_time', function(){
		taskPositionCalc();
	});


	// загрузка регионов
	$('body').on('change', '#task_form #country_id', function() {
    //$('#country_id').change(function () {
        var country_id = $(this).val();
        count = 0;

        default_option = '<option value="0" class="default">'+$('#region_id option.default').html()+'</option>';
        $('#region_id').html(default_option).attr('disabled', true);

        // если ничего не выбрано
        if (country_id == '0') {
            return(false);
        }

        $.get(
            '/task/get_region',
            "country_id=" + country_id,
            function (result) {
                if (result.type == 'error') {
                    alert('error');
                    return(false);
                }
                else {
                    var options = '';
                    $(result.regions).each(function() {
                        options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
                        count += 1;
                    });
                    if(count > 0) {
                    	$('#region_id').append(options).attr('disabled', false);
                    }

        			$('#region_id').change();
                }
            },
            "json"
        );
    });

    // загрузка городов
	$('body').on('change', '#task_form #region_id', function() {
    //$('#region_id').change(function () {
        var region_id = $(this).val();

        default_option = '<option value="0" class="default">'+$('#city_id option.default').html()+'</option>';
        $('#city_id').html(default_option).attr('disabled', true);

        if (region_id == '0') {
            return(false);
        }

        $.get(
            '/task/get_city',
            "region_id=" + region_id,
            function (result) {
                if (result.type == 'error') {
                    alert('error');
                    return(false);
                }
                else {
                    var options = '';
                    $(result.cities).each(function() {
                        options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
                    });
                    $('#city_id').append(options).attr('disabled', false);
                }
            },
            "json"
        );
    });

    $('body').on('click', '.geo_del', function() {
    	$(this).parents('tr').remove();
    });

	$('body').on('click', '#geo_add', function() {

        if ($('#country_id').val() == '0') {
            return(false);
        }

		html  = '<tr>';
		
		html += '<td>';
		html += '<input type="hidden" name="geo[country][]" value="'+$('#country_id').val()+'" />';
		html += $('#country_id option:selected').text();
		html += '</td>';

		html += '<td>';
		html += '<input type="hidden" name="geo[region][]" value="'+$('#region_id').val()+'" />';
		html += $('#region_id option:selected').text();
		html += '</td>';

		html += '<td>';
		html += '<input type="hidden" name="geo[city][]" value="'+$('#city_id').val()+'" />';
		html += $('#city_id option:selected').text();
		html += '</td>';

		html += '<td><a class="btn btn-danger btn-circle geo_del"><i class="glyphicon glyphicon-remove"></i></a></td>';

		html += '</tr>';

		$('#geo_form').before(html);
	});


});

$.noty.layouts.bottomRight = {
    name     : 'bottomRight',
    options  : { // overrides options

    },
    container: {
        object  : '<ul id="noty_bottomRight_layout_container" />',
        selector: 'ul#noty_bottomRight_layout_container',
        style   : function() {
            $(this).css({
                bottom       : 20,
                right        : 45,
                position     : 'fixed',
                width        : '340px',
                height       : 'auto',
                margin       : 0,
                padding      : 0,
                listStyleType: 'none',
                zIndex       : 10000000
            });

            if(window.innerWidth < 600) {
                $(this).css({
                    right: 5
                });
            }
        }
    },
    parent   : {
        object  : '<li />',
        selector: 'li',
        css     : {}
    },
    css      : {
        display: 'none',
        width  : '340px'
    },
    addClass : ''
};

function notify(text, type, n, totalTimeout=5000) {
	if(typeof n !== 'undefined' && !n.closed) {
		if(type == 'error' || type == 'success') {
			setTimeout(function() {n.close();}, 7000);
		}
		return n.setText(text).setType(type);
	}

    var n = noty({
        text        : text,
        type        : type,
        dismissQueue: true,
        layout      : 'bottomRight',
        theme       : 'relax',
        timeout     : totalTimeout,
        closeWith   : ['button', 'click'],
        maxVisible  : 15,
        modal       : false,
	    callback: {
	        onShow: function() {},
	        afterShow: function() {},
	        onClose: function() {},
	        afterClose: function() {},
	        onCloseClick: function() {},
	    }
    });

    return n;
}

function YT_DoneRecalc(itemId) {
	$.ajax({
	  dataType: "json",
	  url: '/task/done_recalc/'+itemId+'?ajax=true',
	  success: function(json) {
	  	if(json.status == 'success') {
			n = notify(json.text, 'success');
	  	} else {
	  		if(typeof json.error !== 'undefined') {
				n = notify(json.error, 'error');
	  		}
	  	}
	  }
	});
}

function YT_ConfirmDelete() {
	if (confirm(LANG_REMOVE_CONFIRM)) {
		return true;
	} else {
		return false;
	}
}

function YT_SetBalance(balance) {
	$('#user_balance').animate({'opacity': 0.3}, 150, function() {
		$(this).html(balance);
	}).animate({'opacity': 1}, 150);
}

function YT_SetStatus(text, type) {
	var elm = $('.status');
	elm.html('<div class="alert alert-'+type+'">'+text+'</div>');
}

function YT_SetTimer(itemId, time) {
	$('#task_'+itemId+' .time').html(time);
}

function YT_GetComment(itemId) {
    $.ajax({
      dataType: "json",
      url: '/work/get_comment/'+itemId,
      success: function(json) {
        if(json.comment !== 'undefined') {
            var targetId = "comment_"+itemId;
            $('#'+targetId).val(json.comment);
        }
      }
    });
    
    return false;
}


function YT_CompleteHandler(itemId, n) {
    $.ajax({
      dataType: "json",
      url: '/work/complete/'+itemId+'?ajax=true',
      success: function(json) {
            if(json.status == 'success') {
                    //YT_SetBalance(json.user_balance);
                    $('#task_'+itemId).removeClass().addClass('waiting');
                    n = notify(json.text, 'success', n);
                    yaCounter30683743.reachGoal('taskDone');
            } else {
                    if(typeof json.error !== 'undefined') {
                            n = notify(json.error, 'error', n);
                            $('#task_'+itemId).addClass('danger');
                    }
            }
      }
    });
}

function YT_RefreshHandler(itemId, n) {
    $.ajax({
      dataType: "json",
      url: '/work/refresh/'+itemId+'?ajax=true',
      success: function(json) {
            if(json.status == 'success') {
                    //YT_SetBalance(json.user_balance);
                    $('#task_'+itemId).removeClass().addClass('waiting');
                    n = notify(json.text, 'success', n);
            } else {
                    if(typeof json.error !== 'undefined') {
                            n = notify(json.error, 'error', n);
                            $('#task_'+itemId).addClass('danger');
                    }
            }
      }
    });
}

var timer = null;
var na = [];

//https://vk.com/share.php?url=&title=&description=&image=
//https://twitter.com/intent/tweet?url={url}&text={name}&via=YouTube&related=YouTube,YouTubeTrends,YTCreators

function YT_TaskClick(itemId, targetTime) {
	if(typeof na[itemId] !== 'undefined') {
		na[itemId].close();
	}
	
	clearInterval(timer);
	
	var width  = 1120;
	var height = 700;
	var top    = 100;
	var left   = ($(document).width() - width) / 2;
	var timeout = (targetTime*1000) + 30000;

	var n = notify(LANG_COMPLETE_TASK_AND_CLOSE_WINDOW, 'information', undefined, timeout);

	na[itemId] = n;


    var canPlay = false;
    var v = document.createElement('video');
    if(v.canPlayType && v.canPlayType('video/mp4').replace(/no/, '')) {
        canPlay = true;
    }

    if(canPlay) {
    	var openedWindow = window.open('/work/go/'+itemId, 'targetWindow', 'width='+width+',height='+height+',top='+top+',left='+left+',toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
	}
	else {
        n = notify(LANG_BROWSER_NOT_ACCEPTED, 'information', n);
        return false;
   	}


	if(!openedWindow) {
		n = notify(LANG_ALLOW_POPUP, 'information', n);
	}
	else {
		var alreadyComplete = false;	
		var sec = targetTime;	
		
		timer = setInterval(function() {   
			if(openedWindow && openedWindow.closed) {
				alreadyComplete = true;
				clearInterval(timer);
			}

			if(targetTime > 0) {
				sec = sec - 1;
				if(sec > 0) {
                    YT_SetTimer(itemId, sec);
				}
				else {
                    YT_SetTimer(itemId, '<span class="glyphicon glyphicon-ok"></span>');
				}
				if(sec <= 0) {
					//alreadyComplete = true;
					//clearInterval(timer);
				}
			}

			if(alreadyComplete) {
				YT_CompleteHandler(itemId, n);
			}
		}, 1000);
	}

	$.ajax({
	  dataType: "json",
	  url: '/work/open/'+itemId,
	  success: function(json) {
	  	if (typeof json.error !== 'undefined') {
			openedWindow.close(); 
			clearInterval(timer);
			notify(json.error, 'error', n);
	  	} 
        else if (typeof json.location !== 'undefined') {
            openedWindow.close();
            clearInterval(timer);
			window.location = json.location;
		}
	  }
	});
	return false;
}