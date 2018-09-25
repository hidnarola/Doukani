/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
//    config.uiColor = '#F34541';
    config.toolbar =
            [{name: 'document', items: ['Source']},
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', '-', 'RemoveFormat']},
            ];
    config.allowedContent = true;

};
