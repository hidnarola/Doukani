/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
   // config.uiColor = '';
//    config.toolbar =
//            [{name: 'document', items: ['Source']},
//             {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline']},
//             {name: 'paragraph',items: [ 'NumberedList', 'BulletedList' ]},
//             { name: 'styles', items: [ 'Styles', 'Format' ]},
//             { name: 'colors' },
//            ];
            
    config.toolbarGroups = [
            { name: 'colors' }
    ];
    config.allowedContent = true;

};

