
xetaChat = {

    /**
     * Global variables.
     */
    actualWindowTitle : $(document).attr('title'),
    lastRefresh : Math.round(new Date().getTime() / 1000),
    notice : null,

    /**
     * Latest message.
     *
     * @type {Object}
     */
    lastMessage : {
        id : null,
        time : null,
        text : null
    },

    /**
     * Settings.
     *
     * @type {Object}
     */
    settings : {
        autoScroll : 1,
        maxMessages : 25,
        maxRetrying : 5,
        floodRule : 3000,
        spamRule : 95,
        messageMaxLength : 400,
        smiliesAdded : false,
        smiliesShowed : false,
        locale : 'en',
        refreshTime : null,
        urlRefresh : null,
        urlDeleteMessage : null,
        urlGetNotice : null
    },

    /**
     * Dom.
     *
     * @type {Object}
     */
    domIDs : {
        // The ID of the chat messages list:
        chatboxContent : 'chatboxContent',
        // The ID of the message text input field:
        inputMessage : 'chatboxMessage',
        //The ID of the Send button.
        buttonSend : 'chatboxSend',
        //The users counter.
        userCounter : 'usersCount',
        //The notice.
        notice : 'chatboxNotice',
        //The smilies box.
        smiliesBox : "smiliesBox",
        //Users list online in the chat.
        usersOnline : "chatboxOnline",
        //ID of the delete message link.
        deleteMessage : "chatboxDeleteMessage"
    },

    /**
     * The dom object related to this.domIDs
     *
     * @type {Object}
     */
    dom : null,

    /**
     * Current user.
     *
     * @type {Object}
     */
    user : {
        id : null,
        groupId : null,
        groupName : null,
        isConnected : null
    },


    /**
     * Languages
     *
     * @type {Object}
     */
    lang : null,

    /**
     * Smileys.
     *
     * @type {Object}
     */
    smileys : {
        crying : {
            replace : '<i class="xeta-smiley icon-crying" data-name="crying" data-toggle="tooltip" title="cry"></i>',
            smiley : ':cry:'
        },
        frustrated : {
            replace : '<i class="xeta-smiley icon-frustrated" data-name="frustrated" data-toggle="tooltip" title="frustrated"></i>',
            smiley : ':frustrated:'
        },
        sleepy : {
            replace : '<i class="xeta-smiley icon-sleepy" data-name="sleepy" data-toggle="tooltip" title="sleepy"></i>',
            smiley : ':sleepy:'
        },
        hipster : {
            replace : '<i class="xeta-smiley icon-hipster" data-name="hipster" data-toggle="tooltip" title="hipster"></i>',
            smiley : ':hipster:'
        },
        heartbroken : {
            replace : '<i class="xeta-smiley icon-heart-broken text-danger" data-name="heartbroken" data-toggle="tooltip" title="heartbroken"></i>',
            smiley : ':heartbroken:'
        },
        heart : {
            replace : '<i class="xeta-smiley icon-heart text-danger" data-name="heart" data-toggle="tooltip" title="heart"></i>',
            smiley : ':heart:'
        },
        boy : {
            replace : '<i class="xeta-smiley icon-boy text-info" data-name="boy" data-toggle="tooltip" title="boy"></i>',
            smiley : ':boy:'
        },
        girl : {
            replace : '<i class="xeta-smiley icon-girl text-pink" data-name="girl" data-toggle="tooltip" title="girl"></i>',
            smiley : ':girl:'
        },
        cool : {
            replace : '<i class="xeta-smiley icon-cool" data-name="cool" data-toggle="tooltip" title="cool"></i>',
            smiley : ':cool:'
        },
        evil : {
            replace : '<i class="xeta-smiley icon-evil" data-name="evil" data-toggle="tooltip" title="evil"></i>',
            smiley : ':evil:'
        },
        un : {
            replace : '<i class="xeta-smiley icon-un" data-name="un" data-toggle="tooltip" title="un"></i>',
            smiley : ':un:'
        },
        ghost : {
            replace : '<i class="xeta-smiley icon-ghost" data-name="ghost" data-toggle="tooltip" title="ghost"></i>',
            smiley : ':ghost:'
        },
        pacman : {
            replace : '<i class="xeta-smiley icon-pacman" data-name="pacman" data-toggle="tooltip" title="pacman"></i>',
            smiley : ':pacman:'
        },
        medal : {
            replace : '<i class="xeta-smiley icon-medal" data-name="medal" data-toggle="tooltip" title="medal"></i>',
            smiley : ':medal:'
        },
        medal2 : {
            replace : '<i class="xeta-smiley icon-medal2" data-name="medal2" data-toggle="tooltip" title="medal2"></i>',
            smiley : ':medal2:'
        },
        superman : {
            replace : '<i class="xeta-smiley icon-superman" data-name="superman" data-toggle="tooltip" title="superman"></i>',
            smiley : ':superman:'
        },
        pokeball : {
            replace : '<i class="xeta-smiley icon-pokeball" data-name="pokeball" data-toggle="tooltip" title="pokeball"></i>',
            smiley : ':pokeball:'
        },
        toad : {
            replace : '<i class="xeta-smiley icon-toad" data-name="toad" data-toggle="tooltip" title="toad"></i>',
            smiley : ':toad:'
        },
        happy : {
            replace : '<i class="xeta-smiley icon-happy" data-name="happy" data-toggle="tooltip" title=":D"></i>',
            smiley : ':D'
        },
        baffled : {
            replace : '<i class="xeta-smiley icon-baffled" data-name="baffled" data-toggle="tooltip" title="o.o"></i>',
            smiley : 'o.o'
        },
        smile : {
            replace : '<i class="xeta-smiley icon-smile" data-name="smile" data-toggle="tooltip" title=":)"></i>',
            smiley : ':)'
        },
        sad : {
            replace : '<i class="xeta-smiley icon-sad" data-name="sad" data-toggle="tooltip" title=":("></i>',
            smiley : ':('
        },
        tongue : {
            replace : '<i class="xeta-smiley icon-tongue" data-name="tongue" data-toggle="tooltip" title=":P"></i>',
            smiley : ':P'
        },
        wink : {
            replace : '<i class="xeta-smiley icon-wink" data-name="wink" data-toggle="tooltip" title=";)"></i>',
            smiley : ';)'
        },
        grin : {
            replace : '<i class="xeta-smiley icon-grin" data-name="grin" data-toggle="tooltip" title="xD"></i>',
            smiley : 'xD'
        },
        confused : {
            replace : '<i class="xeta-smiley icon-confused" data-name="confused" data-toggle="tooltip" title=":S"></i>',
            smiley : ':S'
        },
        angry : {
            replace : '<i class="xeta-smiley icon-angry" data-name="angry" data-toggle="tooltip" title=":@"></i>',
            smiley : ':@'
        },
        shocked : {
            replace : '<i class="xeta-smiley icon-shocked" data-name="shocked" data-toggle="tooltip" title=":O"></i>',
            smiley : ':O'
        },
        neutral : {
            replace : '<i class="xeta-smiley icon-neutral" data-name="neutral" data-toggle="tooltip" title=":|"></i>',
            smiley : ':|'
        }
    },

    /**
     * Initialize the chatbox.
     *
     * @return {void}
     */
    init: function(config, lang) {
        this.lang = lang;
        this.settings = this._mergeObjects(this.settings, config);
        this._initializeDocumentNodes();

        this._updateChat();
    },

    /**
     * Initialize the dom elements.
     *
     * @return {void}
     */
    _initializeDocumentNodes: function() {
        this.dom = {};
        for(var key in this.domIDs) {
            this.dom[key] = document.getElementById(this.domIDs[key]);
        }
    },

    /**
     * Send a request to the server.
     *
     * @return {void}
     */
    _updateChat: function(retrying) {
        retrying = typeof retrying !== 'undefined' ? retrying : 0;

        $.ajax({
            type: "GET",
            url: this.settings.urlRefresh,
            dataType: "xml",
            data : {
                lastMessageId : (this.lastMessage.id !== null) ? this.lastMessage.id : 0
            },
            success: function (response) {
                xetaChat._handleXML(response);
            },
            error: function () {
                //xetaChat._notify('danger', xetaChat.lang.getServerResponse);

                retrying++;
            }
        });

        if(retrying === 0 || (retrying !== 0 && retrying < this.settings.maxRetrying)) {
            //Set a timeout to re-execute this function.
            setTimeout(function() {
                xetaChat._updateChat(retrying);
            }, this.settings.refreshTime);
        }
    },

    /**
     * Delete a message.
     *
     * @param {int} id The id of the message to delete.
     *
     * @return {bool}
     */
    deleteMessage: function(id) {
        $.ajax({
            type : "POST",
            url : this.settings.urlDeleteMessage,
            data : {
                id : id
            },
            dataType : "json",
            success : function (data) {
                if(data.error === false) {
                    if(xetaChat._getMessageNode(id)) {
                        $('#chatboxMessage-' + id).remove();
                    }

                    xetaChat._notify('primary', data.message);
                } else {
                    xetaChat._notify('danger', data.message);
                }
            },
            error : function (e) {
                xetaChat._notify('danger', xetaChat.lang.errorToDeleteMessage);
            }
        });

        return true;
    },

    /**
     * Add all smilies in the smiley box.
     *
     * @return {void}
     */
    addSmiliesToBox: function() {
        if (this.settings.smiliesAdded === false) {
            var html = '';

            for (var i in this.smileys) {
                html += this.smileys[i].replace;
            }

            $(this.dom.smiliesBox).html(html);
            $(this.dom.smiliesBox).fadeIn("slow");

            this.settings.smiliesAdded = true;
            this.settings.smiliesShowed = true;
        } else {
            if (this.settings.smiliesShowed === true) {
                $(this.dom.smiliesBox).fadeOut("slow");
                this.settings.smiliesShowed = false;
            } else {
                $(this.dom.smiliesBox).fadeIn("slow");
                this.settings.smiliesShowed = true;
            }
        }
    },

    /**
     * Send the shout message.
     *
     * @return {bool|void}
     */
    sendShout: function() {
        this._disableInputs(true);

        //If isn't connected, display a notify.
        if (this.user.isConnected === false) {
            this._notify('danger', this.lang.userNotConnected);
            return;
        }

        //Get the value of the message.
        var message = $(this.dom.inputMessage).val().trim();

        //Check the Rules.
        if (this._handleShoutRules(message) === false) {
            return;
        }

        $.ajax({
            type : "POST",
            url : $(this.dom.buttonSend).attr('data-url'),
            dataType : "json",
            data : {
                message : message
            },
            success : function (response) {
                if (response.error === false && (typeof response.hasCmd == 'undefined' || response.hasCmd === false) && typeof response.message == 'undefined') {
                    //Remove the text in the input message.
                    $(xetaChat.dom.inputMessage).val('');

                    //Update the time and the text of the last message.
                    xetaChat.lastMessage.text = message;
                    xetaChat.lastMessage.time = new Date().getTime();
                } else if(typeof response.hasCmd != 'undefined' && response.hasCmd === true && response.error === false) {
                    xetaChat._handleCommands(response);
                } else if(response.error === false && response.hasCmd === false && typeof response.message != 'undefined') {
                    xetaChat._notify('danger', response.message);
                } else {
                    xetaChat._notify('danger', response.message);
                }

                xetaChat._disableInputs(false);
                //Fix for Chrome.
                $(xetaChat.dom.inputMessage).focus();
            },
            error : function () {
                xetaChat._notify('danger', xetaChat.lang.errorToShout);
                xetaChat._disableInputs(false);
            }
        });

        return true;

    },

    /**
     * Add the message to the chat.
     *
     * @param {int} date Timestamp of the created date message.
     * @param {int} userId The id of the user.
     * @param {string} username The username of the user.
     * @param {string} css The CSS of the user group.
     * @param {string} link The link of the user profile.
     * @param {int} groupId The group id of the user.
     * @param {int} messageId The id of the message.
     * @param {string} messageText The text of the message.
     *
     * @return {void}
     */
    _addMessageToChatList: function(date, userId, username, css, link, groupId, messageId, messageText) {
        // Prevent adding the same message twice:
        if(this._getMessageNode(messageId)) {
            return;
        }

        $(this.dom.chatboxContent)
            .prepend($('<li>')
                .attr({
                    id : 'chatboxMessage-' + messageId,
                    'data-userid' : userId,
                    'data-messageid' : messageId
                })
                .append($('<div>')
                    .addClass('dropdown actions')
                    .append($('<a>')
                        .addClass('popupControl')
                        .attr({
                            href : '#',
                            'data-toggle' : 'dropdown',
                            'aria-expanded' : 'false',
                            'aria-haspopup' : 'true'
                        })
                        .append($('<span>')
                            .addClass('caret')
                        )
                    )
                    .append($('<ul>')
                        .addClass('dropdown-menu')
                        .attr({
                            role : 'menu'
                        })
                        .append($('<li>')
                            .append($('<a>')
                                .attr({
                                    id : this.domIDs.deleteMessage,
                                    href : '#',
                                    role : 'menuitem',
                                    'data-id' : messageId
                                })
                                .text('Delete')
                            )
                        )
                    )
                )
                .append($('<span>')
                    .addClass('dateTime')
                    .text(' - ')
                    .prepend($('<time>')
                        .addClass('DateTime')
                        .attr('data-livestamp', date)
                        .text(this.lang.AFewSecondsAgo)
                    )
                )
                .append($('<span>')
                    .append($('<span>')
                        .addClass('chatboxTag')
                        .attr({
                            title : 'Reply',
                            'data-toggle' : 'tooltip',
                            'data-placement' : 'left',
                            'onclick' : "var member = $(this).parent().children('a.username').text(); $('input#chatboxMessage').val($('#chatboxMessage').focus().val() + '@' + member.trim() + ' ');"
                        })
                        .append($('<i>')
                            .addClass('fa fa-reply')
                        )
                    )
                    .append($('<a>')
                        .addClass('username')
                        .attr({
                            style : css,
                            href : link
                        })
                        .text(' ' + username)
                    )
                    .append(': ')
                    .append($('<div>')
                        .addClass('chatboxMessageText')
                        .html(this._formatText(messageText))
                    )
                )
            );
    },

    /**
     * Handle all function related to the server response.
     *
     * @param {object} xml The XML to handle.
     *
     * @return {void}
     */
    _handleXML: function(xml) {
        this._handleInfos(xml);
        this._handleOnlineUsers(xml);
        this._handleChatMessages(xml);
    },

    /**
     * Handle infos tags.
     *
     * @param {object} xml The XML to parse.
     *
     * @return {void}
     */
    _handleInfos: function(xml) {
        $(xml).find("info").each(function (i) {
            var infoType = $(xml).find("info")[i].firstElementChild.nodeName;
            var infoData = $(xml).find("info")[i].firstElementChild.textContent;

            xetaChat._handleInfo(infoType, infoData);
        });
    },

    /**
     * Handle a particular info.
     *
     * @param {string} infoType The info type.
     * @param {string} infoData The data associated.
     *
     * @return {void}
     */
    _handleInfo: function(infoType, infoData) {
        switch(infoType) {
            case 'usersCounter':
                this._updateUsersCounter(infoData);
                break;

            case 'notice':
                if (infoData !== this.notice) {
                    this._updateNotice(infoData);
                    this.notice = infoData;
                }
                break;

            case 'isConnected':
                var connected = this._getBool(infoData);

                //If the user is not connected, then we disabled all inputs.
                if (connected === false) {
                    this._disableInputs(true);
                }

                this.user.isConnected = connected;
                break;
        }
    },

    /**
     * Handle users tags.
     *
     * @param {object} xml The XML to parse.
     *
     * @return {void}
     */
    _handleOnlineUsers: function(xml) {
        if(xml.getElementsByTagName('user')[0].childNodes.length) {
            if($('.panel-chat-online').is(":visible") === false) {
                $('.panel-chat-online').show();
            }

            $(this.dom.usersOnline).html('');

            var lastId = $('id', $(xml).find("user")[$(xml).find("user").length-1]).text();

            $(xml).find("user").each(function (i) {
                xetaChat._handleUser(
                    $('id', this).text(),
                    $('user_id', this).text(),
                    $('username', this).text(),
                    $('group_id', this).text(),
                    $('css', this).text(),
                    $('is_banned', this).text(),
                    $('created', this).text(),
                    $('link', this).text(),
                    lastId
                );
            });
        } else {
            $('.panel-chat-online').hide();
        }
    },

    /**
     * Handle an user.
     * @param {int} id The insert Id.
     * @param {int} userId The Id of the user.
     * @param {string} username The username of the user.
     * @param {int} groupId The group id of the user.
     * @param {string} css The group CSS of the user.
     * @param {boolean} isBanned If the user is banned or not.
     * @param {int} created The date when the user logged in the chat.
     * @param {string} link The link of the user profile.
     * @param {int} lastId The id of the last user in the XML template.
     *
     * @return {void}
     */
    _handleUser: function(id, userId, username, groupId, css, isBanned, created, link, lastId) {
        // Prevent adding the same message twice:
        if(this._getUserNode(userId)) {
            return;
        }

        var end = ' ';
        //Add comma after the usernae while the lastId is different of the id.
        if (lastId != id) {
            end = ', ';
        }

        //Add the user in the HTMl.
        $(this.dom.usersOnline)
            .append($('<li>')
                .attr({
                    id : 'chatboxUser-' + userId
                })
                .append($('<a>')
                    .addClass('username')
                    .attr({
                        style : css,
                        href : link,
                    })
                    .text(username)
                )
                .append(end)
            );
    },

    /**
     * Handle messages tags.
     *
     * @param {object} xml The XML to parse.
     *
     * @return {void}
     */
    _handleChatMessages: function(xml) {
        if(xml.getElementsByTagName('message').length) {
            $(xml).find("message").each(function () {
                xetaChat._addMessageToChatList(
                        $('created', this).text(),
                        $('user_id', this).text(),
                        $('username', this).text(),
                        $('css', this).text(),
                        $('link', this).text(),
                        $('group_id', this).text(),
                        $('id', this).text(),
                        $('text', this).text(),
                        $('command', this).text()
                );
            });

            this._updateChatlistView();
            //Update the latest message.
            this.lastMessage.id = $('id', $(xml).find("message")[$(xml).find("message").length-1]).text();
        }
    },

    /**
     * Update the chat list messages.
     *
     * @return {void}
     */
    _updateChatlistView: function() {
        //We delete the old messages to keep the maxMessages number.
        if(this.dom.chatboxContent.childNodes && this.settings.maxMessages) {
            while(this.dom.chatboxContent.childNodes.length > this.settings.maxMessages) {
                this.dom.chatboxContent.removeChild(this.dom.chatboxContent.lastChild);
            }
        }

        if(this.settings.autoScroll) {
            this.dom.chatboxContent.scrollTop = this.dom.chatboxContent.scrollHeight;
        }
    },

    /**
     * Handle the Commands.
     *
     * @param {object} response The response sended by the server.
     *
     * @return {void}
     */
    _handleCommands: function(response) {
        switch (response.command) {
            case "prune":
                this._handleCommandPrune(response);
                $(this.dom.inputMessage).val('');
            break;

            case "ban":
                $(this.dom.inputMessage).val('');
            break;

            case "unban":
                $(this.dom.inputMessage).val('');
            break;
        }
    },

    /**
     * Delete all messages in the chat expect the last.
     *
     * @param {object} response The response sended by the server.
     *
     * @return {void}
     */
    _handleCommandPrune: function(response) {
        if(this.dom.chatboxContent.childNodes && response.lastMessageId) {
            while(xetaChat.dom.chatboxContent.childNodes[0] && xetaChat.dom.chatboxContent.childNodes[0].id != 'chatboxMessage-' + response.lastMessageId) {
                this.dom.chatboxContent.removeChild(this.dom.chatboxContent.lastChild);
            }
        }
    },

    /**
     * Check all rules related to a post message.
     *
     * @param {string} message The message to check.
     *
     * @return {bool}
     */
    _handleShoutRules: function(message) {
        //Flood rule.
        if(this.lastMessage.time !== null && this.lastMessage.time + this.settings.floodRule > new Date().getTime()) {
            this._notify('danger', this.lang.floodRule);
            this._disableInputs(false);
            return false;
        }

        //Spam Rule.
        var percent = this._similarText(message, this.lastMessage.text, 1);

        if(percent > this.settings.spamRule) {
            this._notify('danger', this.lang.spamRule);
            this._disableInputs(false);
            return false;
        }

        //Empty message.
        if(message.length === 0) {
            this._notify('danger', this.lang.emptyMessage);
            this._disableInputs(false);
            return false;
        }

        //Max length message.
        if(message.length > this.settings.messageMaxLength) {
            this._notify('danger', this.lang.messageMaxLength);
            this._disableInputs(false);
            return false;
        }

        return true;
    },

    /**
     * Disable/Enable the message input and send button.
     *
     * @param {bool} disable True to disable.
     *
     * @return {void}
     */
    _disableInputs: function(disable) {
        if(disable === true) {
            $(this.dom.inputMessage).attr('disabled', true).addClass('disabled');
            $(this.dom.buttonSend).attr('disabled', true).addClass('disabled');
        } else {
            $(this.dom.inputMessage).removeAttr('disabled').removeClass('disabled');
            $(this.dom.buttonSend).removeAttr('disabled').removeClass('disabled');
        }
    },

    /**
     * Compare 2 text and return the similarity in percentage.
     *
     * http://phpjs.org/functions/similar_text/
     *
     * @param {string} first The text to compare.
     * @param {string} second The text to compare.
     * @param {string} percent Optional, tu return a percentage or the number of similare letters.
     *
     * @return {int|float}
     */
    _similarText: function(first, second, percent) {
        if (first === null || second === null || typeof first === 'undefined' || typeof second === 'undefined') {
            return 0;
        }

        first += '';
        second += '';

        var pos1 = 0,
            pos2 = 0,
            max = 0,
            firstLength = first.length,
            secondLength = second.length,
            p, q, l, sum;

        max = 0;

        for (p = 0; p < firstLength; p++) {
            for (q = 0; q < secondLength; q++) {
                for (l = 0;
                    (p + l < firstLength) && (q + l < secondLength) && (first.charAt(p + l) === second.charAt(q + l)); l++)
                ;
                if (l > max) {
                    max = l;
                    pos1 = p;
                    pos2 = q;
                }
            }
        }

        sum = max;

        if (sum) {
            if (pos1 && pos2) {
                sum += this._similarText(first.substr(0, pos1), second.substr(0, pos2));
            }

            if ((pos1 + max < firstLength) && (pos2 + max < secondLength)) {
                sum += this._similarText(first.substr(pos1 + max, firstLength - pos1 - max), second.substr(pos2 + max,
                    secondLength - pos2 - max));
            }
        }

        if (!percent) {
            return sum;
        } else {
            return (sum * 200) / (firstLength + secondLength);
        }
    },

    /**
     * Test if a variable is an array or not. (Part of xetaChat._mergeObjects() function)
     *
     * http://codereview.stackexchange.com/a/16319
     *
     * @param {array} o The variable to test.
     *
     * @return {bool}
     */
    _isArray: function(o) {
      return Object.prototype.toString.call(o) == "[object Array]";
    },

    /**
     * Merge to object. (Similar to array_merge() in PHP)
     *
     * http://codereview.stackexchange.com/a/16319
     *
     * @param {array|object} target The primary array/object.
     * @param {array|object} source The second array/object to merge with the primary array/object.
     *
     * @return {array|object}
     */
    _mergeObjects: function(target, source) {
      var item, tItem, o, idx;

      // If either argument is undefined, return the other.
      // If both are undefined, return undefined.
      if (typeof source == 'undefined') {
        return source;
      } else if (typeof target == 'undefined') {
        return target;
      }

      // Assume both are objects and don't care about inherited properties
      for (var prop in source) {
        item = source[prop];

        if (typeof item === 'object' && item !== null) {

          if (xetaChat._isArray(item) && item.length) {

            // deal with arrays, will be either array of primitives or array of objects
            // If primitives
            if (typeof item[0] !== 'object') {

              // if target doesn't have a similar property, just reference it
              tItem = target[prop];
              if (!tItem) {
                target[prop] = item;

              // Otherwise, copy only those members that don't exist on target
              } else {

                // Create an index of items on target
                o = {};
                for (var i = 0, iLen = tItem.length; i < iLen; i++) {
                  o[tItem[i]] = true;
                }

                // Do check, push missing
                for (var j = 0, jLen = item.length; j < jLen; j++) {
                  if (!(item[j] in o)) {
                    tItem.push(item[j]);
                  }
                }
              }
            } else {
              // Deal with array of objects
              // Create index of objects in target object using ID property
              // Assume if target has same named property then it will be similar array
              idx = {};
              tItem = target[prop];

              for (var k = 0, kLen = tItem.length; k < kLen; k++) {
                idx[tItem[k].id] = tItem[k];
              }

              // Do updates
              for (var l = 0, ll = item.length; l < ll; l++) {
                // If target doesn't have an equivalent, just add it
                if (!(item[l].id in idx)) {
                  tItem.push(item[l]);
                } else {
                  xetaChat._mergeObjects(idx[item[l].id], item[l]);
                }
              }
            }
          } else {
            // deal with object
            xetaChat._mergeObjects(target[prop],item);
          }

        } else {
          // item is a primitive, just copy it over
          target[prop] = item;
        }
      }
      return target;
    },

    /**
     * Display a notification.
     *
     * @param {string} type The type of the notification.
     * @param {string} message The message to display.
     *
     * @return {void}
     */
    _notify: function(type, message) {
        $(".top-right").notify({
            message : {
                text : message
            },
            type : type
        }).show();
    },

    /**
     * Convert a string into a boolen.
     *
     * @param {string} string The string to convert.
     *
     * @return {bool}
     */
    _getBool: function(string) {
        return !!JSON.parse(String(string).toLowerCase());
    },

    /**
     * Check if a message is already display or not.
     *
     * @param {int} messageId The message id to check.
     *
     * @return {null|object}
     */
    _getMessageNode: function(messageId) {
        return ((messageId === null) ? null : document.getElementById('chatboxMessage-' + messageId));
    },

    /**
     * Check if a user is already display or not.
     *
     * @param {int} userId The user id to check.
     *
     * @return {null|object}
     */
    _getUserNode: function(userId) {
        return ((userId === null) ? null : document.getElementById('chatboxUser-' + userId));
    },

    /**
     * Update the users counter.
     *
     * @param {int} counter The integer to set.
     *
     * @return {void}
     */
    _updateUsersCounter: function(counter) {
        $(this.dom.userCounter).text(counter);
    },

    /**
     * Update the notice.
     *
     * Information : The notice is already parsed by HTMLPurifer in ChatComponent.
     *
     * @param {string} notice The notice to display.
     */
    _updateNotice: function(notice) {
        $(this.dom.notice).html(this._replaceSmiley(notice));
    },

    /**
     * Format a text by escape HTML tags and replacing the smileys.
     *
     * @param {string} text The string to format.
     *
     * @return {string}
     */
    _formatText: function(text) {
        return this._replaceSmiley(this._escapeHTML(text));
    },

    /**
     * Replace all smileys in the text.
     *
     * @param {string} data The text to parse to replace it by a smiley.
     *
     * @return {string}
     */
    _replaceSmiley: function(data) {
        var smileys = this.smileys;

        for (var key in smileys) {
            var regex = new RegExp(this._escapeRegExp(smileys[key].smiley), "gi");
            data = data.replace(regex, smileys[key].replace);
        }

        return data;
    },

    /**
     * Escape a text.
     *
     * @param {string} text The text to escape.
     *
     * @return {string}
     */
    _escapeHTML: function(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;")
            .replace(/\'/g, "&#39;");
    },

    /**
     * Escape all RegexExp.
     *
     * @param {string} text The RegexExp to escape.
     *
     * @return {string}
     */
    _escapeRegExp: function(text) {
        return text.replace(/[-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    },
};


$(document).ready(function () {

    /**
     * When an moderator submit a new notice/ has edited the notice.
     *
     * @return {bool}
     */
    $('#noticeForm').submit(function(e) {
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            type : "POST",
            url : $(this).attr('action'),
            dataType : "json",
            data : {
                notice : CKEDITOR.instances.noticeBox.getData()
            },
            success : function (response) {
                $('#noticeModal').modal('hide');

                if(response.error == true) {
                    xetaChat._notify('danger', response.message);
                }
            },
            error : function (e) {
                xetaChat._notify('danger', xetaChat.lang.errorToEditTheNotice);
            }
        });

        return false;
    });

    /**
     * Detroy the CkEditor instance when the notice modal is closed.
     *
     * @return {void}
     */
    $('#noticeModal').on('hide.bs.modal', function () {
        CKEDITOR.instances.noticeBox.destroy();
    });

    /**
     * When an user send a shout by pressing the key "Enter".
     *
     * @return {bool}
     */
    $("#chatboxMessage").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            xetaChat.sendShout();
            return false;
        }
    });

    /**
     * When a user send a shout with the button send.
     *
     * @return {bool}
     */
    $("#chatboxSend").on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        xetaChat.sendShout();
        return false;
    });

    /**
     * Add all smilies to the smiley box.
     *
     * @return {void}
     */
    $('#chatboxSmiliePicker').on('click', function () {
        xetaChat.addSmiliesToBox();
    });

    /**
     * Insert a smiley in the input message.
     *
     * @return {bool}
     */
    $('#smiliesBox').on('click', '.xeta-smiley', function () {
        var smiley = $(this).attr('data-name');

        $(xetaChat.dom.inputMessage).insertAroundCaret(" " + xetaChat.smileys[smiley].smiley, "");

        return false;
    });

    /**
     * Delete a message.
     *
     * @return {bool} To not acts as a link.
     */
    $('#chatboxContent').on('click', '#' + xetaChat.domIDs.deleteMessage, function () {
        var id = $(this).attr('data-id');
        xetaChat.deleteMessage(id);

        return false;
    });
});

// http://stackoverflow.com/questions/946534/insert-text-into-textarea-with-jquery, modified slightly
jQuery.fn.extend({
    insertAroundCaret: function(myValue, myValue2){
        return this.each(function(i) {
            if(document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue + sel.text + myValue2;
                this.focus();
            } else if(this.selectionStart || this.selectionStart == '0') {
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(startPos, endPos)+myValue2+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length + myValue2.length + (endPos-startPos);
                this.selectionEnd = startPos + myValue.length + myValue2.length + (endPos-startPos);
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue + myValue2;
                this.focus();
            }
        });
    }
});
