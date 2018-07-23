import 'core-js/modules/es6.promise';
import * as FontFaceObserver from 'fontfaceobserver';

const element = window.document.documentElement;

new FontFaceObserver('Noto Sans').load('', 5000).then(
    () => {
        element.classList.add('has-fonts');
        element.classList.add('has-base-font');
        element.classList.add('has-main-font');
    },
    () => element.classList.add('has-no-fonts'),
);
