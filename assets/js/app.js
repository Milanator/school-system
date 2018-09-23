import Vue from 'vue';

import CreateQuestions from './components/CreateQuestions'
import SelectQuestions from "./components/SelectQuestions";

window.onload = function () {
	var app = new Vue({
		el: '#app',
		components: {
			CreateQuestions,
			SelectQuestions
		}
	});
};
