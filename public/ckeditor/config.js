/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.image_previewText=' '; //预览区域显示内容
    config.removeDialogTabs = 'image:advanced;image:Link';
    //上傳圖片的router
    config.filebrowserImageUploadUrl = 'http://149.57.136.247/app_backend/public/api/uploadimg?opener=ckeditor&type=images';
    config.filebrowserUploadMethod = 'form';
    config.height=250;
    config.allowedContent=true;
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};

