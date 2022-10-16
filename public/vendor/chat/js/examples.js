/**
 *
 *  Project name: Tinno - HTML5 Chat App Template
 *
 *  File name: example.js
 *
 *  Description: It contains some examples of the use of the item.
 *
 *  Autor: Laborasyon
 *
 *  Portfolio: https://themeforest.net/user/laborasyon/portfolio
 *
 */
'use strict';

var _this = void 0;

(function ($) {
  var __document = $(document);

  var __window = $(window);

  __document.on('click', '.example-delete-chat', function (e) {
    var chat_card = $('.list-group-item.active');
    console.log(chat_card.attr('class'));
    Swal.fire({
      title: 'Sohbeti silmek istediğinden emin misin?',
      showCancelButton: true,
      confirmButtonText: 'Sil',
      animation: false
    }).then(function (result) {
      if (result.isConfirmed) {
        if (chat_card.hasClass('active')) {
            var id = chat_card.attr('id');
            $.get("chat/delete_conversation/", "conversation_id="+id.replace('c_', ''), function(data, status){
            if(data.success)
            {
              selected_close_chat();
            }
            });
        }

        chat_card.slideUp(200, function () {
          chat_card.remove();
        });
      }
    });
    return false;
  });

  __document.on('click', '.example-delete-message', function (e) {
    var message_card = $(e.target).closest('.message-item');
    Swal.fire({
      title: 'Mesajı silmek istediğinden emin misin?',
      showCancelButton: true,
      confirmButtonText: 'Sil',
      animation: false
    }).then(function (result) {
      if (result.isConfirmed) {
        ps_chat_content.update();
        message_card.remove();
      }
    });
    return false;
  });

  __document.on('click', '.example-block-user', function (e) {
    var chat_card = $('.list-group-item.active');
    Swal.fire({
      title: 'Kullanıcıyı engellemek istediğinden emin misin?',
      showCancelButton: true,
      confirmButtonText: 'Engelle',
      animation: false
    }).then(function (result) {
      if (result.isConfirmed) {
        Swal.fire('Engellendi!', '', 'success');
        if (chat_card.hasClass('active')) {
          var id = chat_card.attr('id');
          $.get("chat/block_conversation/", "conversation_id="+id.replace('c_', ''), function(data, status){
          if(data.success)
          {
            selected_close_chat();
          }
          });
        }

        chat_card.slideUp(200, function () {
          chat_card.remove();
        });
      }
    });
    return false;
  });

  __document.on('click', '.video-call-request', function () {
    $('#videoCallRequest').modal('show');
    return false;
  });

  __document.on('click', '.video-call-request-accept', function () {
    $('#videoCallRequest').modal('hide');
    setTimeout(function () {
      $('#videoCall').modal('show');
      $('.chat-stopwatch').stopwatch().stopwatch('start');
    }, 500);
    return false;
  });

  __document.on('click', '.voice-call-request', function () {
    $('#voiceCallRequest').modal('show');
    return false;
  });

  __document.on('click', '.voice-call-accept', function () {
    $('#voiceCallRequest').modal('hide');
    setTimeout(function () {
      $('#voiceCall').modal('show');
      $('.chat-stopwatch').stopwatch().stopwatch('start');
    }, 500);
    return false;
  });

  __document.on('click', '.mute-event', function () {
    $(_this).find('svg').replaceWith(feather.icons['volume-x'].toSvg());
    $(_this).removeClass('mute-event');
    $(_this).addClass('unmute-event');
  });

  __document.on('click', '.unmute-event', function () {
    $(_this).find('svg').replaceWith(feather.icons['volume-2'].toSvg());
    $(_this).removeClass('unmute-event');
    $(_this).addClass('mute-event');
  });

  var send_message = function send_message(msg) {
    if (msg.type === 'in-typing') {
      $('.messages').append("<div class=\"message-item in in-typing\">\n                <div class=\"message-content\">\n                    <div class=\"message-text\">\n                        <div class=\"writing-animation\">\n                            <div class=\"writing-animation-line\"></div>\n                            <div class=\"writing-animation-line\"></div>\n                            <div class=\"writing-animation-line\"></div>\n                        </div>\n                    </div>\n                </div>\n            </div>");
    } else {
      $('.messages .message-item.in-typing').remove();
      $('.messages').append("<div class=\"message-item " + msg.type + "\">\n                <div class=\"message-avatar\">\n                    <figure class=\"avatar avatar-sm\">\n                        <img src=\"" + msg.avatar + "\" class=\"rounded-circle\" alt=\"image\">\n                    </figure>\n                    <div>\n                        <h5>" + msg.name + "</h5>\n                        <div class=\"time\">\n                            <time class=\"timeago\" datetime=\""+new Date().toLocaleString()+"\">Şimdi</time>\n                            " + (msg.type === 'out' ? "" : "") + "\n                        </div>\n                    </div>\n                </div>\n                <div class=\"message-content\">\n                    <div class=\"message-text\">" + msg.text + "</div>                </div>\n            </div>");
      $("time.timeago").timeago();
    }
  };
  
  __document.on('submit', '.chat .chat-footer form', function (e) {
    e.preventDefault();
    var input = $(e.target).find('input[type=text].form-control-main');
    var message = input.val();
    message = $.trim(message);

    var from_full_name = $('#from_full_name').val();
    var from_avatar = $('#from_avatar').val();
    var conversation_id = $('#conversation_id').val();

    $.post("chat/send", $('#sendMessage').serialize(), function(data, status){
      if(data.success)
      {
        send_message({
          type: 'out',
          text: message,
          avatar: from_avatar,
          name: from_full_name
        });
        input.val('');
        $('.chat .chat-body').scrollTop($('.chat .chat-body')[0].scrollHeight);                         
      }
    });
    /*
    if (message) {
      send_message({
        type: 'out',
        text: message,
        avatar: 'avatar9.jpg',
        name: 'Matteo Reedy'
      });
      input.val('');
      $('.chat .chat-body').scrollTop($('.chat .chat-body')[0].scrollHeight);
      setTimeout(function () {
        send_message({
          type: 'in-typing',
          text: 'Hi, do you like this template?',
          avatar: 'avatar2.jpg',
          name: 'Maribel Mallon'
        });
        $('.chat .chat-body').scrollTop($('.chat .chat-body')[0].scrollHeight);
      }, 1000);
      setTimeout(function () {
        send_message({
          type: 'in',
          text: 'Hi, do you like this template?',
          avatar: 'avatar6.jpg',
          name: 'Maribel Mallon'
        });
        $('.chat .chat-body').scrollTop($('.chat .chat-body')[0].scrollHeight);
      }, 3000);
    } else {
      input.focus();
    }
    */
  });

  __document.on('click', '.chat-emojis ul li', function () {
    var emoji = $(this).text();
    var input = $('.chat .chat-footer .form-control.form-control-main');
    input.val(input.val() + ' ' + emoji + ' ').focus();
  });

  __document.on('click', '.left-sidebar .list-group .list-group-item', function (e) {
    var id = $(this).attr('id');
    var conversation_id = id.replace('c_', '');
    $.get("chat/detail/"+id.replace('c_', ''), function(data, status){
      if(data.success)
      {
        $('.chat-header').html(data.header);
        $('.messages').html(data.body);
        $('#conversation_id').val(conversation_id);
        $('.chat').addClass('no-message');
        $('.no-message-container').addClass('d-none');
        $('.chat-preloader').removeClass('d-none');
        $('.left-sidebar .list-group .list-group-item').removeClass('active');
        $(e.currentTarget).addClass('active').removeClass('unread-chat').find('.new-message-count').remove();

        window.Echo.channel('online')
        .listen('.online', (res) => {
          $('.avatar-'+res.user.id).addClass('avatar-state-success');
          $('.isOnline-'+res.user.id).removeClass('text-secondary').addClass('text-success');
          $('.isOnline-'+res.user.id).html('Çevrimiçi');
        });

        window.Echo.private('conversation.'+conversation_id)
        .listen('.new-message', (res) => {
          setTimeout(function () {
            send_message({
                type: 'in-typing',
                text: res.data.text,
                avatar: res.data.avatar,
                name: res.data.name
            });
            $('.chat .chat-body').scrollTop($('.chat .chat-body')[0].scrollHeight);
            }, 1000);
            setTimeout(function () {
            send_message({
                type: 'in',
                text: res.data.text,
                avatar: res.data.avatar,
                name: res.data.name
            });
            $('.chat .chat-body').scrollTop($('.chat .chat-body')[0].scrollHeight);
            }, 3000);
        });
        
        setTimeout(function () {
          $('.chat').addClass('open').removeClass('no-message');
          $('.no-message-container').removeClass('d-none');
          $('.chat-preloader').addClass('d-none');          
          $('.chat .chat-body').scrollTop($('.chat .chat-body')[0].scrollHeight);
          $("time.timeago").timeago();
        }, 500);
      }
  
    });
    
    return false;
  });

  __document.on('click', '.example-close-selected-chat', function () {
    return selected_close_chat();
  }); // Turn off selected chat content on mobile


  __document.on('click', '.example-chat-close', function () {
    selected_close_chat();
    return false;
  });

  $(".chat .chat-body .messages .message-item .message-content-images a").fancybox();

  __document.on('click', '.example-app-tour-start', function () {
    introJsInit();
    $('[data-toggle="dropdown"]').dropdown('hide');
    return false;
  });

  var selected_close_chat = function selected_close_chat() {
    $('.left-sidebar .list-group .list-group-item').removeClass('active');
    $('.chat').addClass('no-message').removeClass('open');
  };

  var introJsInit = function introJsInit() {
    introJs().setOptions({
      steps: [{
        element: document.querySelector('[data-intro-js="1"]'),
        intro: 'Start a chat, create groups or add friends.',
        position: 'right'
      }, {
        element: document.querySelector('[data-intro-js="2"]'),
        intro: "See the chat list."
      }, {
        element: document.querySelector('[data-intro-js="3"]'),
        intro: "Manage your account"
      }, {
        element: document.querySelector('[data-intro-js="4"]'),
        intro: "Check out other people\'s stories!"
      }, {
        element: document.querySelector('[data-intro-js="5"]'),
        intro: "Choose a chat."
      }, {
        element: document.querySelector('[data-intro-js="6"]'),
        intro: "Send messages in the chat."
      }, {
        element: document.querySelector('[data-intro-js="7"]'),
        intro: "Check out other operations."
      }]
    }).setOption("disableInteraction", true).start();
  };
})(jQuery);