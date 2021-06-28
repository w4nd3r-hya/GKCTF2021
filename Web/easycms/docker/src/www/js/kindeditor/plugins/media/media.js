/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('media', function(K) {
	var self = this, name = 'media', lang = self.lang(name + '.'),
		allowMediaUpload = K.undef(self.allowMediaUpload, true),
		allowFileManager = K.undef(self.allowFileManager, false),
		formatUploadUrl = K.undef(self.formatUploadUrl, true),
		extraParams = K.undef(self.extraFileUploadParams, {}),
		filePostName = K.undef(self.filePostName, 'imgFile'),
		uploadJson = K.undef(self.uploadJson, self.basePath + 'php/upload_json.php');
	self.plugin.media = {
		edit : function() {
			var html = [
				'<div style="padding:20px;">',
				//type
			  '<div class="ke-dialog-row">',
			  '<label for="type" style="width:60px;">' + lang.type + '</label>',
			  '<input type="radio" name="type" class="ke-inline-block mg-0" value="upload" checked="checked" />&nbsp;' + lang.upload,
			  '&nbsp;&nbsp;<input type="radio" name="type" class="ke-inline-block mg-0" value="viewServer"/>&nbsp;' + lang.viewServer,
			  '&nbsp;&nbsp;<input type="radio"  name="type" class="ke-inline-block mg-0" value="third"/>&nbsp;' + lang.third,
			  '</div>',
				//url
				'<div class="ke-dialog-row url">',
				'<label for="keUrl" style="width:60px;">' + lang.url + '</label>',
				'<input class="ke-input-text" type="text" id="keUrl" name="url" value="" style="width:200px;" /> &nbsp;',
				'<input type="button" class="ke-upload-button" value="' + lang.upload + '" /> &nbsp;',
				'<span class="ke-button-common ke-button-outer viewServer hidden">',
				'<input type="button" class="ke-button-common ke-button" name="viewServer" value="' + lang.viewServer + '" />',
				'</span>',
        '</div>',
				//html
				'<div class="ke-dialog-row html hide">',
				'<label for="keUrl" style="width:60px;">' + lang.html + '</label>',
				'<textarea class="ke-textarea" id="keHtml" name="html" value="" style="width:360px;height:160px;display:inline-block;margin-left:-5px;"></textarea>',
        '</div>',
				//width
				'<div class="ke-dialog-row width">',
				'<label for="keWidth" style="width:60px;">' + lang.width + '</label>',
				'<input type="text" id="keWidth" class="ke-input-text ke-input-number" name="width" value="550" maxlength="4" />',
				'</div>',
				//height
				'<div class="ke-dialog-row height">',
				'<label for="keHeight" style="width:60px;">' + lang.height + '</label>',
				'<input type="text" id="keHeight" class="ke-input-text ke-input-number" name="height" value="400" maxlength="4" />',
				'</div>',
				//autostart
				'<div class="ke-dialog-row autostart">',
				'<label for="keAutostart" style="width:60px">' + lang.autostart + '</label>',
				'<input type="checkbox" id="keAutostart" name="autostart" value="" /> ',
				'</div>',
				//fullscreen
				'<div class="ke-dialog-row fullscreen">',
				'<label for="keFullscreen" style="width:60px">' + lang.fullscreen + '</label>',
				'<input type="checkbox" id="keFullscreen" name="allowfullscreen" value="" /> ',
				'</div>',
				'</div>'
			].join('');

			var dialog = self.createDialog({
				name : name,
				width : 500,
				height : 310,
				title : self.lang(name),
				body : html,
				yesBtn : {
					name : self.lang('yes'),
					click : function(e) {
            if(isThirdBox[0].checked)
            {
					      html = htmlBox.val();
                if(K.trim(html) === '')
                {
                    alert(lang.pleaseInput);
                    textarea[0].focus();
                    return;
                }
            }
            else
            {
                var url = K.trim(urlBox.val()),
                  width = widthBox.val(),
                  height = heightBox.val();
                if (url == 'http://' || K.invalidUrl(url)) {
                  alert(self.lang('invalidUrl'));
                  urlBox[0].focus();
                  return;
                }
                if (!/^\d*$/.test(width)) {
                  alert(self.lang('invalidWidth'));
                  widthBox[0].focus();
                  return;
                }
                if (!/^\d*$/.test(height)) {
                  alert(self.lang('invalidHeight'));
                  heightBox[0].focus();
                  return;
                }
                var html = K.mediaImg(self.themesPath + 'common/blank.gif', {
                    src : url,
                    class: url.indexOf('file.php?f=') > 0 ? 'videojs' : '',
                    type : K.mediaType(url),
                    width : width,
                    height : height,
                    autostart : autostartBox[0].checked ? 'true' : 'false',
                    allowfullscreen : fullscreenBox[0].checked ? 'true' : 'false',
                    loop : 'true'
                  });
            }
						self.insertHtml(html).hideDialog().focus();
					}
				}
			}),
			div = dialog.div,
			isThirdBox = K('[value="third"]', div),
			htmlBox = K('[name="html"]', div),
			urlBox = K('[name="url"]', div),
			viewServerBtn = K('[name="viewServer"]', div),
			widthBox = K('[name="width"]', div),
			heightBox = K('[name="height"]', div),
			autostartBox = K('[name="autostart"]', div);
			fullscreenBox = K('[name="allowfullscreen"]', div);
			urlBox.val('http://');

			if (allowMediaUpload) {
				var uploadbutton = K.uploadbutton({
					button : K('.ke-upload-button', div)[0],
					fieldName : filePostName,
					extraParams : extraParams,
					url : K.addParam(uploadJson, 'dir=media'),
					afterUpload : function(data) {
						dialog.hideLoading();
						if (data.error === 0) {
							var url = data.url;
							if (formatUploadUrl) {
								url = K.formatUrl(url, 'absolute');
							}
							urlBox.val(url);
							if (self.afterUpload) {
								self.afterUpload.call(self, url, data, name);
							}
							alert(self.lang('uploadSuccess'));
						} else {
							alert(data.message);
						}
					},
					afterError : function(html) {
						dialog.hideLoading();
						self.errorDialog(html);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					dialog.showLoading(self.lang('uploadLoading'));
					uploadbutton.submit();
				});
			} else {
				K('.ke-upload-button', div).hide();
			}

			if (allowFileManager) {
				viewServerBtn.click(function(e) {
					self.loadPlugin('filemanager', function() {
						self.plugin.filemanagerDialog({
							viewType : 'LIST',
							dirName : 'media',
							clickFn : function(url, title) {
								if (self.dialogs.length > 1) {
									K('[name="url"]', div).val(url);
									if (self.afterSelectFile) {
										self.afterSelectFile.call(self, url);
									}
									self.hideDialog();
								}
							}
						});
					});
				});
			} else {
				viewServerBtn.hide();
			}

      $('[name=type]').click(function()
      {
          if($(this).val() == 'upload')
          {
              $('.ke-dialog-row.url, .ke-dialog-row.width, .ke-dialog-row.height, .ke-dialog-row.autostart, .ke-dialog-row.fullscreen').show();
              $('.ke-dialog-row.html').hide();

              $('.ke-inline-block.ke-upload-button').show();
              $('[name=viewServer]').parent('span').addClass('hidden');
          }
          else if($(this).val() == 'viewServer')
          {
              $('.ke-dialog-row.url, .ke-dialog-row.width, .ke-dialog-row.height, .ke-dialog-row.autostart, .ke-dialog-row.fullscreen').show();
              $('.ke-dialog-row.html').hide();

              $('.ke-inline-block.ke-upload-button').hide();
              $('[name=viewServer]').parent('span').removeClass('hidden');
          }
          else
          {
              $('.ke-dialog-row.url, .ke-dialog-row.width, .ke-dialog-row.height, .ke-dialog-row.autostart, .ke-dialog-row.fullscreen').hide();
              $('.ke-dialog-row.html').show();
          }
      })

			var img = self.plugin.getSelectedMedia();
			if (img) {
				var attrs = K.mediaAttrs(img.attr('data-ke-tag'));
				urlBox.val(attrs.src);
				widthBox.val(K.removeUnit(img.css('width')) || attrs.width || 0);
				heightBox.val(K.removeUnit(img.css('height')) || attrs.height || 0);
				autostartBox[0].checked = (attrs.autostart === 'true');
				fullscreenBox[0].checked = (attrs.allowfullscreen === 'true');
			}
			urlBox[0].focus();
			urlBox[0].select();
		},
		'delete' : function() {
			self.plugin.getSelectedMedia().remove();
			// [IE] 删除图片后立即点击图片按钮出错
			self.addBookmark();
		}
	};

	self.clickToolbar(name, self.plugin.media.edit);
});
