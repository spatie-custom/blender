import 'babel-polyfill';

import 'blender.js/modules/ajax.csrf';
import 'blender.js/modules/interface.confirm';
import 'blender.js/modules/form.input.datetimepicker';
import 'blender.js/modules/form.select';
import 'blender.js/modules/form.textarea.autosize';
import 'blender.js/modules/form.locationpicker';
import 'blender.js/modules/table.datatables';
import 'blender.js/modules/table.sortable';
import 'blender.js/modules/tabs';

import { query } from 'spatie-dom';

if (query('blender-media')) {
    require.ensure([], () => {
        require('./modules/media').default();
    }, 'back.media');
}

if (query('blender-content-blocks')) {
    require.ensure([], () => {
        require('./modules/contentBlocks').default();
    }, 'back.blocks');
}

if (query('blender-chart')) {
    require.ensure([], () => {
        require('./modules/chart').default();
    }, 'back.chart');
}

// uncomment when redactor is installed
// if (query('[data-editor]')) {
//     require.ensure([], () => {
//         require('./modules/editor').default();
//     }, 'back.editor');
// }
