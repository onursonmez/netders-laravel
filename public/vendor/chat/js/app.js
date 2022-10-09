/**
 *
 *  Project name: Tinno - HTML5 Chat App Template
 *
 *  File name: app.js
 *
 *  Description: The Javascript codes in this file are the basic codes of the application.
 *  Changing these codes is not recommended.
 *  We used a different file for the examples (examples.js).
 *
 *  Autor: Laborasyon
 *
 *  Portfolio: https://themeforest.net/user/laborasyon/portfolio
 *
 */
'use strict'; // PerfectScrollbar

var perfectScrollbarChatInit;
var perfectScrollbarPersonInit;

function perfectScrollbarPersonInit(selector) {
  perfectScrollbarPersonInit = new PerfectScrollbar(selector);
  return perfectScrollbarPersonInit;
};

function perfectScrollbarChatInit(selector) {
  perfectScrollbarChatInit = new PerfectScrollbar(selector);
  return perfectScrollbarChatInit;
};

function loadPersons(string)
{
  var query;

  if(string)
  {
    query = "search="+string;
  }

  $.get("chat/persons", query, function(data, status){
    if(data.success)
    {
      $('#persons').html(data.html);
      $('#persons').show();

      if(data.count > 0)
      {
        $('.list-group-item').each(function(){
          var conversation_id = $(this).attr('id').replace('c_', '');

          window.Echo.private('conversation.'+conversation_id)
          .listen('.new-message', (res) => {
            loadPersons();
            /*
            $('#c_'+conversation_id).addClass('unread-chat');
            var messageCount = parseInt($('#c_'+conversation_id+' .new-message-count').html());
            if(messageCount > 0 )
            {
              $('#c_'+conversation_id+' .users-list-action .new-message-count').html(messageCount + 1);
            }
            else
            {
              $('#c_'+conversation_id+' .users-list-action').prepend('<div class="new-message-count">1</div>');
            }
            */
          });            
        }); 
      }   
    }
  });  
}

(function ($) {
  var __window = $(window);

  var __document = $(document);

  var __body = $('body'); // Preloader

  __document.ajaxComplete(function(){
    if($('.chat .chat-body').length) {
      perfectScrollbarChatInit.update();
    }
  });

  

  __window.on('load', function () {
    setTimeout(function () {
      $('.preloader').fadeOut(300, function () {
        $(this).remove();
      });
    }, 1000);

    loadPersons();

  }); // Chat body scroll init

  if (__window.width() >= 1200 && $('.chat .chat-body').length) {
    var chat_body = '.chat .chat-body';
    perfectScrollbarChatInit(chat_body);
    $(chat_body).scrollTop($(chat_body)[0].scrollHeight);
  } // Sidebar scroll init


  if (__window.width() >= 1200 && $('.left-sidebar-content').length) {
    document.querySelectorAll('.left-sidebar-content').forEach(function (container) {
      return perfectScrollbarPersonInit(container);
    });
  } // Right sidebar scroll init

  if (__window.width() >= 1200 && $('.right-sidebar-content').length) {
    document.querySelectorAll('.right-sidebar-content').forEach(function (container) {
      return perfectScrollbarPersonInit(container);
    });
  } // Small change in RTL version.

  if (__body.hasClass('rtl')) {
    $('.dropdown-menu.dropdown-menu-right').removeClass('dropdown-menu-right');
  } // Feather icon init


  feather.replace({
    'stroke-width': 1.3
  }); // Let's remove the blur effect in the mobile version

  if (__window.width() < 768) {
    __body.addClass('no-blur-effect');
  } // Bootstrap tooltip

  __document.on('keyup', '#search', function (e) {
    var string = $(this).val();
    if(string.length > 2)
    {
      $('#persons').hide();
      loadPersons(string);
    }
    else
    {
      loadPersons(string);
      $('#persons').show();
    }
    
  });

  $('[data-toggle="tooltip"]').tooltip(); // Clicking on the tooltip applied object to cancel the tooltip

  __document.on('click', '[data-toggle="tooltip"]', function (e) {
    $(e.currentTarget).tooltip('hide');
  }); // Opening the left sidebar

  __document.on('click', '[data-left-sidebar]', function (e) {
    var target = $(e.currentTarget).data('left-sidebar'),
        sidebar = $('.left-sidebar#' + target);
    $('.left-sidebar').removeClass('open');
    sidebar.addClass('open');
    $('[data-left-sidebar]').removeClass('active');
    $('[data-left-sidebar="' + target + '"]').addClass('active');

    if ($('.story-block .story-items').length) {
      setTimeout(function () {
        $('.story-block .story-items').slick('unslick').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: false,
          rtl: __body.hasClass('rtl') ? true : false
        });
      }, 100);
    }

    return false;
  }); // Opening the right sidebar


  __document.on('click', '[data-right-sidebar]', function (e) {
    var id = $(e.currentTarget).data('right-sidebar'),
        sidebar = $('.right-sidebar#' + id); // Let's close the open panels first

    $('.right-sidebar').not(sidebar).removeClass('open'); // Let's open the panel that needs to be opened later.

    sidebar.addClass('open');
    $('[data-toggle="dropdown"]').dropdown('hide');
    $('[data-toggle="tooltip"]').tooltip('hide');
    return false;
  }); // Closing the right sidebar


  __document.on('click', '.right-sidebar-close', function (e) {
    $(e.currentTarget).closest('.right-sidebar').removeClass('open');
    return false;
  }); // Clicking anywhere to close the right sidebar


  __document.on('click', '*', function (e) {
    if (!$(e.target).is($('.right-sidebar, .right-sidebar *, [data-right-sidebar], [data-right-sidebar] *'))) {
      $('.right-sidebar').removeClass('open');
    }
  });
})(jQuery);