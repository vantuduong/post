require('./bootstrap');

import Alpine from 'alpinejs';
import Editor from '@toast-ui/editor'
import '@toast-ui/editor/dist/toastui-editor.css';

import axios from 'axios';


window.Alpine = Alpine;

Alpine.start();

const editor = new Editor({
    el: document.querySelector('#editor'),
    height: '400px',
    initialEditType: 'markdown',
    placeholder: 'Write something cool!',
})

document.querySelector('#createPostForm').addEventListener('submit', e => {
    e.preventDefault();
    document.querySelector('#content').value = editor.getMarkdown();
    e.target.submit();
});
