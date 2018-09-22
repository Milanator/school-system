import Vue from 'vue';

import CreateQuestions from './components/CreateQuestions'

window.onload = function () {
	var app = new Vue({
		el: '#app',
		components: {
			CreateQuestions
		}
	});
};
